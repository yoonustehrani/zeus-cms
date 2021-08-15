<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MustHaveExtension implements Rule
{
    public $extensions = ['jpg', 'png', 'svg', 'jpeg', 'gif'];
    /**
     * Create a new rule instance.
     * @param array $extensions
     * @return void
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
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
        return $value->getClientOriginalExtension() && in_array(strtolower($value->getClientOriginalExtension()), $this->extensions);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $extentions_string = implode(" or ", $this->extensions);
        return "The :attribute extention must be {$extentions_string}.";
    }
}
