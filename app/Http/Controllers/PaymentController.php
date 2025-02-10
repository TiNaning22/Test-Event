<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::with(['peserta', 'event'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.payment', compact('payments'));
    }

    public function notification(Request $request)
    {
        $notif = new Notifications();
        $notif = new Notification();
        
        $transaction = $notif->getResponse();
        $transaction_id = $transaction->order_id;
        $status_code = $transaction->status_code;
        $payment_type = $transaction->payment_type;

        $payment = Payment::where('order_id', $transaction_id)->first();
        
        if ($status_code == '200') {
            $payment->update(['status' => 'paid']);
            $payment->participant->update(['payment_status' => 'paid']);
        } elseif ($status_code == '202') {
            $payment->update(['status' => 'failed']);
            $payment->participant->update(['payment_status' => 'failed']);
            
            // Return tickets to available pool
            $payment->event->increment(
                'available_tickets', 
                $payment->participant->ticket_quantity
            );
        }
    }

    public function status(Payment $payment)
    {
        return response()->json([
            'status' => $payment->status,
            'payment_details' => [
                'amount' => $payment->amount,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at
            ]
        ]);
    }

    public function generateToken(Participant $participant)
    {
        $midtrans = new MidtransService();
        return response()->json([
            'snap_token' => $midtrans->createTransaction(...)
        ]);
    }
}
