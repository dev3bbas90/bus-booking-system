<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('dashboard.home') }}" class="nav-link {{ Request::is('dashboard/') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('dashboard.stations.index') }}" class="nav-link {{ Request::is('dashboard/stations') ? 'active' : '' }}">
        <i class="nav-icon fas fa-charging-station"></i>
        <p>Stations</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('dashboard.buses.index') }}" class="nav-link {{ Request::is('dashboard/buses') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bus"></i>
        <p>Buses</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('dashboard.trips.index') }}" class="nav-link {{ Request::is('dashboard/trips') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane-departure"></i>
        <p>Trips</p>
    </a>
</li>
