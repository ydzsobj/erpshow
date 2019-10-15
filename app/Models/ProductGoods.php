<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGoods extends Model
{
    //
    protected $table = 'product_goods';

    //解析sku属性值
    public function getSkuValueDecodeAttribute(){

        return unserialize($this->attributes['sku_value']);
    }
}
