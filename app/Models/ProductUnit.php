<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    //
    use SoftDeletes;

    protected $table = "product_unit";
    protected $dates = ['deleted_at'];
}
