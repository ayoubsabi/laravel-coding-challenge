<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

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
     * @return Product[]
     */
    public function getProducts(array $criteria, array $orderBy)
    {
        return $this->products->getBy($criteria, $orderBy);
    }

    /**
     * Get product by id.
     *
     * @param  int $id
     * 
     * @return Product
     */
    public function getProductById(int $id)
    {
        return $this->products->find($id);
    }

    /**
     * Create product.
     *
     * @param  array  $data
     * 
     * @return Product
     */
    public function createProduct(array $data)
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
     * @return bool
     */
    public function updateProduct(Product $product, array $data)
    {
        return $product->update($data);
    }

    /**
     * Delete product.
     *
     * @param  Product $product
     * 
     * @return bool|null
     */
    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}