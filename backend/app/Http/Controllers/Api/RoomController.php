<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\RoomFilterService;
use Illuminate\Http\Request;
use App\Models\Amenity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\RoomRequest;

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
                'area' => $room->getSquare(),
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
            ->with('amenities')
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($room) {
                $room->area = $room->getSquare();

                return $room;
            });


        return response()->json([
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'dimensions' => $room->dimensions,
                'area' => $room->getSquare(),
                'price' => $room->price,
                'photos' => $room->photos,
                'featured' => $room->featured,
                'amenities' => $room->amenities->map(function ($amenity) {
                    return [
                        'name' => $amenity->name,
                        'img' => $amenity->img,
                    ];
                }),
            ],
            'otherRooms' => $otherRooms,
        ]);
    }
    public function create(RoomRequest $request)
    {

        $validatedData = $request->validated();

        $validatedData['dimensions'] = [(int)$validatedData['width'], (int)$validatedData['height'], (int)$validatedData['length']];
        if ($request->hasFile('photos')) {
            $images = [];
            foreach ($request->file('photos') as $photo) {
                $imgName = uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('storage/rooms'), $imgName);


                $images[] = 'rooms/' . $imgName;
            }

            $validatedData['photos'] = $images;
        } else {
            $validatedData['photos'] = [];
        }


        $room = Room::create($validatedData);

        if (isset($validatedData['amenities'])) {
            $room->amenities()->attach($validatedData['amenities']);
        }
        return response()->json($room, 201);
    }
    public function update(RoomRequest $request, $id)
    {
        try {
            $room = Room::findOrFail($id);
            } catch (\Exception $e) {
                return response()->json(['errors'=> "Элемента по данному id не существует"],404);
            }
            $validatedData = $request->validated();
            $validatedData['dimensions'] = [(int)$validatedData['width'], (int)$validatedData['height'], (int)$validatedData['length']];
            if ($request->hasFile('photos')) {
                $images = [];
                foreach ($request->file('photos') as $photo) {
                    $imgName = uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('storage/rooms'), $imgName);


                    $images[] = 'images/room/' . $imgName;
                }

                $validatedData['photos'] = $images;
            } else {
                $validatedData['photos'] = [];
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
