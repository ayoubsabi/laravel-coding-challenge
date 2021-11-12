<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
{
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
     * @method update(Product $object, array $data)
     * 
     * @param Product $object
     * @param array $data
     * 
     * @return Product
     */
    public function update(Product $object, array $data): Product
    {
        $object->update($data);

        return $this->getOneBy(['id' => $object->id]);
    }

    /**
     * @method delete(Model $object)
     * 
     * @param Product $object
     * 
     * @return bool|null
     */
    public function delete(Product $object): ?bool
    {
        return $object->delete();
    }

    /**
     * {@inheritdoc}
     */
    protected function createQueryBuilder(string $fields = '*'): Builder
    {
        return Product::select($fields);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareQueryFilters(Builder $queryBuilder, array $criteria = []): Builder
    {
        foreach ($criteria as $fieldName => $value) {
            if (!is_null($value)) {
                $queryBuilder->where($fieldName, $value);
            }
        }

        return $queryBuilder;
    }
}