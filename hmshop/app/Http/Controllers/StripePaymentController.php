<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;


class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $total = $request->total;
        $amount = round(round($total,2)*100);
        Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $request->token,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
  
        return response()->json(['message'=>'Paid successfully'],200);
    }
}
