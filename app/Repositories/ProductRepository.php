<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
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
    protected function createQueryBuilder(string $fields = '*'): Builder
    {
        return Product::select($fields);
    }

    /**
     * @method getOneBy(array $criteria = [])
     * 
     * @return Product|null
     */
    public function getOneBy(array $criteria = []): ?Product
    {
        $this->checkIfFieldsExists(array_keys($criteria), self::PRODUCT_FIELDS);

        return $this->defaultQueryFilters(
            $this->createQueryBuilder()->with('category'),
            $criteria
        )->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getBy(array $criteria = [], array $orderBy = []): Paginator
    {
        $this->checkIfFieldsExists(array_merge(
                array_keys($criteria),
                array_keys($orderBy)
            ),
            self::PRODUCT_FIELDS
        );

        $queryBuilder = $this->defaultQueryFilters(
            $this->createQueryBuilder()->with('category'),
            $criteria
        );

        $queryBuilder = $this->orderBy(
            $queryBuilder,
            $orderBy
        );

        return $queryBuilder->paginate(static::$itemPerPage);
    }

    /**
     * @method create(array $data, Category $category = null)
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
     * @method delete(Model $product)
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