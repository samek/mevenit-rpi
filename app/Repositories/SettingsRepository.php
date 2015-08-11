<?php
/**
 * Created by PhpStorm.
 * User: samek
 * Date: 8/7/15
 * Time: 10:12 PM
 */
namespace App\Repositories;
use App\Models\settings;


class SettingsRepository {

    public function get($val)
    {
        return settings::where('key','=',$val)->first();

    }

    public function create(array $attributes = [])
    {
        return settings::create($attributes);
    }

    public function update(settings $settings, array $attributes)
    {
        $settings->update($attributes);
        return $settings;
    }

    public function all() {
        return settings::all();
    }
}