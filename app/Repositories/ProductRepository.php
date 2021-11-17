<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository extends BaseRepository
{
    const PRODUCT_FIELDS = [
        'id', 'category_id', 'name', 'image', 'price', 'description', 'created_at', 'updated_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected function queryBuilder(): Builder
    {
        return Product::query();
    }

    /**
     * {@inheritdoc}
     * 
     * @return Product
     */
    public function findOneBy(array $criteria = [], array $columns = ['*']): ?Product
    {
        $this->checkIfColumnsExists(array_keys($criteria), self::PRODUCT_FIELDS );

        return $this
            ->queryBuilder()
            ->where(function ($query) use ($criteria) {
                foreach ($criteria as $column => $value) {
                    $query->where($column, $value);
                }
            })
            ->first($columns);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria = [], array $orderBy = [], int $itemPerPage = 10, array $columns = ['*']): Paginator
    {
        $this->checkIfColumnsExists(array_merge(
                array_keys($criteria),
                Arr::only($orderBy, 'column')
            ),
            self::PRODUCT_FIELDS
        );

        return $this
            ->queryBuilder()
            ->where(function ($query) use ($criteria) {
                foreach ($criteria as $column => $value) {
                    $query->where($column, $value);
                }
            })
            ->orderBy(
                Arr::get($orderBy, 'column', 'created_at'),
                Arr::get($orderBy, 'orientation', 'desc')
            )
            ->paginate($itemPerPage, $columns);
    }

    /**
     * @method create(array $data, ?Category $category = null)
     * 
     * @param array $data
     * @param Category $parent
     * 
     * @return Product
     */
    public function create(array $data, ?Category $category = null): Product
    {
        if ($category) {
            return $category->products($data);
        }

        return Product::create($data);
    }

    /**
     * @method update(Product $product, array $data)
     * 
     * @param Product $product
     * @param array $data
     * 
     * @return bool
     */
    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    /**
     * @method delete(Product $product)
     * 
     * @param Product $product
     * 
     * @return bool
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}