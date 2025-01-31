<x-backend.layouts.app>
    @section('title', 'BV Points | Earnings')
    @section('header-title', 'BV Points' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">BV Points Earnings</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        @include('backend.user.bv-points.top-nav')

        <div class="col-12">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">LEFT</p>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> BV {{ $left_point }}</h4>
                                    <br>
                                    <small> </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">RIGHT</p>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> BV {{ $right_point }}</h4>
                                    <br>
                                    <small> </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">BALANCED</p>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> BV {{ $balanced_point }}</h4>
                                    <br>
                                    <small> </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">BV EARNINGS </p>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $earned_usdt }}</h4>
                                    <br>
                                    <small>EXPIRED: USDT {{ $expired_usdt }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">PENDING BV EARNINGS</p>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $pending_usdt }}</h4>
                                    <br>
                                    <small> </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                <div class="media-body text-white">
                                    <p class="mb-1">DIRECT SALES</p>
                                    <h4 class="text-white user-dashboard-card-font-size-change me-4"> LEFT {{ $left_direct_sales }}</h4>
                                    <h4 class="text-white user-dashboard-card-font-size-change"> RIGHT {{ $right_direct_sales }}</h4>
                                    <br>
                                    <small> </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="earnings" class="display table-responsive-my " style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>FROM</th>
                                    <th>PACKAGE</th>
                                    <th class="text-right">LEFT</th>
                                    <th class="text-right">RIGHT</th>
                                    <th class="text-right">DATE</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/bv-points/point-earnings.js') }}"></script>
    @endpush
</x-backend.layouts.app>
