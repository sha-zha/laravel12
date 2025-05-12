@php use Carbon\Carbon; @endphp

@if($data->isNotEmpty())
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                @foreach(array_keys($data->first()->getAttributes()) as $key)
                    <th>{{ $headers[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}</th>
                @endforeach
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
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">Aucune donnée à afficher.</div>
@endif
