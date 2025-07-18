@extends('auth.layouts.auth')

@section('styles')
@vite(['resources/css/app-jetstream.css'])
@endsection
@section('title', __('Account Settings'))
@section('header-title', __('Account Settings'))

@section('contents')


<div class="row">


    <div class="col-xl-9 col-lg-8">

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        @livewire('profile.update-profile-information')
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="mt-10 sm:mt-0">
            @livewire('profile.update-password')
        </div>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="mt-10 sm:mt-0">
            @livewire('profile.two-factor-authentication-form')
        </div>
        @endif

        <div class="mt-10 sm:mt-0">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <div class="mt-10 sm:mt-0">
            @livewire('profile.delete-user-form')
        </div>
        @endif

    </div>
</div>


@endsection