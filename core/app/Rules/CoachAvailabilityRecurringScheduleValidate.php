<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CoachAvailabilityRecurringScheduleValidate implements Rule
{
    public $from_date;
    public $to_date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
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
        $date_diff = date_diff(date_create($this->from_date), date_create($this->to_date))->format('%R%a');
        if($date_diff > 7 && empty(array_filter($value))) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The recurring days are required when availability date range is more than 7 days.';
    }
}
