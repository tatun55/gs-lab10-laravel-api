<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth()->user()->role !== 'admin' && abort(403);
        return Product::orderBy('id', 'asc')->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Auth()->user()->role !== 'admin' && abort(403);
        $product = new Product();
        $product->fill($request->validated())->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Auth()->user()->role !== 'admin' && abort(403);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        Auth()->user()->role !== 'admin' && abort(403);
        $product->fill($request->validated())->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Auth()->user()->role !== 'admin' && abort(403);
        $product->delete();
        return response()->json(['message' => 'Deleted.']);
    }
}
