<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/7/15
 * Time: 10:13 PM
 */

namespace App\Repositories;
use App\Models\network_data;

/**
 * Class NetworkRepository
 * @package App\Repositories
 */
class NetworkRepository {


    public function create(array $attributes = []) {
        return network_data::create($attributes);

    }

    public function get($iface)
    {
        if ($iface!="eth0" and $iface!="wlan0")
            dd("I don't want it");


        $ret = network_data::where('dev','=',$iface)->first();
        //If null just insert it in empty//
        if ($ret == null )
            return $this->_create($iface);
        else
            return $ret;

    }


    private function _create($iface) {
        $vars=array(
            'dev' =>$iface
        );
        return $this->create($vars);
    }

    public function all() {
        return network_data::all();
    }
}