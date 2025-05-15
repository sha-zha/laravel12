<div class="container-fluid">
    <div class="row">
<div class="col-4">
           <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-bold mb-4">{{ $eventId ? 'Modifier' : 'Créer' }} une mission</h2>

                <input type="text" wire:model.defer="title" placeholder="Titre" class="w-full mb-2 border p-2" />
                <input type="datetime-local" wire:model.defer="start" class="w-full mb-2 border p-2" />
                <input type="datetime-local" wire:model.defer="end" class="w-full mb-2 border p-2" />

                <div class="flex justify-between mt-4">
                    <button wire:click="save" class="bg-blue-500 text-white px-4 py-2 rounded">Sauvegarder</button>
                    @if($eventId)
                        <button wire:click="delete" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                    @endif
                    <button wire:click="$set('showModal', false)" class="px-4 py-2">Annuler</button>
                </div>
            </div>

             <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-bold mb-4">{{ $eventId ? 'Modifier' : 'Créer' }} une tâche</h2>
                

<select id="select-beast" placeholder="Select a person..." autocomplete="off" wire:model.defer="client_id">
			<option value="">Select a person...</option>
            @foreach ($clients as $client )
                    <option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
            @endforeach
		</select>


                <input type="text" wire:model.defer="title" placeholder="Titre" class="w-full mb-2 border p-2" />
                <input type="datetime-local" wire:model.defer="start" class="w-full mb-2 border p-2" />
                <input type="datetime-local" wire:model.defer="end" class="w-full mb-2 border p-2" />

                <div class="flex justify-between mt-4">
                    <button wire:click="saveTask" class="bg-blue-500 text-white px-4 py-2 rounded">Sauvegarder</button>
                    @if($eventId)
                        <button wire:click="deleteTask" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                    @endif
                    <button wire:click="$set('showModal', false)" class="px-4 py-2">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
   <div id="calendar" wire:ignore></div>
    </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            selectable: true,
            events: @json($events),
            eventClick: info => {
                Livewire.dispatch('openEditModal', [{id: info.event.id}]);
            }
        });

        calendar.render();

        window.addEventListener('eventSaved', event => {
            calendar.removeAllEvents();
            console.table(event.detail);
            event.detail[0].forEach(element => {
               calendar.addEvent(element)
            });
        });
        
        Livewire.on('eventDeleted', id => {
            const event = calendar.getEventById(id);
            if (event) event.remove();
        });

        new TomSelect("#select-beast",{
	create: true,
	sortField: {
		field: "text",
		direction: "asc"
	}
});
    });
</script>
@endpush