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
}