<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

abstract class BaseRepository
{
    protected static $itemPerPage = 10;

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
     * @method getBy(array $criteria = [], array $orderBy = [], bool $pagination = true)
     * 
     * @param array $criteria
     * @param array $orderBy
     * @param bool $pagination
     * 
     * @return Paginator
     */
    abstract public function getBy(array $criteria = [], array $orderBy = []): Paginator;

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
     * Prepare query filters.
     * @method prepareQueryFilters(Builder $queryBuilder, array $criteria = [])
     *
     * @param \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param array $criteria
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function defaultQueryFilters(Builder $queryBuilder, array $criteria = []): Builder
    {
        foreach ($criteria as $fieldName => $value) {
            $queryBuilder->where($fieldName, $value);
        }

        return $queryBuilder;
    }

    /**
     * Order by query.
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
     * Check if fields exists in the table.
     * @method checkIfFieldsExists(array $inputFields, array $tableFields)
     *
     * @param array $inputFields
     * @param array $tableFields
     * 
     * @return true
     * 
     * @throws \Exception
     */
    protected function checkIfFieldsExists(array $inputFields, array $tableFields): bool
    {
        if (! empty($inputFields) && $nonExistentFields = array_diff($inputFields, $tableFields)) {
            throw new Exception(sprintf("These fields {%s} are not exists in the table", implode(', ', $nonExistentFields)));
        }

        return true;
    }
}