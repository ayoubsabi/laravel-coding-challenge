<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createQueryBuilder(string $fields = '*')
    {
        return $this->select($fields);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareQueryFilters(Builder $queryBuilder, array $criteria = [])
    {
        // TODO: filter logic

        return $queryBuilder;
    }
}