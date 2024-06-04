
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
    <title>DSO Esports - <?php echo $title; ?></title>

    <!-- Icons css -->
    <link href="<?php echo base_url(); ?>assets/admin-new/css/icons.css" rel="stylesheet">

    <!-- Bootstrap css-->
    <link id="style" href="<?php echo base_url(); ?>assets/admin-new/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Style css -->
    <link href="<?php echo base_url(); ?>assets/admin-new/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin-new/css/custom.css" rel="stylesheet">

    <!-- Plugins css -->
    <link href="<?php echo base_url(); ?>assets/admin-new/css/plugins.css" rel="stylesheet">
</head>

<body class="ltr main-body app sidebar-mini index">
    <div class="progress-top-bar"></div>

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top" class="back-to-top rounded-circle shadow"><i class="las la-arrow-up"></i></a>

    <!-- Loader -->
    <div id="global-loader">
        <img src="<?= base_url(); ?>assets/admin-new/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div class="layout-position-binder">
            <!-- main-header -->
            <div class="main-header side-header sticky nav nav-item">
                <div class=" main-container container-fluid">
                    <div class="main-header-left">
                        <div class="responsive-logo">
                            <a href="index.html" class="header-logo">
                                <img src="<?= base_url(); ?>assets/frontend/images/logo.png" alt="logo">
                                <img src="<?= base_url(); ?>assets/frontend/images/logo.png" alt="logo">
                            </a>
                        </div>
                        <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                            <!-- <div class="icon"></div> -->
                            <a class="open-toggle" href="javascript:void(0)">
                                <i class="header-icon fe fe-align-left"></i>
                            </a>
                            <a class="close-toggle" href="javascript:void(0)">
                                <i class="header-icon fe fe-x"></i>
                            </a>
                        </div>
                        <div class="logo-horizontal">
                            <a href="index.html" class="header-logo">
                                <img src="<?= base_url(); ?>assets/frontend/images/logo.png" class="mobile-logo dark-logo-1" alt="logo">
                                <img src="<?= base_url(); ?>assets/frontend/images/logo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="main-header-right">
                        <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                            aria-controls="navbarSupportedContent-4" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                        </button>
                        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                <ul class="nav nav-item header-icons navbar-nav-right ms-auto">
                                    <li class="dropdown right-toggle">
                                        <a class="new nav-link nav-link pe-0" data-bs-toggle="sidebar-right"
                                            data-bs-target=".sidebar-right">
                                            <svg class="ionicon header-icon-svgs"
                                                viewBox="0 0 512 512">
                                                <title>Side Menu</title>
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-miterlimit="10" stroke-width="32"
                                                    d="M80 160h352M80 256h352M80 352h352" />
                                            </svg>
                                            <span class="pulse"></span>
                                        </a>
                                    </li>

                                    <li class="dropdown main-profile-menu nav-item">
                                        <a class="new nav-link profile-user rounded-circle shadow d-flex"  href="javascript:void(0)" data-bs-toggle="dropdown">
                                            <img alt="" rc="<?php echo base_url(); ?>assets/admin/images/staff-w.png">
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="bg-primary p-3 br-ts-5 br-te-5 ">
                                                <div class="d-flex wd-100p">
                                                    <div class="avatar">
                                                        <img alt="avatar" class="rounded-circle" src="<?php echo base_url(); ?>assets/admin/images/staff-w.png">
                                                    </div>
                                                    <div class="ms-3 my-auto">
                                                        <h6 class="tx-15 text-black font-weight-semibold mb-0">
                                                            <?= $this->session->userdata('name'); ?>
                                                        </h6>
                                                        <span class="text-black op-8 tx-11">
                                                            <?= $this->session->userdata('username'); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a class="dropdown-item" href="profile.html"><i
                                                        class="fe fe-user"></i>Profile</a></li>
                                            <li><a class="dropdown-item" href="mail-read.html"><i
                                                        class="fe fe-mail"></i>Inbox</a></li>
                                            <li><a class="dropdown-item" href="settings.html"><i
                                                        class="fe fe-settings"></i>Settings</a></li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>admin/logout">
                                                    <i class="fe fe-power"></i>Log Out
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <aside class="app-sidebar">
                    <div class="main-sidebar-header active">
                        <a class="header-logo active" href="index.html">
                            <img src="<?= base_url(); ?>assets/frontend/images/logo.png" class="main-logo  desktop-dark" alt="logo">
                            <img src="../assets/img/brand/logo-white-1.png" class="main-logo  desktop-dark-1" alt="logo">
                            <img src="<?= base_url(); ?>assets/frontend/images/logo.png" class="main-logo  mobile-dark" alt="logo">
                            <img src="../assets/img/brand/favicon-white-1.png" class="main-logo  mobile-dark-1" alt="logo">
                        </a>
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg></div>
                        <ul class="side-menu">
                            <?php if($this->session->userdata('user_role') < 2) { ?>
                            <li class="slide">
                                <a class="side-menu__item has-link" data-bs-toggle="slide" href="<?= base_url(); ?>admin">
                                    <svg class="ionicon side-menu__icon"
                                            viewBox="0 0 512 512">
                                            <title>Home</title>
                                            <path
                                                d="M80 212v236a16 16 0 0016 16h96V328a24 24 0 0124-24h80a24 24 0 0124 24v136h96a16 16 0 0016-16V212"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32" />
                                            <path d="M480 256L266.89 52c-5-5.28-16.69-5.34-21.78 0L32 256M400 179V64h-48v69"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32" />
                                    </svg>
                                    <span class="side-menu__label">Dashboard</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="ti-game side-menu__icon"></i>
                                    <span class="side-menu__label">Games</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/games">View All</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/games/create">Add New</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/games/categories">Categories</a></li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item has-link" data-bs-toggle="slide" href="<?php echo base_url(); ?>admin/spectator-requests">
                                    <i class="ti-files side-menu__icon"></i>
                                    <span class="side-menu__label">Spectators Request</span>
                                </a>
                            </li>
                            <?php } ?>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="ti-cup side-menu__icon"></i>
                                    <span class="side-menu__label">Tournaments</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/tournaments">View All</a>
                                    </li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/tournaments/create">Add New</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/tournaments/notice-board">Notice Board</a></li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="<?php echo base_url(); ?>admin/matches">
                                    <i class="ti-cup side-menu__icon"></i>
                                    <span class="side-menu__label">Matches</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="<?php echo base_url(); ?>admin/newsletter">
                                    <i class="ti-email side-menu__icon"></i>
                                    <span class="side-menu__label">Newsletter</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="ti-cup side-menu__icon"></i>
                                    <span class="side-menu__label">Job Post</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/jobs">View All</a>
                                    </li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/jobs/create">Add New</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/jobs/applications">Applications</a></li>
                                </ul>
                            </li>

                            <?php if($this->session->userdata('user_role') < 2) { ?>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="icon-people side-menu__icon"></i>
                                    <span class="side-menu__label">Teams RC</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/teams">Manage Teams</a>
                                    </li>
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/teams/recruitment">Recruitment</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="ti-headphone-alt side-menu__icon"></i>
                                    <span class="side-menu__label">Support</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/articles">Articles</a>
                                    </li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/articles/categories">Categories</a></li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="icon-people side-menu__icon"></i>
                                    <span class="side-menu__label">Users</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/users">View All</a>
                                    </li>
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin/users/dso">Dso Members</a>
                                    </li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/users/create">Add New</a></li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="<?php echo base_url(); ?>admin/attendance">
                                    <i class="ti-calendar side-menu__icon"></i>
                                    <span class="side-menu__label">Attendance</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="<?php echo base_url(); ?>admin/tasks">
                                    <i class="ti-folder side-menu__icon"></i>
                                    <span class="side-menu__label">Employee Tasks</span>
                                </a>
                            </li>

                            <li class="slide"> 
                                <a class="side-menu__item" data-bs-toggle="slide"  href="<?= base_url() . 'admin'; ?>/reports">
                                    <i class="ti-folder side-menu__icon"></i>
                                    <span class="side-menu__label">Status Report</span>
                                </a>
                            </li>

                            <li class="slide"> 
                                <a class="side-menu__item" data-bs-toggle="slide"  href="<?= base_url() . 'admin'; ?>/time-off">
                                    <i class="ti-calendar side-menu__icon"></i>
                                    <span class="side-menu__label">Time Off Requests</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="ti-wallet side-menu__icon"></i>
                                    <span class="side-menu__label">Financial Account</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li>
                                        <a class="slide-item" href="<?= base_url(); ?>admin">Dashboard</a>
                                    </li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/">Transactions</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/">Expense Manager</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/">Payroll</a></li>
                                    <li><a class="slide-item" href="<?= base_url(); ?>admin/">Blanace Sheet</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="slide-right" id="slide-right"><svg fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg></div>
                    </div>
                </aside>
            </div>
            <!-- main-sidebar -->
        </div>
