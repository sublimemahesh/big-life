<x-backend.layouts.app>
    @section('title', 'Maxed Out BV Points')
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
        <li class="breadcrumb-item">Maxed Out BV Points</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        @include('backend.user.bv-points.top-nav')

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="maxed-out-bv-points-table" class="display min-w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Package</th>
                                    <th>Left BV</th>
                                    <th>Right BV</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maxedOutBvPoints as $point)
                                <tr>
                                    <td>{{ $point->maxed_out_date }}</td>
                                    <td>{{ $point->purchasedPackage ? $point->purchasedPackage->packageRef->name : 'N/A' }}</td>
                                    <td>{{ $point->left_point }}</td>
                                    <td>{{ $point->right_point }}</td>
                                    <td>{{ $point->reason }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $maxedOutBvPoints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/bv-points/maxed-out-bv-points.js') }}"></script>
    @endpush
</x-backend.layouts.app>
