<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_permissions';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id','user_id','created_at','updated_at'
    ];
}
