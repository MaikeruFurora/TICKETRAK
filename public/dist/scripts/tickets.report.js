$('#downloadReportBtn').on('click', function() {
  // Get the route from the data attribute
  let baseUrl = $(this).data('generate-report');

  // Get input values
  let startDate = $('#fromDate').val();
  let endDate = $('#toDate').val();
  let status = $('#statusFilter').val();

  // Build the URL with query parameters
  let url = baseUrl + '?start_date=' + encodeURIComponent(startDate) +
                        '&end_date=' + encodeURIComponent(endDate) +
                        '&status=' + encodeURIComponent(status);
 
  // Trigger download
  window.location.href = url;
});


$('#fromDate').prop('disabled', true);
$('#toDate').prop('disabled', true);
$("#statusFilter").on('change', function() {
    const status = $(this).val();
    const fromDate = $('#fromDate').val();
    const toDate = $('#toDate').val();
 
        $('#fromDate').prop('disabled', status==="Open");
        $('#toDate').prop('disabled', status==="Open");
});




$('#filterBtn').on('click', function() {
    const status = $('#statusFilter').val();
    const fromDate = $('#fromDate').val();
    const toDate = $('#toDate').val();

    // Get base URL from table attribute
    const baseUrl = $('table[data-report-list-url]').data('report-list-url');

    let queryParams = [];
    if (status) queryParams.push(`status=${encodeURIComponent(status)}`);
    if (fromDate) queryParams.push(`from_date=${encodeURIComponent(fromDate)}`);
    if (toDate) queryParams.push(`to_date=${encodeURIComponent(toDate)}`);

    const queryString = queryParams.length ? `?${queryParams.join('&')}` : '';
    const url = `${baseUrl}${queryString}`;

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(data) { 
            const $tbody = $('#ticketTableBody tbody');
            $tbody.empty(); // Clear previous results

            if (data.length === 0) {
                $tbody.html('<tr><td colspan="8" class="text-center text-muted">No tickets found.</td></tr>');
                return;
            }

            $.each(data, function(index, ticket) {
                const closedAt = ticket.closed_at ? ticket.closed_at : '-';
                const closedBy = ticket.closed_by ?? '-';
                const resolvedDays = ticket.resolved_days ?? '-';
                console.log(resolvedDays);
                
                $tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ticket.ticket_code}</td>
                        <td>${ticket.subject}</td>
                        <td>${ticket.representative}</td> 
                        <td>${ticket.created_at}</td>
                        <td>${ticket.created_by}</td>
                        <td>${closedAt}</td>
                        <td>${closedBy}</td>
                        <td>${resolvedDays}</td>
                    </tr>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching tickets:', error);
        }
    });
});