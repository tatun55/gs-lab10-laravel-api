<?php

namespace App\Http\Controllers\Api\v1;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Product;
use App\Services\ManageStockService;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return $this->res();
    }

    public function store(CartRequest $request, Product $product)
    {
        DB::beginTransaction();
        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth()->user()->id,
                'product_id' => $product->id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity)
            ]
        );
        if (!ManageStockService::check($product->id, Cart::where('id', $cart->id)->value('quantity'))) {
            DB::rollBack();
            return response()->json(['message' => 'Not enough stock!'], 400);
        };
        DB::commit();
        return $this->res();
    }

    public function update(CartRequest $request, Product $product)
    {
        if (!ManageStockService::check($product->id, $request->quantity)) {
            return response()->json(['message' => 'Not enough stock!'], 400);
        };
        Cart::where([['user_id', Auth()->user()->id], ['product_id', $product->id]])
            ->firstOrFail()
            ->update(['quantity' => $request->quantity]);
        return $this->res();
    }

    public function destroy(Product $product)
    {
        Cart::where([['user_id', Auth()->user()->id], ['product_id', $product->id]])
            ->firstOrFail()
            ->delete();
        return $this->res();
    }

    private function res()
    {
        return response()->json(
            Cart::where('user_id', Auth()->user()->id)
                ->with('product:id,name,desc,price')
                ->get()
        )->send();
    }
}
