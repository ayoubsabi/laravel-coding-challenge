<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    protected static $itemPerPage = 10;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($name, $arguments)
    {
        return $this->model->$name(...$arguments) ?? $this->model::$name(...$arguments);
    }

    /**
     * @method all()
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function all(string $fields = '*')
    {
        return $this->model->select($fields);
    }

    /**
     * @method getAll(array $orderBy = [], bool $pagination = true)
     * 
     * @param array $orderBy
     * @param bool $pagination
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
     * @return Object[]
     */
    public function getBy(array $criteria = [], array $orderBy = [], bool $pagination = true)
    {
        $get = $pagination ? 'paginate' : 'get';

        return $this->queryBuilder(
            $this->all(),
            $criteria,
            $orderBy
        )->$get(!$pagination ?: static::$itemPerPage);
    }

    /**
     * @method getOneBy(array $criteria = [])
     * 
     * @return Object|null
     */
    public function getOneBy(array $criteria = [])
    {
        return $this->queryBuilder(
            $this->all(),
            $criteria
        )->first();
    }

    /**
     * Manage query.
     * @method queryBuilder(Builder $queryBuilder, array $criteria, array $orderBy)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $queryBuilder
     * @param array $criteria
     * @param array $orderBy
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function queryBuilder(Builder $queryBuilder, array $criteria = [], array $orderBy = []);
}