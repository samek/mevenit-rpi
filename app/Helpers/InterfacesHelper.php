<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/6/15
 * Time: 9:55 PM
 */

namespace App\Helpers;


class InterfacesHelper {


    private $iface="";

    function __construct($iface="eth0")
    {
        $this->iface=$iface;

    }

    public function getIp() {
        $out = shell_exec('/sbin/ifconfig '.$this->iface.' |grep "inet addr"');
        if (strlen($out)==0)
            //No ip is configured//
            return false;

        ///inet addr:10.0.1.3  Bcast:10.0.1.255  Mask:255.255.255.0
        $out = explode(":",$out);
        $out = explode(" ",$out[1]);
        return $out[0];
    }

    /**
     * @return string
     */
    public function getIface()
    {
        return $this->iface;
    }

    /**
     * @param string $iface
     */
    public function setIface($iface)
    {
        $this->iface = $iface;
        return $this;
    }


}