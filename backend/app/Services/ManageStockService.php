<?php

namespace App\Services;

use App\Product;

class ManageStockService
{
    public static function check($product_id, $quantity): bool
    {
        $stock = Product::where('id', $product_id)->value('stock');
        return $stock >= $quantity;
    }
}
