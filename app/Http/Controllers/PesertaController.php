<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

use Illuminate\Support\Facades\Mail;
use App\Mail\PesertaRegisteredMail;

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

        DB::transaction(function () use ($event, $validated) {
            $participant = $event->peserta()->create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'ticket_quantity' => $validated['ticket_quantity']
                // 'payment_status' => 'pending'
            ]);

            // $payment = $this->createMidtransPayment($participant, $event);
            
            $event->decrement('total_tiket', $validated['ticket_quantity']);
            
            // Send email notification
            // Mail::to($validated['email'])->queue(new RegistrationConfirmation($participant));
            
            return view('payment.payment');
        });
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
