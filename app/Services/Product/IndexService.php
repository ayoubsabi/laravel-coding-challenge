<?php

namespace App\Services\Product;

use Illuminate\Http\Response;
use App\Repositories\ProductRepository;
use App\Http\Resources\Product\Collection;

class IndexService
{
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle($data)
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
}