<x-backend.layouts.app>
    @section('title', 'Rank Bonus Requirements')
    @section('header-title', 'Rank Bonus Requirements' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Monthly Bonus Requirements</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        @if(!$summery_exists)
            <div class="col-sm-12">
                <div class="alert alert-warning">This Month Rank bonus does not exist.</div>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($user->id)
                        <div class="mb-4">
                            <h4 class="card-title">{{ $month }} - Rank bonus requirements</h4>
                            <p>
                                CURRENT HIGHEST ACTIVE PACKAGE ({{ \Carbon::now()->format('Y-m-d') }}): <code>USDT {{ number_format($highest_active_pkg,2) }}</code>
                                <br>
                                HIGHEST ACTIVE PACKAGE FOR {{ $bonus_cal_date }}: <code>USDT {{ $highest_active_pkg_for_period }}</code>
                                <br>
                                <br>
                                TOTAL TEAM INVESTMENT: <code>USDT {{ number_format($user->total_team_investment,2) }}</code>
                                <br>
                                MONTHLY TEAM INVESTMENT: <code>USDT {{ number_format($user->monthly_total_team_investment,2) }}</code>
                            </p>
                        </div>
                    @endif
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
                                                    <label for="month" class="text-gray-700 dark:text-gray-300">Month</label>
                                                    <div class="relative">
                                                        <form autocomplete="off">
                                                            <input id="month" type="text" placeholder="Select a month" readonly="readonly" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input">
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
                                        <div class="flex flex-col mb-2">
                                            <div>
                                                <div class=" pt-2 p-2 ">
                                                    <label for="" class="dark:text-gray-300 opacity-0 text-gray-700">Search</label>
                                                    <div class="relative">
                                                        <button id="search"
                                                                class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
                        <table id="rewards-requirements" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14">RANK</th>
                                <th class="fs-14">STATUS</th>
                                <th class="fs-14">REQUIREMENTS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($user->id)
                                @foreach($ranks_eligible_gifts as $rank => $requirement)
                                    <tr>
                                        <td>Rank 0{{ $rank }}</td>
                                        <td>
                                            @if($rank <= $current_rank &&
                                                    $user->monthly_total_team_investment>= $requirement->total_team_investment &&
                                                    $highest_active_pkg_for_period >= $requirement->active_investment)
                                                QUALIFIED
                                            @else
                                                NOT QUALIFIED
                                            @endif
                                        </td>
                                        <td>
                                            Investment: <code class=''>{{ $requirement->active_investment }}</code><br>
                                            Monthly Team: <code class=''>{{ $requirement->total_team_investment }}</code><br>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">Please Enter a user first</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/ranks/bonus-requirement.js') }}"></script>
    @endpush
</x-backend.layouts.app>
