<?php

namespace App\Http\Controllers;

use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DeviceControllerAPI extends ApiController
{


    private $deviceRepo="";
    function setRepo()
    {
        $this->deviceRepo = new DeviceRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */





    public function reboot() {
        $this->setRepo();
        $msg=array('job'=>"queued");
        $this->deviceRepo->rebootDevice();
        return  $this->respondWithData($msg);

    }
    public function update() {
        $this->setRepo();
        $msg=array('job'=>"queued");
        $this->deviceRepo->updateDevice();
        return $this->respondWithData($msg);

    }
    public function resetNetwork() {
        $this->setRepo();
        $msg=array('job'=>"queued");
        $this->deviceRepo->networkReset();
        return $this->respondWithData($msg);

    }
    public function factoryReset() {
        $this->setRepo();
        $msg=array('job'=>"queued");
        $this->deviceRepo->factoryReset();
        return $this->respondWithData($msg);

    }



}
