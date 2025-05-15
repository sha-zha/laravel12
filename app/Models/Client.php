<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientsFactory> */
    use HasFactory;

    protected $fillable = ['name'];

     public function planners() {
        return $this->hasMany(Planner::class);
    }
}
