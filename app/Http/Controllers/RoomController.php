<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Room::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms',
            'type' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|in:available,booked,maintenance',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ]);
        return Room::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Room::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return $room;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Room::destroy($id);
        return response()->noContent();
    }
}
