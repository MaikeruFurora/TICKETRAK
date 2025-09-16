<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Report</title>  
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 9px;
            color: #333;
            margin: 0;   /* no margin */
            padding: 0;
        }
 
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .header .title {
            font-size: 14px;
            font-weight: 600;
        }

        .header .info {
            text-align: left;
            font-size: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;  /* Wrap long text */
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) td {
            background-color: #fafafa;
        }

        td, th {
            max-width: 150px;  /* Limit column width */
        }

        .no-data {
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">TaskTicket Report</div>
        <div class="info">
            <div>Status: {{ $validated['status'] }}</div>
            <div>Date: {{ $validated['start_date'] }} - {{ $validated['end_date'] }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Ticket No.</th>
                <th>Subject</th>
                <th>Created By</th>
                <th>Created At</th>
                @if ($validated['status'] === 'Closed')
                     <th>Closed At</th>
                    <th>Closed By</th>
                    <th>Resolved Days</th>
                @endif
               
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $ticket)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ticket['ticket_code'] }}</td>
                    <td style="max-width: 200px;">{{ $ticket['subject'] }}</td>
                    <td>{{ $ticket['created_by'] }}</td>
                    <td>{{ $ticket['created_at'] }}</td>
                    @if ($validated['status'] === 'Closed')
                    <td>{{ $ticket['closed_at'] }}</td>
                    <td>{{ $ticket['closed_by'] }}</td>
                    <td>{{ $ticket['resolved_days'] }}</td>
                     @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">No tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
