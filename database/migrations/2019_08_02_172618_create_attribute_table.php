<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attr_name')->comment('类型名称');
            $table->string('attr_english')->comment('英文名称');
            $table->integer('type_id')->comment('类型ID');
            $table->string('attr_value')->nullable()->comment('属性值');
            $table->string('attr_value_ids')->nullable()->comment('属性值ID');
            $table->tinyInteger('attr_show')->default(1)->comment('属性值显示');
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
        Schema::dropIfExists('attribute');
    }
}
