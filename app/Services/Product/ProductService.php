<?php

namespace App\Services\Product;

use Exception;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Rules\Exists;
use App\Services\Utils\ValidatorService;
use App\Services\Utils\LocalFileUploadService;
use Illuminate\Contracts\Pagination\Paginator;

class ProductService
{
    const IMAGE_PATH = 'public/images';

    private $productRepository;
    private $validatorService;
    private $localFileUploadService;

    public function __construct(ProductRepository $productRepository, ValidatorService $validatorService, LocalFileUploadService $localFileUploadService)
    {
        $this->productRepository = $productRepository;
        $this->validatorService = $validatorService;
        $this->localFileUploadService = $localFileUploadService;
    }

    /**
     * @method getProducts(array $criteria, array $orderBy)
     *
     * @param array $criteria
     * @param array $orderBy
     * 
     * @return Paginator
     */
    public function getProducts(array $criteria, array $orderBy): Paginator
    {
        $criteria = $this->validatorService->validate($criteria, [
            'category_id' => [
                'integer',
                new Exists(CategoryRepository::class, 'id')
            ]
        ]);

        $orderBy = $this->validatorService->validate($orderBy, [
            'column' => 'string',
            'orientation' => 'in:asc,desc'
        ]);

        return $this->productRepository->findBy($criteria, $orderBy);
    }

    /**
     * @method getProductById(int $id)
     *
     * @param int $id
     * 
     * @return Product|null
     */
    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findOneBy(['id' => $id]);
    }

    /**
     * @method createProduct(array $data)
     *
     * @param array $data
     * 
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        $data = $this->validatorService->validate($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1|max:9999999',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'category_id' => [
                'required',
                'integer',
                new Exists(CategoryRepository::class, 'id')
            ]
        ]);

        return $this->productRepository->create(
            array_merge($data, [
                'image' => $this->localFileUploadService->save($data['image'], self::IMAGE_PATH)
            ])
        );
    }

    /**
     * @method updateProduct(Product $product, array $data)
     *
     * @param Product $product
     * @param array $data
     * 
     * @return Product
     */
    public function updateProduct(Product $product, array $data): Product
    {
        $data = $this->validatorService->validate($data, [
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric|min:1|max:9999999',
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
            'category_id' => [
                'integer',
                new Exists(CategoryRepository::class, 'id')
            ]
        ]);

        if (isset($data['image'])) {
            $data['image'] = $this->localFileUploadService->update($product->image, $data['image'], self::IMAGE_PATH);
        }

        throw_if(
            ! $this->productRepository->update($product, $data),
            new Exception("Product update failure")
        );

        return $this->productRepository->findOneBy(['id' => $product]);
    }

    /**
     * @method deleteProduct(Product $product)
     *
     * @param Product $product
     * 
     * @return void
     */
    public function deleteProduct(Product $product): void
    {
        throw_if(
            ! $this->productRepository->delete($product),
            new Exception("Product delete failure")
        );

        $this->localFileUploadService->delete(sprintf("%s/%s", self::IMAGE_PATH, $product->image));
    }
}