<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\Paginator;

class ProductService
{
    const IMAGE_PATH = 'public/images';
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
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
        return $this->products->getBy($criteria, $orderBy);
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
        return $this->products->getOneBy(['id' => $id]);
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
        return $this->products->create(
            array_merge($data, [
                'image' => (
                    (new LocalFileUploadService($data['image']))
                        ->save(self::IMAGE_PATH)
                        ->getFileName()
                )
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
        return $this->products->update($product, $data);
    }

    /**
     * Delete product.
     *
     * @param  Product $product
     * 
     * @return bool|null
     */
    public function deleteProduct(Product $product): ?bool
    {
        return $this->products->delete($product);
    }
}