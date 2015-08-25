<?php

namespace App\Http\Controllers;


use App\Helpers\mdsumHelper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jobs\ChangeNetworkSettings;
use App\Jobs\Reboot;
use App\Repositories\SettingsRepository;
use App\Repositories\NetworkRepository;

use App\Repositories\DeviceRepository;


use App\Repositories\StatusRepository;

class StatusControllerAPI extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $statusRepo = new StatusRepository();
        $out = $statusRepo->getStatusAll();
        return $this->respondWithData($out);
    }

    public function online() {
        $statusRepo = new StatusRepository();
        $out = $statusRepo->getStatusOnline();
        $out["connected"]=2;
        return $this->respondWithData($out);
    }

    public function iface($iface) {
        $statusRepo = new StatusRepository();
        $out = $statusRepo->getStatusIface($iface);
        return $this->respondWithData($out);
    }


}
