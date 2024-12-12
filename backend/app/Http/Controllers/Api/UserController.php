<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with('room')->get(); 
    
        
        $formattedBookings = $bookings->map(function ($booking) {
            return [
                'booking_id' => $booking->id,
                'room' => $booking->room->name, 
                'pets' => json_decode($booking->pets),
                'check_in' => Carbon::parse($booking->check_in)->format('Y-m-d'), 
                'check_out' => Carbon::parse($booking->check_out)->format('Y-m-d'), 
                'approved' => $booking->approved,
            ];
        });
    
        return response()->json([
            'user' => $user,
            'bookings' => $formattedBookings
        ], 200);
    }

}
