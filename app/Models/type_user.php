<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class type_user extends Model
{
    protected $table = 'type_users';
    protected $primaryKey = 'type_users_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /**
     * Relación con el modelo User
     */
    public function users()
    {
        return $this->hasMany(User::class, 'type_users_id', 'type_users_id');
    }
}
