<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(){
        return Booking::all();
    }
    public function store(BookingRequest $request)
    {
        $existingBookings = Booking::where('room_id', $request->room_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
            })
            ->exists();

        if ($existingBookings) {
            return response()->json(['message' => 'Выбранный промежуток дат уже занят.'], 409);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(), 
            'room_id' => $request->room_id,
            'check_in' => Carbon::parse($request->check_in), 
            'check_out' => Carbon::parse($request->check_out),
            'approved' => false,
            'pets' => json_encode($request->pets), 
        ]);

        
        return response()->json(['message' => 'Бронь успешно создана!', 'booking' => $booking], 201);
    }
}