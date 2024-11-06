<?php

namespace App\Models;

use App\Models\User;
use App\Models\RolesModel;
use Illuminate\Database\Eloquent\Model;

class UserRolesModel extends Model
{
    protected $table = 'user_roles';
    protected $guarded = [];
    protected $connection = 'mysql';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(RolesModel::class, 'role_id', 'id');
    }
}
