<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    /**
     * @method create(array $data)
     * 
     * @param array $data
     * 
     * @return Model
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * @method update(Category $object, array $data)
     * 
     * @param Category $object
     * @param array $data
     * 
     * @return Category
     */
    public function update(Category $object, array $data): Category
    {
        $object->update($data);

        return $this->getOneBy(['id' => $object->id]);
    }

    /**
     * @method delete(Category $object)
     * 
     * @param Category $object
     * 
     * @return bool|null
     */
    public function delete(Category $object): ?bool
    {
        return $object->delete();
    }

    /**
     * {@inheritdoc}
     */
    protected function createQueryBuilder(string $fields = '*'): Builder
    {
        return Category::select($fields);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareQueryFilters(Builder $queryBuilder, array $criteria = []): Builder
    {
        // TODO: filter logic

        return $queryBuilder;
    }
}