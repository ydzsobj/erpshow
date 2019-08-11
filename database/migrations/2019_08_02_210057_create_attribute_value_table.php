<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attr_value_name')->comment('类型名称');
            $table->string('attr_value_english')->comment('英文名称');
            $table->string('attr_id')->nullable()->comment('属性ID');
            $table->string('type_id')->nullable()->comment('类型ID');
            $table->tinyInteger('attr_value_show')->default(1)->comment('属性值显示');
            $table->tinyInteger('sort')->default(1)->comment('排序');
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
        Schema::dropIfExists('attribute_value');
    }
}
