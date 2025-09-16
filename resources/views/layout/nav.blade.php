<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="#">{{ config('app.name', 'TaskTicket') }}</a>

        <!-- Mobile Offcanvas Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
            aria-controls="mobileMenu" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop Menu -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center">

                <!-- Tickets -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('auth.tickets.*') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('auth.tickets.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details me-1"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 5h18" />
                            <path d="M3 12h18" />
                            <path d="M3 19h18" />
                        </svg>
                        Tickets
                    </a>
                </li>

                <!-- Profile -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('auth.account.profile') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('auth.account.profile') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-1"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Profile
                    </a>
                </li>

                 @if(auth()->user()->role=='ticket_manager' || auth()->user()->role=='administrator')
                  <!-- Reports -->
                 <li class="nav-item">
                      <a class="nav-link px-3 {{ request()->routeIs('auth.report.index') ? 'active fw-bold text-primary' : '' }}"
                          href="{{ route('auth.report.index') }}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                              class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-data">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                              <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                              <path d="M9 17v-4" />
                              <path d="M12 17v-1" />
                              <path d="M15 17v-2" />
                              <path d="M12 17v-1" />
                          </svg>
                          Report
                      </a>
                  </li>
                 @endif

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-user-circle me-1" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="12" r="9" />
                            <circle cx="12" cy="10" r="3" />
                            <path d="M6.168 18.849a6 6 0 0 1 11.664 0" />
                        </svg>
                        {{ auth()->user()->name }}
                    </a>
                    @if(auth()->user()->role=='administrator')
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="{{ route('auth.account.user') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-settings me-1" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="3" />
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06 .06a2 2 0 1 1 -2.83 2.83l-.06 -.06a1.65 1.65 0 0 0 -1.82 -.33 1.65 1.65 0 0 0 -1 1.51v.18a2 2 0 1 1 -4 0v-.18a1.65 1.65 0 0 0 -1 -1.51 1.65 1.65 0 0 0 -1.82 .33l-.06 .06a2 2 0 1 1 -2.83 -2.83l.06 -.06a1.65 1.65 0 0 0 .33 -1.82 1.65 1.65 0 0 0 -1.51 -1h-.18a2 2 0 1 1 0 -4h.18a1.65 1.65 0 0 0 1.51 -1 1.65 1.65 0 0 0 -.33 -1.82l-.06 -.06a2 2 0 1 1 2.83 -2.83l.06 .06a1.65 1.65 0 0 0 1.82 .33h.18a1.65 1.65 0 0 0 1 -1.51v-.18a2 2 0 1 1 4 0v.18a1.65 1.65 0 0 0 1 1.51h.18a1.65 1.65 0 0 0 1.82 -.33l.06 -.06a2 2 0 1 1 2.83 2.83l-.06 .06a1.65 1.65 0 0 0 -.33 1.82v.18a1.65 1.65 0 0 0 1.51 1h.18a2 2 0 1 1 0 4h-.18a1.65 1.65 0 0 0 -1.51 1z" />
                                    </svg>
                                    Account Settings
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>

                <!-- Notifications Dropdown (Desktop) -->
                <li class="nav-item dropdown d-none d-lg-block">
                   <a class="nav-link position-relative px-0" href="#" data-bs-toggle="dropdown">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="24"
                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M5 17h14l-1.5 -5.5a5 5 0 0 0 -10 0z" />
                          <path d="M13.73 21a2 2 0 0 1 -3.46 0" />
                      </svg>

                      @php
                          $unreadCount = auth()->user()->unreadNotifications->count();
                      @endphp

                      @if($unreadCount > 0)
                          <span class="badge bg-danger text-white position-absolute top-3 start-100 translate-middle p-1"
                                style="font-size: 0.65rem; transform: translate(-50%, -50%);">
                              {{ $unreadCount }}
                          </span>
                      @endif
                  </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-0" style="min-width: 350px;">
                        <li class="dropdown-header bg-light px-3 py-2 fw-bold">Notifications</li>
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <li>
                                <a class="dropdown-item d-flex align-items-start px-3 py-2 border-bottom"
                                    href="{{ $notification->data['url'] ?? '#' }}">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $notification->data['title'] ?? 'No Title' }}</div>
                                        <div class="text-truncate text-muted" style="max-width: 250px;">
                                            {{ $notification->data['msg'] ?? '' }}
                                        </div>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-center text-muted py-3">
                                No new notifications
                            </li>
                        @endforelse
                        <li><hr class="dropdown-divider m-0"></li>
                        <li>
                            <a class="dropdown-item text-center fw-bold small text-primary py-2"
                                href="{{  route('auth.notifications.index')  }}">
                                View All
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link px-3 text-danger" href="{{ route('auth.logout') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout me-1" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
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

<!-- Mobile Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">{{ config('app.name') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link px-3" href="{{ route('auth.tickets.index') }}">Tickets</a></li>
            <li class="nav-item"><a class="nav-link px-3" href="{{ route('auth.account.profile') }}">Profile</a></li>

            <!-- Mobile Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link position-relative px-3" href="#" data-bs-toggle="dropdown">
                    Notifications
                    @if($unreadCount > 0)
                        <span class="badge bg-danger text-white rounded-pill ms-1" style="font-size: 0.7rem;">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end p-2 shadow" style="min-width: 300px; max-height: 350px; overflow-y: auto;">
                    <li class="dropdown-header px-2 py-1 fw-bold text-uppercase text-muted">Notifications</li>

                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <li class="mb-2">
                            <a class="dropdown-item p-2 d-flex flex-column border rounded hover-bg-light" href="{{ $notification->data['url'] ?? '#' }}">
                                <div class="fw-bold">{{ $notification->data['title'] ?? 'No Title' }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 260px;">
                                    {{ Str::limit($notification->data['msg'] ?? '', 80) }}
                                </div>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                    @empty
                        <li class="text-center text-muted py-3">No new notifications</li>
                    @endforelse

                    <li><hr class="dropdown-divider m-0"></li>

                    <li>
                        <a class="dropdown-item text-center fw-bold small text-primary py-2" href=" ">
                            View All
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Logout -->
            <li class="nav-item"><a class="nav-link px-3 text-danger" href="{{ route('auth.logout') }}">Sign out</a></li>
        </ul>
    </div>
</div>
