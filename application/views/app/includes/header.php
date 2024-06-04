
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.png">
    <link rel="icon" type="image/icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.png"/>
    <title>Joshua - <?php echo $title; ?></title>
    <!-- This page CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/style.min.css" rel="stylesheet">
    <!-- Dashboard 31 Page CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/dashboard3.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/admin/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/css/summernote-bs4.css" rel="stylesheet" type="text/css" >
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-red-dark fixed-layout">

<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading...</p>
    </div>
</div>

<div id="main-wrapper">
    <header class="topbar">
        <div class="dev-message">
            <p>
                <i class="fa fa-exclamation-triangle"></i>
                The panel is currently underconstruction You May notice some features are unfunctional
            </p>
        </div>
        
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <a class="navbar-brand" href="/member">
                    <b>
                        <img src="<?php echo base_url(); ?>assets/frontend/images/logo.png" alt="homepage" class="light-logo" />
                    </b>
                </a>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                </ul>

                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <ul>
                                <li>
                                    <div class="drop-title">Notifications</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>assets/admin/images/staff-w.png" alt="user" class=""> 
                        <span class="hidden-md-down"><?= $this->session->userdata('name'); ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                            <!-- text-->
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                            <!-- text-->
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            <a href="<?php echo base_url(); ?>member/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            <!-- text-->
                        </div>
                    </li>

                    <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <?php 
                    $user_role = $this->session->userdata('user_role');
                ?>
                <ul id="sidebarnav">
                    <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url(); ?>member" aria-expanded="false">
                            <i class="icon-speedometer"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <?php if($this->session->userdata('user_role') == 3) { ?>
                    <li> 
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-cup"></i>
                            <span class="hide-menu">Tournaments</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= base_url(); ?>member/tournaments">View All</a></li>
                            <li><a href="<?= base_url(); ?>member/tournaments/create">Add New</a></li>
                        </ul>
                    </li>

                    <li> 
                        <a class="waves-effect waves-dark" href="<?php echo base_url(); ?>member/spectator-requests" aria-expanded="false">
                            <i class="ti-files"></i>
                            <span class="hide-menu">Spectators Request</span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php if($user_role == 2 || $user_role == 3) { ?>
                    <li> 
                        <a class="waves-effect waves-dark" href="<?php echo base_url(); ?>member/matches" aria-expanded="false">
                            <i class="ti-cup"></i>
                            <span class="hide-menu">Matches</span>
                        </a>
                    </li>
                    <?php } ?>
                    
                     <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url() . 'member'; ?>/attendance" aria-expanded="false">
                            <i class="ti-calendar"></i>
                            <span class="hide-menu">Attendance</span>
                        </a>
                    </li>

                    <?php if($user_role == 8 || $user_role == 9) { ?>
                    <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url() . 'member'; ?>/projects" aria-expanded="false">
                            <i class="ti-folder"></i>
                            <span class="hide-menu">Manage Tasks</span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php if($user_role == 9 || $user_role == 10) { ?>
                    <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url() . 'member'; ?>/submit-work" aria-expanded="false">
                            <i class="ti-folder"></i>
                            <span class="hide-menu">Submit Work</span>
                        </a>
                    </li>
                    <?php } ?>

                    <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url() . 'member'; ?>/time-off" aria-expanded="false">
                            <i class="icon-login"></i>
                            <span class="hide-menu">Time Off Request</span>
                        </a>
                    </li>

                    <li> 
                        <a class="waves-effect waves-dark" href="<?= base_url() . 'member'; ?>/salary" aria-expanded="false">
                            <i class="ti-credit-card"></i>
                            <span class="hide-menu">Salary</span>
                        </a>
                    </li>
                    <!-- <li> 
                        <a class="waves-effect waves-dark" href="<?php echo base_url(); ?>member/players" aria-expanded="false">
                            <i class="icon-people"></i>
                            <span class="hide-menu">Players</span>
                        </a>
                    </li> -->

                    <!-- <li> 
                        <a class="waves-effect waves-dark" href="<?php echo base_url(); ?>member/settings" aria-expanded="false">
                            <i class="ti-settings"></i>
                            <span class="hide-menu">Settings</span>
                        </a>
                    </li> -->
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>