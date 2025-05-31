<div class="col-12">
    <div class="order nav nav-tabs">
        <a class="nav-link {{ request()->routeIs('user.bv_points.earnings') ? 'active' : '' }}" href="{{ !request()->routeIs('user.bv_points.earnings') ? route('user.bv_points.earnings') : 'javascript:void(0)' }}">BV Earnings</a>
        <a class="nav-link {{ request()->routeIs('user.bv_points.rewards') ? 'active' : '' }}" href="{{ !request()->routeIs('user.bv_points.rewards') ? route('user.bv_points.rewards') : 'javascript:void(0)' }}">BV Rewards</a>
        <a class="nav-link {{ request()->routeIs('user.bv-points.maxed-out') ? 'active' : '' }}" href="{{ !request()->routeIs('user.bv-points.maxed-out') ? route('user.bv-points.maxed-out') : 'javascript:void(0)' }}">Maxed Out BV Points</a>
        {{--<a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart') : 'javascript:void(0)' }}">Income Chart</a>--}}
    </div>
</div>
