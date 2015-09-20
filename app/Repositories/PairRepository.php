<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/30/15
 * Time: 10:58 AM
 */

namespace app\Repositories;

use App\Repositories\DeviceRepository;
use App\Repositories\SettingsRepository;

class PairRepository {


    private $deviceRepo ="";
    private $pairLink="http://api.meven.it/v1/device-link/?code=##CODE##&deviceId=##DEVICEID##";
    private $code="";
    private $deviceId="";
    private $json="";
    private $settingsRepo="";



    function __construct()
    {
        $this->deviceRepo   = new DeviceRepository();
        $this->code         = $this->deviceRepo->getDeviceCode();
        $this->deviceId     = $this->deviceRepo->getDeviceId();
        $this->settingsRepo = new SettingsRepository();
    }

    public function connect() {
        $this->pairLink = str_replace("##CODE##",$this->code,$this->pairLink);
        $this->pairLink = str_replace("##DEVICEID##",$this->deviceId,$this->pairLink);
        //dd($this->pairLink);

        $out = array();
        $out["deviceId"]=$this->deviceId;
        $out["code"]    =$this->code;



        $this->json     = @file_get_contents($this->pairLink);

        $this->json     = json_decode($this->json);



        if (isset($this->json->data->slideshowUrl)) {
            //We're connected and should write data gathered - also redirect to slideshow//
            $out["status"]=1;
            $out["slideshowUrl"]=$this->json->data->slideshowUrl;
            $this->settingsRepo->insertSettings($this->json->data);
        } else {
            $out["status"]=-1;
        }
       // dd($this->json);
        return $out;
    }

}