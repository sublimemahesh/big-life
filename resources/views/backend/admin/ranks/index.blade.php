<x-backend.layouts.app>
    @section('title', 'Ranks | Reports')
    @section('header-title', 'Ranks | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Ranks</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="w-full my-3 dark:bg-gray-800">
                        <div class="rounded-sm">

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
                                                    <label for="rank" class="text-gray-700 dark:text-gray-300">RANK</label>
                                                    <div class="relative">
                                                        <select id="rank" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <option value="">ALL</option>
                                                            @for($i = 1; $i <= config('rank-system.rank_level_count'); $i++)
                                                                <option value="{{ $i }}" {{ request()->input('rank') === $i ? 'selected' : '' }}>RANK {{ $i }}</option>
                                                            @endfor
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
                                                    <label for="date-range" class="text-gray-700 dark:text-gray-300">PERIOD</label>
                                                    <div class="relative">
                                                        <form autocomplete="off">
                                                            <input id="date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
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
                                                    <label for="status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                                    <div class="relative">
                                                        <select id="status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                            <option value="">ALL</option>
                                                            <option value="active" {{ request()->input('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                                                            <option value="inactive" {{ request()->input('status') === 'inactive' ? 'selected' : '' }}>INACTIVE</option>
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
                                                    <div class="relative">
                                                        <label for="search" class="dark:text-gray-300 opacity-0 text-gray-700">search</label>
                                                        <div class="relative">
                                                            <button id="search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
                    </div>
                    <div class="table-responsive">
                        <table id="rewards" class="display nowrap mb-1 table-responsive-my" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th>USER</th>
                                <th class="text-center">RANK</th>
                                <th>ELIGIBILITY</th>
                                <th>STATUS</th>
                                <th>TOTAL RANKERS</th>
                                <th class="text-center">ACTIVATED</th>
                                <th class="text-center">CREATED</th>
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
        <script src="{{ asset('assets/backend/js/admin/ranks/ranks.js') }}"></script>
    @endpush
</x-backend.layouts.app>
