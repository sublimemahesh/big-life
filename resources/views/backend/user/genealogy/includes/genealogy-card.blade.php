<div class="genealogy">
    <div class="card  {{ $user->active_packages_count > 0 ? 'card-active' : 'inactive' }}   ">


        <div class="card-img">
            <img class="card-img2  card-img2-mob" src="{{ $user->profile_photo_url }}" alt="">
        </div>

        <div class="row text-nowrap g-icon mbo-g-icon new-stl">
            <div class="col-sm-12 col-12" title="Left BV: {{ $user->left_points_balance }}">
                <label style="background: #1fcde8 ;width: 50px;border-radius: 10%;">
                    <div style="text-align:left;padding: 4px 6px 4px 6px;">
                        <i class="fa fa-chevron-left" aria-hidden="true" style="font-size:10px"></i>
                        <span style="font-size:12px">{{ $user->left_points_balance }}</span>
                    </div>
                </label>
            </div>

            <div class="col-sm-12 col-12" title="Right BV: {{ $user->right_points_balance }}">
                <label style="background: #1fcde8;width: 50px;border-radius:10%;">
                    <div style="text-align:left; padding: 4px 6px 4px 6px;">
                        <i class="fa fa-chevron-right" aria-hidden="true" style="font-size:10px"></i>
                        <span style="font-size: 12px ;">{{ $user->right_points_balance }}</span>
                    </div>
                </label>
            </div>


            <div class="col-sm-12 col-12" title="Members : {{ $user->descendants->count() }}">
                <label style="background: #1fcde8;width:50px;;border-radius:10%;">
                    <div style="text-align:left; padding: 4px 6px 4px 6px" class="d-flex flex-row align-items-center justify-content-evenly">
                        <i class="fa fa-street-view" aria-hidden="true" style="font-size:10px"></i>
                        &nbsp;
                        <span style="font-size: 12px;">
                            {{ $user->descendants->where('position', \App\Enums\BinaryPlaceEnum::LEFT->value)->count() }}
                        </span>
                        &nbsp;&boxv;&nbsp;
                        <span style="font-size: 12px;">
                            {{ $user->descendants->where('position', \App\Enums\BinaryPlaceEnum::RIGHT->value)->count() }}
                        </span>
                    </div>
                </label>
            </div>
        </div>


        <div class="card-info">
            <h5 class="text-title">{{ $user->username }}</h5>
            <p class="text-body-name" title="{{ $user->name }}">{{ $user->name }}</p>
            <p class="text-id">#{{str_pad($user->id, 4, "0", STR_PAD_LEFT)}}</p>
            <p class="text-body {{ $user->active_packages_count > 0 ? 'text-status-active' : '' }}">
                <i class="fa fa-bolt" aria-hidden="true"></i> <span>{{ $user->active_packages_count > 0 ? 'Active' :
                'Inactive' }}</span>
            </p>
        </div>
    </div>
</div>
