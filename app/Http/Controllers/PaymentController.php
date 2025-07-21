<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\User;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $amountInKobo = $plan->price * 100;

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->post(env('PAYSTACK_PAYMENT_URL') . '/transaction/initialize', [
            'email' => Auth::user()->email,
            'amount' => $amountInKobo,
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'plan_id' => $plan->id,
                'user_id' => Auth::id(),
            ],
        ]);

        if ($response->successful()) {
            return redirect($response['data']['authorization_url']);
        }

        return back()->with('error', 'Payment initialization failed.');
    }

    public function handleGatewayCallback(Request $request)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->get(env('PAYSTACK_PAYMENT_URL') . '/transaction/verify/' . $request->reference);

        if ($response->successful() && $response['data']['status'] === 'success') {
            $plan_id = $response['data']['metadata']['plan_id'];
            $user = Auth::user();

            // Mark plan as paid (you can create a UserPlan model or update user record)
            $user->plan_id = $plan_id;
            $user->plan_expiry = now()->addYear();
            $user->save();

            return redirect()->route('plans.index')->with('success', 'Payment successful. Plan activated!');
        }

        return redirect()->route('plans.index')->with('error', 'Payment failed or canceled.');
    }
}
