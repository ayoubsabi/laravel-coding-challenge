<?php

namespace App\Rules;

use App\Repositories\Factory as RepositoryFactory;
use Illuminate\Contracts\Validation\Rule;

class Exists implements Rule
{
    private $repository;
    private $column;

    /**
     * Create a new rule instance.
     * 
     * @param string $repositoryClassName
     * @param string $column
     *
     * @return void
     */
    public function __construct(string $repositoryClassName, string $column)
    {
        $this->repository = RepositoryFactory::createInstance($repositoryClassName);
        $this->column = $column;
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
        return ! is_null($this->repository->findOneBy([$this->column => $value]));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No record found.';
    }
}
