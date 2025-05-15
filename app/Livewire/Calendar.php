<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\On;

class Calendar extends Component
{
    public $events = [];
    public $showModal = false;
    public $data = [];
    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::all()->map(fn($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'start' => $e->start,
            'end' => $e->end,
        ])->toArray();
    }

    #[On('openCreateModal')]
    public function openCreateModal($start, $end)
    {
        $this->resetForm();
        $this->start = $start;
        $this->end = $end;
        $this->showModal = true;
    }

    #[On('openEditModal')]
    public function openEditModal($id)
    {
        $event = Event::findOrFail($id);
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

        $this->dispatch('eventSaved', [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start,
            'end' => $event->end
        ]);

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