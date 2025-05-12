<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">    
</head>
<body>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <table class="table">
        <thead>
            <tr>
                <td>name</td>
            </tr>
            <tr>Action</tr>
        </thead>
        <tbody>
           
                @foreach ($data as $client )
                 <tr>
                     <td>{{ $client->name }}</td>
                 </tr>
                 <tr>
                    <td>
                        <a href="{{ route('client.edit',$client->id) }}">Editer</a>
                        <form action="{{ route('client.destroy', $client->id) }}" method="post">
                            @csrf   
                             @method('DELETE')
                            <input type="submit" value="supprimer">
                        </form>
                    </td>
                 </tr>
           
                @endforeach
                
        </tbody>
    </table>

    <h2>Composant table</h2>
   <x-table 
    :data="$data"
    :headers="[
        'id' => 'ID',
        'name' => 'Nom',
        'email' => 'Courriel',
        'created_at' => 'Créé le',
        'updated_at' => 'Mis à jour le'
    ]"
   route-name="client"
/>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>