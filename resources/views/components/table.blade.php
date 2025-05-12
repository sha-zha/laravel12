@php use Carbon\Carbon; @endphp

@if($data->isNotEmpty())
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                @foreach(array_keys($data->first()->getAttributes()) as $key)
                    <th>{{ $headers[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}</th>
                @endforeach
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
              @foreach($item->getAttributes() as $value)
                
                  
                               <td>
                            @php
                                $isDate = in_array($key, ['created_at', 'updated_at', 'deleted_at']) &&
                                          strtotime($value) !== false;
                            @endphp

                            @if($isDate)
                                {{ Carbon::parse($value)->translatedFormat('d F Y à H:i') }}
                            @elseif(is_array($value) || is_object($value))
                                <pre>{{ json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                            @else
                                {{ $value }}
                            @endif
                        </td>
               
                
                  @endforeach
                   <td>
                
                     <a href="{{ route("{$routeName}.show", $item->id) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route("{$routeName}.edit", $item->id) }}" class="btn btn-sm btn-warning">Modifier</a>

                    <!-- Bouton Supprimer confirmation-->
<button type="button"
        class="btn btn-sm btn-danger btn-delete"
        data-bs-toggle="modal"
        data-bs-target="#confirmDeleteModal"
        data-action="{{ route("{$routeName}.destroy", $item->id) }}">
    Supprimer
</button>

                    </td>
                </tr>                
            @endforeach
               
        </tbody>
    </table>
@else
    <div class="alert alert-info">Aucune donnée à afficher.</div>
@endif

<!-- Formulaire caché, vide au départ -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Bootstrap unique -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                Es-tu sûr de vouloir supprimer cet élément ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Oui, supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAction = null;

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            currentAction = this.getAttribute('data-action');
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (currentAction) {
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', currentAction);
            form.submit();
        }
    });
</script>