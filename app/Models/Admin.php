<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['roles'];
    protected $casts   = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->where('id','!=',2)->withTimestamps();
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

}
