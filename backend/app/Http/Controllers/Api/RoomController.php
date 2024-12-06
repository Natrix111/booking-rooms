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
            $validator = Validator::make($request->all(),([
                'name' => 'required|string',
                'width' => 'required|integer|min:1',
                'height' => 'required|integer|min:1',
                'length' => 'required|integer|min:1',
                'amenities' => [
                    'nullable',
                    'array',
                    Rule::in(Amenity::pluck('name')->toArray()), // Гарантирует, что значения из amenities существуют в базе данных
                ],
                'price' => 'required|numeric',
                'photos' => 'nullable|array|max:5',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'featured' => 'boolean',
            ]));
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $validatedData = $validator->validated();
            $validatedData['dimensions'] = json_encode([$validatedData['width'], $validatedData['height'], $validatedData['length']]);

            if ($request->hasFile('photos')) {
                $images = [];
                foreach ($request->file('photos') as $photo) {
                    $imgName = uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('images/room'), $imgName);


                    $images[] = 'images/room/' . $imgName;
                }

                $validatedData['photos'] = json_encode($images);
            } else {
                $validatedData['photos'] = json_encode([]);
            }


            $room = Room::create($validatedData);

            return response()->json($room, 201);



    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'length' => 'required|integer|min:1',
            'amenities' => [
                'nullable',
                'array',
                Rule::in(Amenity::pluck('name')->toArray()),
            ],
            'price' => 'required|numeric',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $validatedData = $validator->validated();

            $validatedData['dimensions'] = json_encode([$validatedData['width'], $validatedData['height'], $validatedData['length']]);
            if ($request->hasFile('photos')) {
                $images = [];
                foreach ($request->file('photos') as $photo) {
                    $imgName = uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('images/room'), $imgName);


                    $images[] = 'images/room/' . $imgName;
                }

                $validatedData['photos'] = json_encode($images);
            } else {
                $validatedData['photos'] = json_encode([]);
            }

            $room->update($validatedData);

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
