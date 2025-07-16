@extends('auth.layouts.auth')

@section('title', 'User Dashboard')
@section('header-title', 'Welcome ' . Auth::user()->name)
@section('header-title2',Auth::user()->username)

@section('contents')

<main class="main">

    <!-- dashboard area -->
    <div class="dashboard-area py-120">
        <div class="container">
            <div class="row">

                @include('auth.layouts.sidebar')
               
                <div class="col-lg-9 col-md-8">
                    <div class="dashboard-content">

                        @include('auth.layouts.header')

                        <div class="dashboard-widget-wrapper">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>INCOME BALANCE</h5>
                                            <span class='user-dashboard-card-font-size-change'> USDT {{number_format($wallet->balance,2) }}</span>
                                        </div>
                                        <i class="flaticon-world"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>PAYOUT BALANCE</h5>
                                            <span class='user-dashboard-card-font-size-change' class='user-dashboard-card-font-size-change'>USDT {{number_format($available_withdraw_level,2) }}</span>
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
                                            <span class='user-dashboard-card-font-size-change'>USDT {{$direct_comm_income + $indirect_comm_income }}</span>
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
                        </div>

                        <div class="dashboard-table-wrapper">
                            <div class="dashboard-table-head">
                                <h3>BV Earnings</h3>
                                <select class="select">
                                    <option value="">Sort By Default</option>
                                    <option value="1">This Month</option>
                                    <option value="2">Last Month</option>
                                    <option value="3">This Year</option>
                                    <option value="4">Last Year</option>
                                </select>
                            </div>
                            <div class="dashboard-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">POINTS</th>
                                            <th scope="col">AMOUNT</th>
                                            <th scope="col">PAID</th>
                                            <th scope="col">LOST</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bv_rewards as $bv)
                                        <tr>
                                            <th>{{ $bv->bv_points }}</th>
                                            <td>{{ number_format($bv->amount,2) }}</td>
                                            <td>{{ number_format($bv->paid,2) }}</td>
                                            <td>{{ number_format($bv->lost_amount,2) }}</td>
                                            <td>{{ $bv->status }}</td>
                                            <td>{{ $bv->created_at->format('Y-m-d h:i A') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td> No Rankers</td>
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
    </div>
    <!-- dashboard area end -->


</main>


@endsection
