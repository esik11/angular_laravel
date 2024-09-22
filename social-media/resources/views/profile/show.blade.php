@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Profile</h2>
    <div>
        @if ($profile)
            <img src="{{ $profile->profile_picture ? asset('storage/profile_pictures/' . $profile->profile_picture) : asset('images/default-profile.png') }}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px;">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Bio:</strong> {{ $profile->bio }}</p>
            <p><strong>Address:</strong> {{ $profile->address }}</p>
            <p><strong>Phone Number:</strong> {{ $profile->phone_number }}</p>
        @else
            <p>No profile information available. Please create your profile.</p>
        @endif
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    </div>
</div>
@endsection
