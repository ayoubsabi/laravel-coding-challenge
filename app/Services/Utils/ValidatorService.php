<?php

namespace App\Services\Utils;

use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

class ValidatorService
{
    private $validatorFactory;

    public function __construct(ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @method validate(array $data, array $rules)
     *
     * @param array $data
     * @param array $rules
     * 
     * @return array
     */
    public function validate(array $data, array $rules): array
    {
        return $this->validatorFactory->make($data, $rules)->validate();
    }
}