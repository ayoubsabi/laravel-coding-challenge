<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    protected static $itemPerPage = 10;

    /**
     * Call predefined model's functions
     * 
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $model = sprintf(
            'App\Models\%s',
            str_replace('Repository', '', class_basename(static::class))
        );

        return $model::$name(...$arguments);
    }

    /**
     * @method getAll(array $orderBy = [], bool $pagination = true)
     * 
     * @param array $orderBy
     * @param bool $pagination
     * 
     * @return Object[]
     */
    public function getAll(array $orderBy = [], bool $pagination = true)
    {
        return $this->getBy([], $orderBy, $pagination);
    }

    /**
     * @method getBy(array $criteria = [], array $orderBy = [], bool $pagination = true)
     * 
     * @param array $criteria
     * @param array $orderBy
     * @param bool $pagination
     * 
     * @return Object[]
     */
    public function getBy(array $criteria = [], array $orderBy = [], bool $pagination = true)
    {
        $queryBuilder = $this->prepareQueryFilters(
            $this->createQueryBuilder(),
            $criteria
        );

        $queryBuilder = $this->orderBy(
            $queryBuilder,
            $orderBy
        );

        $get = $pagination ? 'paginate' : 'get';

        return $queryBuilder->$get(!$pagination ?: static::$itemPerPage);
    }

    /**
     * @method getOneBy(array $criteria = [])
     * 
     * @return Object|null
     */
    public function getOneBy(array $criteria = [])
    {
        return $this->prepareQueryFilters(
            $this->createQueryBuilder(),
            $criteria
        )->first();
    }

    /**
     * Order data.
     * @method orderBy(Builder $queryBuilder, array $orderBy)
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param array $orderBy
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function orderBy(Builder $queryBuilder, array $orderBy)
    {
        foreach ($orderBy as $fieldName => $orientation) {
            $queryBuilder->orderBy($fieldName, $orientation);
        }

        return $queryBuilder;
    }

    /**
     * Create query builder
     * @method createQueryBuilder(string $fields = '*')
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function createQueryBuilder(string $fields = '*');

    /**
     * Prepare query filters.
     * @method prepareQueryFilters(Builder $queryBuilder, array $criteria = [])
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param array $criteria
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function prepareQueryFilters(Builder $queryBuilder, array $criteria = []);
}