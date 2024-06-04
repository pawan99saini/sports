<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Employees</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/employees">Employees</a></li>
                        <li class="breadcrumb-item active">View Employee</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/employees" class="btn btn-info d-none d-lg-block m-l-15">
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
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <a href="#">
                                                <?php 
                                                    $userImage = 'frontend/images/profilePhoto.png';

                                                    if($employeesData[0]->user_image != 'N/A') {
                                                        $userImage = 'admin/images/userimage' . $employeesData[0]->user_image;
                                                    }
                                                ?>
                                                <img src="<?php echo base_url(); ?>assets/<?php echo $userImage; ?>" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0 mb-0"><?php echo $employeesData[0]->name; ?> </h3>
                                                    <small class="text-muted"><?php echo $employeesData[0]->designation; ?></small>
                                                    <div class="staff-id">Employee ID : NS-<?php echo $employeesData[0]->id; ?></div>
                                                    <div class="small doj text-muted">
                                                        Date of Join : <?php echo date('F, d Y', strtotime($employeesData[0]->date_joined)); ?>
                                                    </div>
                                                    <div class="staff-msg">
                                                        <a class="btn btn-custom" href="<?php echo base_url(); ?>admin/conversation/chat/<?php echo $employeesData[0]->username; ?>">Send Message</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Phone:</div>
                                                        <div class="text">
                                                            <a href=""><?php echo $employeesData[0]->phone; ?></a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Email:</div>
                                                        <div class="text">
                                                            <a href=""><?php echo $employeesData[0]->email; ?></a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Address:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Gender:</div>
                                                        <div class="text"><?php echo $employeesData[0]->gender; ?></div>
                                                    </li>
                                                    <li>
                                                    <div class="title">Reports to:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="<?php echo base_url(); ?>assets/frontend/images/profilePhoto.png" alt="">
                                                                </div>
                                                            </div>
                                                            <a href="/maroon/app/profile/employee-profile">Jeffery Lalor</a>
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

                    <div class="p-nav-tab">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> 
                                <a class="nav-link active" data-toggle="tab" href="#activity" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span> 
                                    <span class="hidden-xs-down">User Activity</span>
                                </a> 
                            </li>

                            <li class="nav-item"> 
                                <a class="nav-link" data-toggle="tab" href="#projects" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-briefcase"></i>
                                    </span> 
                                    <span class="hidden-xs-down">Projects</span>
                                </a> 
                            </li>
                            
                            <li class="nav-item"> 
                                <a class="nav-link" data-toggle="tab" href="#report" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-receipt"></i>
                                    </span> 
                                    <span class="hidden-xs-down">Analaycs Report</span>
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
                                    User Activity
                                    <div class="title-text-right">
                                        <span>
                                            <b>Activity Report For Month: </b> <?php echo date('M'); ?>
                                        </span>
                                    </div>
                                </h4>

                               <div class="inline-box">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">User Status</div>
                                            <div class="text">
                                                <span class="userStat <?php echo strtolower($employeesData[0]->log_status); ?>">
                                                    <?php echo $employeesData[0]->log_status; ?>
                                                </span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title">Today's Login</div>
                                            <div class="text">
                                                11-Nov-2020 08:00 PM
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title">Last Login</div>
                                            <div class="text">
                                                11-Nov-2020 08:00 PM
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title">Last Logout</div>
                                            <div class="text">
                                                11-Nov-2020 08:00 PM
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title">Day's Logged In</div>
                                            <div class="text">
                                                0 / 22 Working Days
                                            </div>
                                        </li>
                                    </ul>
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