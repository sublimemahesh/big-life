<x-backend.layouts.app>
    @section('title', 'Packages | CMS')
    @section('header-title', 'Packages | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.packages.index') }}">Packages</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @can('update', \App\Models\Package::class)
                        <div class="mb-4">
                            <a class="btn btn-dark btn-xs btn-rounded" href="{{ route('admin.packages.arrange') }}">
                                Arrange
                            </a>
                        </div>
                        <hr>
                    @endcan
                    @include('backend.admin.packages.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="packages">
                        <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>NAME</th>
                                <th>SLUG</th>
                                <th>AMOUNT (USDT)</th>
                                <th>GAS FEE (USDT)</th>
                                <th>BV POINT</th>
                                <th>MAX OUT (USDT)</th>
                                {{--<th>MONTH OF PERIOD</th>--}}
                                {{--<th>DAILY LEVERAGE</th>--}}
                                <th>IS ACTIVE</th>
                                <th>LAST MODIFIED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td class="py-2">
                                        @can('update', $package)
                                            <a class="btn btn-xs btn-info sharp" href="{{ route('admin.packages.edit', $package) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $package)
                                            <a class="btn btn-xs btn-danger sharp delete-package" data-package="{{ $package->id }}" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->slug }}</td>
                                    <td class="text-end">{{ number_format($package->amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($package->gas_fee, 2) }}</td>
                                    <td class="text-end">{{ $package->bv_points }}</td>
                                    <td class="text-end"> {{ number_format($package->daily_max_out_limit, 2) }}</td>
                                    {{--<td>{{ $package->month_of_period }}</td>--}}
                                    {{--<td>{{ $package->daily_leverage }}</td>--}}
                                    <td>
                                        @if($package->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Active</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $package->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/package.js') }}"></script>
    @endpush
</x-backend.layouts.app>

