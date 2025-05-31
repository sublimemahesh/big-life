<x-backend.layouts.app>
    @section('title', 'Buy Package')
    @section('header-title', 'Packages' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Buy Package</li>
    @endsection


    <div class="row">
        @include('backend.user.transactions.top-nav')
        <div class="col-12">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-xl mb-6">
                <div class="font-bold mb-1">📢 Important Note on Daily Earning Limits</div>
                <p class="text-sm leading-relaxed">
                    Your daily earnings are capped based on your <strong>highest active package</strong>. Please keep in mind:
                </p>
                <ul class="list-item list-disc ml-5 text-sm mt-2 space-y-1">
                    <li class="li-disc">Even if you have multiple active packages, <strong>only the highest invested package</strong> determines your daily maximum earning limit.</li>
                    <li class="li-disc">Once you reach or exceed this daily limit, <strong>no further BV or referral rewards will be credited</strong> for that day.</li>
                    <li class="li-disc"><span class="text-red-700 font-semibold">⚠️ If you hit your daily limit, your collected left and right BV points will be reset to Zero.</span></li>
                    <li class="li-disc">This means you will need to start collecting BV points from zero again the next day.</li>
                    <li class="li-disc">To avoid losing BV points, make sure <strong>your total daily earnings stay below your max-out limit</strong>.</li>
                    <li class="li-disc">If you have multiple packages with the same value, the one purchased earlier will be considered for limit calculation.</li>
                </ul>
                <p class="text-sm mt-3">
                    ✅ You can still earn from all your packages, but your <strong>total daily earnings</strong> (from all sources) will not exceed the cap set by your top package.
                </p>
            </div>
        </div>
        @foreach($packages as $package)
            {{--@php
                $gas_fee = $is_gas_fee_added ? $package->gas_fee : 0;
            @endphp--}}
            <div class="col-xl-3 col-md-6 col-sm-12 col-lg-3">
                <div class="card text-center">
                    <div class="card-header bp-header-txt">
                        <h5 class="card-title">{{ $package->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <ul class="list-group">

                                <li class="list-group-item"><b>Price </b>USDT {{ $package->amount }}</li>
                                <li class="list-group-item">
                                    {{--@if(!$is_gas_fee_added)
                                        <del><b>Gas Fee </b>USDT {{ $package->gas_fee }}</del>
                                    @endif
                                    @if($is_gas_fee_added)--}}
                                    <b>Gas Fee </b>USDT {{ $package->gas_fee }}
                                    {{--@endif--}}
                                </li>
                                <li class="list-group-item"><b>Package </b>{{ $package->name }}</li>
                                <li class="list-group-item">
                                    Within Investment Period
                                </li>
                                <li class="list-group-item">
                                    <b> {{--{{ $package->daily_leverage }} %--}} 0.4% - 1.3% </b> Daily Profit
                                </li>
                            </ul>
                        </div>

                        <button type="button" class="btn btn-primary bp-price-btn no-hover-style"> {{ $package->currency }} {{ $package->amount + $package->gas_fee }}</button>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary mb-2" id="{{ $package->slug }}-choose">Choose</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="pay-method-modal">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Payment method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>
                                Please <code>search username in the below box</code> and <code>select the username</code> you want to purchase the package If you want to purchase a package for <code>someone else</code>.
                            </p>
                            <div>
                                Please Note:
                                <ul class="list-disc">
                                    <li class="mt-2">
                                        If you want to purchase a package for <code>Yourself</code>. Please <code>keep the select box empty</code>
                                    </li>
                                    <li class="mt-2">
                                        <code>GAS FEE</code> will be added to every order.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-4 d-none">
                                <div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="purchase_for">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-wallet cursor-pointer" id="wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/main-wallet.png') }}" alt="">
                                            <div class="mb-3"></div>
                                            <h6> INTERNAL WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-topup-wallet cursor-pointer" id="topup-wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/topup-wallet.png') }}" alt="logo"/>
                                            <div class="mb-3"></div>
                                            <h6> EXTERNAL WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            {{--<div class="col-sm-6">
                                <div class="card bg-secondary pay-method-binance-pay cursor-pointer" id="binance-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center">
                                        <img src="{{ asset('assets/images/binance.png') }}" alt="logo" />
                                            <div class="mb-3"></div>
                                            <h6>BINANCE PAY</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-manual-pay cursor-pointer" id="manual-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center"><span>
                                        <img src="{{ asset('assets/images/manual.png') }}" alt="logo"/>
                                            <div class="mb-3"></div>
                                            <h6>MANUAL PAY</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="temp-binance-pay">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Binance Pay Wallet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>
                                Please make a payment and inform us.
                            </p>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <div class="card bg-secondary cursor-pointer">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            <div class="mb-3"></div>
                                            <img class="w-100 img-thumbnail" src="{{ asset('assets/images/binance-qr.jpg') }}" alt="wallet-address">
                                            <div class="mt-4">
                                                <span class="fs-17">TCnvwSL6pshsspKJSkkYXgFp9AUBotthNq</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        <script>
            const ALLOWED_PACKAGES = {!! json_encode($packages->pluck('slug'),JSON_THROW_ON_ERROR) !!};
        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/choose.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="{{ asset('assets/backend/js/packages/gift_slider.js') }}"></script>
    @endpush
</x-backend.layouts.app>
