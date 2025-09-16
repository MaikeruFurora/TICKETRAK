$(function () {
            let tableURL = $('#accountUser').data('table-url');
            let roleUrl = $('#accountUser').data('role-url');

            $('#accountUser').DataTable({
                processing: true,   // show "Processing..." indicator
                serverSide: true,   // use server-side processing
                responsive: true,
                autoWidth: false,
                ajax: tableURL, // <-- route to your controller
                columns: [
                    { data: "id", name: "id" },
                    { data: "name", name: "name" },
                    { data: "username", name: "username" },
                    { data: "email", name: "email" },
                    { data: "is_active", name: "is_active" },
                    { data: "created_at", name: "created_at" },
                    { data: "role", name: "role" },
                    { data: "action", name: "action", orderable: false, searchable: false }
                ],
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                error: function (xhr) {
                    if (xhr.status === 401) { 
                        alertify.error("Your session has expired. Please login again.");
                        window.location.href = "/";
                    }
                }
            });

         $('#accountUser').on('change', '.user-role', function () {
            let userId = $(this).data('id');
            let newRole = $(this).val();
            let $select = $(this);

            $select.prop('disabled', true);

            $.ajax({
                url: roleUrl,
                type: 'POST', // or POST if you want
                data: {
                    id: userId,
                    role: newRole,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        alertify.success("Role updated successfully!");
                    } else {
                        alertify.error("Failed to update role!");
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        alertify.error("Session expired! Please login again.");
                        window.location.href = '/';
                    } else {
                        alertify.error("Something went wrong!");
                    }
                },
                complete: function () {
                    $select.prop('disabled', false);
                }
            });
        });

        });