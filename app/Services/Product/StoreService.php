<?php

namespace App\Services\Product;

use App\Http\Resources\Product\Resource;
use Illuminate\Http\Response;
use App\Repositories\ProductRepository;
use App\Services\LocalFileUploadService;

class StoreService
{
    const IMAGE_PATH = 'public/images';
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle($data)
    {
        return response([
            'data' => new Resource(
                $this->products->create(
                    array_merge($data, [
                        'image' => $this->handleFileUpload($data['image'])->getFileName()
                    ])
                )
            )],
            Response::HTTP_CREATED
        );
    }

    protected function handleFileUpload($file)
    {
        return (new LocalFileUploadService($file))->save(self::IMAGE_PATH);
    }
}