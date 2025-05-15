<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Planner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable = ['title', 'start', 'end'];
    public function removeFromPlanner($plannerId): void
{
    $this->planners()->detach($plannerId);
}
    
    public function planners(): BelongsToMany
{
    return $this->belongsToMany(Planner::class, 'planner_task');
}
}
