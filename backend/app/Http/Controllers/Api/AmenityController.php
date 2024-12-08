<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AmenityRequest;

class AmenityController extends Controller
{
    public function index()
    {
        return Amenity::all();
    }
    public function create(AmenityRequest $request)
    {

        $amenity = new Amenity();

        if ($request->hasFile('img')) {

            $image = $request->file('img');

            $imgName = uniqid().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('images/amenity'), $imgName);



            $amenity->img = 'images/amenity/' . $imgName;
        }


        $amenity->name = $request->input('name');
        $amenity->save();

        return response()->json($amenity, 201);
    }

    public function update(AmenityRequest $request, $id)
    {


        $amenity = Amenity::findOrFail($id);


        if ($request->has('name')) {
            $amenity->name = $request->input('name');
        }

        if ($request->hasFile('img')) {
            if ($amenity->img) {
                $oldImagePath = public_path($amenity->img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('img');
            $imgName = uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/amenity'), $imgName);
            $amenity->img = 'images/amenity/' . $imgName;
        }

        $amenity->save();

        return response()->json($amenity, 200);
    }

    public function delete($id)
    {
        try {
        $amenity = Amenity::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['errors'=> "Элемента по данному id не существует"],404);
        }
        $amenity->delete();

        return response()->json("Удалено", 200);
    }

}
