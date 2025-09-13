@extends('layout.app')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Page Title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Ticket Dashboard</h2>
                    <div class="text-muted mt-1">Overview of support tickets and activities</div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="text-blue me-3">
                                <i class="ti ti-ticket ti-2x"></i>
                            </span>
                            <div>
                                <div class="h3 mb-0">124</div>
                                <div class="text-muted">Total Tickets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="text-green me-3">
                                <i class="ti ti-circle-check ti-2x"></i>
                            </span>
                            <div>
                                <div class="h3 mb-0">98</div>
                                <div class="text-muted">Resolved Tickets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="text-yellow me-3">
                                <i class="ti ti-hourglass ti-2x"></i>
                            </span>
                            <div>
                                <div class="h3 mb-0">20</div>
                                <div class="text-muted">Pending Tickets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="text-red me-3">
                                <i class="ti ti-alert-triangle ti-2x"></i>
                            </span>
                            <div>
                                <div class="h3 mb-0">6</div>
                                <div class="text-muted">Critical Tickets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Table -->
        <div class="row row-cards mt-3">
            <!-- Tickets by Status Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tickets by Status</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-tickets-status" style="height: 250px;"></div>
                    </div>
                </div>
            </div>

            <!-- Tickets by Department -->
            <div class="col-lg-6">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Tickets</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#TCK-1001</td>
                                    <td>Login Issue</td>
                                    <td><span class="badge bg-yellow">Pending</span></td>
                                    <td><span class="badge bg-red">High</span></td>
                                    <td>2025-09-10</td>
                                </tr>
                                <tr>
                                    <td>#TCK-1002</td>
                                    <td>Email not working</td>
                                    <td><span class="badge bg-green">Resolved</span></td>
                                    <td><span class="badge bg-blue">Medium</span></td>
                                    <td>2025-09-09</td>
                                </tr>
                                <tr>
                                    <td>#TCK-1003</td>
                                    <td>Server downtime</td>
                                    <td><span class="badge bg-red">Critical</span></td>
                                    <td><span class="badge bg-red">High</span></td>
                                    <td>2025-09-08</td>
                                </tr>
                                <tr>
                                    <td>#TCK-1004</td>
                                    <td>Password reset</td>
                                    <td><span class="badge bg-green">Resolved</span></td>
                                    <td><span class="badge bg-blue">Low</span></td>
                                    <td>2025-09-08</td>
                                </tr>
                                <tr>
                                    <td>#TCK-1005</td>
                                    <td>VPN Issue</td>
                                    <td><span class="badge bg-yellow">Pending</span></td>
                                    <td><span class="badge bg-red">High</span></td>
                                    <td>2025-09-07</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>

       

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Tickets by Status Pie Chart
    new ApexCharts(document.querySelector("#chart-tickets-status"), {
        chart: { type: 'pie' },
        series: [98, 20, 6],
        labels: ['Resolved', 'Pending', 'Critical'],
        colors: ['#2ecc71', '#f1c40f', '#e74c3c']
    }).render();

    // Tickets by Department Bar Chart
    new ApexCharts(document.querySelector("#chart-tickets-dept"), {
        chart: { type: 'bar', height: 250 },
        series: [{
            name: 'Tickets',
            data: [40, 25, 15, 10]
        }],
        xaxis: { categories: ['IT', 'HR', 'Finance', 'Support'] },
        colors: ['#3498db']
    }).render();
</script>
@endpush
