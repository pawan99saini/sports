<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme-color="default">
    <head>

        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Title -->
        <title>Admin Panel - DSO Esports</title>

        <!-- Favicon -->
        <link rel="icon" href="<?= base_url(); ?>assets/frontend/images/favicon.png" type="image/x-icon"/>

        <!-- Icons css -->
        <link href="<?= base_url(); ?>assets/admin-new/css/icons.css" rel="stylesheet">

        <!--  Bootstrap css-->
        <link id="style" href="<?= base_url(); ?>assets/admin-new/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Style css -->
        <link href="<?= base_url(); ?>assets/admin-new/css/style.css" rel="stylesheet">

    </head>
    <body class="ltr error-page1 bg-primary">

        <!-- Progress bar on scroll -->
        <div class="progress-top-bar"></div>

        <!-- Loader -->
        <div id="global-loader">
            <img src="<?= base_url(); ?>assets/admin-new/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <div class="square-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="bg-svg">
            <div class="page" >
                <div class="z-index-10">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 mx-auto my-auto py-4 justify-content-center">
                                <div class="card-sigin">
                                    <!-- Demo content-->
                                    <div class="main-card-signin d-md-flex">
                                        <div class="wd-100p">
                                            <div class="d-flex">
                                                <a href="index.html">
                                                    <img src="<?= base_url(); ?>assets/frontend/images/logo.png" class="sign-favicon ht-80 logo-dark" alt="logo">
                                                    <img src="<?= base_url(); ?>assets/frontend/images/logo.png" class="sign-favicon ht-40 logo-light-theme" alt="logo">
                                                </a>
                                            </div>
                                            <div class="mt-3">
                                                <h2 class="tx-medium tx-primary">Welcome back!</h2>
                                                <h6 class="font-weight-semibold mb-4 text-white-50">Please sign in to continue.</h6>
                                                <div class="panel tabs-style7 scaleX mt-2">
                                                    <div class="panel-body p-0">
                                                        <div class="tab-content mt-3">
                                                            <div class="tab-pane active" id="signinTab1">
                                                                <form class="form-horizontal form-material" id="loginform" onsubmit="return false;" action="<?php echo base_url(); ?>admin/loginprocess">
                                                                    <div id="msg-login"></div>
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Username" type="text" name="username" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Password" type="password" name="password" />
                                                                    </div>
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <p class="mb-0"><a href="javascript:void(0);" class="tx-primary">Forgot password?</a></p>
                                                                        <button type="submit" class="btn btn-primary">Log In</button>
                                                                    </div>

                                                                    <div class="loader-sub" id="login-load">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- JQuery min js -->
        <script src="<?= base_url(); ?>assets/admin-new/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap js -->
        <script src="<?= base_url(); ?>assets/admin-new/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!--Internal  Perfect-scrollbar js -->
        <script src="<?= base_url(); ?>assets/admin-new/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <script src="<?= base_url(); ?>assets/admin-new/js/login.js"></script>
    </body>
</html>
