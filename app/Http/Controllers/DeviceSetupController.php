<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NetworkRepository;


class DeviceSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $network = new NetworkRepository();
        $eth0  = $network->get('eth0');
        $wlan0 = $network->get('wlan0');

        $data=array();
        $data["connected"] = 1;
        $data["eth0"] = $eth0->ip;
        $data["wlan0"] = $wlan0->ip;


        return view("index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $networkrepo = new NetworkRepository();

        /*$table->increments('id');
        $table->string('dev');
        $table->integer('dhcp')->default(1);
        $table->string('ip')->nullable();
        $table->string('netmask')->nullable();
        $table->string('gateway')->nullable();
        $table->string('dns1')->nullable();
        $table->string('dns2')->nullable();
        $table->string('wifiname')->nullable();
        $table->string('secure')->nullable();  /// null or WPA WPA2 WEP
        $table->string('pass')->nullable();
        $table->integer('status')->default(1); /// 1 = ready for setup 3 = it's setup // 9 unconfigured///
        */
        $eth0_vars=array(
            'dev' =>'wlan0',
            'ip'  =>'10.0.1.13',
            'netmask' =>'255.255.255.0',
            'gateway' =>'10.0.1.1',
            'dns1'    =>'8.8.8.8',
            'dns2'    =>'8.8.4.4',
        );
        $eth0 = $networkrepo->create($eth0_vars);
        dd($eth0);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
