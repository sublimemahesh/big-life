@extends('auth.layouts.auth')

@section('title', 'Buy Package111')
@section('header-title', 'Packages' )
@section('plugin-styles')
@endsection
@section('breadcrumb-items')
@endsection


@section('contents')



    <main class="main">

      


        <!-- invest plan -->

            @php use Illuminate\Support\Str; @endphp

<div class="invest-plan2 py-120">
    <div class="container">
        <div class="invest-plan-wrapper">
            <div class="row">
                @foreach($packages as $package)
                    @php
                        $name = strtolower($package->name);

                        if (preg_match('/\bstandard\b/i', $package->name)) {
                            $class = 'plan-color-4';
                        } elseif (preg_match('/\bvip\b/i', $package->name)) {
                            $class = 'plan-color-7';
                        } elseif (preg_match('/\bbasic\b/i', $package->name)) {
                            $class = 'plan-color-2';
                        } else {
                            $class = 'plan-color-2'; // Default
                        }
                    @endphp

                    <div class="col-md-6 col-lg-3">
                        <div class="plan-item">
                            <div class="plan-item-head {{ $class }}">
                                <h4 class="plan-title">{{ $package->name }}</h4>
                                <div class="plan-rate">
                                    <h2 class="plan-price">{{ $package->amount }}</h2>
                                    <span class="plan-price-type">USDT</span>
                                </div>
                            </div>
                            <div class="plan-item-list">
                                <ul>
                                    <li>Gas Fee USDT {{ $package->gas_fee }}</li>
                                    <li>Package {{ $package->name }}</li>
                                    <li>Within Investment Period</li>
                                    <li>0.4% - 1.3% Daily Profit</li>
                                </ul>
                                <a href="#" class="plan-btn" id="{{ $package->slug }}-choose">Invest Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach  
            </div>
        </div>
    </div>
</div>


        <!-- invest plan end -->

        


    </main>



@endsection