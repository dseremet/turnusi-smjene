<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    public $fillable = ['user_id', 'name', 'shift', 'working_from', 'working_to'];

    public $dates = ['working_from', 'working_to'];
}
