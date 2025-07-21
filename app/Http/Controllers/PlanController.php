<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yabacon\Paystack;

class PlanController extends Controller
{
    public function showPlans()
    {
        $plans = DB::table('plans')->get();
        return view('plans.index', compact('plans'));
    }

    public function redirectToPaystack(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'email' => 'required|email',
        ]);

        $plan = DB::table('plans')->find($request->plan_id);

        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

        $tranx = $paystack->transaction->initialize([
            'amount' => $plan->price * 100, // in kobo
            'email' => $request->email,
            'reference' => uniqid('ART-'),
            'callback_url' => route('paystack.callback'),
            'metadata' => [
                'plan_id' => $plan->id,
                'user_email' => $request->email,
            ],
        ]);

        return redirect($tranx->data->authorization_url);
    }

    public function handleGatewayCallback(Request $request)
    {
        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

        $reference = $request->query('reference');
        $tranx = $paystack->transaction->verify([
            'reference' => $reference,
        ]);

        if ($tranx->data->status === 'success') {
            // Store record
            DB::table('plan_payments')->insert([
                'email' => $tranx->data->customer->email,
                'plan_id' => $tranx->data->metadata->plan_id,
                'amount' => $tranx->data->amount / 100,
                'status' => 'successful',
                'reference' => $tranx->data->reference,
                'paid_at' => now(),
            ]);

            return view('plans.success', ['message' => 'Payment successful!']);
        }

        return view('plans.failed', ['message' => 'Payment failed. Please try again.']);
    }
}
