<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query();

        if ($request->has('room_id')) {
            $query->where('room_id', $request->input('room_id'));
        }

        $bookings = $query->with('room')->paginate(10); 

        return response()->json($bookings, 200);
    }

    
    public function approve($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            } catch (\Exception $e) {
                return response()->json(['errors'=> "Элемента по данному id не существует"],404);
            }
        
        $booking->approved = true;
        $booking->save();

        return response()->json(['message' => 'Заявка одобрена!'], 200);
    }

    
    public function destroy($id)
    {   
        try {
            $booking = Booking::findOrFail($id);
            } catch (\Exception $e) {
                return response()->json(['errors'=> "Элемента по данному id не существует"],404);
            }
       
        $booking->delete();

        return response()->json(['message' => 'Заявка удалена!'], 200);
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


    public function userdelete($id)
    {
        try{
            $booking = Booking::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['errors'=> "Элемента по данному id не существует"],404);
        }
        
        if (!$booking->approved && $booking->user_id==Auth::id()) {
            $booking->delete();
            return response()->json(['message' => 'Бронирование удалено!'], 200);
        }

        return response()->json(['message' => 'Нельзя удалить одобренное или чужое бронирование!'], 403);
    }
}