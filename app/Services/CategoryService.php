<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

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
     * @return Category[]
     */
    public function getCategories(array $criteria, array $orderBy)
    {
        return $this->categories->getBy($criteria, $orderBy);
    }

    /**
     * Get category by id.
     *
     * @param  int $id
     * 
     * @return Category
     */
    public function getCategoryById(int $id)
    {
        return $this->categories->find($id);
    }

    /**
     * Create category.
     *
     * @param  array  $data
     * 
     * @return Category
     */
    public function createCategory(array $data)
    {
        return $this->categories->create($data);
    }

    /**
     * Update category.
     *
     * @param  Category $category
     * @param  array  $data
     * 
     * @return bool
     */
    public function updateCategory(Category $category, array $data)
    {
        return $category->update($data);
    }

    /**
     * Delete category.
     *
     * @param  Category $category
     * 
     * @return bool|null
     */
    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}