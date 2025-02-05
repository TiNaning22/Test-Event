<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $event = Event::all();
        return view('dashboard-event.dashboard', compact('event'));
    }

    public function create()
    {
        return view('dashboard-event.create');
    }

    public function store(Request $request)
    {
        $event = Event::create($request->all());

        return redirect()->route('dashboard.index');
    }

    public function update(Request $request)
    {
        $event = Event::find($request->id);
        $event->update($request->all());

        return redirect()->route('dashboard.index');
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect()->route('dashboard.index');
    }
}
