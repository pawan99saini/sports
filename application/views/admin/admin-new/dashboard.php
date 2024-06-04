<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">DASHBOARD</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Main</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-9">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body py-0 px-3">
                                <div class="row">
                                    <div class="col-xxl-3 col-xl-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-between flex-wrap border-primary-end p-4">
                                        <div>
                                            <p class="tx-primary tx-12 mb-1">Total Players</p>
                                            <h4 class="tx-22 numberfont font-weight-semibold mb-1"><?= $total_players; ?></h4>
                                            <p class="tx-11 tx-muted mb-0">Overall</p>
                                        </div>
                                        <div class="flex-center">
                                            <span class="svg-primary total-profit-svg main-dashboard-cards-svg">
                                                <i class="icon-people"></i>
                                            </span>
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" class="svg-primary total-profit-svg main-dashboard-cards-svg" viewBox="0 0 24 24" width="24px" fill="#175787">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M21 7.28V5c0-1.1-.9-2-2-2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-2.28c.59-.35 1-.98 1-1.72V9c0-.74-.41-1.37-1-1.72zM20 9v6h-7V9h7zM5 19V5h14v2h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6v2H5z"></path>
                                                <circle cx="16" cy="12" r="1.5"></circle>
                                            </svg> -->
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-between flex-wrap border-primary-end p-4">
                                        <div>
                                            <p class="tx-primary tx-12 mb-1">Open Tournaments</p>
                                            <h4 class="tx-22 numberfont font-weight-semibold mb-1">
                                                <?= $active_tournaments; ?>
                                            </h4>
                                            <p class="tx-11 tx-muted mb-0">Overall</p>
                                        </div>
                                        <div class="flex-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-secondary total-order-svg main-dashboard-cards-svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#175787">
                                                <g>
                                                    <rect fill="none" height="24" width="24"></rect>
                                                    <path d="M18,6h-2c0-2.21-1.79-4-4-4S8,3.79,8,6H6C4.9,6,4,6.9,4,8v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8C20,6.9,19.1,6,18,6z M12,4c1.1,0,2,0.9,2,2h-4C10,4.9,10.9,4,12,4z M18,20H6V8h2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8h4v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8 h2V20z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-between flex-wrap border-primary-end p-4">
                                        <div>
                                            <p class="tx-primary tx-12 mb-1">Inactive Tournaments</p>
                                            <h4 class="tx-22 numberfont font-weight-semibold mb-1"><?= $inactive_tournaments; ?></h4>
                                            <p class="tx-11 tx-muted mb-0">Over All</p>
                                        </div>
                                        <div class="flex-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" class="svg-warning total-sales-svg main-dashboard-cards-svg" viewBox="0 0 24 24" width="24px" fill="#175787">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-between flex-wrap ps-4 py-4 pe-2">
                                        <div class="flex-grow-1">
                                            <p class="tx-primary tx-12 mb-1">Site Visits</p>
                                            <h4 class="tx-22 numberfont font-weight-semibold mb-1"><?= $site_visits->num_rows(); ?> 
                                                <span class="badge badge-success-transparent tx-success tx-11">
                                                    56 <i class="fe fe-arrow-up tx-11"></i>
                                                </span>
                                            </h4>
                                            <p class="tx-11 tx-muted mb-0">From The Begining</p>
                                        </div>
                                        <div id="total-investment" class="mx-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-end -->
                </div>
                <div class="row">
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card ">
                            <div class="card-header">
                                <div class="card-title d-flex justify-content-between">
                                    Activity Log
                                    <div class="ms-auto">
                                        <a href="#" class="tx-muted tx-11 font-weight-semibold">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="ps-0 list-unstyled mb-0">
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center ms-4 activity-content1">
                                            <p class="mb-1">
                                                <span class="text-primary">Katy Perri </span><span class="tx-11 font-weight-normal">commented.</span>
                                            </p>
                                            <span class="tx-11 tx-muted">1h</span>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between ms-4 activity-content2">
                                            <p class="mb-1 wd-250">
                                                Neon Tarly <span class="tx-11 font-weight-normal">added</span> <span class="text-secondary">Robin Bright</span> <span class="tx-11 font-weight-normal">to the</span> Summit AI <Spam class="tx-11 font-weight-normal">Project.</Spam>
                                            </p>
                                            <span class="tx-11 tx-muted">6h</span>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center ms-4 activity-content4">
                                            <p class="mb-1 wd-250 d-flex align-items-center">
                                                Wanda Rag <span class="tx-11 font-weight-normal mx-1">replied your comment </span><span class="mx-1 text-danger font-weight-bold mt-1 tx-15"><i class="fe fe-check"></i></span>
                                            </p>
                                            <span class="tx-11 tx-muted">1d</span>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center ms-4 activity-content3">
                                            <p class="mb-1 wd-250">
                                                You <span class="tx-11 font-weight-normal">deleted <span class="badge badge-sm badge-warning-transparent mx-1">20 files</span>from the</span> Summit AI <span class="tx-11 font-weight-normal">project.</span>
                                            </p>
                                            <span class="tx-11 tx-muted">4h</span>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center ms-4 activity-content5">
                                            <p class="mb-1 wd-250 d-flex align-items-center">
                                                Created <span class="tx-11 font-weight-normal tx-success mx-1"> a New Task </span> Today <span class="mx-1 text-success font-weight-bold mt-1"><i class="fe fe-plus p-1 tx-10 bg-success-transparent rounded-circle"></i></span>
                                            </p>
                                            <span class="tx-11 tx-muted">2h</span>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center ms-4 activity-content6">
                                            <p class="mb-1 wd-250">
                                                New Member <span class="tx-11 font-weight-normal badge badge-info-transparent">@andras.betson</span> added Yesterday.
                                            </p>
                                            <span class="tx-11 tx-muted">1d</span>
                                        </div>
                                    </li>
                                    <li class="mb-0">
                                        <div class="d-flex justify-content-between ms-4 activity-content7">
                                            <p class="mb-1 wd-250">
                                                Neon Tarly <span class="tx-11 font-weight-normal">added</span> <span class="tx-orange">Robin Bright</span> <span class="tx-11 font-weight-normal">to the</span> Summit AI <Spam class="tx-11 font-weight-normal">Project.</Spam>
                                            </p>
                                            <span class="tx-11 tx-muted">6h</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- col-end -->
                    <div class="col-xxl-8 col-xl-12">
                        <div class="card ">
                            <div class="card-header flex-between">
                                <div class="card-title d-flex justify-content-between">
                                    Sales Report
                                </div>
                                <div class="dropdown ms-auto">
                                    <button
                                        class="btn tx-muted tx-11 font-weight-semibold btn-sm dropdown-toggle"
                                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Monthly
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item tx-muted" href="#">Day</a></li>
                                        <li><a class="dropdown-item tx-muted" href="#">Yearly</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="sales-stats d-flex mb-4">
                                    <div class="row project-stats">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <p class="mb-1">Active Orders</p>
                                            <div>
                                                <span class="mt-1 tx-16 numberfont font-weight-normal tx-primary">106</span>
                                                <span class="tx-success"><i class="fa fa-caret-up mx-1"></i>
                                                <span class="badge bg-success-transparent numberfont tx-success tx-11">+0.12%</span></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <p class="mb-1">Completed Orders</p>
                                            <div class="mb-1 font-weight-semibold">
                                                <span class="mt-1 tx-16 numberfont font-weight-normal tx-primary">420</span>
                                                <span class="tx-success"><i class="fa fa-caret-up mx-1"></i>
                                                <span class="badge bg-success-transparent numberfont tx-success tx-11">+0.24%</span></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <p class="mb-1">Sales Revenue</p>
                                            <div class="mb-0">
                                                <span class="mt-1 tx-16 font-weight-normal numberfont tx-secondary">$32,124.00</span>
                                                <span class="tx-danger"><i class="fa fa-caret-up mx-1"></i>
                                                <span class="badge bg-danger-transparent numberfont tx-danger tx-11">-0.24%</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="salesChart"></div>
                            </div>
                        </div>
                    </div><!-- col-end -->

                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-6 col-xxl-7">
                        <div class="card ">
                            <div
                                class="card-header custom-header d-flex justify-content-between align-items-center">
                                <div class="card-title d-flex justify-content-between">Best Selling Products</div>
                                <div class="ms-auto">
                                    <ul class="nav nav-fill">
                                        <li class="nav-item pending-products me-3">
                                            <a class="nav-link tx-12 px-0 active"
                                                aria-current="page" href="#Active" data-bs-toggle="tab">Pending</a>
                                        </li>
                                        <li class="nav-item pending-products">
                                            <a class="nav-link tx-12 px-0" href="#Complete"
                                                data-bs-toggle="tab">Conformed</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane active table-responsive" id="Active">
                                        <table class="table border-0 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0 tx-muted font-weight-normal ps-4">
                                                        ProductName</th>
                                                    <th class="border-top-0 tx-muted font-weight-normal">TotalOrders
                                                    </th>
                                                    <th class="border-top-0 tx-muted font-weight-normal">Status</th>
                                                    <th class="border-top-0 tx-muted font-weight-normal pe-4 text-end">
                                                        Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/32.png" alt="img"
                                                                class="radius-4 avatar p-2 bg-warning-transparent">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1 font-weight-semibold">SPECTS YELLOW</P>
                                                                <span class="tx-muted tx-11">
                                                                    #4002364Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">520</P>
                                                            <span class="tx-muted tx-11">
                                                                july 24, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$40.00</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/34.png" alt="img"
                                                                class="radius-4 avatar p-2 bg-primary-transparent">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">HEADPHONES Blue
                                                                </P>
                                                                <span class="tx-muted tx-11">
                                                                    #2002484Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">240</P>
                                                            <span class="tx-muted tx-11">
                                                                Nov 18, 2021
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-secondary">out of
                                                                stock</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$39.89</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/33.png" alt="img"
                                                                class="radius-4 avatar p-2 bg-pink-transparent">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">BAG Pink</P>
                                                                <span class="tx-muted tx-11">
                                                                    #30023784Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">400</P>
                                                            <span class="tx-muted tx-11">
                                                                April 16, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$22.60</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/37.png" alt="img"
                                                                class="radius-4 avatar p-2 bg-success-transparent">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">SHOES Green</P>
                                                                <span class="tx-muted tx-11">
                                                                    #4002364Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">89</P>
                                                            <span class="tx-muted tx-11">
                                                                Feb 06, 2021
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-secondary">out of
                                                                stock</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$38.04</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/35.png" alt="img"
                                                                class="radius-4 avatar p-2 bg-primary-transparent">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">WATCH Blue</P>
                                                                <span class="tx-muted tx-11">
                                                                    #2402429Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">106</P>
                                                            <span class="tx-muted tx-11">
                                                                Sep 24, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$25.64</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane table-responsive" id="Complete">
                                        <table class="table border-0 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0 tx-muted font-weight-normal ps-4">
                                                        ProductName</th>
                                                    <th class="border-top-0 tx-muted font-weight-normal">TotalOrders
                                                    </th>
                                                    <th class="border-top-0 tx-muted font-weight-normal">Status</th>
                                                    <th class="border-top-0 tx-muted font-weight-normal pe-4 text-end">
                                                        Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/7.jpg" alt="img"
                                                                class="radius-4 avatar">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">White Shoes</P>
                                                                <span class="tx-muted tx-12">
                                                                    #4002364Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">89</P>
                                                            <span class="tx-muted tx-12">
                                                                Feb 06, 2021
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-warning">out of
                                                                stock</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$38.04</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/18.jpg" alt="img"
                                                                class="radius-4 avatar">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">WATCH Blue</P>
                                                                <span class="tx-muted tx-12">
                                                                    #2402429Edb
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">106</P>
                                                            <span class="tx-muted tx-12">
                                                                Sep 24, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$25.64</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/19.jpg" alt="img"
                                                                class="radius-4 avatar">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">DIGITAL CAMERA</P>
                                                                <span class="tx-muted tx-12">
                                                                    #24024345df
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">34</P>
                                                            <span class="tx-muted tx-12">
                                                                Sep 29, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$1,299.00</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/20.jpg" alt="img"
                                                                class="radius-4 avatar">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">PHOTO FRAME</P>
                                                                <span class="tx-muted tx-12">
                                                                    #2402429Der
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">124</P>
                                                            <span class="tx-muted tx-12">
                                                                Sep 28, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-secondary">out of stock</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$12.00</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="../assets/img/ecommerce/6.jpg" alt="img"
                                                                class="radius-4 avatar">
                                                            <div class="d-flex flex-column ms-2">
                                                                <P class="mb-1">FLOWER POT</P>
                                                                <span class="tx-muted tx-12">
                                                                    #2402429Eff
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column ms-2">
                                                            <P class="mb-1 font-weight-semibold numberfont tx-14">236</P>
                                                            <span class="tx-muted tx-12">
                                                                Sep 22, 2020
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="tx-primary">stock
                                                                Ready</span>
                                                        </div>
                                                    </td>
                                                    <td class="pe-4">
                                                        <div class="float-end">
                                                            <span class="font-weight-semibold numberfont tx-14">$20.99</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-6 col-xxl-5">
                        <div class="card ">
                            <div class="card-header">
                                <div class="card-title d-flex justify-content-between">
                                    transactions history
                                    <div class="ms-auto">
                                        <a href="#" class="tx-muted tx-11 font-weight-semibold">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);"><span class="avatar avatar-md br-5 bg-primary-transparent text-primary me-3"><i class="fe fe-credit-card"></i></span></a>
                                        <div class="w-100">
                                            <a href="javascript:void(0);">
                                                <span class="mb-1 text-default me-3">Visa Card</span>
                                                <span class="badge border-primary border text-primary fs-11 my-auto">Processing</span>
                                            </a>
                                            <p class="tx-11 text-muted me-3">Just now</p>
                                        </div>
                                        <div class="ms-auto my-auto">
                                            <p class="numberfont font-weight-semibold tx-14">
                                                <span class="tx-primary me-1">-</span>$2,45,000
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);"><span class="avatar avatar-md br-5 bg-warning-transparent text-warning me-3"><i class="fe fe-smartphone"></i></span></a>
                                        <div class="w-100">
                                            <a href="javascript:void(0);">
                                                <span class="mb-1 text-default me-3">Through UPI</span>
                                            </a>
                                            <p class="tx-11 text-muted me-3">Yesterday</p>
                                        </div>
                                        <div class="ms-auto my-auto">
                                            <p class="numberfont font-weight-semibold tx-14">
                                                <span class="tx-warning me-1">+</span>$100.<span class="tx-10">00</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);"><span class="avatar avatar-md br-5 bg-orange-transparent text-orange me-3"><i class="fe fe-arrow-down"></i></span></a>
                                        <div class="w-100">
                                            <a href="javascript:void(0);">
                                                <span class="mb-1 text-default me-3">Bank Of Baroda Credit Card</span>
                                                <span class="badge border-orange border tx-orange fs-11 my-auto">Completed</span>
                                            </a>
                                            <p class="tx-11 text-muted me-3">17-04-2022</p>
                                        </div>
                                        <div class="ms-auto my-auto">
                                            <p class="numberfont font-weight-semibold tx-14">
                                                $1,50,000
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);"><span class="avatar avatar-md br-5 bg-success-transparent text-success me-3"><i class="fe fe-arrow-up"></i></span></a>
                                        <div class="w-100">
                                            <a href="javascript:void(0);">
                                                <span class="mb-1 text-default me-3">Paid By PayPal</span>
                                            </a>
                                            <p class="tx-11 text-muted me-3">21-04-2022</p>
                                        </div>
                                        <div class="ms-auto my-auto">
                                            <p class="numberfont font-weight-semibold tx-14">
                                                <span class="tx-success me-1">-</span>$500.<span class="tx-10">00</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);"><span class="avatar avatar-md br-5 bg-secondary-transparent tx-secondary me-3"><i class="fe fe-more-horizontal"></i></span></a>
                                        <div class="w-100">
                                            <a href="javascript:void(0);">
                                                <span class="mb-1 text-default me-3">Credit Card</span>
                                                <span class="badge border-secondary border text-secondary fs-11 my-auto">Processing</span>
                                            </a>
                                            <p class="tx-11 text-muted me-3 mb-0">25-04-2022</p>
                                        </div>
                                        <div class="ms-auto my-auto">
                                            <p class="numberfont font-weight-semibold tx-14">
                                                <span class="tx-secondary me-1">+</span>$3,000
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- col-end -->

            <div class="col-xl-12 col-xxl-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header">
                                <div class="card-title d-flex justify-content-between">
                                    Tasks
                                    <div class="ms-auto">
                                        <a href="#" class="tx-muted tx-12 font-weight-normal">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                <ul class="tasks-all mb-0">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center shadow">
                                                <a href="#"
                                                    class="text-primary d-flex align-items-center justify-content-center"><i
                                                        class="fe fe-activity"></i></a>
                                            </div>
                                            <div class="ms-3 flex-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">To Do</p>
                                                    <span class="badge badge-primary-transparent"><i class="fe fe-arrow-right tx-10 me-2"></i>10.06.2020</span>
                                                </div>
                                                <p class="tx-muted mb-0 tx-11 d-flex align-items-center">2m ago
                                                    <span class="ms-2 d-flex align-items-center"> <span
                                                            class="rounded-circle ht-5 wd-5 bg-primary me-1"></span>
                                                        in progress</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-secondary-transparent rounded-circle d-flex align-items-center justify-content-center shadow">
                                                <a href="#"
                                                    class="text-secondary d-flex align-items-center justify-content-center"><i
                                                        class="fe fe-command"></i></a>
                                            </div>
                                            <div class="ms-3 flex-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Task In Progress</p>
                                                    <span class="badge badge-secondary-transparent"><i class="fe fe-arrow-right tx-10 me-2"></i>02.06.2022</span>
                                                </div>
                                                <p class="tx-muted mb-0 tx-11 d-flex align-items-center">2m ago
                                                    <span class="ms-2 d-flex align-items-center"> <span
                                                            class="rounded-circle ht-5 wd-5 bg-secondary me-1"></span>started</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-orange-transparent rounded-circle d-flex align-items-center justify-content-center shadow">
                                                <a href="#"
                                                    class="text-orange d-flex align-items-center justify-content-center"><i
                                                        class="fe fe-globe"></i></a>
                                            </div>
                                            <div class="ms-3 flex-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Completed Task</p>
                                                    <span class="badge badge-warning-transparent"><i class="fe fe-arrow-right tx-10 me-2"></i>06.12.2022</span>
                                                </div>
                                                <p class="tx-muted mb-0 tx-11 d-flex align-items-center">2m ago
                                                    <span class="ms-2 d-flex align-items-center"> <span
                                                            class="rounded-circle ht-5 wd-5 bg-warning me-1"></span>completed</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-success-transparent rounded-circle d-flex align-items-center justify-content-center shadow">
                                                <a href="#"
                                                    class="text-success d-flex align-items-center justify-content-center"><i
                                                        class="fe fe-activity"></i></a>
                                            </div>
                                            <div class="ms-3 flex-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">To Do</p>
                                                    <span class="badge badge-success-transparent"><i class="fe fe-arrow-right tx-10 me-2"></i>12.06.2021</span>
                                                </div>
                                                <p class="tx-muted mb-0 tx-11 d-flex align-items-center">2m ago
                                                    <span class="ms-2 d-flex align-items-center"> <span
                                                            class="rounded-circle ht-5 wd-5 bg-success me-1"></span>
                                                        in progress</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title">Profits By Country</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="mb-1">India<span class="float-end tx-primary"><i class="fa fa-long-arrow-up mx-1"></i> <span class="text-primary">$21,234.90</span></span></div>
                                    <div class="progress-bar-custom progress-bar-custom-primary">
                                        <div class="progress-custom fill-1 progress-primary wd-95">
                                            <div class="glow glow-primary"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="mb-1">Usa  <span class="text-primary float-end">Increased<span class="badge badge-secondary-transparent ms-2">42%</span></span></div>
                                    <div class="progress-bar-custom progress-bar-custom-secondary mb-3">
                                        <div class="progress-custom fill-1 progress-secondary wd-200">
                                            <div class="glow glow-secondary"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="mb-1">Russia<span class="float-end tx-success"><i class="fa fa-long-arrow-up mx-1"></i> <span class="text-success">+$14,256</span></span></div>
                                    <div class="progress-bar-custom progress-bar-custom-success mb-3">
                                        <div class="progress-custom fill-1 progress-success wd-55">
                                            <div class="glow glow-success"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="mb-1">Uae<span class="float-end tx-orange"><i class="fa fa-long-arrow-down mx-1"></i> <span class="text-orange">-$4,345.69</span></span></div>
                                    <div class="progress-bar-custom progress-bar-custom-orange mb-3">
                                        <div class="progress-custom fill-1 progress-orange wd-150">
                                            <div class="glow glow-orange"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="mb-1">China<span class="float-end tx-purple"><i class="fa fa-long-arrow-up mx-1"></i> <span class="text-purple">+$72,234.50</span></span></div>
                                    <div class="progress-bar-custom progress-bar-custom-purple mb-1">
                                        <div class="progress-custom fill-1 progress-purple wd-200">
                                            <div class="glow glow-purple"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title d-flex justify-content-between">
                                    Billings
                                </div>
                                <div class="panel">
                                    <div class="panel tabs-style6">
                                        <div class="panel-head ms-auto">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item flex-1"><a class="nav-link px-3 active" data-bs-toggle="tab" href="#tab_received"><i class="fe fe-corner-right-down me-2 tx-10"></i>Received</a></li>
                                                <li class="nav-item flex-1"><a class="nav-link px-3" data-bs-toggle="tab" href="#tab_paid"><i class="fe fe-check-square me-2 tx-10"></i>Paid</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel-body border-0 p-0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_received">
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Joseph Arimathea<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$5,000</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">15
                                                                    Invoices</a><span
                                                                    class="tx-muted tx-11">Today</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Simon Cyrene<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$89,400</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">37
                                                                    Invoices</a><span class="tx-muted tx-11">20
                                                                    Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded-circle bg-secondary-transparent avatar-sm">
                                                            <span class="tx-muted font-weight-normal mt-1">PS</span>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Penelope Smallbone<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$20,400</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">2 Invoices</a><span
                                                                    class="tx-muted tx-11">20 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div >
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Ruby Bartlett<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$49,250</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">37
                                                                    Invoices</a><span class="tx-muted tx-11">17
                                                                    Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Sylvia Trench<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$9,260</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">4 Invoices</a><span
                                                                    class="tx-muted tx-11">10 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="mb-0">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Simon Cyrene<span
                                                                    class="tx-primary numberfont font-weight-semibold tx-14">+$89,400</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">37
                                                                    Invoices</a><span class="tx-muted tx-11">20
                                                                    Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="tab_paid">
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded-circle bg-secondary-transparent avatar-sm">
                                                            <span class="tx-muted font-weight-normal mt-1">LE</span>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Lisbon Es<span class="tx-secondary font-weight-semibold numberfont tx-14">-$20,000</span>
                                                            </p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">2 Invoices</a><span
                                                                    class="tx-muted tx-11">Today</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Liza Doolittle<span
                                                                    class="tx-secondary numberfont font-weight-semibold tx-14">-$65,000</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">7 Invoices</a><span
                                                                    class="tx-muted tx-11">15 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Tiffany Case<span
                                                                    class="tx-secondary numberfont font-weight-semibold tx-14">-$6,030</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">2 Invoices</a><span
                                                                    class="tx-muted tx-11">15 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Shady Tree<span class="tx-secondary font-weight-semibold numberfont tx-14">-$5,800</span>
                                                            </p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">7 Invoices</a><span
                                                                    class="tx-muted tx-11">14 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Henry Flex<span
                                                                    class="tx-secondary numberfont font-weight-semibold tx-14">-$68,100</span></p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">7 Invoices</a><span
                                                                    class="tx-muted tx-11">11 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="mb-0">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <i class="fe fe-user p-2 bg-primary-transparent tx-primary rounded-circle"></i>
                                                        </div>
                                                        <div class="flex-1 ms-3">
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                Shady Tree<span class="tx-secondary font-weight-semibold numberfont tx-14">-$5,800</span>
                                                            </p>
                                                            <p
                                                                class="mb-0 d-flex align-items-center justify-content-between">
                                                                <a href="invoice.html"
                                                                    class="tx-muted tx-11">7 Invoices</a><span
                                                                    class="tx-muted tx-11">14 Jan 22</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row  -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="card-title">Product Summary</div>
                    </div>
                    <div class="card-body example1-table">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal">Date</th>
                                        <th class="font-weight-normal">Client Name</th>
                                        <th class="font-weight-normal">Product</th>
                                        <th class="font-weight-normal">Transaction ID</th>
                                        <th class="font-weight-normal">Cost</th>
                                        <th class="font-weight-normal">Payment Method</th>
                                        <th class="font-weight-normal">Status</th>
                                        <th class="font-weight-normal">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01-01-22</td>
                                        <td><a href="userlist.html">Sean Black</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/22.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Et et kasd ipsum clita</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#11002255660</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$4,350</td>
                                        <td>Online</td>
                                        <td><span
                                                class="badge badge-pill bg-primary-transparent tx-primary px-3 py-2 tx-11">Delivered</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-11-21</td>
                                        <td><a href="userlist.html">Santi Argo</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/16.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="javascript:void(0)">Sed vero et ipsum et</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#23412858169</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$18,900</td>
                                        <td>Cash On Delivery</td>
                                        <td><span
                                                class="badge badge-pill bg-orange-transparent tx-orange px-3 py-2 tx-11">Shipped</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>26-01-22</td>
                                        <td><a href="userlist.html">Carmen Goh</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/20.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Rebum dolores at erat ipsum</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#51702935164</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$3,200</td>
                                        <td>Online</td>
                                        <td><span
                                                class="badge badge-pill bg-secondary-transparent tx-secondary px-3 py-2 tx-11">Pending</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17-09-21</td>
                                        <td><a href="userlist.html">Emma Grate</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/18.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Ipsum et sit diam ut</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#71802951620</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$22,600</td>
                                        <td>Online</td>
                                        <td><span
                                                class="badge badge-pill bg-primary-transparent tx-primary px-3 py-2 tx-11">Delivered</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>06-08-21</td>
                                        <td><a href="userlist.html">Anne Gloindian</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/7.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">No stet eos justo voluptua</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#91012557664</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$6,700</td>
                                        <td>Cash On Delivery</td>
                                        <td><span
                                                class="badge badge-pill bg-secondary-transparent tx-secondary px-3 py-2 tx-11">Cancelled</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>25-01-22</td>
                                        <td><a href="userlist.html">Tex Ryta</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/11.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Dolor sea lorem lorem diam</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#41506275962</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$8,600</td>
                                        <td>Cash On Delivery</td>
                                        <td><span
                                                class="badge badge-pill bg-orange-transparent tx-orange px-3 py-2 tx-11">Shipped</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17-04-21</td>
                                        <td><a href="userlist.html">Barry Kade</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/17.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Eos justo nonumy stet sit</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#12352990666</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$49,670</td>
                                        <td>Online</td>
                                        <td><span
                                                class="badge badge-pill bg-secondary-transparent tx-secondary px-3 py-2 tx-11">Pending</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>08-02-21</td>
                                        <td><a href="userlist.html">Marge Areen</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/21.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">Diam voluptua stet invidunt
                                                    sed</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#47652758630</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$1,000</td>
                                        <td>Cash On Delivery</td>
                                        <td><span
                                                class="badge badge-pill bg-primary-transparent tx-primary px-3 py-2 tx-11">Delivered</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>01-01-22</td>
                                        <td><a href="userlist.html">Ruby Bartlett</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="../assets/img/ecommerce/9.jpg" alt="avatar"
                                                        class="br-5 shadow">
                                                </div>
                                                <a href="product-details.html">No voluptua amet sit clita</a>
                                            </div>
                                        </td>
                                        <td><a href="invoice.html">#31201254680</a></td>
                                        <td class="font-weight-semibold numberfont tx-15">$15,500</td>
                                        <td>Online</td>
                                        <td><span
                                                class="badge badge-pill bg-secondary-transparent tx-secondary px-3 py-2 tx-11">Cancelled</span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-def tx-muted"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row closed -->

    </div>
    <!-- /Container -->

</div>
<!-- /main-content -->
