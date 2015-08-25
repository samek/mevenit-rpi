<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SettingsRepository;

/**
 * Class SettingsControllerAPI
 * @package App\Http\Controllers
 */
class SettingsControllerAPI extends ApiController
{


    /**
     * @return mixed
     */
    public function index() {


        $settingsRepo = new SettingsRepository();

        $out = $settingsRepo->allArray();
        return $this->respondWithData($out);
    }
}
