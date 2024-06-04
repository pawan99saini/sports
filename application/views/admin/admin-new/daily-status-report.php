<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Daily Status Report</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Status Report</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Reports</h4>
                    </div>
                         
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Username</th>
                                        <th>Date Posted</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($reportData as $report): ?>    
                                    <tr>
                                        <td><?= $report->id; ?></td>
                                        <?php 
                                        	$username = $meta->get_username($report->userID);
                                        ?>
                                        <td><?= $username; ?></td>
                                        <td><?= date('F d, Y', strtotime($report->date_posted)); ?></td>
                                        <td>
                                            <?php if($report->status == 0) { ?>
                                            <label class='badge badge-warning'>Pending</label> 
                                            <?php } elseif($report->status == 1) { ?>
                                            <label class='badge badge-danger'>Rejected</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Approved</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                        	<a href="<?= base_url() . 'admin/getReport'; ?>" class="get-report" data-id="<?php echo $report->id; ?>">
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View Report</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" class="report-details" action="<?php echo base_url(); ?>admin/updateReport" enctype="multipart/form-data" style="display: none;">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Title</label>
                                    <p class="title"></p>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label">Attach File</label>
                                    <div class="thumbnail">
                                    	<a href="" target="_blank">
                                    		<img src="" />
                                    	</a>
                                    </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-12">
                                    <label class="form-label">Description</label>
                                    <p class="description"></p>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-12">
                                    <label class="form-label">Comment</label>
                                    <textarea name="description" class="form-control" rows="6"></textarea>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group col-md-12">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                    	<option value="0">Pending</option>
                                    	<option value="1">Rejected</option>
                                    	<option value="2">Approved</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary row-inline waves-effect waves-light m-r-10 emp-submit">
                                        Submit Report
                                    </button>
                                </div>
                            </div>
                        </form>

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
</div>