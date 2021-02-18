<?php

namespace App\Http\Controllers\Api\v1;

use App\Address;
use App\Cart;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\PurchaseComplete;
use App\Product;
use App\PurchaseDetail;
use App\PurchaseDetailRaw;
use App\Services\ManageStockService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth()->user()->id;
        $address = Address::findOrFail($request->address_id);
        $address->user_id !== $userId && abort(403);

        DB::beginTransaction();
        try {

            // purchases
            $purchase = new Purchase();
            $purchase->user_id = $userId;
            $purchase->address_id = $request->address_id;
            $purchase->save();

            // purchase_details_raw
            $purchaseItems['items'] = Cart::where('user_id', $userId)
                ->with('product:id,name,desc,price')
                ->get()
                ->toArray();
            if (empty($purchaseItems['items'])) {
                throw new Exception("Cart is empty!", 1);
            };
            $purchaseItems['address'] = $address->toArray();
            $purchase_detail_raw = new PurchaseDetailRaw();
            $purchase_detail_raw->purchase_id = $purchase->id;
            $purchase_detail_raw->raw = $purchaseItems;
            $purchase_detail_raw->save();

            // purchase_details
            $now = now();
            $total = 0;
            foreach ($purchaseItems['items'] as $item) {
                if (!ManageStockService::check($item['product']['id'], $item['quantity'])) {
                    throw new Exception("Not enough stock!", 2);
                };

                // update stocks
                Product::where('id', $item['product']['id'])->decrement('stock', $item['quantity']);

                $total += $item['product']['price'] * $item['quantity'];
                unset($item['product']);
                unset($item['user_id']);
                $item['purchase_id'] = $purchase->id;
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $items[] = $item;
            }
            PurchaseDetail::insert($items);

            // delete cart
            Cart::where('user_id', $userId)->delete();

            // send mail
            Mail::to(Auth()->user()->email)->send(new PurchaseComplete($purchaseItems, $total));


            DB::commit();
            return response()->json(["message" => "Purchase completed!"]);
        } catch (Exception $e) {
            DB::rollback();
            if ($e->getCode() === 1) {
                return response()->json(['message' => $e->getMessage()], 400);
            } else if ($e->getCode() === 2) {
                return response()->json(['message' => $e->getMessage()], 400);
            } else {
                return response()->json(["message" => "Error!"], 400);
            }
        }
    }
}
