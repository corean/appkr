@php
    $size = isset($size) ? $size : 48;
@endphp

@if (isset($user) and $user)
    <a href="{{ gravatar_profile_url($user->email) }}" class="pull-left">
        <img src="{{ gravatar_url($user->email, $size) }}" alt="{{ $user->name }}" class="media-object img-thumbnail">
    </a>
@else
    <a href="{{ gravatar_profile_url('unknown@example.com') }}" class="pull-left">
        <img src="{{ gravatar_url('unknown@example.com', $size) }}" alt="Unknown User"
             class="media-object img-thumbnail">
    </a>
@endif