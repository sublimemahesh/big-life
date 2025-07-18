<x-backend.layouts.app>
    @section('title', 'Purchased Staking Plans | Reports')
    @section('header-title', 'Staking Plans | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Payments</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="w-full my-3 dark:bg-gray-800">
                        <div class="rounded-sm">
                            <div class="px-4 py-3 cursor-pointer dark:bg-secondary-dark border border-gray-200 dark:border-gray-600">
                                <button class="appearance-none text-left text-base font-medium text-gray-500 focus:outline-none dark:text-gray-300" type="button">
                                    Filter
                                </button>
                            </div>
                            <div class="border-l border-b border-r border-gray-200 dark:border-gray-600 px-2 py-4 dark:border-0  dark:bg-secondary-dark">
                                <div>
                                    <div class="md:flex md:flex-wrap">
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="user_id" class="text-gray-700 dark:text-gray-300">USER ID</label>
                                                    <div class="relative">
                                                        <input id="user_id" value="{{ request()->input('user_id') }}" placeholder="Enter User ID" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="purchaser_id" class="text-gray-700 dark:text-gray-300">PURCHASED BY</label>
                                                    <div class="relative">
                                                        <input id="purchaser_id" value="{{ request()->input('purchaser_id') }}" placeholder="Enter User ID" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="transaction-date-range" class="text-gray-700 dark:text-gray-300">PERIOD</label>
                                                    <div class="relative">
                                                        <form autocomplete="off">
                                                            <input id="transaction-date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
                                                        </form>
                                                        <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="transaction-status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                                    <div class="relative">
                                                        <select id="transaction-status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <option value="">ALL</option>
                                                            <option value="active" {{ request()->input('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                                                            <option value="expired" {{ request()->input('status') === 'expired' ? 'selected' : '' }}>EXPIRED</option>
                                                            <option value="cancelled" {{ request()->input('status') === 'cancelled' ? 'selected' : '' }}>CANCELED</option>
                                                            <option value="hold" {{ request()->input('status') === 'hold' ? 'selected' : '' }}>HOLD</option>
                                                        </select>
                                                        <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="package_id" class="text-gray-700 dark:text-gray-300">STAKING PACKAGE</label>
                                                    <div class="relative">
                                                        <select id="package_id" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <option value="">ALL</option>
                                                            @foreach($packages as $package)
                                                                <option value="{{ $package->id }}" {{ (int)request()->input('package_id') === $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="plan_id" class="text-gray-700 dark:text-gray-300">STAKING PLANS</label>
                                                    <div class="relative">
                                                        <select id="plan_id" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <option value="">ALL</option>
                                                        </select>
                                                        <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mb-2">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="transaction-search" class="text-gray-700 dark:text-gray-300">&nbsp;</label>
                                                    <div class="relative">
                                                        <button id="transaction-search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                            Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="transactions" class="display mb-1 nowrap table-responsive" style="table-layout: fixed ">
                            <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>TRX ID</th>
                                <th>USER / PACKAGE</th>
                                <th class="text-center">STATUS</th>
                                <th>MATURITY DATE</th>
                                <th>INTEREST RATE</th>
                                <th>CREATED</th>
                                <th>INVESTED</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th colspan="8" style="text-align:right"></th>
                            </tr>
                            </tfoot>
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
        <script src="{{ asset('assets/backend/js/admin/staking-plans/main.js') }}"></script>
    @endpush
</x-backend.layouts.app>
