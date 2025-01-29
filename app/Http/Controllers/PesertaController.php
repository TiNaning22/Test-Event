<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'ticket_quantity' => 'required|integer|min:1',
            'event_id' => 'required|exists:events,id',
        ]);
        
        $event = Event::find($validated['event_id']);
        if ($event->total_tickets < $validated['ticket_quantity']) {
            return response()->json(['message' => 'Not enough tickets available'], 400);
        }
        
        $event->total_tickets -= $validated['ticket_quantity'];
        $event->save();
        
        return Peserta::create($validated);
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
