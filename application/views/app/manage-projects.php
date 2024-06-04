<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Projects</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item active">projects</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body projectDetails"> 

                    </div>
                    
                    <div class="card-body rel-box projectOverview">
                        <button class="kanban-btn horizon-prev">
                            <i class="ti-angle-double-left"></i>
                        </button>
                        <div class="kanban-body">
                            <div class="kanban-inner-wrapper">
                            <?php 
                            	$projectsData = array('New Project', 'In Progress', 'Available To Review', 'Revision Requested', 'Completed');
                            	$i = 1;

                            	foreach($projectsData as $project):
                            ?>	
                                <?php 
                                    $revision = '';
                                    if($this->session->userdata('user_role') == 9 && $project == 'Revision Requested') { 
                                        $revision = 'style="display : none;"';
                                    } 
                                ?>
                                <div class="kanban-block-wrapper" <?= $revision; ?>>
                                    <div class="kanban-block-header">
                                        <h3><?= $project; ?></h3>
                                        <span>0</span>
                                    </div>
                                    
                                    <div class="kb-stager" id="block<?= $i; ?>" data-stage="<?= $i; ?>">
                                    	<?php foreach($agentTask as $task): ?>
                                    	<?php if($task->status == $i) { ?>
                                        <div class="kanban-block kanban-details" data-exe-stage="<?= $i; ?>" id="kb-<?= $task->id; ?>" data-pid="<?= $task->id; ?>" url="<?= base_url() . 'member/projects/view/' . $task->id; ?>"> 
                                            <div class="kanban-content">
                                                <h5><?= $task->title; ?></h5>

                                                <div class="block-info">
                                                    <div class="files-box">
                                                        <i class="ti-files"></i>
                                                        <span>0 Files</span>
                                                    </div>

                                                    <div class="notify-box-kb">
                                                        <span>0 Notifications</span>
                                                    </div>
                                                </div>

                                                <div class="kb-timeframe">
                                                    <i class="ti-timer"></i>
                                                    <span>No Deadline</span>
                                                </div>

                                                <?php 
                                                    if($task->status == 1) {
                                                        $percentage = 0;
                                                    } else {
                                                        $percentage = number_format((100 / 5) * $task->status);
                                                    }
                                                ?>

                                                <div class="kb-progress-box">
                                                    <label><span class="per"><?= $percentage; ?></span>% Completed</label>
                                                    <div class="kb-progress-bar">
                                                        <div class="kb-inner-bar" style="width: <?= $percentage; ?>%;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="kb-users">
                                                <p>Associated Users</p>
                                                <ul>
                                                    <?php 
                                                        $get_image = $meta->get_user_meta('user_image', $task->agentID);
                                                        
                                                        if($get_image == null) {
                                                            $image_url = base_url() . 'assets/frontend/images/default.png';
                                                        } else {
                                                            $image_url = base_url() . 'assets/uploads/users/user-' . $task->agentID . '/' . $get_image;
                                                        }
                                                    ?>
                                                    <li>
                                                        <div class="profile-img">
                                                            <img src="<?= $image_url; ?>" />
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    	<?php } ?>
                                    	<?php endforeach; ?>
                                    </div>
                                </div>
                            <?php $i++; ?>    
                            <?php endforeach; ?>    
                            </div>
                        </div>

                        <button class="kanban-btn horizon-next">
                            <i class="ti-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
