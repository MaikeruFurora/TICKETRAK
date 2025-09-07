<!-- Offcanvas toggler in the top nav -->
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">TicketRak</a>

    <!-- show offcanvas toggler on small screens -->
    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
      aria-controls="mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- normal desktop items -->
    <div class="d-none d-lg-flex align-items-center ms-auto">
      <a class="nav-link px-3" href="#">Dashboard</a>
      <a class="nav-link px-3" href="{{  route('auth.tickets.index') }}">Tickets</a>
      <a class="nav-link px-3" href="{{  route('auth.account.profile') }}">Profile</a>
      <!-- user dropdown -->
      <div class="dropdown mx-3">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Account</a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{  route('auth.account.user') }}">Account User</a></li>
          
        </ul>
      </div>
      <!-- user dropdown -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{  explode(' ', auth()->user()->name)[0] }}</a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{  route('auth.account.profile') }}">Profile</a></li>
          <li><a class="dropdown-item text-danger" href="{{ route('auth.logout') }}">Sign out</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Offcanvas panel -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
      <li><hr></li>
      <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
      <li class="nav-item"><a class="nav-link text-danger" href="{{ route('auth.logout') }}">Sign out</a></li>
    </ul>
  </div>
</div>
