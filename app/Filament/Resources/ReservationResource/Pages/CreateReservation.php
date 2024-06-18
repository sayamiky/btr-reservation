<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\DetailReservation;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create(array_merge($data, [
            'reservation_code' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10),
        ]));

        foreach ($data['reservation_details'] as $detail) {
            $price = Product::find($detail['product_id'])->first()->price;
            $file = new DetailReservation();
            $file->reservation_code = $record->reservation_code;
            $file->product_id = $detail['product_id'];
            $file->pax_type = $detail['pax_type'];
            $file->price = $price;
            // $file->discount = $detail['discount'];
            $file->qty = $detail['qty'];
            $file->total = $detail['qty'] * $price;
            $file->save();
        }

        $record->update([
            'invoice_code' => "INV/" . now()->format('Ymd') . "/BTR/" . $record->id,
            'total' => $record->detail->sum('total'),
            'original_date' => $record->reservation_date 
            // + $transfer
        ]);

        return $record;
    }
}
