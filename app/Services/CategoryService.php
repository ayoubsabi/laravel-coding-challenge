<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\Paginator;

class CategoryService
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get categories.
     *
     * @param  array  $criteria
     * 
     * @return Paginator
     */
    public function getCategories(array $criteria, array $orderBy): Paginator
    {
        return $this->categories->getBy($criteria, $orderBy);
    }

    /**
     * Get category by id.
     *
     * @param  int $id
     * 
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return $this->categories->getOneBy(['id' => $id]);
    }

    /**
     * Create category.
     *
     * @param  array  $data
     * 
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return $this->categories->create($data);
    }

    /**
     * Update category.
     *
     * @param  Category $category
     * @param  array  $data
     * 
     * @return Category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        return $this->categories->update($category, $data);
    }

    /**
     * Delete category.
     *
     * @param  Category $category
     * 
     * @return bool|null
     */
    public function deleteCategory(Category $category): ?bool
    {
        return $this->categories->delete($category);
    }
}