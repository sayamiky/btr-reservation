<?php

namespace App\Rules;

use App\Models\Reservation;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinimumDaysRule implements ValidationRule
{

    public function __construct(public $reservationCode)
    {
        //
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $inputDate = Carbon::parse($value);
        $rsv = Reservation::where('reservation_code', $this->reservationCode)->first();
        $reservationDate = Carbon::parse($rsv->reservation_date)->format('Y-m-d');
        
        if (!$inputDate->diffInDays($reservationDate) >= 3) {
            $fail("Reschedule should be done before H-3 reservation date");
        }
    }
}
