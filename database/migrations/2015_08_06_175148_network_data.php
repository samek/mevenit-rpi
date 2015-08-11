<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NetworkData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('network_data', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('dev');
            $table->integer('dhcp')->default(1);
            $table->string('ip')->nullable();
            $table->string('netmask')->nullable();
            $table->string('gateway')->nullable();
            $table->string('dns1')->nullable();
            $table->string('dns2')->nullable();
            $table->string('wifiname')->nullable();
            $table->string('secure')->nullable();  /// null or WPA WPA2 WEP
            $table->string('pass')->nullable();
            $table->integer('status')->default(1); /// 1 = ready for setup 3 = it's setup // 9 unconfigured///

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('network_data');
    }
}
