<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Predis;

use App\Booking;
use App\BookingOptional;
use App\Optional;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingOptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'New Optional';
        $pageHeader = 'New Optional';
        return view('dashboard.add_new_optional',compact('pageTitle','pageHeader'));
    }


    public function storenewoptional(Request $request)
    {
        $test = $request->all();

        $data = Optional::create([
           'nome' => $request->nome,
           'column_name' => strtolower(str_replace(" ", "_", $request->nome)),
           'prezzo_per_unita' => $request->prezzo_per_unita,
           'updated_at' => null,
           'created_at' => null
        ]);

            Schema::table('booking_optionals',
                function (Blueprint $table) use ($test)
                {
                    $table->integer(strtolower(str_replace(" ", "_", $test['nome'])))->nullable();
                }
            );

    }

    public function optionalcreate($id)
    {
        $optionals = Optional::all();

        $booking_id = $id;

        $pageTitle = 'New Optional';

        $pageHeader = 'New Optional';

        return view('dashboard.optional_booking', compact('optionals','booking_id','pageTitle','pageHeader'));
    }


    public function store(Request $request)
    {
        $optional = new BookingOptional();

        $optional->booking_id = $request->booking_id;

        $booking = Booking::findOrFail($request->booking_id);

        $end = strtotime($booking->end_date);

        $start = strtotime($booking->start_date);

        $time = $end - $start;

       $test =  explode('.',$time/86400);

       if($time>=86400){
           $num_day = $test[0]+1;

       }else {
           $num_day = 1;
       };

        $optional->coffee_break = $this->coffee_break($request->coffee_break);
        $optional->quick_lunch = $request->quick_lunch;
        $optional->videoproiettore = $this->videoproiettore($request->videoproiettore);
        $optional->wifi = $this->wifi($request->wifi);
        $optional->videoconferenza = $this->videoconferenza($request->videoconferenza);
        $optional->webconference = $this->webconference($request->webconference);
        $optional->lavagna_foglimobili = $this->lavagna_foglimobili($request->lavagna_foglimobili);
        $optional->stampante = $this->stampante($request->stampante,$num_day);
        $optional->upgrade_banda10mb = $this->upgrade_banda10mb($request->upgrade_banda10mb);
        $optional->wirless_4mb20accessi = $this->wirless_4mb20accessi($request->wirless_4mb20accessi);
        $optional->wirless_8mb35accessi = $this->wirless_8mb35accessi($request->wirless_8mb35accessi);
        $optional->wirless_10mb50accessi = $this->wirless_10mb50accessi($request->wirless_10mb50accessi);
        $optional->videoregistrazione = $this->videoregistrazione($request->videoregistrazione,$num_day);
        $optional->lavagna_interattiva = $this->lavagna_interattiva($request->lavagna_interattiva,$num_day);


        $optional->save();

        return redirect('/dashboard/bookings');
    }


    public function show(BookingOptional $bookingOptional)
    {
        //
    }


    public function edit($id)
    {
        $bookingOptionals = BookingOptional::where('booking_id','=',$id)->get();

       // return $bookingOptionals;
        $optionals = Optional::all();
        $pageTitle = 'Optional Edit';
        $pageHeader = 'Optional Edit';
     //   return $bookingOptionals;
        return view('dashboard.optional_booking_edit',compact('bookingOptionals','optionals','pageHeader','pageTitle'));
    }


    public function update(Request $request, $id)
    {
        $bookingOptional = BookingOptional::find($id);

        $booking = Booking::find($bookingOptional->booking_id);

        $end = strtotime($booking->end_date);

        $start = strtotime($booking->start_date);

        $time = $end - $start;

        $test =  explode('.',$time/86400);

        if($time>=86400){
            $num_day = $test[0]+1;

        }else {
            $num_day = 1;
        };

         //return $num_day;

        $bookingOptional->coffee_break = $this->coffee_break($request->coffee_break);
        $bookingOptional->quick_lunch = $request->quick_lunch;
        $bookingOptional->videoproiettore = $this->videoproiettore($request->videoproiettore);
        $bookingOptional->wifi = $this->wifi($request->wifi);
        $bookingOptional->videoconferenza = $this->videoconferenza($request->videoconferenza);
        $bookingOptional->webconference = $this->webconference($request->webconference);
        $bookingOptional->lavagna_foglimobili = $this->lavagna_foglimobili($request->lavagna_foglimobili);
        $bookingOptional->stampante = $this->stampante($request->stampante,$num_day);
        $bookingOptional->upgrade_banda10mb = $this->upgrade_banda10mb($request->upgrade_banda10mb);
        $bookingOptional->wirless_4mb20accessi = $this->wirless_4mb20accessi($request->wirless_4mb20accessi);
        $bookingOptional->wirless_8mb35accessi = $this->wirless_8mb35accessi($request->wirless_8mb35accessi);
        $bookingOptional->wirless_10mb50accessi = $this->wirless_10mb50accessi($request->wirless_10mb50accessi);
        $bookingOptional->videoregistrazione = $this->videoregistrazione($request->videoregistrazione);
        $bookingOptional->lavagna_interattiva = $this->lavagna_interattiva($request->lavagna_interattiva);

        $bookingOptional->save();

        return redirect('/dashboard/bookings');
    }


    public function destroy(BookingOptional $bookingOptional)
    {
        //
    }

    public function coffee_break($num)
    {
        $dati =  Optional::where('column_name','=','coffee_break')->get();

        foreach($dati as $data){
            $prezzo = $data->prezzo_per_unita;
        }

        $price = $prezzo*$num;
        return $price;
    }

    public function videoproiettore($num)
    {
        $price = $num*50;
        return $price;
    }

    public function wifi($num)
    {
        if($num<51){
            $price = $num*5;
            return $price;
        } else{
            dd('n. max 50 utenti');
        }

    }

    public function videoconferenza($num)
    {
        if($num == 1){
            $price = 60;
            return $price;
        }else {
            $price=null;
        }

    }

    public function webconference($num)
    {
        if($num == 1){
            $price = 50;
            return $price;
        }else {
           $price = null;
        }
    }

    public function lavagna_foglimobili($day)
    {
        $price = $day*8;
        return $price;
    }

    public function stampante($num_stampanti,$num_day)
    {
        if($num_stampanti<6){
            $price = $num_stampanti*$num_day*30;
            return $price;
        } else{
            dd('max 5 stampanti');
        }
    }

    public function upgrade_banda10mb($num)
    {
        $price = $num*150;
        return $price;
    }

    public function upgrade_banda8mb($num)
    {
        $price = $num*100;
        return $price;
    }

    public function upgrade_banda20mb($num)
    {
        $price = $num*200;
        return $price;
    }

    public function wirless_4mb20accessi($num)
    {
        $price = $num*100;
        return $price;
    }

    public function wirless_8mb35accessi($num)
    {
        $price = $num*150;
        return $price;
    }

    public function wirless_10mb50accessi($num)
    {
        $price = $num*200;
        return $price;
    }

    public function videoregistrazione($num_day)
    {
        $price = $num_day*30;
        return $price;
    }

    public function lavagna_interattiva($num_day)
    {
        $price = $num_day*50;
        return $price;
    }


}
