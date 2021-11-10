<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     * {@inheritdoc}
     */
    protected function queryBuilder(Builder $queryBuilder, array $criteria = [], array $orderBy = [])
    {
        if(isset($criteria['category_id'])) {

            $queryBuilder->where('category_id', $criteria['category_id']);

        }

        foreach (['name', 'price'] as $field) {

            if(isset($orderBy[$field])) {

                $order = $orderBy[$field];

                $queryBuilder
                    ->orderBy($field, $order);

            }

        }

        return $queryBuilder;
    }
}