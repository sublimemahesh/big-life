@extends('auth.layouts.auth')

@section('title', 'User Dashboard')
@section('header-title', 'Welcome ' . Auth::user()->name)
@section('header-title2',Auth::user()->username)

@section('contents')




<div class="dashboard-widget-wrapper">

    <div class="row">

        <div class="row">
            <div class="col-xl-12">
                <div class="card bubles rounded-3 profile-card-bg-image">
                    <div class="card-body ref-card-body">
                        <div class="bubles-down buy-coin d-flex justify-content-between mb-0 mx-0">
                            <div class="w-100">
                                <h1 class="mb-0 lh-1 text-uppercase">{{ Auth::user()->username }}</h1>
                                <p class="fs-26 mb-1 mx-0 text-muted w-100 text-uppercase">{{ Auth::user()->name }}</p>
                                <p class="fs-16 fw-bold text-warning">{{ Auth::user()->currentRank->rank ?? 'NO' }} STAR
                                </p>

                                <div>
                                    <label href="#" class="btn btn btn-user  profile-card-btn">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        Inactive Direct Sales: {{ auth()->user()->pending_direct_sales_count }}
                                    </label>

                                    {{--<label href="#" class="btn btn btn-user profile-card-btn">
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                        Loss sale count: USDT {{ $lost_commissions }}
                                    </label>--}}
                                </div>
                                @if (config('app.env') === 'local')
                                <div class="btn-genealogy btn-genealogy mt-2">
                                    {{--<a href="{{ route('user.genealogy.position.register') }}"
                                        class="btn btn-info rounded-3 profile-card-btn">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        Registration new user
                                    </a>--}}

                                    <a href="{{ route('user.genealogy') }}"
                                        class="btn btn-info rounded-3 profile-card-btn mt-4">
                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        My genealogy
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="float-left width-295  rounded-3">
                                <img src="{{ Auth::user()->profile_photo_url }}"
                                    class=" w-100 profile-img-border img-round profile-pic-m" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card rounded-3">
                <div class="card-body">
                    <canvas id="overlapping-bars"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card rounded-3">
                <div class="card-body d-flex flex-column justify-content-center px-2">
                    <canvas id="earnings-pie-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if (Auth::user()->id === config('fortify.super_parent_id') ||(Auth::user()->parent_id !== null &&
        Auth::user()->position !== null))
        <div class="row">
            <div class="col-lg-12">
                <div class="bg-secondary card d-flex">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <h3 class="fw-normal mb-0 text-secondary">Join Our Referral Program Today!</h3>
                                <h1 class="mb-4">Earn More with Our Referral Program</h1>
                                <div class="row align-items-center">
                                    @if(Auth::user()->active_date !== null)
                                    <div class="col-12 col-md-6 col-xxl-6 mb-4">
                                        <label for="">Left Referral Link</label>
                                        <div class="input-group mb-3 input-primary copy-text">
                                            <input class="form-control border-end-0" readonly
                                                value="{{ Auth::user()->left_referral_link }}"
                                                placeholder="Referral link">
                                            <button class="input-group-text copy-el"><i
                                                    class="bi bi-copy"></i>Copy</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xxl-6 mb-4">
                                        <label for="">Right Referral Link</label>
                                        <div class="input-group mb-3 input-primary copy-text">
                                            <input class="form-control border-end-0" readonly
                                                value="{{ Auth::user()->right_referral_link }}"
                                                placeholder="Referral link">
                                            <button class="input-group-text copy-el"><i
                                                    class="bi bi-copy"></i>Copy</button>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-12 col-md-12 mb-4">
                                        <div class="form-control border-end-0">Please Activate a package first!</div>
                                    </div>
                                    @endif
                                    <p>Join our referral program and start earning rewards effortlessly! Share your
                                        unique referral code with friends, and when they activate their package, you get
                                        exclusive benefits. Copy your code now and invite them to be part of our growing
                                        community!</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4  d-flex justify-content-center">
                                <img src="{{ asset('assets/backend/images/ref.gif') }}" class="img-250">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            Your genealogy position is still not available. Please contact your up link user,
            or you will automatically place after 1 day. Please note that genealogy placement required to have an
            active
            package.
            when you have purchased a package only you will be able to get position in genealogy.
        </div>
        @endif

    </div>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>INCOME BALANCE</h5>
                    <span class='user-dashboard-card-font-size-change'> USDT {{number_format($wallet->balance,2)
                        }}</span>
                </div>
                <i class="flaticon-world"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>PAYOUT BALANCE</h5>
                    <span class='user-dashboard-card-font-size-change' class='user-dashboard-card-font-size-change'>USDT
                        {{number_format($available_withdraw_level,2) }}</span>
                </div>
                <i class="flaticon-wallet"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>Members</h5>
                    <span class='user-dashboard-card-font-size-change'>LEFT {{ $leftDescendantCount }} | </span>
                    <span class='user-dashboard-card-font-size-change'>RIGHT {{ $rightDescendantCount }}</span>
                </div>
                <i class="flaticon-dollar"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>TOTAL INVESTMENT11</h5>
                    <span>USDT {{$total_investment }}</span>
                    <br>
                    <small>
                        <a href="{{ route('user.transactions.index') }}">Details</a>
                    </small>
                </div>
                <i class="flaticon-management"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>ACTIVE PLAN</h5>
                    <span>USDT {{$active_investment }}</span>
                    <br>
                    <small>
                        <a href="{{ route('user.packages.active') }}">Details</a>
                    </small>
                </div>
                <i class="flaticon-graph"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>EXPIRED PLAN</h5>
                    <span class='user-dashboard-card-font-size-change'>USDT {{$expired_investment }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>PLAN INCOME</h5>
                    <span class='user-dashboard-card-font-size-change'>USDT {{ number_format($invest_income,2) }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>TOTAL COMMISSIONS</h5>
                    <span class='user-dashboard-card-font-size-change'>USDT {{$direct_comm_income +
                        $indirect_comm_income }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>LOST COMMISSIONS</h5>
                    <span class='user-dashboard-card-font-size-change'>USDT {{$lost_commissions }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>TOTAL EARNED</h5>
                    <span class='user-dashboard-card-font-size-change'>USDT {{ $income }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>TODAY INCOME</h5>
                    <span class='user-dashboard-card-font-size-change'> USDT {{ $today_income }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget">
                <div class="dashboard-widget-content">
                    <h5>TEAM COUNT</h5>
                    <span class='user-dashboard-card-font-size-change'>{{$descendants_count }}</span>
                </div>
                <i class="flaticon-mine"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12 col-sm-6">
                    <div class="card rounded-3">
                        <div class="border-0 card-header pb-2 pt-3">
                            <h2 class="heading mb-0">Latest Incomes <span>(USDT)</span></h2>
                        </div>
                        <div class="card-body pt-0 pb-3 mt-2">
                            <nav class="buy-sell style-1 ">
                                <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                                    <button class="last-income-round nav-link border border-right  active"
                                        id="nav-package-earning-tab last-income-round" data-bs-toggle="tab"
                                        data-bs-target="#nav-package-earning" type="button" role="tab"
                                        aria-controls="nav-package-earning" aria-selected="true">Latest Package Earnings
                                    </button>
                                    <button class="nav-link border border-left" id="nav-direct-sale-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-direct-sale" type="button" role="tab"
                                        aria-controls="nav-direct-sale" aria-selected="false">Direct Sales
                                    </button>
                                    <button class="nav-link border border-left " id="nav-indirect-sale-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-indirect-sale" type="button"
                                        role="tab" aria-controls="nav-indirect-sale" aria-selected="false">In-Direct
                                        Sales
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent3">
                                <div class="tab-pane fade show active" id="nav-package-earning" role="tabpanel"
                                    aria-labelledby="package-earning-tab">
                                    <div class="list-row-head text-nowrap text-left px-3">
                                        <span class="px-0">Received</span>
                                        <span class="px-0">Package</span>
                                        <span class="px-0">Paid Percentage</span>
                                        <span class="px-0 ">Date</span>
                                    </div>
                                    <div class="list-table success">
                                        @foreach ($package_latest as $day_earn)
                                        <div class="list-row px-3">
                                            <span class="p-0">$ {{ number_format($day_earn->amount,2) }}</span>
                                            <span class="p-0">{{ $day_earn->earnable->package_info_json->name }}</span>
                                            <span class="p-0">{{ $day_earn->payed_percentage ??
                                                $day_earn->earnable->payable_percentage }}%</span>
                                            <span class="p-0 ">{{ $day_earn->created_at->format('Y-m-d') }}</span>
                                            <div class="bg-layer"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-direct-sale" role="tabpanel"
                                    aria-labelledby="nav-direct-sale-tab">
                                    <div class="list-row-head text-nowrap text-left px-3">
                                        <span class="px-0">Received</span>
                                        <span class="px-0">Paid</span>
                                        <span class="px-0">Lost</span>
                                        <span class="px-0">User</span>
                                        <span class="px-0">Date</span>

                                        {{--<span class="px-0">Next Pay</span>--}}
                                    </div>
                                    <div class="list-table success">
                                        @foreach ($direct as $sale)
                                        <div class="list-row px-3">
                                            <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                            <span class="p-0">$ {{ number_format($sale->paid,2) }}</span>
                                            <span class="p-0">$ {{ number_format($sale->lost_amount,2) }}</span>
                                            <span class="p-0">{{ $sale->purchasedPackage->user->username }}</span>
                                            <span class="p-0">{{ $sale->created_at->format('Y-m-d') }}</span>
                                            {{--<span class="p-0">{{
                                                Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>--}}
                                            <div class="bg-layer"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-indirect-sale" role="tabpanel"
                                    aria-labelledby="nav-indirect-sale-tab">
                                    <div class="list-row-head text-nowrap text-left px-3">
                                        <span class="px-0">Received</span>
                                        <span class="px-0">Paid</span>
                                        <span class="px-0">Lost</span>
                                        <span class="px-0 ">User</span>
                                        <span class="px-0 ">Date</span>
                                        {{-- <span class="px-0">Next Pay</span>--}}
                                    </div>
                                    <div class="list-table success">
                                        @foreach ($indirect as $sale)
                                        <div class="list-row px-3">
                                            <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                            <span class="p-0">$ {{ number_format($sale->paid,2) }}</span>
                                            <span class="p-0">$ {{ number_format($sale->lost_amount,2) }}</span>
                                            <span class="p-0 ">{{ $sale->purchasedPackage->user->username }}</span>
                                            <span class="p-0 ">{{ $sale->created_at->format('Y-m-d') }}</span>
                                            {{--<span class="p-0">{{
                                                Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>--}}
                                            <div class="bg-layer"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="owl-carousel owl-banner">
                @foreach ($banners as $section)
                <div class="item">
                    <img class="img-round" src="{{ storage('pages/' . $section->image) }}">
                </div>
                @endforeach
            </div>
            <br>
            <br>
        </div>

        <div class="col-lg-12">
            <div class="card rounded-3">
                <div class="card-header">
                    <h4 class="card-title">BV Earnings</h4>
                </div>
                <div class="card-body py-1">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>POINTS</strong></th>
                                    <th><strong>AMOUNT</strong></th>
                                    <th><strong>PAID</strong></th>
                                    <th><strong>LOST</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    <th><strong>DATE</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bv_rewards as $bv)
                                <tr>
                                    <td class="py-1 cus-fs">{{ $bv->bv_points }}</td>
                                    <td class="py-1 cus-fs">{{ number_format($bv->amount,2) }}</td>
                                    <td class="py-1 text-success cus-fs">{{ number_format($bv->paid,2) }}</td>
                                    <td class="py-1 text-danger cus-fs">{{ number_format($bv->lost_amount,2) }}</td>
                                    <td class="py-1 cus-fs">{{ $bv->status }}</td>
                                    <td class="py-1 cus-fs">{{ $bv->created_at->format('Y-m-d h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center"> No Rankers</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@push('modals')
<div class="modal fade" id="notification-modal">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pending DownLiners ({{ Auth::user()->pending_direct_sales_count }})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-3 bg-secondary cursor-pointer">
                            <div class="text-center">
                                <div class="my-4" id="show-note">
                                    <div>
                                        You have pending downline requests to approve.
                                        Please approve the requests to place your downlines in the genealogy.
                                    </div>
                                    <a href="{{ route('user.genealogy') }}" class="btn btn-primary mt-3">
                                        Place Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- popups--}}
<div class="modal fade" id="popup-modal">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100"> {{ $popup->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-3 bg-secondary cursor-pointer">
                            <div class="text-center">
                                <div class="my-4" id="show-note">
                                    {!! $popup->content !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- popups--}}
<div class="modal fade" id="birthday-modal">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="{{ asset('assets/backend/images/bday-wish.jpeg') }}" alt="Happy Birthday"
                    class="rounded-2 w-100">
            </div>
        </div>
    </div>
</div>

@endpush


<!-- dashboard area end -->
@endsection

 @push('scripts')
        <script src="{{ asset('assets/backend/vendor/webticker/jquery.webticker.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/dashboard.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/coin_prices.js') }}"></script>

        <script>

            const pending_assign_count = parseInt("{{ Auth::user()->pending_direct_sales_count }}")
            if (pending_assign_count > 0) {
                const notificationNoteModal = new bootstrap.Modal('#notification-modal', {
                    backdrop: 'static',
                })
                notificationNoteModal.show()
            }
            const popup_exists = !!parseInt('{{ $popup->exists }}');
            if (popup_exists > 0) {
                const popupModal = new bootstrap.Modal('#popup-modal', {
                    backdrop: 'static',
                })
                popupModal.show()
            }

            @php
                $birthday = auth()->user()->profile?->dob ? auth()->user()->profile->dob : null;
            @endphp

            const is_birthday = !!parseInt('{{ !empty($birthday) && Carbon::parse($birthday)->isBirthday() }}');
            if (is_birthday > 0) {
                const birthdayModal = new bootstrap.Modal('#birthday-modal')
                birthdayModal.show()
            }


            const myChart = new Chart(document.getElementById('overlapping-bars'), {
                type: 'bar',
                data: {!! json_encode($yearlyIncomeChartData,JSON_THROW_ON_ERROR) !!},
                responsive: true,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: `Income Chart {{ date('Y') }}`
                        }
                    }
                },
            });

            @php
                $pii_chart_data = [$invest_income,$direct_comm_income,$indirect_comm_income]
            @endphp

            new Chart(document.getElementById('earnings-pie-chart'), {
                type: 'pie',
                data: {
                    labels: ['PACKAGE', 'DIRECT', 'INDIRECT'],
                    datasets: [
                        {
                            label: 'Total Earnings',
                            data: {!! json_encode($pii_chart_data, JSON_THROW_ON_ERROR) !!},
                            borderWidth: 0.5,
                            borderColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(75, 192, 192)',],
                            backgroundColor: ['rgb(255, 99, 132,0.5)', 'rgb(54, 162, 235,0.5)', 'rgb(75, 192, 192,0.5)',],
                        }
                    ]
                },
                plugins: [ChartDataLabels],
                options: {
                    tooltips: {
                        enabled: true
                    },
                    responsive: true,
                    plugins: {
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                return (value * 100 / sum).toFixed(2) <= 0 ? null : (value * 100 / sum).toFixed(2) + "%";
                            },
                            color: '#fff',
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: 10
                                },
                                usePointStyle: true,
                                boxWidth: 15,
                            },
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'My Earnings Summary',
                        },
                    }
                },
            })

        </script>
    @endpush


