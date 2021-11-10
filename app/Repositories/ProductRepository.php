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
    public function queryBuilder(Builder $queryBuilder, array $criteria = [], array $orderBy = [])
    {
        if(!empty($criteria)) {

            $queryBuilder->where(function ($query) use ($criteria) {
                        
                foreach ($criteria as $column => $value) {

                    if(!empty($value)) {

                        switch (true) {

                            case is_numeric($value):
                                $query->where($column, $value);
                                break;

                            case is_array($value):
                                $query->whereIn($column, $value);
                                break;

                            case preg_match('/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/', $value):
                                $query->whereDate($column, $value);
                                break;                      

                            default:
                                $query->where($column, 'like', "%$value%");
                                break;
                        }

                    }

                }

            });

        }

        if(!empty($orderBy)) {

            foreach ($orderBy as $fields => $order) {

                $fields = explode(',', $fields);

                foreach ($fields as $field) {

                    $queryBuilder
                        ->orderBy($field, $order);

                }

            }

        }

        return $queryBuilder;
    }
}