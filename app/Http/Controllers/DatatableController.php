<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Enumerations\BookingStatus;
use App\Role;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class DatatableController
 */
class DatatableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * DatatableController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get room data for room datatables
     *
     * @return mixed
     */
    public function getRooms()
    {
        $rooms = Room::all();
        return DataTables::of($rooms)
            ->addColumn('action', function ($room) {
                $viewText = __('View');
                $editText = __('Edit');
                $deleteText = __('Delete');

                $viewUrl = route('rooms.show', ['id' => $room->id]);
                $editUrl = route('rooms.edit', ['id' => $room->id]);
                $deleteUrl = route('rooms.destroy', ['id' => $room->id]);

                $actionBtn = [];
                $viewBtn = '<a class="btn btn-primary btn-xs" href="'. $viewUrl .'"><span class="glyphicon glyphicon-search"></span> '.$viewText.'</a>';
                $editBtn = '<a class="btn btn-default btn-xs" href="'. $editUrl .'"><span class="glyphicon glyphicon-edit"></span> '.$editText.'</a>';
                $deleteBtn = '<button class="btn btn-default btn-xs btn-delete" data-name="'.$room->name.'" data-remote="'. $deleteUrl .'"><span class="glyphicon glyphicon-trash"></span> '.$deleteText.'</button>';

                $actionBtn[] = auth()->user()->canReadRoom() ? $viewBtn : '';
                $actionBtn[] = auth()->user()->canUpdateRoom() ? $editBtn : '';
                $actionBtn[] = auth()->user()->canDeleteRoom() ? $deleteBtn : '';

                return implode(' ', $actionBtn);
            })
            ->make(true);
    }

    /**
     * Get all booking based on user access
     *
     * TODO filter data based on user
     * @return mixed
     */
    public function getBookings()
    {
        $user = auth()->user();

        $bookings = $user->hasRole('superadmin|admin') ?
            Booking::withTrashed()->get() : Booking::where('booked_by', '=', $user->id)->withTrashed()->get();
        return DataTables::of($bookings)
            ->addColumn('room_name', function ($booking) {
                return $booking->room->name;
            })
            ->removeColumn('room_id')
            ->editColumn('booked_by', function ($booking) {
                return $booking->user->name;
            })
            ->editColumn('start_date', function ($booking) {
                return isset($booking->start_date) ?
                    $booking->start_date->format(Booking::DATE_FORMAT) : '';
            })
            ->editColumn('end_date', function ($booking) {
                return isset($booking->end_date) ?
                    $booking->end_date->format(Booking::DATE_FORMAT) : '';
            })
            ->addColumn('duration', function ($booking) {
                return $booking->getDuration();
            })
            ->editColumn('status', function ($booking) {
                return $booking->getStatusTextualRepresentation();
            })
            ->addColumn('action', function ($booking) {
                $editText = __('Edit');
                $cancelText = __('Cancel');

                $editUrl = route('bookings.edit', ['id' => $booking->id]);
                $deleteUrl = route('bookings.destroy', ['id' => $booking->id]);

                $editBtn = '<a class="btn btn-primary btn-xs" href="'. $editUrl .'"><span class="glyphicon glyphicon-edit"></span> '.$editText.'</a>';
                $cancelBtn = '<button class="btn btn-danger btn-xs btn-delete" data-remote="'. $deleteUrl .'"><span class="glyphicon glyphicon-remove"></span> '.$cancelText.'</button>';

                $actionBtn = $booking->status === BookingStatus::OPTION ? $cancelBtn . $editBtn: '';
                return auth()->user()->canDeleteBooking() ? $actionBtn : '';
            })
            ->make(true);
    }

    /**
     * Get all users
     *
     * @return mixed
     */
    public function getUsers()
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole(['superadmin', 'admin'])) {
            $users = User::all();
            return DataTables::of($users)
                ->editColumn('created_at', function($user){
                    return $user->created_at->format(User::CREATED_AT_DATE_FORMAT);
                })
                ->addColumn('action', function ($user) {
                    $editText = __('Edit');
                    $deleteText = __('Delete');

                    $editUrl = route('users.edit', ['id' => $user->id]);
                    $deleteUrl = route('users.destroy', ['id' => $user->id]);

                    $actionBtn = [];
                    $editBtn = '<a class="btn btn-primary btn-xs" href="'. $editUrl .'"><span class="glyphicon glyphicon-edit"></span> '.$editText.'</a>';
                    $deleteBtn = '<button class="btn btn-default btn-xs btn-delete" data-name="'.$user->name.'" data-remote="'. $deleteUrl .'"><span class="glyphicon glyphicon-trash"></span> '.$deleteText.'</button>';

                    $actionBtn[] = auth()->user()->canUpdateUser() ? $editBtn : '';
                    $actionBtn[] = auth()->user()->canDeleteUser() ? $deleteBtn : '';

                    return implode(' ', $actionBtn);
                })
                ->make(true);
        }
    }

    /**
     * Get all roles
     *
     * @return mixed
     */
    public function getRoles()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            $roles = Role::all();
            return DataTables::of($roles)
                ->addColumn('action', function ($role) {
                    $editText = __('Edit');
                    $deleteText = __('Delete');

                    $editUrl = route('security.edit', ['id' => $role->name]);
                    $deleteUrl = route('security.destroy', ['id' => $role->id]);

                    $actionBtn = [];
                    $editBtn = '<a class="btn btn-primary btn-xs" href="'. $editUrl .'"><span class="glyphicon glyphicon-edit"></span> '.$editText.'</a>';
                    $deleteBtn = '<button class="btn btn-default btn-xs btn-delete" data-name="'.$role->name.'" data-remote="'. $deleteUrl .'"><span class="glyphicon glyphicon-trash"></span> '.$deleteText.'</button>';

                    $actionBtn[] = auth()->user()->canUpdateUser() ? $editBtn : '';
                    $actionBtn[] = auth()->user()->canDeleteUser() ? $deleteBtn : '';

                    return implode(' ', $actionBtn);
                })
                ->make(true);
        }
    }
}
