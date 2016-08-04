<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/7/15
 * Time: 10:15 PM
 */

namespace app\Repositories;
use App\Jobs\factoryReset;
use App\Jobs\resetNetwork;
use App\Repositories\SettingsRepository;
use App\Helpers\pingHelper;
use App\Helpers\InterfacesHelper;
use App\Helpers\mdsumHelper;
use App\Jobs\Reboot;
use App\Jobs\update;

use Illuminate\Foundation\Bus\DispatchesJobs;
/**
 * Class DeviceRepository
 * @package app\Repositories
 */
class DeviceRepository {
    use DispatchesJobs;
    /**
     * @var SettingsRepository|string
     */
    private $settingsRepo="";

    /**
     *
     */
    function __construct()
    {
        $this->settingsRepo = new SettingsRepository();
    }


    /**
     * @return mixed
     */
    public function  getDeviceId() {
        ///returns device id//
        //If there's no we create it//

        $DeviceId=$this->settingsRepo->get('deviceId');


        if ($DeviceId==null) {
            $attr=array(
                'key'=>'deviceId',
                'value'=>strtoupper(str_random(15)),
            );
            $DeviceId = $this->settingsRepo->create($attr);
        }

        return $DeviceId->value;
    }


    /**
     *
     */
    public function rebootDevice() {
        $this->dispatch(new Reboot());
    }

    public function updateDevice() {
        $this->dispatch(new update());
    }

    public function factoryReset() {
        $this->dispatch(new factoryReset());
    }

    public function networkReset() {
        $this->dispatch(new resetNetwork());
    }

    /**
     * @return mixed
     */
    public function getDeviceCode() {
        $DeviceCode=$this->settingsRepo->get('code');


        if ($DeviceCode==null) {
            $attr=array(
                'key'=>'code',
                'value'=>mt_rand(100000,999999),
            );
            $DeviceCode = $this->settingsRepo->create($attr);
        }

        return $DeviceCode->value;
    }


    /**
     * @return bool
     */
    public function getOnline() {
        $alive = new pingHelper();
        return $alive->isOnline();
    }

    /**
     * @return array
     */
    public function getCurrentIp() {
        $net = new InterfacesHelper("eth0");
        $out =array();
        $out["eth0"] =  $net->getIp();
        $out["wlan0"] = $net->setIface("wlan0")->getIp();
        return $out;
    }

    /**
     * @return array
     */
    public function checkHash() {
        $out=array();
        $md5sum = new mdsumHelper();
        $out["/etc/network/interfaces.default"] = $md5sum->setFile("/etc/network/interfaces.default")->check();
        $out["/etc/wpa_supplicant/wpa_supplicant.conf"] = $md5sum->setFile("/etc/wpa_supplicant/wpa_supplicant.conf")->check();
        return $out;
    }

    /**
     * @return bool
     */
    public function setHash() {
        $md5sum = new mdsumHelper();
        $md5sum->setFile("/etc/network/interfaces.default")->update();
        $md5sum->setFile("/etc/wpa_supplicant/wpa_supplicant.conf")->update();
        return true;
    }
    
    private function isCheckDataOk($checkData) {
        if (!$checkData)
            return false;
            
        if ($checkData["code"] == 200)
            return true;
            
        if ($checkData["errorNb"] == 300)
            return true;
            
        return false;
    }

    /**
     * @return string
     */
    public function readyToServe() {
        $alive = new pingHelper();
        $slideUrl = $this->settingsRepo->get('slideshowUrl');

        //return "/#/connect";

        if (!$alive->isOnline())
            return "/#/configure-device";
        
        if (($slideUrl === null) || (!$slideUrl->value))
            return "/#/connect";

        $deviceCheckUrl = $this->settingsRepo->get('apiUrl');

        $checkData = '';
        
        try {

            $context = stream_context_create(["http" => ["ignore_errors" => true]]);
            $checkData = file_get_contents($deviceCheckUrl->value, false, $context);
            $checkData = json_decode($checkData,1);

        } catch (\Exception $e) {

            $checkData = null;
                    
        }
        
        if (!$this->isCheckDataOk($checkData)) {
        
            $this->settingsRepo->insertSettings(["slideshowUrl" => "0"]);
            return "/#/connect";
        
        }
            
        return $slideUrl->value;

    }


}
