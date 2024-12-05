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
        $rooms = $this->roomFilterService
            ->applyFilters($request)
            ->with('amenities')
            ->get();

        $rooms = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'dimensions' => $room->dimensions,
                'price' => $room->price,
                'photos' => $room->photos,
                'featured' => $room->featured,
                'amenities' => $room->amenities->map(function ($amenity) {
                    return [
                        'name' => $amenity->name,
                        'img' => $amenity->img,
                    ];
                }),
            ];
        });

        return response()->json($rooms);
    }


    public function filters()
    {
        $minPrice = Room::min('price');
        $maxPrice = Room::max('price');

        $areas = Room::all()
            ->map(function ($room) {
                return $room->getSquare();
            })
            ->unique()
            ->sort()
            ->values();

        $amenities = Amenity::pluck('name')->unique()->values();

        return response()->json([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'amenities' => $amenities,
            'areas' => $areas,
        ]);
    }

    public function show($id)
    {
        $room = Room::with('amenities')->findOrFail($id);

        $otherRooms = Room::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json([
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'dimensions' => $room->dimensions,
                'area' => $room->area,
                'price' => $room->price,
                'photos' => $room->photos,
                'featured' => $room->featured,
                'amenities' => $room->amenities->map(function ($amenity) {
                    return [
                        'name' => $amenity->name,
                        'icon' => $amenity->img,
                    ];
                }),
            ],
            'otherRooms' => $otherRooms,
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
