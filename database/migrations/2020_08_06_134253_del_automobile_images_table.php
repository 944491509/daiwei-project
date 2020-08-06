<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelAutomobileImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('automobile_images');
        Schema::table('automobiles', function (Blueprint $table) {
            $table->decimal('price')->comment('购买价格')->nullable()->change();
            $table->text('image')->comment('车辆图片')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('automobile_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('automobile_id')->comment('汽车id');
            $table->string('path', 100)->comment('图片路径');
        });
        Schema::table('automobiles', function (Blueprint $table) {
            $table->decimal('price')->comment('购买价格')->nullable()->change();
            $table->dropColumn('image');
        });
    }
}
