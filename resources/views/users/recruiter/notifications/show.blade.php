@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notifications') }}</div>

                <div class="card-body">
                    <ul>
                        @forelse($notifications as $notification)
                            <li>
                                @if($notification->type === 'App\Notifications\AdminToRecruiterNotification')
                                    The admin has Notification for you. {{ $notification->data['title'] }}
                                @endif
                            </li>
                        @empty
                            <li>You have no unread notifications at this time.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
