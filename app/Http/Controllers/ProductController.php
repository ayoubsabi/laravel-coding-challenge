<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Services\ProductService;
use App\Http\Requests\Product\IndexFormRequest;
use App\Http\Requests\Product\StoreFormRequest;
use App\Http\Requests\Product\UpdateFormRequest;
use App\Http\Resources\Product\Collection;
use App\Http\Resources\Product\Resource;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Product\IndexFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexFormRequest $request)
    {
        $validatedData = $request->validated();

        return $this->successResponse(
            new Collection(
                $this->productService->getProducts([
                        'category_id' => $validatedData['category_id'] ?? null
                    ],
                    $validatedData['order_by'] ?? []
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\StoreFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {
        return $this->successResponse(new Resource(
                $this->productService->createProduct($request->validated())
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Http\Requests\Product\UpdateFormRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, UpdateFormRequest $request)
    {
        return $this->successResponse(new Resource(
                $this->productService->updateProduct($product, $request->validated())
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $this->successResponse(
            $this->productService->deleteProduct($product),
            Response::HTTP_NO_CONTENT
        );
    }
}
