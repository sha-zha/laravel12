<div>
    <div id="calendar"></div>

    @if ($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow w-1/3">
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
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            selectable: true,
            events: @json($events),
            select: info => {
                Livewire.dispatch('openCreateModal', info.startStr, info.endStr);
            },
            eventClick: info => {
                Livewire.dispatch('openEditModal', info.event.id);
            }
        });
        calendar.render();

        Livewire.on('eventSaved', event => {
            calendar.addEvent(event);
        });

        Livewire.on('eventDeleted', id => {
            const event = calendar.getEventById(id);
            if (event) event.remove();
        });
    });
</script>
@endpush