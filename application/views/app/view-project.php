<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Project Details</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member/projects">projects</a></li>
                        <li class="breadcrumb-item active">View Project</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>member/projects" class="btn btn-info d-none d-lg-block m-l-15">
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
                                <h2 class="card-title"><?= $projectsData[0]->title; ?></h2>
                                <div class="project-dt-area">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="project-info-top">
                                                <ul>
                                                    <li>
                                                        <i class="icon-calender"></i>
                                                        <span>Posted: <?php echo date('d M, Y', strtotime($projectsData[0]->date_created)); ?></span>
                                                    </li>

                                                    <li>
                                                        <i class="icon-calender"></i>
                                                        <span>Deadline: <?php echo date('d M, Y', strtotime($projectsData[0]->project_deadline)); ?></span>
                                                    </li>

                                                    <li>
                                                        <?php 
                                                            $dateDeadline = date('M d, Y H:i:s', strtotime($projectsData[0]->project_deadline)); 

                                                            echo '<input type="hidden" name="timeLeft" value="'.$dateDeadline.'" />';
                                                           
                                                            if(strtotime($dateDeadline) <= 0) {
                                                                $dataClock = '<div class="late-dlvr">Project Is Overdue</div>';
                                                            } else {
                                                                $dataClock = '<div class="clock"><span></span></div>';
                                                            }
                                                        ?>

                                                        <i class="icon-hourglass"></i>
                                                        <span>Time Left: <?= $dataClock; ?></span>
                                                    </li>

                                                    <li>
                                                        <i class="ti-user"></i>
                                                        <span>Created By: <?php //$projectsData[0]->name; ?></span>
                                                    </li>

                                                    <li>
                                                    <?php 
                                                        if($projectsData[0]->status == 1) { 
			                                            	$status = "<label class='badge badge-warning'>New Project</label>";     
			                                            } elseif($projectsData[0]->status == 2) { 
			                                            	$status = "<label class='badge badge-info'>In Progress</label>";
			                                            } elseif($projectsData[0]->status == 3) { 
			                                            	$status = "<label class='badge badge-warning'>Available To Review</label>"; 
			                                            } elseif($projectsData[0]->status == 4) { 
			                                            	$status = "<label class='badge badge-warning'>Revision Requested</label>";
			                                            } else { 
			                                            	$status = "<label class='badge badge-success'>Completed</label>"; 
			                                            } 
			                                        ?>
                                                        <i class="ti-check-box"></i>
                                                        <span>Project Status: <?= $status; ?></span>
                                                    </li>

                                                    <li>
                                                        <i class="icon-people"></i>
                                                        <span>Budget : 
                                                            <?= 
                                                                $projectsData[0]->price;
                                                            //$meta->get_username($projectsData[0]->agentID); ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="project-breif">
                                                <h2>Project Brief</h2>
                                                <div class="project-content">
                                                    <p>
                                                        <?= $projectsData[0]->description; ?>
                                                    </p>
                                                </div>

                                                <div class="project-files">
                                                    <ul>
                                                        <li>
                                                            <div class="files-box">
                                                                <i class="icon-paper-clip"></i>
                                                                <span><a href="#" download>Download.png</a></span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="discussion-board">
                                                <h4><i class="ti-comments"></i> Update Comment Board</h4>

                                                <div class="commenting-bar">
                                                <?php 
                                                    foreach($projectMessages as $message):
                                                        $userData = $this->process_data->get_data('users', array('id' => $message->senderID));
                                                        $date = $message->date_posted;
                                                        $date_posted = date('F d', strtotime($date)) .','.date('Y', strtotime($date)) . ' at '. date('h:i:s A', strtotime($date)); 
                                                        echo '<div class="comment">
                                                            <div class="thumb"><i class="fa fa-user"></i></div>
                                                            <div class="comment-content">
                                                                <h4>
                                                                    <a href="'.base_url().'profile/'.$userData[0]->username.'">'.$userData[0]->first_name . ' ' . $userData[0]->last_name . '</a>
                                                                    <span><i class="fa fa-calendar-alt"></i> '.$date_posted.'</span>
                                                                </h4>

                                                                <p>'.$message->comment.'</p>
                                                            </div>
                                                        </div>';
                                                    endforeach; 
                                                ?>
                                                </div>

                                                <div class="comments-wrap">
                                                    <form method="POST" action="<?= base_url(); ?>member/postProjectComment" enctype="multipart/form-data" class="post-project-comment" onsubmit="return false;">
                                                        <textarea name="comment" class="form-control" placeholder="Type Comment"></textarea>
                                                        <input type="hidden" name="projectID" value="<?= $projectsData[0]->id; ?>" />
                                                        <div id="basic_message"></div>
                                                        <div class="file-upload-init">
                                                            <div class="fileUploader">
                                                                <input type="file" name="file" multiple="true" id="basic" />
                                                                <div id="basic_drop_zone" class="dropZone">
                                                                    <h4>
                                                                        <i class="fa fa-upload"></i>
                                                                        <span>Drop files here</span>
                                                                    </h4>
                                                                </div>
                                                                <div id="basic_progress"></div>
                                                            </div>
                                                        </div>  

                                                        <button type="submit" id="startUpload" class="btn btn-info row-inline waves-effect waves-light m-r-10">Post Comment</button>

                                                        <div class="loader-sub" id="comment-load">
                                                            <div class="lds-ellipsis">
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="p-nav-tab">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> 
                                <a class="nav-link active" data-toggle="tab" href="#activity" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span> 
                                    <span class="hidden-xs-down">Activity Log</span>
                                </a> 
                            </li>

                            <li class="nav-item"> 
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-comment-alt"></i>
                                    </span> 
                                    <span class="hidden-xs-down">Discussion Board</span>
                                </a> 
                            </li>
                        </ul>
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
                                                <div class="date"><?php echo $meta->time_ago($logData->date_activity); ?></div>
                                            </div> 
                                        <?php endforeach; ?>
                                        </div>
                                        <?php } ?>                                      
                                    </div>                                        
                                </div>
                            </div>

                            <div class="tab-pane" id="projects" role="tabpanel">
                                <h4 class="card-title">Projects</h4>
                            </div>

                            <div class="tab-pane" id="report" role="tabpanel">
                                <h4 class="card-title">Analatycs Report</h4>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>

<script>
    var projectID = <?= $projectsData[0]->id; ?>;
</script>