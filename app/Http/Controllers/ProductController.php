<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Services\Product\IndexService;
use App\Services\Product\StoreService;
use App\Http\Requests\Product\IndexFormRequest;
use App\Http\Requests\Product\StoreFormRequest;
use App\Http\Requests\Product\UpdateFormRequest;

class ProductController extends Controller
{
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
        return $this->productService->getProducts($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\StoreFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {
        return $this->productService->createProduct($request->validated());
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
        return $this->productService->updateProduct($product, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $this->productService->deleteProduct($product);
    }
}
