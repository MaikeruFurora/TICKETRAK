$(function () {
    let tableURL = $('#ticketsTable').data('table-url');

    let table = $('#ticketsTable').DataTable({ 
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        autoWidth: false,
        responsive: {
        details: {
        display: DataTable.Responsive.display.modal({
            header: function (row) {
           var data = row.data();
                return '<span style="font-size: 12px;">Details for ' + data['code'] + '</span>';
            },
            modalClass: 'small-font-modal'
        }),
        renderer: DataTable.Responsive.renderer.tableAll()
        }
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
