<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getRandomReviews() {
        return Review::inRandomOrder()->limit(5)->get();
    }
}
