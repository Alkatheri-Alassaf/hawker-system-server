<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public static function makePayment(Request $request, $applicationID)
    {
        $hawkerID = $request->input("hawkerID");
        $amount = $request->input("amount");
        $cardNumber = $request->input("cardNumber");
        $cardExpiryDate = $request->input("cardExpirayDate");
        $cvv = $request->input("cvv");
        $paymentStatus = $request->input("paymentStatus");

        $payment = Payment::create([
            "applicationID" => $applicationID,
            "hawkerID" => $hawkerID,
            "amount" => $amount,
            "cardNumber" => $cardNumber,
            "cardExpiryDate" => $cardExpiryDate,
            "cardCVVNumber" => $cvv,
            "paymentStatus" => $paymentStatus
        ]);

        if ($payment)
            return true;
        else
            return false;
    }
}
