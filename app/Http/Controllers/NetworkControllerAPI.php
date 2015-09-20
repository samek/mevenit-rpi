<?php

namespace App\Http\Controllers;

use App\Jobs\ChangeNetworkSettings;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NetworkRepository;

class NetworkControllerAPI extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    public function reset() {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(),1);
        $data["status"]=-1; // Needs to be updated//
        //$data = json_decode('{"dhcp":-1,"ip":"10.0.0.1","netmask":"255.255.255.0","gateway":"10.0.0.1","dns1":"7.7.7.7","dev":"eth0"}',1);
        $networkrepo = new NetworkRepository();

        $dev = $networkrepo->updateIface($data);
        //dd($dev);
        $this->dispatch(new ChangeNetworkSettings());
        return  $this->respondWithData($data);
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
