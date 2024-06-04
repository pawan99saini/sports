<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Job Listings</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Job Listings</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/jobs/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Job Post
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Job Posts</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
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
                                            <a href="<?= base_url() ?>admin/jobs/view/<?php echo $job->id; ?>" data-toggle="tooltip" data-placement="top" title="View Job">
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