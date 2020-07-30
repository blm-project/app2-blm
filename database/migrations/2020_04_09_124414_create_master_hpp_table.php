<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterHppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hpp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hpp_component',255)->nullable();
            $table->decimal('hpp_price',14,2)->nullable();
            $table->decimal('hpp_total',14,2)->nullable();
            $table->double('hpp_margin')->nullable();
            $table->decimal('hpp_price_sold',14,2)->nullable();
            $table->string('hpp_status',255)->nullable();
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
        Schema::dropIfExists('hpp');
    }
}
