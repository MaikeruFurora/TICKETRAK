@extends('emails.layouts.base')

@section('content')
    <h2 style="margin-top:0; font-size:20px; color:#073A5E;">{{ $title  ?? ''}}</h2>

    <p style="font-size:14px; line-height:1.6; color:#073A5E;">
       {!! $msg ?? '' !!}
    </p>

    @if (!empty($ticket))
        <!-- Ticket details in table -->
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin-top: 15px;">
            <tr style="background-color: #447795; color: #ffffff;">
                <th align="left">Field</th>
                <th align="left">Value</th>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #ddd;">Ticket Code</td>
                <td style="border-bottom: 1px solid #ddd;">{{ $ticket->code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #ddd;">Subject</td>
                <td style="border-bottom: 1px solid #ddd;">{{ $ticket->subject ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #ddd;">Description</td>
                <td style="border-bottom: 1px solid #ddd;">{{ $ticket->description ?? 'N/A' }}</td>
            </tr>
        </table>
        
    @endif

    @if($actionUrl && $actionText)
        <p style="text-align:center; margin:30px 0;">
            <a href="{{ $actionUrl }}" 
               style="display:inline-block; padding:12px 24px; background-color:#073A5E; color:#F2FAFB; font-weight:bold; text-decoration:none; border-radius:6px;">
                {{ $actionText }}
            </a>
        </p>
    @endif
@endsection
