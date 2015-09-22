<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/6/15
 * Time: 9:23 PM
 */

namespace App\Helpers;


class pingHelper {

    private $state="";


    function __construct($dest=false)
    {
        if (!$dest)
             $dest="google.com";
        //TEMP REMOVE NETWORK PROBLEM REMOVE ME
        $this->state = shell_exec("/usr/bin/fping ".$dest);
        //$this->state = "alive";

    }
    public  function isOnline() {
        if (stristr($this->state,"alive")) {
            return true;
        }
        return false;
    }
}