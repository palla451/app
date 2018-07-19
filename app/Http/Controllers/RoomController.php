<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoom;
use App\Http\Requests\UpdateRoom;
use App\Price;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class RoomController
 */
class RoomController extends Controller
{
    private $data;

    /**
     * RoomController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('permission:create-room|read-room|update-room|delete-room');

        $this->data = [
            'pageTitle' => __('Room Management'),
            'pageHeader' => __('Room Management'),
            'pageSubHeader' => __('Manage your rooms here')
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.room-management', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoom $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoom $request)
    {

        $data = $request->all();

        if($data['location']=='Eur'){
            $data['location_id']=1;
        }elseif ($request['location']=='Boezio'){
            $data['location_id']=2;
        } else{
            $data['location_id']=3;
        }


      //  return $data;
      //  $data = $request->all();

        $room = Room::create($data);

        $price1 = Price::create([
            'price_id' => $room->id,
            'room_id'  => $room->id,
            'price'    => $data['price1'],
            'duration' => 1,
        ]);

        $price2 = Price::create([
            'price_id' => $room->id,
            'room_id'  => $room->id,
            'price'    => $data['price2'],
            'duration' => 2,
        ]);

        $price3 = Price::create([
            'price_id' => $room->id,
            'room_id'  => $room->id,
            'price'    => $data['price3'],
            'duration' => 3,
        ]);

        $price4 = Price::create([
            'price_id' => $room->id,
            'room_id'  => $room->id,
            'price'    => $data['price4'],
            'duration' => 4,
        ]);

        $price8 = Price::create([
            'price_id' => $room->id,
            'room_id'  => $room->id,
            'price'    => $data['price8'],
            'duration' => 8,
        ]);

        return response()->json([
            'message' => __('Room :name is successfully saved!', ['name' => $data['name']])
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
        $this->data['room'] = Room::findOrFail($id);

        return view('dashboard.room-show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->canUpdateRoom()) {
            return response()->json([
                'message' => __('You have no authorization to perform this action.')
            ], 403);
        }

        $this->data['room'] = Room::findOrFail($id);
        return view('dashboard.room-edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoom $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoom $request, $id)
    {
        $data = $request->all();
        $room = Room::findOrFail($id);
        $room->fill($data);
        $room->save();

        return response()->json([
            'message' => __('Room :name is successfully updated!', ['name' => $data['name']])
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
        if (!auth()->user()->canDeleteRoom()) {
            return response()->json([
                'message' => __('You have no authorization to perform this action.')
            ], 403);
        }

        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json([
            'message' => __(':name is successfully deleted!', ['name' => $room->name])
        ]);
    }

}
