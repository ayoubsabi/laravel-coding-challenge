<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

class CategoryRepository extends AbstractRepository
{
    const CATEGORY_FIELDS = [
        'id', 'parent_id', 'name', 'created_at', 'updated_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected function queryBuilder(): Builder
    {
        return Category::query();
    }

    /**
     * {@inheritdoc}
     * 
     * @return Category
     */
    public function findOneBy(array $criteria = [], array $columns = ['*']): ?Category
    {
        $this->checkIfColumnsExists(array_keys($criteria), self::CATEGORY_FIELDS);

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
            self::CATEGORY_FIELDS
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
     * @method create(array $data)
     * 
     * @param array $data
     * 
     * @return Category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * @method update(Category $category, array $data)
     * 
     * @param Category $category
     * @param array $data
     * 
     * @return bool
     */
    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * @method delete(Category $category)
     * 
     * @param Category $category
     * 
     * @return bool
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}