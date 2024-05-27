<?php

namespace App\Http\Controllers;

use App\Http\Resources\Reservation\TransferReservationResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use App\Models\TransferReservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function driverInformation($reservation_code)
    {
        $driver = TransferReservation::with('driver')->where('reservation_code', $reservation_code)->first();
        return (new TransferReservationResource($driver))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    public function changePickupSchedule(Request $request, $reservation_code)
    {
        $request->validate([
            'pickup_time' => ['required', 'date_format:H:i']
        ]);

        $reservation = Reservation::where('reservation_code', $reservation_code)->first();
        
        $transfer = TransferReservation::where('reservation_code', $reservation_code)->update([
            'pickup_time' => $request->pickup_time
        ]);

        return (new ReservationResource($reservation->loadMissing('guest', 'transfer')))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    public function reschedule(Request $request, $reservation_code)
    {
        $request->validate([
            'reservation_date' => ['required', 'date_format:Y-m-d']
        ]);

        $reservation = Reservation::where('reservation_code', $reservation_code)->update([
            'reservation_date' => $request->reservation_date
        ]);

        $reservation = Reservation::where('reservation_code', $reservation_code)->first();

        return (new ReservationResource($reservation))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }
}
