<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/7/15
 * Time: 10:12 PM
 */
namespace App\Repositories;
use App\Models\settings;


/**
 * Class SettingsRepository
 * @package App\Repositories
 */
class SettingsRepository {

    /**
     * @param $val
     * @return mixed
     */

    public function insertSettings($array) {

        foreach ($array as $key=>$val) {
            unset($attr);
            if (!isset($val) or !isset($key))
                continue;
            if (is_object($val))
                continue;
            if (trim($val)=="" or trim($key)=="")
                continue;
            $attr["key"]   = $key;
            $attr["value"] = $val;
            $cVal = $this->get($key);
            if ($cVal!=null) {
                //we update it//
                $this->update($cVal,$attr);
            } else {
                $this->create($attr);
            }
        }
    }

    public function get($val)
    {
        return settings::where('key','=',$val)->first();

    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        //dd($attributes);
        return settings::create($attributes);
    }

    /**
     * @param settings $settings
     * @param array $attributes
     * @return settings
     */
    public function update(settings $settings, array $attributes)
    {
        $settings->update($attributes);
        return $settings;
    }

    /**
     * @return mixed
     */
    public function all() {
        return settings::all();
    }

    /**
     * @return array
     */
    public function allArray() {
        $settings =  settings::all();
        $out =array();
        foreach ($settings as $set) {
            $out[$set->key] = $set->value;
        }
        return $out;
    }

    public function getPairDataSettings() {
        $keys = array('deviceId','code','slideshowUrl');

        $out = array();
        foreach ($keys as $key) {
            $k = $this->get($key);
            if ($k!=null) {
                $out[$k->key]= $k->val;
            }

        }
        return $out;
    }
}