<html>

<head>
    <title>VetClin - @yield('titulo')</title>
    <meta charset="UTF-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            padding: 40px;
        }

        .navbar {
            margin-bottom: 30px;
        }

        .card {
            margin: 20px;
        }

        .card-header {
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-success">
        <a class="navbar-brand" href="{{ route('clinica.index') }}"><b>VetClin System</b></a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li @if($tag=="CLI" ) class="nav-item active" @else class="nav-item" @endif>
                    <a class="nav-link" href="{{ route('cliente.index') }}">
                        <b>Clientes</b>
                    </a>
                </li>
                <li @if($tag=="VET" ) class="nav-item active" @else class="nav-item" @endif>
                    <a class="nav-link" href="{{ route('veterinario.index') }}">
                        <b>Veterinários</b>
                    </a>
                </li>
                <li @if($tag=="ESP" ) class="nav-item active" @else class="nav-item" @endif>
                    <a class="nav-link" href="{{ route('especialidade.index') }}">
                        <b>Especialidades</b>
                    </a>
                </li>
                <li @if($tag=="PET" ) class="nav-item active" @else class="nav-item" @endif>
                    <a class="nav-link" href="{{ route('pet.index') }}">
                        <b>Pets</b>
                    </a>
                </li>
                <li @if($tag=="RAC" ) class="nav-item active" @else class="nav-item" @endif>
                    <a class="nav-link" href="{{ route('raca.index') }}">
                        <b>Raças</b>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="card">
        <div class="card-header bg-success">
            <div class="row">
                <div class="col-sm-8">
                    <h3><b>{{$titulo}}</b></h2>
                </div>
                <div class="col-sm-4" align="right">
                    @if($tag=='CLI') <img src="{{ asset('img/icons/cliente.png') }}">
                    @elseif($tag=='VET') <img src="{{ asset('img/icons/vet.png') }}">
                    @elseif($tag=='ESP') <img src="{{ asset('img/icons/especialidade.png') }}">
                    @elseif($tag=='PET') <img src="{{ asset('img/icons/pet.png') }}">
                    @elseif($tag=='RAC') <img src="{{ asset('img/icons/raca.png') }}">
                    @elseif($tag=='ICA') <img src="{{ asset('img/icons/clinica.png') }}">
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @yield('conteudo')
        </div>
    </div>
    <hr>
</body>
<footer>
    <b>&copy;2020 - Jéss Gonçalves.</b>
</footer>

<script src="{{asset('js/app.js')}}" type="text/javascript"></script>

@yield('script')

</html>