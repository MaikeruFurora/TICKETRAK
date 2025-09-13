<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-primary" href="#">
      {{  config('app.name', 'TaskTicket') }}
    </a>

    <!-- Mobile Offcanvas Toggler -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
      aria-controls="mobileMenu" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Desktop Menu -->
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link px-3 {{ request()->routeIs('auth.tickets.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('auth.tickets.index') }}">
            <!-- Ticket SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3 5h18" />
              <path d="M3 12h18" />
              <path d="M3 19h18" />
            </svg>
            Tickets
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 {{ request()->routeIs('auth.account.profile') ? 'active fw-bold text-primary' : '' }}" href="{{ route('auth.account.profile') }}">
            <!-- Profile SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <circle cx="12" cy="7" r="4" />
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
            Profile
          </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">
            <!-- User Circle SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <circle cx="12" cy="12" r="9" />
              <circle cx="12" cy="10" r="3" />
              <path d="M6.168 18.849a6 6 0 0 1 11.664 0" />
            </svg>
            {{ auth()->user()->name }}
          </a>
          @if (auth()->user()->role=='administrator')
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
              <li><a class="dropdown-item" href="{{ route('auth.account.user') }}">
                <!-- Settings SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <circle cx="12" cy="12" r="3" />
                  <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06 .06a2 2 0 1 1 -2.83 2.83l-.06 -.06a1.65 1.65 0 0 0 -1.82 -.33 1.65 1.65 0 0 0 -1 1.51v.18a2 2 0 1 1 -4 0v-.18a1.65 1.65 0 0 0 -1 -1.51 1.65 1.65 0 0 0 -1.82 .33l-.06 .06a2 2 0 1 1 -2.83 -2.83l.06 -.06a1.65 1.65 0 0 0 .33 -1.82 1.65 1.65 0 0 0 -1.51 -1h-.18a2 2 0 1 1 0 -4h.18a1.65 1.65 0 0 0 1.51 -1 1.65 1.65 0 0 0 -.33 -1.82l-.06 -.06a2 2 0 1 1 2.83 -2.83l.06 .06a1.65 1.65 0 0 0 1.82 .33h.18a1.65 1.65 0 0 0 1 -1.51v-.18a2 2 0 1 1 4 0v.18a1.65 1.65 0 0 0 1 1.51h.18a1.65 1.65 0 0 0 1.82 -.33l.06 -.06a2 2 0 1 1 2.83 2.83l-.06 .06a1.65 1.65 0 0 0 -.33 1.82v.18a1.65 1.65 0 0 0 1.51 1h.18a2 2 0 1 1 0 4h-.18a1.65 1.65 0 0 0 -1.51 1z" />
                </svg>
                Account Settings
              </a></li>
            </ul>
          @endif
        </li>

        <li class="nav-item">
          <a class="nav-link px-3 text-danger" href="{{ route('auth.logout') }}">
            <!-- Logout SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
              <path d="M7 12h14l-3 -3m0 6l3 -3" />
            </svg>
            Sign out
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
