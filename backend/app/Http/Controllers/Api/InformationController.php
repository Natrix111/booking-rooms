<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Information::all();
    }
    public function update(Request $request)
    {
        
        $request->validate([
            'title' => 'nullable|string|max:30',
            'slogan' => 'nullable|string',
            'city' => 'nullable|string|max:50',
        ]);
        
        
        $information = Information::first();

        
        if ($request->has('title')) {
            $information->title = $request->input('title');
        }
        if ($request->has('slogan')) {
            $information->slogan = $request->input('slogan');
        }
        if ($request->has('city')) {
            $information->city = $request->input('city');
        }

        
        $information->save();

        return response()->json($information);
    }
}
