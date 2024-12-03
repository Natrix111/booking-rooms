<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\RoomFilterService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomFilterService;

    public function __construct(RoomFilterService $roomFilterService)
    {
        $this->roomFilterService = $roomFilterService;
    }

    public function index(Request $request)
    {
        $rooms = $this->roomFilterService->applyFilters($request)->get();

        return response()->json($rooms);
    }

    public function filters()
    {
        $rooms = Room::all();

        $minPrice = Room::min('price');
        $maxPrice = Room::max('price');

        $amenities = $rooms
            ->flatMap(function ($room) {
                return $room->getAmenities();
            })
            ->unique()
            ->values();

        $areas = $rooms
            ->map(function ($room) {
                return $room->getSquare();
            })
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'amenities' => $amenities,
            'areas' => $areas,
        ]);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);

        $otherRooms = Room::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json([
            'room' => $room,
            'otherRooms' => $otherRooms,
        ]);
    }
}
