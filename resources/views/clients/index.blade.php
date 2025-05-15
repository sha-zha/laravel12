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
    <div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif



<a href="{{route('client.create') }}" class="btn btn-primary">Ajouter</a>
<main>

  @livewire('calendar')

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    @stack('scripts')
<script>
    // Disparition automatique de l'alerte après 60 secondes
    setTimeout(() => {
        const alert = document.getElementById('flash-alert');
        if (alert) {
            alert.classList.remove('show'); // effet Bootstrap
            alert.classList.add('fade'); // pour bien le cacher visuellement
            setTimeout(() => alert.remove(), 500); // suppression du DOM
        }
    }, 60000); // 60 000 ms = 60 secondes
</script>

</body>

</html>