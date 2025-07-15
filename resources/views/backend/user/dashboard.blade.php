@extends('auth.layouts.auth')

@section('title', 'User Dashboard')
@section('header-title', 'Welcome ' . Auth::user()->name)
@section('header-title2',Auth::user()->username)

@section('contents')

<main class="main">

    <!-- dashboard area -->
    <div class="dashboard-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="dashboard-sidebar">
                        <div class="dashboard-profile">
                            <img src="assets/img/investor/user.jpg" alt="">
                            <div class="profile-content">
                                <h5>Geo Caver</h5>
                                <p><a href="https://live.themewild.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="7f1c1e091a0d3f1a071e120f131a511c1012">[email&#160;protected]</a></p>
                            </div>
                        </div>
                        <div class="dashboard-menu">
                            <ul>
                                <li><a href="dashboard.html" class="active"><i class="far fa-tachometer-alt-average"></i> Dashboard</a></li>
                                <li><a href="user-deposit.html"><i class="far fa-sack-dollar"></i> Deposit Money</a></li>
                                <li><a href="user-withdraw.html"><i class="far fa-wallet"></i> Withdraw Money</a></li>
                                <li><a href="user-investment.html"><i class="far fa-box-usd"></i> Total Investment</a></li>
                                <li><a href="user-transaction.html"><i class="far fa-credit-card-front"></i> Transaction</a></li>
                                <li><a href="user-notification.html"><i class="far fa-bell"></i> Notifications</a></li>
                                <li><a href="user-setting.html"><i class="far fa-cog"></i> Settings</a></li>
                                <li><a href="user-referral.html"><i class="far fa-link"></i> Referral Link</a></li>
                                <li><a href="dashboard.html#"><i class="far fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="dashboard-content">
                        <div class="dashboard-content-head">
                            <div class="dashboard-content-search">
                                 <h5>Geo Caver</h5>
                            </div>
                            <div class="dashboard-content-head-menu">
                                <ul>
                                    <li>
                                        <div class="dropdown">
                                            <a class="dashboard-head-notification" href="dashboard.html#" data-bs-toggle="dropdown">
                                                <span class="dashboard-head-notification-count">5</span>
                                                <i class="far fa-bell"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dashboard-head-notification-dropdown">
                                                <li>
                                                    <div class="dashboard-head-notification-top">
                                                        <span>5 New Notifications</span>
                                                        <a href="dashboard.html#">Clear</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <div class="dashboard-head-notification-item">
                                                        <a href="dashboard.html#">
                                                            <h6>Caver Deposit 1,000 USD</h6>
                                                            <span>1 hour ago</span>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="dashboard-head-notification-item">
                                                        <a href="dashboard.html#">
                                                            <h6>Caver Deposit 1,000 USD</h6>
                                                            <span>1 hour ago</span>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="dashboard-head-notification-item">
                                                        <a href="dashboard.html#">
                                                            <h6>Caver Deposit 1,000 USD</h6>
                                                            <span>1 hour ago</span>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li class="text-center">
                                                    <a class="dashboard-head-notification-bottom" href="dashboard.html#">View All</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a class="dashboard-head-profile" href="dashboard.html#" data-bs-toggle="dropdown">
                                                <i class="far fa-user-circle"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dashboard-head-profile-dropdown">
                                                <li><a class="dropdown-item" href="dashboard.html#"><i class="far fa-user"></i> My Profile</a></li>
                                                <li><a class="dropdown-item" href="dashboard.html#"><i class="far fa-cog"></i> Account Settings</a></li>
                                                <li><a class="dropdown-item" href="dashboard.html#"><i class="far fa-sign-out"></i> Log Out</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dashboard-widget-wrapper">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>INCOME BALANCE</h5>
                                            <span> USDT {{number_format($wallet->balance,2) }}</span>
                                        </div>
                                        <i class="flaticon-world"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>PAYOUT BALANCE</h5>
                                            <span>USDT {{number_format($available_withdraw_level,2) }}</span>
                                        </div>
                                        <i class="flaticon-wallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>Pending Withdraw</h5>
                                            <span>$5,5841</span>
                                        </div>
                                        <i class="flaticon-dollar"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>Referral</h5>
                                            <span>$5,5841</span>
                                        </div>
                                        <i class="flaticon-management"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>Total Profit</h5>
                                            <span>$5,5841</span>
                                        </div>
                                        <i class="flaticon-graph"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-widget">
                                        <div class="dashboard-widget-content">
                                            <h5>Total Earning</h5>
                                            <span>$5,5841</span>
                                        </div>
                                        <i class="flaticon-mine"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard-table-wrapper">
                            <div class="dashboard-table-head">
                                <h3>Transaction History</h3>
                                <select class="select">
                                    <option value="">Sort By Default</option>
                                    <option value="1">This Month</option>
                                    <option value="2">Last Month</option>
                                    <option value="3">This Year</option>
                                    <option value="4">Last Year</option>
                                </select>
                            </div>
                            <div class="dashboard-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2025</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- dashboard area end -->


</main>


@endsection
