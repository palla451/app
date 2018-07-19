<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class LocationController extends Controller
{
        public function index()
        {
            $rooms = Room::with('location')->get();

            return $rooms;
        }
}
