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
            
            $image->move(public_path('images/amenity'), $imgName);

             
            
            $amenity->img = 'images/amenity/' . $imgName;
        }


        $amenity->name = $request->input('name');
        $amenity->save();
    
        return response()->json($amenity, 201);
    }

    public function update(Request $request, $id)
    {
  
        // Найдите существующий объект Amenity по его ID
        $amenity = Amenity::findOrFail($id);
        
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string', // Поле name можно обновить или оставить пустым
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Поле img тоже является необязательным
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Обновите имя, если оно присутствует в запросе
        if ($request->has('name')) {
            $amenity->name = $request->input('name');
        }
    
        // Проверка и загрузка нового изображения
        if ($request->hasFile('img')) {
            // Удалите старое изображение, если необходимо
            if ($amenity->img) {
                $oldImagePath = public_path($amenity->img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Удаление старого изображения
                }
            }
    
            $image = $request->file('img');
            $imgName = uniqid() . '.' . $image->getClientOriginalExtension();
    
            $image->move(public_path('images/amenity'), $imgName);
            $amenity->img = 'images/amenity/' . $imgName; // Обновление пути к новому изображению
        }
    
        // Сохраните изменения в базе данных
        $amenity->save();
    
        // Верните обновленный объект
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
