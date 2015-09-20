<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\DeviceRepository;

class JumpControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $devicerepo = new DeviceRepository();

        return redirect::away($devicerepo->readyToServe());
    }


}
