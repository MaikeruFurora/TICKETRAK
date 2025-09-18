@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Notifications</h2>
            <div class="text-muted my-2">
                All your notifications (unread and read)
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Notification List</h3>
        <form action="{{ route('auth.notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">Mark All as Read</button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $index => $notification)
                        <tr class="{{ is_null($notification->read_at) ? 'table-secondary' : '' }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notification->data['title'] ?? 'No Title' }}</td>
                            <td>{{ $notification->data['msg'] ?? '-' }}</td>
                            <td>
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outline-primary">View</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($notification->read_at)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unread</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('auth.notifications.markRead', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary">Mark as Read</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No notifications yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{ $notifications->links() }}
        </div>

    </div>
</div>
@endsection
