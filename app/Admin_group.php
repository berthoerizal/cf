<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin_group extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //admin_groups {id, group_name, group_desc}
    protected $fillable = ['group_name', 'group_desc'];
}
