<div class="row">
    <div class="col-sm-8">
        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="commission_level_count">Commission Level Count</label>
            <div class="col-sm-9">
                <input class="form-control" id="commission_level_count" name="commission_level_count" value="{{ $commission_level_count->value }}" type="text">
            </div>
        </div>
        <div id="level-commission-inputs">
            @foreach($commissions as $level => $commission)
                <div class="form-group row mb-2" id="commissions-level-{{ $level }}">
                    @if($loop->first)
                        <label class="col-sm-3 col-form-label" for="commissions.{{ $level }}">Direct Commissions (Lvl {{ $level }})</label>
                    @else
                        <label class="col-sm-3 col-form-label" for="commissions.{{ $level }}">Indirect Commissions (Lvl {{ $level }})</label>
                    @endif
                    <div class="col-sm-9">
                        <div>
                            <input class="form-control" data-input="commissions" id="commissions.{{ $level }}" name="commissions[{{ $level }}]" value="{{ $commission }}" placeholder="Commissions" type="text">
                        </div>
                        <span> Commission Percentage After Fist purchase: <code>{{ $commission / $old_users_commission_divide->value }} %</code> </span>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>

        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="old_users_commission_divide">Commission Divided After Fist purchase</label>
            <div class="col-sm-9">
                <input class="form-control" id="old_users_commission_divide" data-input="commissions" name="old_users_commission_divide" value="{{ $old_users_commission_divide->value }}" type="text">
            </div>
        </div>
    </div>
</div>
