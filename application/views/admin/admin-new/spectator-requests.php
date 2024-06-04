<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Spectators</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Spectators</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Manage Apllications</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/getApplications" onsubmit="return false;" class="get-applications">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Select Tournament</label>
                                    <select name="tournamentID" class="form-control">
                                        <option value="">Tournament</option>
                                        <?php foreach($tournamentData as $tournament): ?>  
                                        <option value="<?= $tournament->id; ?>" ><?= $tournament->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                                        View Applications
                                    </button>

                                    <div class="loader-sub" id="spec-load">
			                            <div class="lds-ellipsis">
			                                <div></div>
			                                <div></div>
			                                <div></div>
			                                <div></div>
			                            </div>
			                        </div>
                                </div>
                            </div>
                        </form>

                        <div class="app-data"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div