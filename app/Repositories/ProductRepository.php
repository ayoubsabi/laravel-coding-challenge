<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
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
        foreach ($criteria as $fieldName => $value) {
            if (!is_null($value)) {
                $queryBuilder->where($fieldName, $value);
            }
        }

        return $queryBuilder;
    }
}