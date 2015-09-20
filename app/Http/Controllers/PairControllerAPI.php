<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PairRepository;

class PairControllerAPI extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pairRepo = new PairRepository();

       return  $this->respondWithData($pairRepo->connect());
    }


}
