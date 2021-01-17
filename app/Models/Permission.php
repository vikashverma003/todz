<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'title','created_at','updated_at'
    ];
}
