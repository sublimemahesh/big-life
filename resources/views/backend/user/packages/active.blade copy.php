<x-backend.layouts.app>
    @section('title', 'My Packages')
    @section('header-title', 'Active Packages')
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/css/user/main.css') }}" rel="stylesheet">

    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">My Packages</li>
    @endsection

    <div class="alert alert-info">
        All package earnings will be generated after 7 working days from the date of purchase.
    </div>

    <div class="row">
        @include('backend.user.transactions.top-nav')
        <div class="col-12">

            @php
                $topPackage = Auth::user()->highestInvestedPackage()->first();
            @endphp

            @if($topPackage)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-xl mb-6">
                    <div class="font-bold mb-1">📢 Daily Earning Limit Warning</div>
                    <p class="text-sm leading-relaxed">
                        Your current daily earning limit is based on your <strong>${{ number_format($topPackage->invested_amount, 2) }} package</strong>, purchased on <strong>{{ $topPackage->created_at->format('M d, Y') }}</strong>.
                    </p>
                    <ul class="!list-disc ml-5 text-sm mt-2 space-y-1">
                        <li class="li-disc"><strong>Daily Max Limit:</strong> ${{ number_format(Auth::user()->effective_daily_max_out_limit, 2) }}</li>
                        <li class="li-disc">All earnings — including referral commissions and BV rewards — count toward this limit.</li>
                        <li class="li-disc"><span class="text-red-700 font-semibold">⚠️ If this limit is reached, your left and right BV points will be reset to Zero.</span></li>
                        <li class="li-disc">You will start collecting BV points again from zero the next day.</li>
                        <li class="li-disc">To retain BV points, make sure your earnings stay <strong>below the daily limit</strong>.</li>
                    </ul>
                    <p class="text-sm mt-3">
                        ✅ You can still earn from all your packages, but only up to your daily limit based on the top package.
                    </p>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-xl mb-6">
                    <div class="font-bold mb-1">📢 Important Note on Daily Earning Limits</div>
                    <p class="text-sm leading-relaxed">
                        Your daily earnings are capped based on your <strong>highest active package</strong>. Please keep in mind:
                    </p>
                    <ul class="!list-disc ml-5 text-sm mt-2 space-y-1">
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
            @endif
        </div>
        @foreach ($activePackages as $subscription)
            <div class="col-xl-6 ">
                <div class="card1">
                    <div class="card text-white  card2 active-card-bp">
                        <div class="card-header">


                            <h5 class="card-title text-white">
                                {{ $subscription->transaction->create_order_request_info->goods->goodsName }} |
                                <span class='card-currency'>
                                    {{ $subscription->transaction->currency }} {{ $subscription->transaction->amount}}
                                </span>
                            </h5>
                        </div>

                        <div class="card-body mb-0 package-body">
                            <p class="card-text">Buy Date : <b> {{ $subscription->created_at->format('Y-m-d h:i A') }}</b></p>
                            <p class="card-text">Active Date : <b> {{ $subscription->package_activate_date }}</b></p>
                            <p class="card-text">Next Payment Date :<b> {{ $subscription->next_payment_date }} </b></p>
                            <p class="card-text">Plan Expire Return :<b> {{ $subscription->transaction->currency }}  {{ $subscription->invested_amount * ($withdrawal_limits->package ?? 300) /100 }} </b></p>
                            <p class="card-text">Completed Return :<b> {{ $subscription->transaction->currency }}  {{ $subscription->earnings_sum_amount ?? 0 }} </b></p>
                            <p class="card-text">Pending Return : <b> {{ $subscription->transaction->currency }}  {{ ($subscription->invested_amount * ($withdrawal_limits->package ?? 300) /100) - $subscription->earnings_sum_amount }} </b></p>
                            <p class="card-text">Purchased by : <b> #{{ str_pad($subscription->purchaser_id, 4, '0', STR_PAD_LEFT)}}</b></p>
                        </div>
                        <div class="card-footer">
                            <div class="card-footer-link">
                                <a href="{{ URL::signedRoute('user.transactions.invoice', $subscription->transaction_id) }}"
                                   class="btn bg-white text-primary btn-card">Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script>
            // dataTable3
            let table = $('#active-packages').DataTable({
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        </script>
    @endpush
</x-backend.layouts.app>
