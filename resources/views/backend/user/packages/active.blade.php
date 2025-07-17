@extends('auth.layouts.auth')

@section('title', 'My Packages')
@section('header-title', 'Active Packages')
@section('plugin-styles')
@endsection
@section('breadcrumb-items')
@endsection


@section('contents')



        <!-- invest plan -->
        <div class="invest-plan py-120">
            <div class="container">
                <div class="invest-plan-wrapper">
                    <div class="row">

                     @foreach ($activePackages as $subscription)

                        <div class=" col-lg-4 col-md-6">
                            <div class="plan-item plan-color-1">
                                <h4 class="plan-title">{{ $subscription->transaction->create_order_request_info->goods->goodsName }} </h4>
                                <div class="plan-rate">
                                    <h2 class="plan-price">{{ $subscription->transaction->amount}}</h2>
                                    <span class="plan-price-type"> {{ $subscription->transaction->currency }} </span>
                                </div>
                                <div class="plan-item-list">
                                    <ul>
                                        <li>Buy Date <b> {{ $subscription->created_at->format('Y-m-d h:i A') }}</b> </li>
                                        <li>Active Date : <b> {{ $subscription->package_activate_date }}</b></li>
                                        <li>Next Payment Date :<b> {{ $subscription->next_payment_date }} </b></li>
                                        <li>Plan Expire Return :<b> {{ $subscription->transaction->currency }}  {{ $subscription->invested_amount * ($withdrawal_limits->package ?? 300) /100 }} </b></li>
                                        <li>Completed Return :<b> {{ $subscription->transaction->currency }}  {{ $subscription->earnings_sum_amount ?? 0 }} </b></li>
                                        <li>Pending Return : <b> {{ $subscription->transaction->currency }}  {{ ($subscription->invested_amount * ($withdrawal_limits->package ?? 300) /100) - $subscription->earnings_sum_amount }} </b></li>
                                        <li>Purchased by : <b> #{{ str_pad($subscription->purchaser_id, 4, '0', STR_PAD_LEFT)}}</b></li>
                                    </ul>
                                </div>
                                <a href="{{ URL::signedRoute('user.transactions.invoice', $subscription->transaction_id) }}" class="plan-btn">Invoice</a>
                            </div>
                        </div>

                    @endforeach


                    </div>
                </div>
            </div>
        </div>
        <!-- invest plan end -->


@endsection
