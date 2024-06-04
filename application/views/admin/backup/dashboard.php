<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Dashboard</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 m-b-30 text-center"> 
                            	<small>Visit</small>
                                <h2><i class="ti-arrow-up text-success"></i> <?= $site_visits->num_rows(); ?></h2>
                                <div id="sparklinedash"></div>
                            </div>
                            <!-- <div class="col-lg-3 col-md-6 m-b-30 text-center"> 
                            	<small>Total Page Views</small>
                                <h2><i class="ti-arrow-up text-purple"></i> 5064</h2>
                                <div id="sparklinedash2"></div>
                            </div>
                            <div class="col-lg-3 col-md-6 m-b-30 text-center"> 
                            	<small>Unique Visitor</small>
                                <h2><i class="ti-arrow-up text-info"></i> 664</h2>
                                <div id="sparklinedash3"></div>
                            </div>
                            <div class="col-lg-3 col-md-6 m-b-30 text-center"> 
                            	<small>Bounce Rate</small>
                                <h2><i class="ti-arrow-down text-danger"></i> 50%</h2>
                                <div id="sparklinedash4"></div>
                            </div> -->
                        </div>
                        <ul class="list-inline font-12 text-center">
                            <li><i class="fa fa-circle text-cyan"></i> Site A</li>
                            <li><i class="fa fa-circle text-primary"></i> Site B</li>
                            <li><i class="fa fa-circle text-purple"></i> Site C</li>
                        </ul>
                        <div id="morris-area-chart" style="height: 340px;"></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

        <div class="row">
            <!-- column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Players</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                            <span class="display-5 text-info"><i class="icon-people"></i></span>
                            <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $total_players; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Open Tournaments</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                            <span class="display-5 text-purple"><i class="icon-folder"></i></span>
                            <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $active_tournaments; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inactive Tournaments</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                            <span class="display-5 text-primary"><i class="icon-folder-alt"></i></span>
                            <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $inactive_tournaments; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Teams</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                            <span class="display-5 text-success"><i class="icon-wallet"></i></span>
                            <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $total_teams; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
        </div>
    </div>
</div>