<?php

namespace App\Http\Controllers;

use App\Http\Resources\Reservation\TransferReservationResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Mail\SendDriverInfoPickup;
use App\Mail\SendDriverInfoReschedule;
use App\Mail\SendNotificationPickup;
use App\Mail\SendNotificationReschedule;
use App\Models\Reservation;
use App\Models\TransferReservation;
use App\Rules\MinimumDaysRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        Mail::to($reservation->guest->email)->send(new SendNotificationPickup($reservation));
        Mail::to($reservation->transfer->driver->email)->send(new SendDriverInfoPickup($reservation));

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

        if (Carbon::parse($request->reservation_date) < now()) {
            return response()->json([
                'message' => 'The reservation date field must be a date after now.',
                'status' => false
            ])->setStatusCode(500);
        }
        $reservation = Reservation::where('reservation_code', $reservation_code)->update([
            'reservation_date' => $request->reservation_date
        ]);

        $reservation = Reservation::where('reservation_code', $reservation_code)->first();

        Mail::to($reservation->guest->email)->send(new SendNotificationReschedule($reservation));
        Mail::to($reservation->transfer->driver->email)->send(new SendDriverInfoReschedule($reservation));

        return (new ReservationResource($reservation))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    function mailingTester($reservation_code) {
        $reservation = Reservation::where('reservation_code', $reservation_code)->first();

        $mail = Mail::to($reservation->guest->email)->send(new SendNotificationReschedule($reservation));

        if (!$mail) {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => "success"
        ]);
    }
}
