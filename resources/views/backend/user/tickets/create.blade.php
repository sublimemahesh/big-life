@extends('auth.layouts.auth')
 @section('title', 'Create | Support Tickets')
    @section('header-title', 'Create Support Tickets' )
    @section('plugin-styles')
    @endsection

@section('contents')

<div class="row">
        <div class="col-sm-12">
            <livewire:user.tickets.create/>
        </div>
    </div>

@endsection
