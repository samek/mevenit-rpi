<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/6/15
 * Time: 9:55 PM
 */

namespace App\Helpers;
use App\Models\network_data;
use App\Repositories\NetworkRepository;


class InterfacesHelper {


    private $iface="";
    private $netmask="";
    private $gateway="";
    private $dns="";
    private $dhcp=true;
    private $ifIp="";

    private $path="";
    private $interfaces;
    private $wpa;
    private $wifiname="";
    private $pass="";





    function __construct($iface="eth0")
    {
        $this->iface=$iface;
        $this->path       = base_path()."/resources/system/";
        $this->wpa        = $this->path."wpa_supplicant.conf.default";
        $this->interfaces = $this->path."interfaces.default";

    }

    ///You better be root// (should be called from queue)
    public function reset() {
        $networkrepo = new NetworkRepository();

        $this->resetInterFaces();
        $this->resetWpa();


        $networkrepo->setDefault("eth0");
        $networkrepo->setDefault("wlan0");
    }


    public function restart() {
        $this->ifRestart("eth0");
        $this->ifRestart("wlan0");
    }


    private function resetWpa() {
        copy($this->wpa,"/etc/wpa_supplicant/wpa_supplicant.conf");
	$this->stopHotspot();
    }

    private function resetInterFaces() {
        copy($this->interfaces,"/etc/network/interfaces");
    }

    private function stopHotspot() {
	shell_exec("/bin/systemctl stop isc-dhcp-server");
	shell_exec("/bin/systemctl stop hostapd");
    }

    public function writeWpa($data) {
        file_put_contents("/etc/wpa_supplicant/wpa_supplicant.conf",$data);
	$this->stopHotspot();
    }

    public function writeInterFaces($data) {
        file_put_contents("/etc/network/interfaces",$data);

    }

    ///You better be root// (should be called from queue)
    public function ifRestart($iface) {
        if ($iface!="eth0" or $iface!="wlan0")
        shell_exec("/sbin/ifdown ".$iface);
        shell_exec("/sbin/ifup ".$iface);
    }


    public function fillData(network_data $data) {
        $this->setIfIp($data->ip);
        $this->setDhcp($data->dhcp);
        $this->setNetmask($data->netmask);
        $this->setGateway($data->gateway);
        $this->setDns($data->dns1." ".$data->dns2);
        $this->setIface($data->dev);
        $this->setPass($data->pass);
        $this->setWifiname($data->wifiname);
    }

    public function getIp() {
        $out = shell_exec('/sbin/ifconfig '.$this->iface.' |grep "inet addr"');
        if (strlen($out)==0)
            //No ip is configured//
            return false;

        ///inet addr:10.0.1.3  Bcast:10.0.1.255  Mask:255.255.255.0
        $out = explode(":",$out);
        $out = explode(" ",$out[1]);
        return $out[0];
    }



    public function createInterfacesConfig() {
        $outIfaces="";

        if ($this->dhcp==1) {
            $outIfaces.="auto ".$this->iface."\n";
            $outIfaces.="allow-hotplug ".$this->iface."\n";
            $outIfaces.="iface ".$this->iface." inet dhcp\n";
        } else {
            //should be static
            $outIfaces.="auto ".$this->iface."\n";
            $outIfaces.="allow-hotplug ".$this->iface."\n";
            $outIfaces.="iface ".$this->iface." inet static\n";
            if ($this->getIfIp())
                $outIfaces.="address ".$this->getIfIp()."\n";
            if ($this->getNetmask())
                $outIfaces.="netmask ".$this->getNetmask()."\n";
            else
                $outIfaces.="netmask 255.255.255.0\n";

            if ($this->getGateway())
                $outIfaces.="gateway ".$this->getGateway()."\n";
            if ($this->getDns())
                $outIfaces.="dns-nameservers ".$this->getDns()."\n";
            else
                $outIfaces.="dns-nameservers 8.8.8.8\n";
        }



        if (strstr($this->iface,"wlan")) {
            $outIfaces.="wpa-conf /etc/wpa_supplicant/wpa_supplicant.conf\n";
        }

        if (stristr($this->iface,"lo")) {
            return $this->createLocalInterfacesConfig();
        }

        $outIfaces.="\n";
        return $outIfaces;
    }


    public function createWpaSupplicant() {
       if ($this->getPass()!="") {
           $out =  $this->_createWpaSupplicantPass($this->getWifiname(),$this->getPass());
       } else {
           //It's open network
           $out =  $this->_createWpaSupplicantOpen($this->getWifiname());
       }

        $prepend = file_get_contents($this->wpa);
        return $prepend.$out;
    }

    private function _createWpaSupplicantPass($ssid,$pass) {
        return shell_exec("/usr/bin/wpa_passphrase ".$ssid." '".$pass."'");
    }

    private function _createWpaSupplicantOpen($ssid) {
        return 'network={
  ssid="'.$ssid.'"
  key_mgmt=NONE
  priority=1
}';
    }


    public function createLocalInterfacesConfig() {
        $out = "auto lo\n";
        $out.="iface lo inet loopback\n\n\n";
        return $out;
    }


    /**
     * @return string
     */
    public function getIfIp()
    {
        return $this->ifIp;
    }

    /**
     * @param string $ifIp
     */
    public function setIfIp($ifIp)
    {
        $this->ifIp = $ifIp;
        return $this;
    }

    /**
     * @return string
     */
    public function getNetmask()
    {
        return $this->netmask;
    }

    /**
     * @param string $netmask
     */
    public function setNetmask($netmask)
    {
        $this->netmask = $netmask;
        return $this;
    }

    /**
     * @return string
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param string $gateway
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return string
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * @param string $dns
     */
    public function setDns($dns)
    {
        $this->dns = $dns;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDhcp()
    {
        return $this->dhcp;
    }

    /**
     * @param boolean $dhcp
     */
    public function setDhcp($dhcp)
    {
        $this->dhcp = $dhcp;
        return $this;
    }


    /**
     * @return string
     */
    public function getIface()
    {
        return $this->iface;
    }

    /**
     * @param string $iface
     */
    public function setIface($iface)
    {
        $this->iface = $iface;
        return $this;
    }

    /**
     * @return string
     */
    public function getWifiname()
    {
        return $this->wifiname;
    }

    /**
     * @param string $wifiname
     */
    public function setWifiname($wifiname)
    {
        $this->wifiname = $wifiname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }



}
