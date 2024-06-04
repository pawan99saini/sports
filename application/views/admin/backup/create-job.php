<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Create Job Post</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/jobs">Jobs</a></li>
                        <li class="breadcrumb-item active">Create Job</li>
                    </ol>

                    <a href="<?= base_url(); ?>jobs" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Create' : 'Edit'; ?> Job Post</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createJob" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Job Title</label>
                                    <input type="text" name="job_title" class="form-control" value="<?php echo $job_title; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Salary Package</label>
                                    <input type="text" name="package" class="form-control" value="<?php echo $package; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Job Type</label>
                                    <select name="job_type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="1" <?= ($job_type == 1) ? 'selected': ''; ?>>Full Time</option>
                                        <option value="2" <?= ($job_type == 2) ? 'selected': ''; ?>>Part Time</option>
                                    </select>
                                </div>

                                <div class="form-group col-6">
                                    <label>Job Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="1" <?= ($status == 1) ? 'selected': ''; ?>>Open</option>
                                        <option value="0" <?= ($status == 0) ? 'selected': ''; ?>>Closed</option>
                                    </select>
                                </div>

                                <div class="form-group col-6">
                                    <label>Job Location</label>
                                    <input type="text" name="location" class="form-control" value="<?php echo $location; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Company</label>
                                    <input type="text" name="company" class="form-control" value="<?php echo $company; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Experience Required</label>
                                    <input type="text" name="experience" class="form-control" value="<?php echo $experience; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Job Description</label>
                                    <textarea name="description" class="form-control" rows="6"><?php echo $description; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                                        <?php if($id == '') { ?>
                                        Create 
                                        <?php } else { ?>
                                        Update
                                        <?php } ?>    
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>