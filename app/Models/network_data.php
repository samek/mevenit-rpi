<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class network_data extends Model
{
    protected $table = 'network_data';
    public  $timestamps = false;
    protected $fillable = array('dev', 'dhcp','ip','netmask','gateway','dns1','dns2','wifiname','secure','pass','status');
    /*
     * $table->increments('id');
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
     */
}
