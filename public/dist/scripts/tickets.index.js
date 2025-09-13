$(function () {
    let tableURL = $('#ticketsTable').data('table-url');

    let table = $('#ticketsTable').DataTable({ 
        processing: true,
        serverSide: true,
        responsive: {
            details: { type: 'column', target: 'tr' }
        },
        columnDefs: [
            { className: 'dtr-control', orderable: false, targets: 0 }
        ],
        ajax: {
            url: tableURL,
            data: function (d) {
                d.status = $('#statusFilter').val();
                d.from_date = $('#fromDate').val();
                d.to_date = $('#toDate').val();
            }
        },
        columns: [
            { data: null, defaultContent: '' },
            { data: "code", name: "code" },
            { data: "subject", name: "subject" },
            { data: "description", name: "description" },
            { data: "created_at", name: "created_at" },
            { data: "status", name: "status" },
            { data: "action", name: "action", orderable: false, searchable: false }
        ]
    });

    // Reload table when clicking Filter
    $('#filterBtn').on('click', function () {
        table.ajax.reload();
    });

});
