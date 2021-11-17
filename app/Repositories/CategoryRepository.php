<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

class CategoryRepository extends BaseRepository
{
    const CATEGORY_FIELDS = [
        'id', 'parent_id', 'name', 'created_at', 'updated_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected function createQueryBuilder(string $fields = '*'): Builder
    {
        return Category::select($fields);
    }

    /**
     * @method getOneBy(array $criteria = [])
     * 
     * @return Category|null
     */
    public function getOneBy(array $criteria = []): ?Category
    {
        $this->checkIfFieldsExists(array_keys($criteria), self::CATEGORY_FIELDS);

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
            self::CATEGORY_FIELDS
        );

        $queryBuilder = $this->defaultQueryFilters(
            $this->createQueryBuilder(),
            $criteria
        );

        $queryBuilder = $this->orderBy(
            $queryBuilder,
            $orderBy
        );

        return $queryBuilder->paginate(static::$itemPerPage);
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