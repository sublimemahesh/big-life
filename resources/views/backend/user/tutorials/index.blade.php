@extends('auth.layouts.auth')
@section('title', 'Tutorial')
@section('header-title', 'Tutorial' )
@section('styles')
@vite(['resources/css/app-jetstream.css'])
@endsection

@section('contents')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Video Tutorial</h4>
    </div>
    <div class="card-body">
        <!-- Nav tabs -->
        <div class="default-tab">
            <ul class="nav nav-tabs" role="tablist">
                @foreach ($tutorials->children as $key => $section)
                @if ($key== 0)
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#{{$section->slug}}"><i
                            class="fa fa-book"></i><span>!&nbsp; {{$section->title}}</span></a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#{{$section->slug}}"><i
                            class="fa fa-book"></i><span>!&nbsp;{{$section->title}}</span></a>
                </li>
                @endif
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($tutorials->children as $key => $section)
                @if ($key== 0)
                <div class="tab-pane fade show active" id="{{$section->slug}}" role="tabpanel">
                    <div class="pt-4">
                        {!! html_entity_decode($section->content) !!}
                    </div>
                </div>
                @else
                <div class="tab-pane fade" id="{{$section->slug}}">
                    <div class="pt-4">
                        {!! html_entity_decode($section->content) !!}
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection
