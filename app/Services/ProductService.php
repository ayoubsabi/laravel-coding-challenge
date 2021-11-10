<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Repositories\ProductRepository;
use App\Http\Resources\Product\Resource;
use App\Http\Resources\Product\Collection;

class ProductService
{
    const IMAGE_PATH = 'public/images';
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function getProducts($data)
    {
        $orderBy = [];

        if(isset($data['order_by'])) {

            $orderBy = $data['order_by'];
            unset($data['order_by']);

        }

        return response(new Collection(
                $this->products->getBy($data, $orderBy)
            ),
            Response::HTTP_CREATED
        );
    }

    public function createProduct($data)
    {
        return response([
            'data' => new Resource(
                $this->products->create(
                    array_merge($data, [
                        'image' => (
                            (new LocalFileUploadService($data['image']))
                                ->save(self::IMAGE_PATH)
                                ->getFileName()
                        )
                    ])
                )
            )],
            Response::HTTP_CREATED
        );
    }

    public function updateProduct($product, $data)
    {
        $product->update($data);

        return response(
            $product,
            Response::HTTP_CREATED
        );
    }

    public function deleteProduct($product)
    {
        $product->delete();

        return response(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}