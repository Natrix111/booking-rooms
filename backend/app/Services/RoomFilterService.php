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

        if ($request->filled('areas')) {
            $areas = explode(',', $request->areas);
            $query->where(function ($query) use ($areas) {
                foreach ($areas as $area) {
                    $query->orWhereRaw('(dimensions->>0)::int * (dimensions->>1)::int = ?', [(int)$area]);
                }
            });
        }

        if ($request->filled('max_area')) {
            $query->whereRaw('(dimensions->>0)::int * (dimensions->>1)::int <= ?', [$request->max_area]);
        }

        if ($request->filled('amenities')) {
            $amenities = explode(',', $request->amenities);

            foreach ($amenities as $amenity) {
                $query->whereHas('amenities', function ($query) use ($amenity) {
                    $query->where('amenities.name', $amenity);
                });
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
