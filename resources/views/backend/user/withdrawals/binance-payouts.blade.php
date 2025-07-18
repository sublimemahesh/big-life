<x-backend.layouts.app>
    @section('title', 'My Withdrawals')
    @section('header-title', 'My Withdrawals' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Make withdrawal request</li>
    @endsection
    <div class="row">
        @include('backend.user.wallet.top-nav')
        <div class="col-xl-8 col-sm-6">
            @if($remaining_withdraw_amount_for_day <= 0 || !in_array(Carbon::today()->englishDayOfWeek,$withdrawal_days_of_week,true))
                <div class="alert alert-warning">
                    Please be informed that withdrawals are currently unavailable today.
                    We kindly request you to revisit our platform on the designated days of the week mentioned below for further processing of your withdrawals.
                    And also, Please ensure that you have remaining withdrawal amount for the day
                </div>
            @endif
            <div class="alert alert-warning">
                <strong>Weekly Withdrawal Limit:</strong> Please note that you can only make one Binance withdrawal request per week. If you have already made a withdrawal request in the past 7 days, your new request will be declined.
            </div>

            @php
                $lastWithdrawal = \App\Models\Withdraw::where('user_id', Auth::user()->id)
                    ->where('type', 'MANUAL')
                    ->whereIn('status', ['PENDING', 'PROCESSING', 'SUCCESS'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                $nextWithdrawalTime = $lastWithdrawal ? $lastWithdrawal->created_at->addDays(7) : null;
            @endphp

            @if($nextWithdrawalTime && $nextWithdrawalTime->isFuture())
                <div class="alert alert-info mt-3">
                    <h6 class="text-center">Next Withdrawal Available In:</h6>
                    <div id="withdrawal-countdown" class="h4 font-weight-bold text-center">
                        <span id="countdown-days">00</span>d
                        <span id="countdown-hours">00</span>h
                        <span id="countdown-minutes">00</span>m
                        <span id="countdown-seconds">00</span>s
                    </div>
                </div>
            @endif
        </div>
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Binance Payout</h4>
                        <p>
                            Just so you know, transaction fees will be added to every withdrawal request based on your wallet type. <br>
                            For wallets with type <code>"INTERNAL" </code>, The transaction fee is <code>USDT {{ $payout_transfer_fee->value }}%</code>.<br>
                            {{--For wallets with type <code>"STAKING"</code>, the transaction fee is <code>USDT {{ $staking_withdrawal_fee->value }}</code>.--}}
                        </p>
                        <p>
                            Your Wallet Balance: <code>USDT {{ $wallet->balance }}</code>.
                            Your current payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code>. <br>
                            (Purchase a new package to increase your payout limit)
                        </p>
                        <p>All active packages will be expired when the payout limit is reached 0. <br>
                            (Your withdrawal limit is reduced when withdrawing money using the main wallet)</p>
                        <hr>
                        <p>
                            {{-- MAIN WALLET  --}}
                            INTERNAL WALLET
                            <br>
                            &emsp; Balance: <code>USDT {{ $wallet->balance }}</code> <br>
                            &emsp; Payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code>
                        </p>

                        <p class="d-none">
                            EXTERNAL WALLET <br>
                            {{-- TOPUP WALLET <br> --}}
                            &emsp; Balance: <code>USDT {{ $wallet->topup_balance }}</code>
                        </p>
                        <hr>
                        <p>
                            MAX AMOUNT THAT CAN WITHDRAW TODAY <br>
                            &emsp; Balance: <code>USDT {{ $daily_max_withdrawal_limits->value }}</code>
                        </p>
                        <p>
                            REMAINING AMOUNT FOR TODAY FOR WITHDRAW <br>
                            &emsp; Balance: <code>USDT {{ $remaining_withdraw_amount_for_day }}</code>
                        </p>
                        <p>
                            ALLOWED DAYS FOR THE WITHDRAWAL <br>
                            &emsp; <code class="text-uppercase"> {{ implode(", ",$withdrawal_days_of_week) }}</code>
                        </p>
                        {{--<p>
                            STAKING WALLET <br>
                            &emsp; Balance: <code>USDT {{ $wallet->staking_balance }}</code>
                        </p>--}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form x-data="{payout_amount: {{$minimum_payout_limit->value}} }">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Withdrawal Amount
                                    </label>
                                    <input min="{{ $minimum_payout_limit->value }}" x-model="payout_amount" id="withdraw-amount" type="number" class="form-control">
                                    <div class="text-info">Total Amount:
                                        <code id="show-receiving-amount"></code>
                                        {{--<code id="show-receiving-amount" x-html=" 'USDT ' + (parseFloat(payout_amount) + {{ (float) $payout_transfer_fee->value }})"></code>--}}
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" name="remark" rows="3" placeholder="Remark" class="form-control h-auto"></textarea>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Email:</b> {{ $profile->binance_email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $profile->binance_id }}</p>
                                        <p class="mb-0"><b>Address:</b> {{ $profile->wallet_address }}</p>
                                        <p class="mb-0"><b>Phone:</b> {{ $profile->binance_phone }}</p>
                                        @if($profile->binance_qr_code)
                                            <div class="mt-3">
                                                <p class="mb-0"><b>Binance QR Code:</b></p>
                                                <img src="{{ storage('user/binance_qr_codes/' . $profile->binance_qr_code) }}"
                                                     class="img-fluid mt-2" style="max-width: 200px; max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-info">Change Details:
                                        <a href="{{ route('profile.show') }}">Edit Profile</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="payout-container">
                                    <div class="title">Choose a Wallet</div>
                                    <div class="plans row">
                                        <label class="plan basic-plan col-sm-4" for="main">
                                            <input checked value="main" type="radio" name="wallet_type" id="main"/>
                                            <div class="plan-content">
                                                <img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/life-saver-img.svg" alt=""/>
                                                <div class="plan-details">
                                                    <span>  Internal Wallet</span>
                                                    {{-- <span>Main Wallet</span> --}}
                                                </div>
                                            </div>
                                        </label>

                                        <label class="plan complete-plan col-sm-4 d-none" for="topup">
                                            <input type="radio" id="topup" name="wallet_type" value="topup"/>
                                            <div class="plan-content">
                                                <img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/potted-plant-img.svg" alt=""/>
                                                <div class="plan-details">
                                                    <span>External Wallet</span>
                                                    {{-- <span>Topup Wallet</span> --}}
                                                </div>
                                            </div>
                                        </label>

                                        {{--<label class="plan complete-plan col-sm-4" for="staking">
                                            <input type="radio" id="staking" name="wallet_type" value="staking"/>
                                            <div class="plan-content">
                                                <img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/potted-plant-img.svg" alt=""/>
                                                <div class="plan-details">
                                                    <span>Staking Wallet</span>
                                                </div>
                                            </div>
                                        </label>--}}
                                    </div>
                                </div>
                                <hr>
                                {{--<div class="coin-warpper d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <ul class="nav nav-pills">
                                            <li class="nav-item wow fadeInUp">
                                                <a href="javascript:void(0)" class="nav-link bitcoin ms-0 active">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/usdt.png')}}" alt="visa">
                                                    USDT
                                                </a>
                                            </li>
                                            <li class=" nav-item wow fadeInUp">
                                                <button class="nav-link bitcoin ms-0 disabled">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/bitcoin.png')}}" alt="Bitcoin">
                                                    Bitcoin
                                                </button>
                                            </li>
                                            <li class=" nav-item wow fadeInUp">
                                                <button class="nav-link bitcoin ms-0 disabled">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/etherium.png')}}" alt="etherium">
                                                    Etherium
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>--}}
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" autocomplete="new-password">
                                </div>
                                @if(Auth::user()?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code</label>
                                        <input id="code" type="password" class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                {{--<p>
                                    OTP code will be sent to Email: {{ substr(auth()->user()?->email, 0, 2) }}*****{{ substr(auth()->user()?->email, -9) }}
                                    @if(str_starts_with(auth()->user()?->phone, '+94'))
                                        and Phone:  {{ substr(auth()->user()?->phone, 0, 5) }}*****{{ substr(auth()->user()?->phone, -2) }}
                                    @endif
                                </p>
                                <div id="2ft-section">
                                    <button type="submit" id="send-2ft-code" class="btn btn-sm btn-google mb-2">Send
                                        Verification Code
                                    </button>
                                </div>--}}
                                <button type="submit" id="confirm-payout" class="btn btn-sm btn-success mb-2">Confirm & Withdraw</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const MINIMUM_PAYOUT_LIMIT = parseFloat("{{ $minimum_payout_limit->value }}");
            const P2P_TRANSFER_FEE = parseFloat("{{ $payout_transfer_fee->value }}");
            const STAKING_TRANSFER_FEE = parseFloat("{{ $staking_withdrawal_fee->value }}");
            const MAX_WITHDRAW_LIMIT = parseFloat("{{ $max_withdraw_limit }}");
        </script>
        <script !src="">
            // Countdown timer for next withdrawal availability
            @if(isset($nextWithdrawalTime) && $nextWithdrawalTime && $nextWithdrawalTime->isFuture())
            const countdownDate = new Date('{{ $nextWithdrawalTime->toIso8601String() }}').getTime();

            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = countdownDate - now;

                if (distance < 0) {
                    document.getElementById('withdrawal-countdown').innerHTML = 'Withdrawal available now!';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
                document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
            };

            // Update countdown every second
            updateCountdown();
            setInterval(updateCountdown, 1000);
            @endif
        </script>
        <script src="{{ asset('assets/backend/js/user/wallet/binance-payout.js') }}"></script>
    @endpush
</x-backend.layouts.app>
