<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Booking;

class MyBookingController extends Controller
{
    public function show()
    {
        $id = Auth::id();

        $pageTitle = 'My Bookings';

        $pageHeader = 'My Booking';

        $pageSubHeader = 'all my bookings view';

        $bookings = Booking::with('user','room')->where('booked_by','=',$id)->get();

      //  return $bookings;
        return view('dashboard.user_profile',compact('bookings', 'pageTitle','pageHeader','pageSubHeader'));
    }
}
