<?php

namespace App\Inspections;

class Spam
{
    /**
     * @var array
     */
    protected $inspection = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    /**
     * @param $body
     * @return bool
     */
    public function detect($body)
    {
        foreach($this->inspection as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}