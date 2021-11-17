<?php

namespace App\Repositories;

use App\Traits\TableColumnsChecker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

abstract class BaseRepository
{
    use TableColumnsChecker;

    /**
     * @method queryBuilder()
     * 
     * @param string $fields
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function queryBuilder(): Builder;

    /**
     * @method findOneBy(array $criteria = [], array $columns = ['*'])
     * 
     * @param array $criteria
     * @param array $columns
     * 
     * @return Model|object|null
     */
    abstract public function findOneBy(array $criteria = [], array $columns = ['*']);

    /**
     * @method findBy(array $criteria = [], array $orderBy = [], int $itemPerPage = 10, array $columns = ['*'])
     * 
     * @param array $criteria
     * @param array $orderBy
     * @param int $itemPerPage
     * @param array $columns
     * 
     * @return Paginator
     */
    abstract public function findBy(array $criteria = [], array $orderBy = [], int $itemPerPage = 10, array $columns = ['*']): Paginator;

    /**
     * @method findAll(array $orderBy = [], int $itemPerPage = 10, array $columns = ['*'])
     * 
     * @param array $orderBy
     * @param int $itemPerPage
     * @param array $columns
     * 
     * @return Paginator
     */
    public function findAll(array $orderBy = [], int $itemPerPage = 10, array $columns = ['*']): Paginator
    {
        return $this->findBy([], $orderBy, $itemPerPage, $columns);
    }
}