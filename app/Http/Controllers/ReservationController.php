<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Reservation;
use App\Transaction;
use App\Http\Requests;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new Reservation)->all();
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
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create($request->all());
        $reservation->schedule()->create([
          'date' => $request->get('date'),
          'tourTimeID' => $request->get('tourTimeID'),
        ]);
        return $reservation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Reservation::findOrFail($id)->relations();
    }

    /**
     * Display the specified resource on date.
     *
     * @param  int  $date
     * @return \Illuminate\Http\Response
     */
    public function byDate($date)
    {
        return Reservation::byDate($date);
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
        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        if ( $request->has('tourTimeID') ) {

          $reservation->schedule->update($request->all());
          $reservation->group->update($request->all());

        }

        if ($reservation) {

            return ['status' => true, 'message' => 'Updated'];

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (new Reservation)->findOrFail($id)->delete();
    }
}
