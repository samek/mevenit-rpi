<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/6/15
 * Time: 9:38 PM
 */

namespace App\Helpers;

use App\Repositories\SettingsRepository;
class mdsumHelper {

    private $settingsrepo="";
    private $file="";

    function __construct($file="/etc/network/interfaces.default")
    {

        $this->file=$file;
        $this->settingsrepo = new SettingsRepository();

    }

    public function check() {

        if ($md5 = $this->settingsrepo->get($this->file)) {
            /// so we have it .. let's check if it's realy the same//
            //
            $check = $this->_md5sum();
            //dd($md5->value." vs ".$check);
            if ($check!=$md5->value) {
                return false;
            }

            return true;

        } else {
            return false;
        }

    }


    public function update() {

        $check = $this->_md5sum();

        $attr=array();
        if (!$md5 = $this->settingsrepo->get($this->file)) {
            //$md5 = new settings();
            //$md5->key=$this->file;
            $attr['key']=$this->file;
            $attr['value']=$check;
            $this->settingsrepo->create($attr);
        } else {
            $md5->value=$check;
            $md5->save();
        }


    }

    private function _md5sum() {
        if (!file_exists($this->file))
            return false;

        $check = shell_exec("/usr/bin/md5sum ".$this->file);
        $check = explode(" ",$check);
        $check = $check[0];
        return $check;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }


}
