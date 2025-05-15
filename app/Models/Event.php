<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Planner;

class Event extends Model
{
    protected $fillable = ['title', 'start', 'end'];

    public function planners(): BelongsToMany
{
    return $this->belongsToMany(Planner::class, 'event_planner');
}
}
