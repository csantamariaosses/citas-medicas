<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administración
          </a>
          <ul class="dropdown-menu">

            <li><a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a></li>
            <li><a class="dropdown-item" href="{{ route('permissions.index') }}">Permisos</a></li>
            <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a></li>
            <li><a class="dropdown-item" href="{{ route('patients.index') }}">Pacientes</a></li>
            <li><a class="dropdown-item" href="{{ route('bloodTypes.index') }}">Tipos de Sangre</a></li>
            <li><a class="dropdown-item" href="{{ route('doctores.index') }}">Doctores</a></li>
            <li><a class="dropdown-item" href="{{ route('specialities.index') }}">Especialidades</a></li>
            <li><a class="dropdown-item" href="{{ route('appointments.index') }}">Citas</a></li>
            <li><a class="dropdown-item" href="{{ route('calendar.index') }}">Calendario</a></li>
            <li><a class="dropdown-item" href="{{ route('agendadoc') }}">Agenda Doc</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
        @auth
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link nav-link" style="display: inline; padding: 0; margin-top: 8px; border: none; background: none;">Logout</button>                
            </form>
            
       </li>
        <li class="nav-item">
           <a class="nav-link"  style="color:#0000ff"  href="#">{{  Auth::user()->name }}</a>
        </li>

        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        @endauth
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>