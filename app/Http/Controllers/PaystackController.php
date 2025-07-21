<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Yabacon\Paystack;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class PaystackController extends Controller
{
    protected $paystack;

    public function __construct()
    {
        $this->paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));
    }

    // Redirect after selecting a plan
    public function redirectToGateway(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();
        $amount = $plan->price * 100;

        // Save selected plan in session for use after callback
        session(['selected_plan_id' => $plan->id]);

        // If free plan, skip Paystack
        if ($amount === 0) {
            Payment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => 0,
                'status' => 'free',
                'reference' => 'FREE-' . strtoupper(uniqid())
            ]);

            return redirect()->route('plans.index')->with('success', 'Subscribed to free plan.');
        }

        $data = [
            'amount' => $amount,
            'email' => $user->email,
            'reference' => Paystack::genTranxRef(),
            'callback_url' => route('paystack.callback'),
            'metadata' => [
                'plan_id' => $plan->id,
                'user_id' => $user->id
            ]
        ];

        try {
            $response = $this->paystack->transaction->initialize($data);
            return redirect($response->data->authorization_url);
        } catch (\Yabacon\Paystack\Exception\ApiException $e) {
            return back()->with('error', 'Paystack error: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('plans.index')->with('error', 'No transaction reference found.');
        }

        $secretKey = env('PAYSTACK_SECRET_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->get('https://api.paystack.co/transaction/verify/' . $reference);

        $body = $response->json();

        if (!$body['status']) {
            return redirect()->route('plans.index')->with('error', 'Transaction verification failed.');
        }

        $data = $body['data'];

        $planId = session('selected_plan_id');
        if (!$planId) {
            return redirect()->route('plans.index')->with('error', 'Plan info missing from session.');
        }

        // Save payment details to database
        Payment::create([
            'user_id' => Auth::id(),
            'reference' => $data['reference'],
            'amount' => $data['amount'] / 100,
            'gateway_response' => $data['gateway_response'],
            'channel' => $data['channel'],
            'currency' => $data['currency'],
            'status' => $data['status'],
            'plan_id' => $planId,
        ]);

        return redirect()->route('plans.index')->with('success', 'Payment successful! You’ve subscribed to a plan.');
    }

    public function paymentHistory()
    {
        $userId = Auth::id();

        $payment = DB::table('payments')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$payment) {
            return view('payments.history', ['payment' => null]);
        }

        $plan = DB::table('plans')->where('id', $payment->plan_id)->first();

        return view('payments.history', [
            'payment' => $payment,
            'plan' => $plan,
        ]);
    }

    // OLD callback kept for compatibility
    public function handleGatewayCallback(Request $request)
    {
        $reference = $request->query('reference');

        try {
            $tranx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);

            if (!$tranx->status) {
                return redirect()->route('plans.index')->with('error', 'Transaction failed');
            }

            if ($tranx->data->status == 'success') {
                Payment::create([
                    'user_id' => $tranx->data->metadata->user_id,
                    'plan_id' => $tranx->data->metadata->plan_id,
                    'amount' => $tranx->data->amount / 100,
                    'status' => 'success',
                    'reference' => $reference
                ]);

                return redirect()->route('plans.index')->with('success', 'Payment successful');
            } else {
                return redirect()->route('plans.index')->with('error', 'Payment not successful');
            }

        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', 'Callback error: ' . $e->getMessage());
        }
    }
}
