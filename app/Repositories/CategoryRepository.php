<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    /**
     * {@inheritdoc}
     */
    public function queryBuilder(Builder $queryBuilder, array $criteria = [], array $orderBy = [])
    {
        // customize query

        return $queryBuilder;
    }
}