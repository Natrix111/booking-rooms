<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    public function index()
    {
        return Amenity::all();
    }
    public function create(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $amenity = new Amenity();

        if ($request->hasFile('img')) {
            $image = $request->file('img');
           
            $imgName = uniqid().'.'.$image->getClientOriginalExtension(); 
            
            $image->move(public_path('images'), $imgName);

             
            
            $amenity->img = 'images/' . $imgName;
        }

        $amenity->name = $request->input('name');
        $amenity->save();
    
        return response()->json($amenity, 201);
    }

    public function update(Request $request, $id)
    {
        //Метод PUT в postman не отправляет formdata, поэтому вообще хз как реализовывать смену картинки
        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        try {
            $amenity = Amenity::findOrFail($id);
            } catch (\Exception $e) {
                return response()->json(['errors'=> "Элемента по данному id не существует"],404);
            }

    
        if ($request->has('name')) {
            $amenity->name = $request->input('name');
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
