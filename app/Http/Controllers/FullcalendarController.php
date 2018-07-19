<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Room;
use Illuminate\Http\Request;

/**
 * Class FullcalendarController
 */
class FullcalendarController extends Controller
{
    public static function getBookingByRoomId($id)
    {
        $booking = Booking::where('room_id', '=', $id)
                            ->orderBy('start_date')
                            ->get([
                                'booked_name',
                                'start_date',
                                'end_date',
                            ]);

        return $booking->map(function($event) {
            $booking['title'] = 'Booked by ' . $event->booked_name;
            $booking['start'] = $event->start_date->toDateTimeString();
            $booking['end'] = $event->end_date->toDateTimeString();
            return $booking;
        });
    }

    public static function getBookingAll()
    {
        $booking = Booking::orderBy('start_date')
            ->get([
                'id',
                'room_id',
                'booked_name',
                'start_date',
                'end_date',
            ]);

        return $booking->map(function($event) {
            $booking['id'] = (string)$event->room_id;
            $booking['resourceId'] = (string)$event->room_id;
            $booking['start'] = (string)$event->start_date->toDateTimeString();
            $booking['end'] = (string)$event->end_date->toDateTimeString();
            $booking['title'] = (string)$event->booked_name;
            return $booking;
        });
    }


    public static function getBookingEur()
    {
        $booking = Booking::orderBy('start_date')
            ->where('location_id','=','1')
            ->get([
                'id',
                'room_id',
                'booked_name',
                'start_date',
                'end_date',
            ]);

        return $booking->map(function($event) {
            $booking['id'] = (string)$event->room_id;
            $booking['resourceId'] = (string)$event->room_id;
            $booking['start'] = (string)$event->start_date->toDateTimeString();
            $booking['end'] = (string)$event->end_date->toDateTimeString();
            $booking['title'] = (string)$event->booked_name;
            return $booking;
        });
    }

    public static function getBookingBoezio()
    {
        $booking = Booking::orderBy('start_date')
            ->where('location_id','=','2')
            ->get([
                'id',
                'room_id',
                'booked_name',
                'start_date',
                'end_date',
            ]);

        return $booking->map(function($event) {
            $booking['id'] = (string)$event->room_id;
            $booking['resourceId'] = (string)$event->room_id;
            $booking['start'] = (string)$event->start_date->toDateTimeString();
            $booking['end'] = (string)$event->end_date->toDateTimeString();
            $booking['title'] = (string)$event->booked_name;
            return $booking;
        });
    }

    public static function getBookingRegolo()
    {
        $booking = Booking::orderBy('start_date')
            ->where('location_id','=','3')
            ->get([
                'id',
                'room_id',
                'booked_name',
                'start_date',
                'end_date',
            ]);

        return $booking->map(function($event) {
            $booking['id'] = (string)$event->room_id;
            $booking['resourceId'] = (string)$event->room_id;
            $booking['start'] = (string)$event->start_date->toDateTimeString();
            $booking['end'] = (string)$event->end_date->toDateTimeString();
            $booking['title'] = (string)$event->booked_name;
            return $booking;
        });
    }


    public static function getRoomAll()
    {
        $room = Room::all();

        return $room->map(function($event) {
            $room['id'] = (string)$event->id;
            $room['title'] = (string)$event->name;
            $room['eventColor'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            return $room;
        });
    }

    public static function getRoomEur()
    {
        $room = Room::where('location_id','=','1')->get();

        return $room->map(function($event) {
            $room['id'] = (string)$event->id;
            $room['title'] = (string)$event->name;
            $room['eventColor'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            return $room;
        });
    }

    public static function getRoomBoezio()
    {
        $room = Room::where('location_id','=','2')->get();

        return $room->map(function($event) {
            $room['id'] = (string)$event->id;
            $room['title'] = (string)$event->name;
            $room['eventColor'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            return $room;
        });
    }

    public static function getRoomRegolo()
    {
        $room = Room::where('location_id','=','3')->get();

        return $room->map(function($event) {
            $room['id'] = (string)$event->id;
            $room['title'] = (string)$event->name;
            $room['eventColor'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            return $room;
        });
    }


}
