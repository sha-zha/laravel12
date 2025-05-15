<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Planner extends Model
{
  
    protected $fillable = ['client_id','created_at'];
    
   public function client()
{
    return $this->belongsTo(Client::class);
}


public function events(): BelongsToMany
{
    return $this->belongsToMany(Event::class, 'event_planner');
}
public function tasks(): BelongsToMany
{
    return $this->belongsToMany(Task::class, 'planner_task');
}
}
