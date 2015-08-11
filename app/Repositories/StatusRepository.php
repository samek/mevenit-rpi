<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/11/15
 * Time: 11:39 PM
 */

namespace app\Repositories;
use App\Repositories\SettingsRepository;
use App\Repositories\NetworkRepository;
use App\Repositories\DeviceRepository;
use App\Models\wifi_data;

/**
 * Class StatusRepository
 * @package app\Repositories
 */
class StatusRepository {


    /**
     * @var SettingsRepository|string
     */
    private $settingsRepo="";
    /**
     * @var NetworkRepository|string
     */
    private $networkRepo ="";
    /**
     * @var DeviceRepository|string
     */
    private $deviceRepo  ="";


    /**
     *
     */
    function __construct()
    {
        $this->settingsRepo = new SettingsRepository();
        $this->deviceRepo   = new DeviceRepository();
        $this->networkRepo  = new NetworkRepository();

    }




    ///ALL STATUS///
    /**
     * @return array
     */
    public function getStatusAll() {
    $out = array();

        $out['network']['interfaces']['eth0'] = $this->_getIfaceStatus("eth0");
        $out['network']['interfaces']['wlan0'] = $this->_getIfaceStatus("wlan0");


        $out['connected'] = $this->_getOnlineStatus();
        $out['slideshowUrl'] = $this->_getSlideShowUrl();


        //Wifi networks//
        if ($wlans = $this->_getWifiNetworks())
            $out['network']['wifiNetworks'] =$wlans;
        else
            $out['network']['wifiNetworks'] =array();

        //Hashing of network files//
        $out['network']['hash'] = $this->deviceRepo->checkHash();
        return $out;
    }


    /**
     * @return array
     */
    public function getStatusOnline() {
        $out = array();
        $out["connected"] = $this->_getOnlineStatus();
        return $out;
    }


    /**
     * @param $iface
     * @return array
     */
    public function getStatusIface($iface) {
        $out  = array();
        $out[$iface] = $this->_getIfaceStatus($iface);
        return $out;
    }

    /**
     * @param $iface
     * @return mixed
     */
    private function _getIfaceStatus($iface) {
       //dd($this->networkRepo->get($iface));
       $iface = $this->networkRepo->get($iface);
       return $iface->toArray();

   }

    /**
     * @return bool|mixed
     */
    private function _getWifiNetworks() {
        $wlans = wifi_data::where('key','=','networks')->first();
        if ($wlans!=null) {
            $wlans = json_decode(($wlans->value));
            return $wlans;
        }
        else {
            return false;
        }
    }

    /**
     * @return int
     */
    private function _getOnlineStatus() {

        $connected =1;
        if ($this->deviceRepo->getOnline()) {
            ///We are online but may not be paired//
            $connected=2;
            if ($surl = $this->_getSlideShowUrl()) {
                $connected    =3;
            }
        } else {
            $connected=1;
        }
        return $connected;
    }


    /**
     * @return bool
     */
    private function _getSlideShowUrl() {
        if ($surl = $this->settingsRepo->get('slideshowUrl')!=null)
            return $surl;
        else
            return false;
    }
}