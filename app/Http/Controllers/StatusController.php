<?php

namespace App\Http\Controllers;


use App\Helpers\mdsumHelper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jobs\ChangeNetworkSettings;
use App\Jobs\Reboot;
use App\Repositories\SettingsRepository;


use App\Repositories\DeviceRepository;


class StatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $devicerepo = new DeviceRepository();



        $out = array();


        if ($devicerepo->getOnline()) {
            $out["online"]="true";
        } else {
            $out["omline"]="false";
        }

        $out = array_merge($out,$devicerepo->getCurrentIp());
        $out["deviceId"] = $devicerepo->getDeviceId();
        $out["code"]     = $devicerepo->getDeviceCode();

        //dd($devicerepo->checkHash());
        $out = array_merge($out,$devicerepo->checkHash());
        //$devicerepo->setHash();


        $this->dispatch(new ChangeNetworkSettings($out["deviceId"]));
       // $this->dispatch(new Reboot());

        return $this->respondWithData($out);
    }


}
