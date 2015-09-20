<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    protected $table = 'settings';
    public    $timestamps = false;
    protected $fillable = array('key', 'value');
    protected $primaryKey = 'key';
}
