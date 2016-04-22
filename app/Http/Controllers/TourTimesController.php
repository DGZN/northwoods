<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TourTime;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TourTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Display tour time schedule for date resourece.
     *
     * @return \Illuminate\Http\Response
     */
    public function schedule()
    {
        if ( Input::has('date') ) {

            return (new \App\ReservationSchedule)->availableTimes(Input::get('date'));

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has(['start-time', 'end-time', 'tierID'])) {
          $tour = (new TourTime)->fill([
            'name' => $request->get('start-time') . ' ' . $request->get('end-time'),
            'tierID' => $request->get('tierID')
          ]);
          $tour->save();
          return $tour;

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return TourTime::destroy($id);
    }
}
