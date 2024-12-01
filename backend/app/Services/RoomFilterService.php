<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomFilterService
{
    public function applyFilters(Request $request)
    {
        $query = Room::query();

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }


        if ($request->filled('min_area')) {
            $query->whereRaw('(dimensions->>0)::int * (dimensions->>1)::int >= ?', $request->min_area);
        }

        if ($request->filled('max_area')) {
            $query->whereRaw('(dimensions->>0)::int * (dimensions->>1)::int <= ?', [$request->max_area]);
        }


        if ($request->filled('amenities')) {
            $amenities = explode(',', $request->amenities);
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        if ($request->filled('sort_by')) {
            $sortField = $request->sort_by;
            $sortOrder = $request->sort_order ?? 'asc';
            $query->orderBy($sortField, $sortOrder);
        }

        return $query;
    }
}
