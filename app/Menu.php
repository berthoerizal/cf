<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // {id, menu_code, menu_name, menu_desc, menu_ref_id}
    protected $fillable = ['menu_code', 'menu_name', 'menu_desc', 'menu_ref_id'];
}
