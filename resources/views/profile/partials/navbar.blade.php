<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mon Application</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            @auth
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Tableau de bord Admin</a>
                    </li>
                @elseif(Auth::user()->role === 'agent')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agent.tableau') }}">Tableau de bord Agent</a>
                    </li>
                @endif
            @endauth
        </ul>
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <span class="nav-link">Bonjour, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>
