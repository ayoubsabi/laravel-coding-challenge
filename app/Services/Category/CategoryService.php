<?php

namespace App\Services\Category;

use Exception;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\Utils\ValidatorService;
use Illuminate\Contracts\Pagination\Paginator;

class CategoryService
{
    private $categoryRepository;
    private $validatorService;

    public function __construct(CategoryRepository $categoryRepository, ValidatorService $validatorService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->validatorService = $validatorService;
    }

    /**
     * @method getCategories(array $criteria, array $orderBy)
     *
     * @param array $criteria
     * @param array $orderBy
     * 
     * @return Paginator
     */
    public function getCategories(array $criteria, array $orderBy): Paginator
    {
        $criteria = $this->validatorService->validated($criteria, [
            'parent_id' => 'integer|exists:App\Models\Category,id'
        ]);

        $orderBy = $this->validatorService->validated($orderBy, [
            'name' => 'in:asc,desc',
            'created_at' => 'in:asc,desc'
        ]);

        return $this->categoryRepository->findBy($criteria, $orderBy);
    }

    /**
     * @method getCategoryById(int $id)
     *
     * @param int $id
     * 
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findOneBy(['id' => $id]);
    }

    /**
     * @method createCategory(array $data)
     *
     * @param array $data
     * 
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        $data = $this->validatorService->validated($data, [
            'name' => 'required|string',
            'parent_id' => 'nullable|integer|exists:App\Models\Category,id'
        ]);

        return $this->categoryRepository->create($data);
    }

    /**
     * @method updateCategory(Category $category, array $data)
     *
     * @param Category $category
     * @param array $data
     * 
     * @return Category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $data = $this->validatorService->validated($data, [
            'name' => 'required|string',
            'parent_id' => 'integer|exists:App\Models\Category,id'
        ]);

        throw_if(
            ! $this->categoryRepository->update($category, $data),
            new Exception("Category update failure")
        );

        return $this->categoryRepository->findOneBy(['id' => $category->id]);
    }

    /**
     * @method deleteCategory(Category $category)
     *
     * @param Category $category
     * 
     * @return void
     */
    public function deleteCategory(Category $category): void
    {
        throw_if(
            ! $this->categoryRepository->delete($category),
            new Exception("Category delete failure")
        );
    }
}