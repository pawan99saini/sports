<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Dashboard</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <a href="#">
                                                <?php 
                                                    $get_image = $meta->get_user_meta('user_image', $profileData[0]->id);
                                                    
                                                    if($get_image == null) {
                                                        $image_url = base_url() . 'assets/frontend/images/default.png';
                                                    } else {
                                                        $image_url = base_url() . 'assets/uploads/users/user-' . $profileData[0]->id . '/' . $get_image;
                                                    }
                                                ?>
                                                <img src="<?= $image_url; ?>" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0 mb-0"><?= $profileData[0]->first_name . ' ' . $profileData[0]->last_name; ?> </h3>
                                                    <small class="text-muted">@<?= $profileData[0]->username; ?></small>
                                                    <div class="staff-id">Employee ID : DSO-<?= $profileData[0]->id; ?></div>
                                                    <div class="small doj text-muted">
                                                        Date of Join : <?php echo date('F, d Y', strtotime($profileData[0]->created_at)); ?>
                                                    </div>

                                                    <div class="staff-msg clock-out-box">
                                                        <div class="time-clock-wrapper">
                                                            <div class="time-clock">
                                                            <?php 
                                                                if(count($attendance) == 0) { 
                                                                    $time_in_box = 'style="display: none;"';  
                                                                    $time_in_btn = '';  
                                                                    $timed_in    = '00:00:00';    
                                                                } else {
                                                                    $time_out_prev = $attendance[0]->time_out;

                                                                    if($time_out_prev == '00:00:00') {
                                                                        $time_in_box = '';
                                                                        $time_in_btn = 'style="display: none;"';
                                                                    } else {
                                                                        $time_in_box = 'style="display: none;"';
                                                                        $time_in_btn = '';
                                                                    } 
                                                                    
                                                                    $timed_in    = $attendance[0]->time_in;
                                                                } 
                                                            ?>       
                                                                <a class="btn btn-custom clock-out time-in" href="<?= base_url(); ?>member/attendance/time_in" <?= $time_in_btn; ?> data-type="time-in">
                                                                    <i class="mdi mdi-clock"></i> Clock In
                                                                </a>

                                                                <div class="timed-box" <?= $time_in_box; ?>>
                                                                    <i class="mdi mdi-clock"></i>
                                                                    <span>Timed In At : <?= $timed_in; ?></span>
                                                                </div> 
                                                            </div>
                                                            
                                                            <div class="time-clock"> 
                                                            <?php 
                                                                if(count($attendance) > 0) { 
                                                                    $log_time = $attendance[0]->total_log_time;
                                                                    $time_out = $attendance[0]->time_out;

                                                                    if($log_time > 0) {
                                                                        $time_out_box = '';
                                                                        $show_timeout = 'style="display: none;"';
                                                                    } else {
                                                                        $time_out_box = 'style="display: none;"';
                                                                        $show_timeout = '';
                                                                    }
                                                                } else {
                                                                    $log_time = 0;
                                                                    $time_out_box = 'style="display: none;"';
                                                                    $time_out = '00:00:00';
                                                                    $show_timeout = 'style="display: none;"';
                                                                }
                                                            ?>   
                                                                <a class="btn btn-custom clock-out time-out" href="<?= base_url(); ?>member/attendance/time_out" <?= $show_timeout; ?> data-type="time-out">
                                                                    <i class="mdi mdi-clock"></i> Clock Out
                                                                </a>
                                                            
                                                                <div class="timed-box" <?= $time_out_box; ?>>
                                                                    <i class="mdi mdi-clock"></i>
                                                                    <span>Timed Out At : <?= $time_out; ?></span>
                                                                </div>    
                                                            </div>
                                                        </div>

                                                        <div class="clock-message-box"></div>

                                                        <div class="loader-sub" id="clock-out-load">
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
                                            <div class="col-md-7">
                                                <div class="activity-log-dashboard">
                                                    <h5 class="card-title">Recent Activity</h5>
                                                    <div class="activity-log-wrapper">
                                                        <div class="not-found-text">No Activity Found</div>
                                                        <?php /*f( empty( $activityLog ) ) { ?>
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
                                                        <?php }*/ ?>                                      
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                <?php if($this->session->userdata('user_role') < 8) { ?>    
                    <!-- column -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Active Tournaments</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info"><i class="icon-people"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $active_tournaments; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Offline Tournaments</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-purple"><i class="icon-folder"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto"><?= $inactive_tournaments; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                <?php } ?>
                </div>
            </div>
            <?php 
                $login_time  = (isset($userLog[0]->login_time)) ? date('l jS F Y h:i:s A', strtotime($userLog[0]->login_time)) : 'N/A';
                $logout_time = (isset($userLog[0]->logout_time)) ? date('l jS F Y h:i:s A', strtotime($userLog[0]->logout_time)) : 'N/A';

                if(isset($userLog[0]->login_time)) {
                    $date1 = $userLog[0]->login_time;
                    $date2 = $userLog[0]->logout_time;
                    $timestamp1 = strtotime($date1);
                    $timestamp2 = strtotime($date2);
                    $duration = abs($timestamp2 - $timestamp1)/(60*60) . " hour(s)";
                } else {
                    $duration = 'N/A';
                }
            ?>
            <div class="col-lg-6">
                <div class="news-slide m-b-15">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex m-b-10 align-items-center no-block">
                                <h5 class="card-title ">Actvity Log</h5>
                            </div>

                            <div class="row">
                                <div class="col-12  m-t-10">
                                    <h1 class="text-info">Last Login</h1>
                                    <p class="text-muted"><?= $login_time; ?></p>
                                </div>

                                <div class="col-12  m-t-10">
                                    <h1 class="text-danger">Last Logout</h1>
                                    <p class="text-muted"><?= $logout_time; ?></p>
                                </div>

                                <!-- <div class="col-12  m-t-10">
                                    <h1 class="text-success">Session Duraton</h1>
                                    <p class="text-muted"><?= $duration; ?></p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>