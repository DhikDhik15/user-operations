<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    protected $table = 'roles';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
