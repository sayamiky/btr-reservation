<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\DetailReservation;
use App\Models\TransferReservation;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        $record =  static::getModel()::create(array_merge($data, [
            'reservation_code' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5),
        ]));

        $record->update([
            'invoice_code' => "INV/" . now()->format('Ymd') . "/BTR/".$record->id,
        ]);

        //     // Create a new Guardian model instance
        //     foreach ($details as $detail) {
        //         $file = new DetailReservation();
        //         $file->reservation_code = $record->reservation_id;
        //         $file->product_id = $detail->product_id;
        //         $file->pax_type = $detail->pax_type;
        //         $file->price = $detail->price;
        //         $file->discount = $detail->discount;
        //         $file->qty = $detail->qty;
        //         $file->total = $detail->qty* $detail->price;
        //         $file->save();
        //     }

        //     $file = new TransferReservation();
        //     $file->reservation_code = $record->reservation_id;
        //     $file->driver_id = $data['driver_id'];
        //     $file->pickup_location = $data['pickup_location'];
        //     $file->pickup_time = $data['pickup_time'];
        //     $file->dropoff_location = $data['dropoff_location'];
        //     $file->distance = $data['distance'];
        //     $file->price = $data['price'];
        //     $file->note = $data['note'];
        //     $file->save();

        return $record;
    }
}
