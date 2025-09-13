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
         dom:
        "<'row mb-2'<'col-12 col-md-6'l><'col-12 col-md-6'f>>" +
        "<'row'<'col-12'tr>>" +
        "<'row mt-2'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
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
            { data: "created_by", name: "created_by", orderable: false },
            { data: "created_at", name: "created_at" },
            { data: "closed_at", name: "closed_at" },
            { data: "closed_by", name: "closed_by" },
            { data: "action", name: "action", orderable: false, searchable: false }
        ]
    });

    // Reload table when clicking Filter
    $('#filterBtn').on('click', function () {
        table.ajax.reload();
    });

});
