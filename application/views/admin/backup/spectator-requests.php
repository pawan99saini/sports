<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Spectators</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Spectators</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Apllications</h4>
                        
                        <form method="POST" action="<?php echo base_url(); ?>admin/getApplications" onsubmit="return false;" class="get-applications">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Select Tournament</label>
                                    <select name="tournamentID" class="form-control">
                                        <option value="">Tournament</option>
                                        <?php foreach($tournamentData as $tournament): ?>  
                                        <option value="<?= $tournament->id; ?>" ><?= $tournament->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <div class="col-12">
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