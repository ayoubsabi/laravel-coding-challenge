<?php

namespace App\Services\Product;

use Exception;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Utils\ValidatorService;
use App\Services\Utils\LocalFileUploadService;
use Illuminate\Contracts\Pagination\Paginator;

class ProductService
{
    const IMAGE_PATH = 'public/images';
    private $productRepository, $validatorService, $localFileUploadService;

    public function __construct(ProductRepository $productRepository, ValidatorService $validatorService, LocalFileUploadService $localFileUploadService)
    {
        $this->productRepository = $productRepository;
        $this->localFileUploadService = $localFileUploadService;
        $this->validatorService = $validatorService;
    }

    /**
     * Get products.
     *
     * @param  array  $criteria
     * 
     * @return Paginator
     */
    public function getProducts(array $criteria, array $orderBy): Paginator
    {
        $criteria = $this->validatorService->validated($criteria, [
            'category_id' => 'integer|exists:App\Models\Category,id'
        ]);

        $orderBy = $this->validatorService->validated($orderBy, [
            'name' => 'in:asc,desc',
            'price' => 'in:asc,desc'
        ]);

        return $this->productRepository->getBy($criteria, $orderBy);
    }

    /**
     * Get product by id.
     *
     * @param  int $id
     * 
     * @return Product|null
     */
    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->getOneBy(['id' => $id]);
    }

    /**
     * Create product.
     *
     * @param  array  $data
     * 
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        $data = $this->validatorService->validated($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1|max:9999999',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'category_id' => 'required|integer|exists:App\Models\Category,id'
        ]);

        if (! $filename = $this->localFileUploadService->save($data['image'], self::IMAGE_PATH)) {
            throw new Exception("File upload failure");
        }

        return $this->productRepository->create(
            array_merge($data, [
                'image' => $filename
            ])
        );
    }

    /**
     * Update product.
     *
     * @param  Product $product
     * @param  array  $data
     * 
     * @return Product
     */
    public function updateProduct(Product $product, array $data): Product
    {
        $data = $this->validatorService->validated($data, [
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric|min:1|max:9999999',
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
            'category_id' => 'integer|exists:App\Models\Category,id',
        ]);

        if (isset($data['image'])) {
            if (! $filename = $this->localFileUploadService->update($data['image'], self::IMAGE_PATH, $product->image)) {
                throw new Exception("File upload failure");
            }

            $data['image'] = $filename;
        }

        if (! $this->productRepository->update($product, $data)) {
            throw new Exception("Product update failure");
        }

        return $this->productRepository->getOneBy(['id' => $product]);
    }

    /**
     * Delete product.
     *
     * @param  Product $product
     * 
     * @return bool
     */
    public function deleteProduct(Product $product): bool
    {
        if (! $this->localFileUploadService->delete(sprintf("%s/%s", self::IMAGE_PATH, $product->image))) {
            throw new Exception("File delete failure");
        }

        if (! $this->productRepository->delete($product)) {
            throw new Exception("Product delete failure");
        }

        return true;
    }
}