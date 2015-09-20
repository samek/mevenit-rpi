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



    public function updateIface(array $attributes = []) {
        $ret = $this->get($attributes["dev"]);

        if ($ret!=null) {
            foreach ($attributes as $key => $val) {
                $ret->$key = $val;
            }
            //dd($ret);
            $ret->save();
            return $ret;
        } else {
            return $this->create($attributes);
        }

    }


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
            return $this->_createDefault($iface);
        else
            return $ret;

    }


    public function setDefault($iface) {
        $if = $this->get($iface);
        $if->delete(); // empty and setup it up again//
        $if = $this->get($iface);
    }

    private function _createDefault($iface) {
        $vars=array(
            'dev' =>$iface,
            'dhcp'=>'1',
        );
        return $this->create($vars);
    }

    public function all() {
        return network_data::all();
    }
}