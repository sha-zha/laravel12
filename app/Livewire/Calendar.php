<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Planner;
use App\Models\Task;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\Client;
class Calendar extends Component
{
    public $events = [];
    public $showModal = false;
    public $data = [];
    public $client_id =null;
     public $eventId = null;
    public $title = '';
    public $start = '';
    public $end = '';
    public ?Client $client = null;
    public $clients = [];

    public function mount($client = null)
    {
        if ($client instanceof Client) {
            $this->client = $client;
        } elseif (is_numeric($client)) {
            $this->client = Client::find($client);
        }

        $this->loadEvents();
    }

    public function loadEvents()
    {
         if ( $this->client instanceof Client) {
             $plans = Planner::with(['events','tasks', 'client'])
             ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
             ->where('client_id',$this->client->id)->get();

        } else {
            $plans = Planner::with(['events','tasks', 'client'])
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();
      
        }

         $events = [];
        $tasks = [];
        $clients =[];
    foreach ($plans as $plan) {
        foreach ($plan->events as $event) {
            $events[] = [
            'id'    => $event->id,
            'title' => $event->title,
            'start' => $event->start,
            'end'   => $event->end,
            ];
        }
        
        foreach($plan->tasks as $task ) {
            $tasks[] = [
           'id'    => $task->id,
            'title' => $task->title,
            'start' => $task->start,
            'end'   => $task->end,
            ];
        }

        array_push($clients, ['id' => $plan->client->id, 'name'=> $plan->client->name]);
    }
    $this->clients = $clients;
    $this->events = array_merge($tasks, $events);
}

    #[On('openCreateModal')]
    public function openCreateModal($data)
    {
        $this->resetForm();
        $this->start = $data['start'];
        $this->end = $data['end'];
        $this->showModal = true;
    }

    #[On('openEditModal')]
    public function openEditModal($data)
    {
        $event = Event::findOrFail($data['id']);
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->start = $event->start;
        $this->end = $event->end;
        $this->showModal = true;
    }

    public function save()
    {
     
        $this->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $event = Event::updateOrCreate(
            ['id' => $this->eventId],
            ['title' => $this->title, 'start' => $this->start, 'end' => $this->end]
        );
        
        $this->events = collect($this->events)
        ->push([
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start,
            'end' => $event->end
        ]);

        $this->dispatch('eventSaved', $this->events);

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete()
    {
        if ($this->eventId) {
            Event::destroy($this->eventId);
            $this->dispatch('eventDeleted', $this->eventId);
            $this->resetForm();
            $this->showModal = false;
        }
    }

     public function saveTask(Request $request)
    {
     
        $this->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $planner = Planner::where('client_id', $this->client_id)
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->first();

    
        $event = Task::updateOrCreate(
            ['id' => $this->eventId],
            ['title' => $this->title, 'start' => $this->start, 'end' => $this->end]
        );

        if($planner){
            $planner->tasks()->syncWithoutDetaching([$event->id]);
        }

        
        $this->events = collect($this->events)
        ->push([
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start,
            'end' => $event->end
        ]);

        $this->dispatch('eventSaved', $this->events);

        $this->resetForm();
        $this->showModal = false;
    }

    public function deleteTask()
    {
        if ($this->eventId) {
            $task = Task::with('planners')->where('id', $this->eventId)->first();
            $task->removeFromPlanner($task->planners[0]->id);
            $task->delete();
            $this->dispatch('eventDeleted', $this->eventId);
            $this->resetForm();
            $this->showModal = false;
        }
    }

    public function resetForm()
    {
        $this->eventId = null;
        $this->title = '';
        $this->start = '';
        $this->end = '';
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}