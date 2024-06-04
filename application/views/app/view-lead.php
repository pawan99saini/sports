<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">View Lead</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/leads">Leads</a></li>
                        <li class="breadcrumb-item active">View Lead</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/leads" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<div class="profile-info-left">
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Company Name:</div>
                                                        <div class="text">
                                                            <?php echo $company_name; ?>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Name:</div>
                                                        <div class="text">
                                                            <?php echo $first_name . ' ' . $last_name; ?>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Email:</div>
                                                        <div class="text">
                                                            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Phone:</div>
                                                        <div class="text">
                                                            <div class="text"><?php echo $phone; ?></div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Country:</div>
                                                        <div class="text"><?php echo $country; ?></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Lead Source:</div>
                                                        <div class="text"><?php echo $lead_source; ?></div>
                                                    </li>
                                                  
                                                    <li>
                                                    	<div class="title">Lead Status:</div>
                                                        <div class="text">
                                                        <?php 
			                                    			if($lead_status == 0) {
			 													echo "<label class='badge badge-danger'>Not Contacted</label>";
			                                    			} elseif($lead_status == 1) {
			                                    				echo "<label class='badge badge-warning'>Phone Number Viewed</label>";
			                                    			} elseif($lead_status == 2) {
			                                    				echo "<label class='badge badge-info'>Contacted</label>";
			                                    			} elseif($lead_status == 3) {
			                                    				echo "<label class='badge badge-success'>Converted To Customer</label>";
			                                    			} else {
			                                    				echo "<label class='badge badge-danger'>Not Interested</label>";
			                                    			}
			                                    		?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <ul class="personal-info">
                                            	<li>
                                                    <div class="title">Assigned User:</div>
                                                    <div class="text userAssign">
                                                    <?php 
                                                    	if($assigned_user == 0) {
                                                    ?>
                                                    	<div class="form-group col-6">
						                                    <label>Assign To</label>
						                                    <select name="assigned_user" class="form-control set-assign">
						                                        <option value="">Select User</option> 
						                                        <?php foreach($agentsData as $data): ?>      
						                                        <option value="<?= $data->id; ?>"><?= $data->id . ' - ' . $data->name; ?> (<?= $data->designation; ?>)</option>
						                                        <?php endforeach; ?>
						                                    </select>

						                                    <input type="hidden" name="lead" value="<?= $id; ?>" />
						                                </div>

						                                <div class="loader-sub" id="load-lead">
								                            <div class="lds-ellipsis">
								                                <div></div>
								                                <div></div>
								                                <div></div>
								                                <div></div>
								                            </div>
					                        			</div>
                                                    <?php 
                                                    	} else {
                                                    		$html  = '<a href="' . base_url() . 'admin/employees/profile/' . $employeesData[0]->username . '">';

															$userImage = 'assets/admin/images/default-profile-3.png';

													        if($employeesData[0]->user_image != 'N/A') {
													            $userImage = 'assets/admin/images/userimage/' . $employeesData[0]->user_image;
													        }

													        $html .= '<img data-toggle="tooltip" data-original-title="'.$employeesData[0]->name.'" src="'. base_url() . $userImage . '" class="img-circle">'; 
													        $html .= '</a>';

													        echo $html;
                                                     	} 
                                                    ?>
                                                    </div>
                                                </li>   

                                                <li>
                                                    <div class="title">Employee Remarks:</div>
                                                    <div class="text">
                                                        <?php 
                                                            if($customer_response == 1) {
                                                                echo "<label class='badge badge-success'>Interested</label>";
                                                            } 

                                                            if($customer_response == 2) {
                                                                echo "<label class='badge badge-danger'>Not Interested</label>";
                                                            } 

                                                            if($customer_response == 3) {
                                                                echo "<label class='badge badge-warning'>No Answer</label>";
                                                            } 

                                                            if($customer_response == 4) {
                                                                echo "<label class='badge badge-warning'>Voicemail</label>";
                                                            }

                                                            if($customer_response == 5) {
                                                                echo "<label class='badge badge-warning'>Follow Up</label>";

                                                                $dateFollowUp = date('M d, Y', strtotime($date_followup)); 
                                                                $timeLeft     = $dateFollowUp . ' ' .$time_followup;

                                                                echo '<input type="hidden" name="timeLeft" value="'.$timeLeft.'" />';
                                                                echo '<div class="clock"><span></span></div>';
                                                            }

                                                            if($customer_response == 6) {
                                                                echo "<label class='badge badge-danger'>Number Invalid</label>";
                                                            }
                                                        ?>
                                                        <div class="remarks"><p><?= $feedback; ?></p></div>
                                                    </div>
                                                </li>                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity" role="tabpanel">
                                <h4 class="card-title">
                                    Activity Log
                                </h4>

                               	<div class="inline-box">
                               		<div class="activity-log-wrapper">
                            			<?php if( empty( $activityLog ) ) { ?>
                            			<div class="not-found-text">No Activity Found</div>
                            			<?php } else { ?>
                            			<div class="activity-feed">
                                		<?php foreach($activityLog as $logData): ?>
                                			<div class="feed-item">
                                				<div class="text"><?php echo $logData->description; ?></div>
                                				<div class="date"><?php echo $data_cli->time_ago($logData->date_activity); ?></div>
                                			</div> 
                                		<?php endforeach; ?>
                                		</div>
                            			<?php } ?>                                		
                            		</div>
                                	    
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>