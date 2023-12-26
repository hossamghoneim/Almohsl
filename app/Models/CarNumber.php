<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarNumber extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts   = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];

    public function miniTrackers()
    {
        return $this->hasMany(MiniTracker::class);
    }

    public function bigTrackers()
    {
        return $this->hasMany(BigTracker::class);
    }
}
