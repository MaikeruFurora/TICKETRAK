<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ticketrak</title>
  <link rel="icon" href="{{ asset('dist/images/logo.svg') }}" type="image/x-icon">
   <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 + Tabler CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">
  <!-- DataTables Bootstrap 5 CSS -->
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <!-- Select2 CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <style>
    /* Override Tabler default font */
    body, .page, .page-body, .container-xl,
    input, select, button, textarea {
      font-family: 'Poppins', Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    /* Specifically target date input */
    input[type="date"] {
      font-family: 'Poppins', Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    input[type="text"] {
      font-family: 'Poppins', Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }


    /* Make table responsive font slightly smaller on mobile */
    @media (max-width: 576px) {
      table.dataTable {
        font-size: 0.85rem;
      }
    }

    /* Add subtle spacing for forms and buttons on mobile */
    .form-label {
      font-size: 0.75rem;
    }

    .btn {
      font-size: 0.85rem;
    }

    /* Optional: subtle card shadow tweak */
    .card {
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    
    /* Match Tabler’s card/table spacing */
    .dataTables_wrapper .dataTables_filter input {
      border-radius: 8px;
      padding: 0.25rem 0.5rem;
      border: 1px solid #ddd;
      margin-left: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0.3rem 0.6rem;
      border-radius: 6px;
    }

    .dataTables_wrapper .dataTables_info {
      font-size: 0.85rem;
      color: #6c757d;
    }

    td.dtr-control {
      text-align: center;
      vertical-align: middle;
      cursor: pointer;
    }
    @media (max-width: 768px) {
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter {
      text-align: center;
      width: 100%;
    }

    div.dataTables_wrapper div.dataTables_filter input {
      width: 100% !important; /* full width search */
      margin-top: .5rem;
    }
  }



  </style>
  @yield('style')
</head>
<body> 
  <div class="page">
    @include('layout.nav')
    <div class="page-wrapper">
      <div class="page-body">
        <div class="container-xl">
          @yield('content')
        </div>
      </div>
    </div>
    @include('layout.footer')
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  @yield('scripts')
</body>
</html>