<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * @var array
     */
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * @param $body
     * @throws Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if(stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}