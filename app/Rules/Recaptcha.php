<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Zttp\Zttp;

class Recaptcha implements Rule
{
    const URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $response = Zttp::asFormParams()->post(static::URL, [
            'secret' => config('forum.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        return $response->json()['success'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The recaptcha verification failed. Try again.';
    }
}
