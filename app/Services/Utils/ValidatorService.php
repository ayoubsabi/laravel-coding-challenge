<?php

namespace App\Services\Utils;

use Illuminate\Support\Facades\Validator;

class ValidatorService
{
    /**
     * Validate user inputs.
     *
     * @param array  $data
     * 
     * @param array $rules
     * 
     * @return array
     */
    public function validated(array $data, array $rules): array
    {
        return Validator::make($data, $rules)->validated();
    }
}