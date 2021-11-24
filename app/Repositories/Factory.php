<?php

namespace App\Repositories;

use Exception;

class Factory
{
    /**
     * Create AbstractRepository instance
     * @method createInstance(string $repositoryClassName)
     * 
     * @param string $repositoryClassName
     * 
     * @return AbstractRepository
     */
    public static function createInstance(string $repositoryClassName): AbstractRepository
    {
        throw_if(
            ! class_exists($repositoryClassName),
            new Exception(sprintf("%s class not found", $repositoryClassName))
        );

        $repository = new $repositoryClassName();

        throw_if(
            ! $repository instanceof AbstractRepository,
            new Exception(sprintf("This class is not an instance of %s", AbstractRepository::class))
        );

        return $repository;
    }
}