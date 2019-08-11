<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name')->comment('产品名称');
            $table->string('product_english')->nullable()->comment('英文名称');
            $table->integer('category_id')->default(0)->comment('分类ID');
            $table->string('category_name')->nullable()->comment('分类名称');
            $table->integer('type_id')->nullable()->comment('类型ID');
            $table->string('type_name')->nullable()->comment('类型名称');
            $table->integer('brand_id')->nullable()->comment('品牌ID');
            $table->string('brand_name')->nullable()->comment('品牌名称');
            $table->char('product_spu',6)->comment('产品货号');
            $table->string('product_barcode')->nullable()->comment('产品条形码');
            $table->decimal('product_cost_price', 8, 2)->comment('成本价');
            $table->decimal('product_price', 8, 2)->comment('销售价');
            $table->tinyInteger('product_storage_alarm')->default(0)->comment('库存报警');
            $table->decimal('product_freight', 8, 2)->nullable()->comment('产品运费');
            $table->string('product_size')->nullable()->comment('产品尺寸');
            $table->string('product_weight')->nullable()->comment('产品重量或体积');
            $table->text('spec_name')->nullable()->comment('规格名称');
            $table->text('spec_value')->nullable()->comment('规格数值');
            $table->string('product_image')->nullable()->comment('产品图片');
            $table->text('product_content')->nullable()->comment('产品内容');
            $table->integer('supplier_id')->nullable()->comment('主供应商');
            $table->integer('supplier_bid')->nullable()->comment('辅供应商');
            $table->tinyInteger('product_commend')->default(0)->comment('产品推荐');
            $table->enum('product_state', ['0', '1'])->default('1')->comment('产品状态 0下架，1正常');
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
        Schema::dropIfExists('product');
    }
}
