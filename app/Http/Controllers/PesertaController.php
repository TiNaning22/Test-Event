<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Event;
use App\Models\Peserta;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use App\Mail\PesertaRegisteredMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'ticket_quantity' => 'required|integer|min:1'
        ]);
    
        if ($event->total_tiket < $validated['ticket_quantity']) {
            return response()->json([
                'message' => 'Insufficient tickets available'
            ], 400);
        }
    
        $peserta = DB::transaction(function () use ($event, $validated) {
            $peserta = $event->peserta()->create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'ticket_quantity' => $validated['ticket_quantity']
            ]);
    
            $event->decrement('total_tiket', $validated['ticket_quantity']);
    
            return $peserta;
        });
    
        if (!$peserta) {
            return response()->json([
                'message' => 'Failed to create participant'
            ], 500);
        }
    
        $midtrans = new MidtransService();
        $order_id = 'ORDER-' . $peserta->id . '-' . time();
        
        $transaction = $midtrans->createTransaction(
            $order_id,
            $peserta->ticket_quantity * $event->price,
            [
                'first_name' => $peserta->full_name,
                'email' => $peserta->email,
                'phone' => $peserta->phone_number,
            ]
        );
    
        if ($transaction['success']) {
           $payment = Payment::create([
                'peserta_id' => $peserta->id,
                'event_id' => $event->id,
                'order_id' => $order_id,
                'amount' => $peserta->ticket_quantity * $event->price,
                'snap_token' => $transaction['snap_token']
            ]);
    
            return view('payment.payment', [
                'snap_token' => $transaction['snap_token'],
                'payments' => [$payment],
                'event' => $event,
                'peserta' => $peserta,
            ]);
        }
    
        return response()->json([
            'message' => 'Payment creation failed'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
