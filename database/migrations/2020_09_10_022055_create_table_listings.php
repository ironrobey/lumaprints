<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_listings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shops_id');
            $table->string('currency');
            $table->float('price');
            $table->float('rating');
            $table->integer('reviews');
            $table->text('url');
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
        Schema::dropIfExists('table_listings');
    }
}
