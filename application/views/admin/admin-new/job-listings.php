<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Job Listings</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jobs</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/jobs/create" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Create Job Post
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Job Posts</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Job Title</th>
                                        <th>Location</th>
                                        <th>Salary Range</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($jobsData as $job): ?>    
                                    <tr>
                                        <td><?= $job->id; ?></td>
                                        <td><?= $job->title; ?></td>
                                        <td><?= $job->location; ?></td>
                                        <td><?= $job->package; ?></td>
                                        <td>
                                        <?php 
                                            if($job->status == 0) {
                                                echo "<label class='badge badge-danger'>Closed</label>";
                                            } else {
                                                echo "<label class='badge badge-success'>Open</label>";
                                            }
                                        ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/jobs/create/<?= $job->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>careers/<?php echo $job->slug; ?>" data-toggle="tooltip" data-placement="top" title="View Job">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/jobs/delete/<?php echo $job->id; ?>" onclick="return confirm('Want to delete the Job');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
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