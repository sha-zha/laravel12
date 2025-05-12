   <form action="{{ (isset($client)) ? route('client.update', $client->id) : route('client.store') }}" method="post">
      @csrf
      @if(isset($client))
        @method('PUT')
    @endif
      <label for="name">Nom</label>
      <input type="text" name="name" id="name" value="{{ old('name', $client->name ?? '') }}">
      @error('name')
      <span class="text-danger">{{ $message}}</span>
      @enderror
      <button type="submit">Valider</button>
   </form>