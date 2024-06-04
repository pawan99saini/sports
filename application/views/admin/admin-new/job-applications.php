<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Job Application</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/jobs">Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Applications</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/jobs" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="valorantApplication">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Job Title</th>
                                        <th>Name</th>
                                        <th>Discord Username</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Previous Work</th>
                                        <th>Drivers License</th>
                                        <th>Birth Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($valorantData as $data): ?>  
                                    <tr>
                                        <td><?= $data->id; ?></td>
                                        <td><?= $data->job_title; ?></td>
                                        <td><?= $data->first_name . ' ' . $data->last_name; ?></td>
                                        <td><?= $data->username; ?></td>
                                        <td><?= $data->phone; ?></td>
                                        <td><?= $data->email; ?></td>
                                        <td><?= $data->previous_work; ?></td>
                                        <td>
                                            <img src="<?= base_url() . 'assets/uploads/job-applications/' . $data->drivers_liscence; ?>" />
                                        </td>
                                        <td>
                                            <img src="<?= base_url() . 'assets/uploads/job-applications/' . $data->birth_certficate; ?>" />
                                        </td>           
                                    </tr>
                                <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>

<input type="hidden" name="passwordVerify" value="false" />

<div id="confirmPassword" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?= base_url(); ?>admin/confirmAdminPassword" class="password-confirm" onsubmit="return false;">
                <div class="modal-body">
                    <div class="user-message"></div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>

                    <input type="hidden" name="rowID" value="" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                        Confirm Password  
                    </button>
                    <button type="button" class="btn btn-info row-inline waves-effect text-white" data-bs-dismiss="modal">Cancel</button>
                    <div class="loader-sub" id="data-load">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->