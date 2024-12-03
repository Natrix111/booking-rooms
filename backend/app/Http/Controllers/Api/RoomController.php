<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\RoomFilterService;
use Illuminate\Http\Request;
use App\Models\Amenity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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


    public function create(Request $request)
    {
        //Осталось доделась загрузку изображений, будет позже
            $validator = Validator::make($request->all(),([
                'name' => 'required|string',
                'dimensions' => 'required|json',
                'amenities' => [
                    'nullable',
                    'array',
                    Rule::in(Amenity::pluck('name')->toArray()), // Гарантирует, что значения из amenities существуют в базе данных
                ],
                'price' => 'required|numeric',
                'photos' => 'nullable|array',
                'featured' => 'boolean',
            ]));
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $validatedData = $validator->validated();
            $room = Room::create($validatedData);
    
            return response()->json($room, 201);

    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'dimensions' => 'required|json',
            'amenities' => [
                'nullable',
                'array',
                Rule::in(Amenity::pluck('name')->toArray()),
            ],
            'price' => 'required|numeric',
            'photos' => 'nullable|array',
            'featured' => 'boolean',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        
        try {
            $room = Room::findOrFail($id);
            } catch (\Exception $e) {
                return response()->json(['errors'=> "Элемента по данному id не существует"],404);
            }
        $room->update($validator->validated());
    
        return response()->json($room, 200);
    }

    public function delete($id)
    {
        try {
        $room = Room::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['errors'=> "Элемента по данному id не существует"],404);
        }
        $room->delete();

        return response()->json(["message"=>"Удалено"], 200);
    }

}
