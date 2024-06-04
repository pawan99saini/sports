<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Leaves</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Leaves</h4>
                        
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Days</th>
                                        <th>Leave Type</th>
                                        <th>Date Applied</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($leavesData as $leave): ?>    
                                    <tr>
                                        <td><?= $leave->id; ?></td>
                                        <td><?= $leave->username; ?></td>
                                        <td><?= date('F d, Y', strtotime($leave->date_from)); ?></td>
                                        <td><?= $leave->total_leaves; ?></td>
                                        <td><?= $leave->leave_type; ?></td>
                                        <td><?= date('F d, Y', strtotime($leave->date_request)); ?></td>
                                        <td>
                                            <?php if($leave->status == 0) { ?>
                                            <label class='badge badge-warning'>Pending</label> 
                                            <?php } elseif($leave->status == 1) { ?>
                                            <label class='badge badge-danger'>Rejected</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Approved</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="view-application" data-id="<?php echo $leave->id; ?>">
                                                <i class="fa fa-eye"></i>
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

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Request Leave</h4>
                        
                        <div class="application-details"></div>

                        <div class="loader-wrapper">
                            <div class="loader-sub" id="report-load">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
</div>