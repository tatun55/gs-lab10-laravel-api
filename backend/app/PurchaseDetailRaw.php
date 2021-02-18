<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetailRaw extends Model
{
    protected $casts = ['raw' => 'json'];
}
