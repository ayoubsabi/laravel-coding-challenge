<?php

namespace App\Http\Controllers;

use App\Services\Product\IndexService;
use App\Services\Product\StoreService;
use App\Http\Requests\Product\IndexFormRequest;
use App\Http\Requests\Product\StoreFormRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Product\IndexFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexFormRequest $request)
    {
        return app(IndexService::class)->handle($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\StoreFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {
        return app(StoreService::class)->handle($request->validated());
    }
}
