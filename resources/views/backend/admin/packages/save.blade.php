<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="package-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">NAME1</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text" value="{{ $package->name ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="currency">CURRENCY</label>
                <div class="col-sm-9">
                    <input class="form-control" disabled placeholder="Currency" type="text" value="{{ $package->currency ?? 'USDT' }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="amount">AMOUNT</label>
                <div class="col-sm-9">
                    <input class="form-control" id="amount" name="amount" placeholder="Amount" type="text" value="{{ $package->amount ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="gas_fee">GAS FEE</label>
                <div class="col-sm-9">
                    <input class="form-control" id="gas_fee" name="gas_fee" placeholder="Amount" type="text" value="{{ $package->gas_fee ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="bv_points">BV Points</label>
                <div class="col-sm-9">
                    <input class="form-control" id="bv_points" name="bv_points" placeholder="BV Points" type="number" value="{{ $package->bv_points ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="daily_max_out_limit">Daily Max Out Limit</label>
                <div class="col-sm-9">
                    <input class="form-control" id="daily_max_out_limit" name="daily_max_out_limit" placeholder="Daily Max Out Limit" type="number" value="{{ $package->daily_max_out_limit ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2 d-none">
                <label class="col-sm-3 col-form-label" for="month_of_period">MONTH OF PERIOD</label>
                <div class="col-sm-9">
                    <input class="form-control" id="month_of_period" name="month_of_period" placeholder="Month of period" type="text" value="{{ $package->month_of_period ?? 15 }}">
                </div>
            </div>
            <div class="form-group row mb-2 d-none">
                <label class="col-sm-3 col-form-label" for="daily_leverage">DAILY LEVERAGE</label>
                <div class="col-sm-9">
                    <input class="form-control" id="daily_leverage" name="daily_leverage" placeholder="Daily leverage" type="text" value="{{ $package->daily_leverage ?? 1 }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="is_active">IS ACTIVE</label>
                <div class="col-sm-9">
                    <div class="form-check custom-checkbox mb-3 check-xs">
                        <input type="checkbox" {{ !empty($package->id) && $package->is_active ? 'checked' : null }} class="form-check-input" name="is_active" id="is_active">
                        <label class="form-check-label" for="is_active"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-package" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const PACKAGE_ID = '{{ $package->id ?? null }}'
        </script>
    @endpush
</div>
