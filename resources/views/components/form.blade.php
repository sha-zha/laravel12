<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    @foreach($model->getAttributes() as $key => $value)
        @continue(in_array($key, ['id', 'created_at', 'updated_at']))

        <div class="mb-3">
            <label for="{{ $key }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>

            @php
                $type = 'text';
                if (str_contains($key, 'email')) $type = 'email';
                elseif (str_contains($key, 'password')) $type = 'password';
                elseif (str_contains($key, 'date')) $type = 'date';
                elseif (is_bool($value) || $value === 0 || $value === 1) $type = 'checkbox';
                elseif (strlen($value) > 255) $type = 'textarea';
            @endphp

            @if($type === 'textarea')
                <textarea class="form-control" name="{{ $key }}" id="{{ $key }}">{{ old($key, $value) }}</textarea>
            @elseif($type === 'checkbox')
                <input type="checkbox" class="form-check-input" name="{{ $key }}" id="{{ $key }}" {{ $value ? 'checked' : '' }}>
            @else
                <input type="{{ $type }}" class="form-control" name="{{ $key }}" id="{{ $key }}" value="{{ old($key, $value) }}">
            @endif
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>