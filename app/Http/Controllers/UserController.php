<?php

namespace App\Http\Controllers;

use App\Enumerations\UserStatus;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\User;
use App\Booking;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 */
class UserController extends Controller
{
    private $data;

    /**
     * RoomController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('role:superadmin|admin');

        $this->data = [
            'pageTitle' => __('User Management'),
            'pageHeader' => __('User Management'),
            'pageSubHeader' => __('Manage users here')
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.user-management', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUser $request)
    {
        $data = $request->all();

        $data['status'] = UserStatus::ACTIVE;
        $roleId = $data['role'];
        $data['password'] = bcrypt($data['password']);

        unset($data['role']);

        $user = User::create($data);
        $user->syncRoles([$roleId]);

        return response()->json([
            'message' => __('User :name is successfully saved!', ['name' => $user->name])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'My Bookings';

        $pageHeader = 'My Booking';

        $pageSubHeader = 'all my bookings view';

        $bookings = Booking::with('user','room')->where('booked_by','=',$id)->get();

        return view('dashboard.user_profile',compact('bookings', 'pageTitle','pageHeader','pageSubHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->checkAbilityToUpdateSelectedUser($id)) {
            $message = __('You have no authorization to perform this action.');
            abort(403, $message);
        }
        $this->data['user'] = User::findOrFail($id);
        return view('dashboard.user-edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request, $id)
    {
        $data = $request->all();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $roleId = $data['role'];
        unset($data['role']);

        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();

        $user->syncRoles([$roleId]);

        return response()->json([
            'message' => __('User :name is successfully updated!', ['name' => $data['name']])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->canDeleteUser()) {
            return response()->json([
                'message' => __('You have no authorization to perform this action.')
            ], 403);
        }

        if (Auth::user()->id == $id) {
            return response()->json([
                'message' => __('You cannot delete yourself.')
            ], 422);
        }

        if (User::find($id)->hasRole('superadmin')) {
            return response()->json([
                'message' => __('You cannot delete superadmin.')
            ], 422);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => __(':name is successfully deleted!', ['name' => $user->name])
        ]);
    }

}
