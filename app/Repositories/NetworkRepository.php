<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/7/15
 * Time: 10:13 PM
 */

namespace App\Repositories;
use App\Models\network_data;

class NetworkRepository {


    public function get($iface)
    {
        return network_data::where('dev','=',$iface)->first();

    }


    public function all() {
        return network_data::all();
    }
}