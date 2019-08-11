<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_id')->comment('产品ID');
            $table->string('sku_id')->comment('sku编号');
            $table->string('sku_name')->comment('sku名称');
            $table->string('sku_english')->nullable()->comment('英文名称');
            $table->integer('category_id')->default(0)->comment('分类ID');
            $table->integer('brand_id')->nullable()->default(0)->comment('品牌ID');
            $table->string('category_name')->nullable()->comment('分类名称');
            $table->decimal('sku_cost_price', 8, 2)->comment('sku成本价');
            $table->decimal('sku_price', 8, 2)->comment('sku销售价');
            $table->string('sku_barcode')->nullable()->comment('sku条形码');
            $table->text('sku_value')->nullable()->comment('sku属性值');
            $table->integer('sku_num')->nullable()->default(0)->comment('sku数量');
            $table->integer('sku_num_alarm')->nullable()->default(0)->comment('库存报警值');
            $table->string('sku_image')->nullable()->comment('产品图片');
            $table->enum('sku_state', ['0', '1'])->default('1')->comment('产品状态 0下架，1正常');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_goods');
    }
}
