@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Your Notifications</h2>

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    @forelse ($notifications as $notification)
        <div class="p-4 mb-3 rounded-xl shadow-sm {{ $notification->is_read ? 'bg-gray-100' : 'bg-yellow-100' }}">
            <p class="text-gray-800">{{ $notification->message }}</p>
            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                @csrf
                <button type="submit" class="mt-2 text-blue-600 text-sm underline">Mark as read</button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">You have no notifications.</p>
    @endforelse
</div>
@endsection
