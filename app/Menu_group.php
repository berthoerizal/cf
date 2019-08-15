<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu_group extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // menu_groups {id, admin_group_id, menu_id, mgroup_status, mgroup_r, mgroup_c, mgroup_u, mgroup_d, mgroup_a}
    protected $fillable = ['admin_group_id', 'menu_id', 'mgroup_status', 'mgroup_c', 'mgroup_r', 'mgroup_u', 'mgroup_d', 'mgroup_a'];
}
