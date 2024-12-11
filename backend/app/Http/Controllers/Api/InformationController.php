<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Http\Requests\UpdateInformationRequest;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Information::all();
    }
    public function update(UpdateInformationRequest $request)
    { 
        $information = Information::first(); 

        $information->fill($request->only([
            'title',
            'slogan',
            'city',
        ]));

        $information->save();

        return response()->json($information);
    }
}
