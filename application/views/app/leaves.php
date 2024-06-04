<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Leaves</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>member">Dashboard</a></li>
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
                        
                        <form method="POST" action="<?php echo base_url(); ?>member/create_leave">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="leave_date" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label class="custom-control custom-checkbox m-b-0">
                                    <input type="checkbox" name="leave_method" value="yes" class="custom-control-input">
                                    <span class="custom-control-label">I Am Looking For multiple Dates Leave?</span>
                                </label>
                            </div>

                            <div class="leaves_date_req" style="display: none;">
                            	<div class="form-group">
                            		<label>Date Type</label>

                            		<div class="inline-radio">
                        				<div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="date_type" value="multi_dates" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Multiple Dates</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="date_type" value="date_range" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Date Range</label>
                                        </div>
                                    </div>
                            	</div>

                            	<div class="form-group multi_dates date-method" style="display: none;">
	                                <label>
	                                	Multiple Dates
	                                	<a href="javascript:void(0);" class="add-dates">Add Date</a>
	                                </label>

	                                <div class="multi-date-box">
		                                <div class="dates_row">
			                                <input type="date" name="leaves_date[]" class="form-control" value="" />
			                            </div>
			                        </div>

			                        <input type="hidden" name="date_count" value="1" />
		                        </div>

		                        <div class="form-group date_range date-method" style="display: none;">
	                                <label>Date To</label>
	                                <input type="date" name="end_date" class="form-control" value="" />
		                        </div>
                            </div>

                            <div class="form-group">
                                <label>Leave Type</label>
                                <select name="leave_type" class="form-control">
                                    <option value="Full Day">Full Day</option>
                                    <option value="Half Day">Half Day</option>
                                    <option value="Sick Leave">Sick Leave</option>
                                    <option value="Annual">Annual</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Reason</label>
                                <textarea name="reason" class="form-control" rows="12" placeholder="Briefly Describe Us The Reason"></textarea>
                            </div>

                            <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 cat-submit">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
</div>