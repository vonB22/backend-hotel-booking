<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        return Booking::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        return $booking;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->update($request->all());
        return $booking;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->delete();
        return response()->noContent();
    }
}
