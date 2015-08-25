<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DeviceControllerAPI extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */




    public function reboot() {
        $msg=array('job'=>"queued");
        return  $this->respondWithData($msg);

    }
    public function update() {
        $msg=array('job'=>"queued");
        return $this->respondWithData($msg);

    }
    public function resetNetwork() {
        $msg=array('job'=>"queued");
        return $this->respondWithData($msg);

    }
    public function factoryReset() {
        $msg=array('job'=>"queued");
        return $this->respondWithData($msg);

    }



}
