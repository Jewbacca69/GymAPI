<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class WithinWorkingHours implements ValidationRule
{
    protected $workingHours;

    public function __construct($workingHours)
    {
        $this->workingHours = $workingHours;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */

    public function validate(string $attribute, $value, Closure $fail): void
    {
        list($start, $end) = explode('-', $this->workingHours);

        $startTime = Carbon::createFromFormat('H:i', $start)->format('H:i');
        $endTime = Carbon::createFromFormat('H:i', $end)->format('H:i');

        $reservationDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $value);

        $reservationTime = $reservationDateTime->format('H:i');

        if ($reservationTime < $startTime || $reservationTime > $endTime) {
            $fail("The reservation time must be within the gym's working hours.");
        }
    }
}
