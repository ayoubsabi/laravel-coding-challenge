<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

abstract class BaseRepository
{
    protected static $itemPerPage = 10;

    /**
     * @method getAll(array $orderBy = [])
     * 
     * @param array $orderBy
     * 
     * @return Paginator
     */
    public function getAll(array $orderBy = []): Paginator
    {
        return $this->getBy([], $orderBy);
    }

    /**
     * @method getBy(array $criteria = [], array $orderBy = [], bool $pagination = true)
     * 
     * @param array $criteria
     * @param array $orderBy
     * @param bool $pagination
     * 
     * @return Paginator
     */
    public function getBy(array $criteria = [], array $orderBy = []): Paginator
    {
        $queryBuilder = $this->prepareQueryFilters(
            $this->createQueryBuilder(),
            $criteria
        );

        $queryBuilder = $this->orderBy(
            $queryBuilder,
            $orderBy
        );

        return $queryBuilder->paginate(static::$itemPerPage);
    }

    /**
     * @method getOneBy(array $criteria = [])
     * 
     * @return Model|null
     */
    public function getOneBy(array $criteria = []): ?Model
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
    public function orderBy(Builder $queryBuilder, array $orderBy): Builder
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
     * @param string $fields
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function createQueryBuilder(string $fields = '*'): Builder;

    /**
     * Prepare query filters.
     * @method prepareQueryFilters(Builder $queryBuilder, array $criteria = [])
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param array $criteria
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function prepareQueryFilters(Builder $queryBuilder, array $criteria = []): Builder;
}