<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['zip_code', 'pref', 'city', 'street',];
    protected $hidden = ['user_id', 'created_at', 'updated_at'];
}
