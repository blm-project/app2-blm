<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_vendor_name',255)->nullable();
            $table->longtext('master_vendor_address')->nullable();
            $table->string('master_vendor_phone',255)->nullable();
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
        Schema::dropIfExists('master_vendor');
    }
}
