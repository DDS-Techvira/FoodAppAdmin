<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\CoachAvailabilityModel;

class CoachAvailabilityDateRangeOverlap implements Rule
{
    public $coach_code;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($coach_code)
    {
        //
        $this->coach_code = $coach_code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 
        return ! CoachAvailabilityModel::whereDate('from_date', '<=', $value)
                                    ->whereDate('to_date', '>=', $value)->where('coach_code', $this->coach_code)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute could not be overlap woth existing schedules.';
    }
}
