<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function show($filename)
    {
        
        $path = public_path('images/' . $filename);

        
        if (!file_exists($path)) {
            return response()->json(['message' => 'Изображения не существует'], Response::HTTP_NOT_FOUND);
        }

        
        return response()->file($path);
    }
}