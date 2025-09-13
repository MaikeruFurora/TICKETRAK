<!-- Stats Cards -->
<div class="row row-cards my-1">
    <!-- Total Tickets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <span class="avatar avatar-lg bg-blue-lt me-3">
                    <!-- Ticket icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 4h12v4h-12z"/>
                        <path d="M6 20h12v-4h-12z"/>
                        <path d="M6 8h12v8h-12z"/>
                    </svg>
                </span>
                <div>
                    <div class="h2 mb-0">{{ $ticket['total'] ?? 0 }}</div>
                    <div class="text-muted">Total Tickets</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resolved Tickets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <span class="avatar avatar-lg bg-green-lt me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M9 12l2 2l4 -4"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </span>
                <div>
                    <div class="h2 mb-0">{{ $ticket['closed'] ?? 0 }}</div>
                    <div class="text-muted">Resolved Tickets</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Tickets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <span class="avatar avatar-lg bg-yellow-lt me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hourglass" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 2l12 0"/>
                        <path d="M6 22l12 0"/>
                        <path d="M6 2l0 6a6 6 0 0 0 12 0l0 -6"/>
                        <path d="M18 22l0 -6a6 6 0 0 0 -12 0l0 6"/>
                    </svg>
                </span>
                <div>
                    <div class="h2 mb-0">{{ $ticket['open'] ?? 0 }}</div>
                    <div class="text-muted">Pending Tickets</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Critical Tickets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <span class="avatar avatar-lg bg-red-lt me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 9v2m0 4v.01"/>
                        <path d="M10 3l-7 12h14l-7 -12z"/>
                    </svg>
                </span>
                <div>
                    <div class="h2 mb-0">{{ $ticket['critical'] ?? 0 }}</div>
                    <div class="text-muted">Critical Tickets</div>
                </div>
            </div>
        </div>
    </div>
</div>