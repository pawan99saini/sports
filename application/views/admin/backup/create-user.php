<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Create User</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/users">Users</a></li>
                        <li class="breadcrumb-item active">Create User</li>
                    </ol>

                    <a href="<?= base_url(); ?>users" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Create' : 'Edit'; ?> User</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createUser" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>User Type</label>
                                    <select name="user_type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="1" <?= ($user_type == 1) ? 'selected': ''; ?>>Admin</option>
                                        <option value="2" <?= ($user_type == 2) ? 'selected': ''; ?>>Spectator</option>
                                        <option value="3" <?= ($user_type == 3) ? 'selected': ''; ?>>Tournament Operator</option>
                                        <option value="4" <?= ($user_type == 4) ? 'selected': ''; ?>>Player</option>
                                        <option value="5" <?= ($user_type == 5) ? 'selected': ''; ?>>Team Owner</option>
                                        <option value="6" <?= ($user_type == 6) ? 'selected': ''; ?>>CFO</option>
                                        <option value="7" <?= ($user_type == 7) ? 'selected': ''; ?>>Support</option>
                                        <option value="8" <?= ($user_type == 8) ? 'selected': ''; ?>>Minecraft Builder</option>
                                        <option value="9" <?= ($user_type == 9) ? 'selected': ''; ?>>Minecraft Programmer</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="spectator" style="display: none;">
                                    <div class="form-group col-6">
                                        <label>Valid Photo ID</label>
                                        <input type="file" name="photoID" class="form-control" />
                                    </div>

                                    <div class="form-group col-6">
                                        <label>Social Media ID (Any)</label>
                                        <input type="text" name="sm_id" class="form-control" value="<?php echo $sm_id; ?>" />
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>country</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Assign Credits</label>
                                    <input type="text" name="credits" class="form-control" value="<?= $credits; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" value="" />
                                </div>

                                <div class="form-group col-6">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control cpass" />
                                </div>
                                
                                <span class="error_pass"></span>    
                                
                                <div class="clearfix"></div>

                                <?php 
                                    $show = 'none';
                                    if($user_type == 2 || $user_type == 3 || $user_type == 6 || $user_type == 7 || $user_type == 8 || $user_type == 9) {
                                        $show = 'block';
                                    }
                                ?>

                                <div class="attendance-details" <?= 'style="display: '.$show.';"'; ?>>
                                    <?php 
                                        $salary_types = array('Weekly', 'Bi Weekly', 'Monthly', 'Hourly', 'Project Based');
                                    ?>
                                    <div class="form-group col-6">
                                        <label>Billing Cycle</label>
                                        <?= $salary_cycle; ?>
                                        <div class="inline-radio">
                                            <?php foreach($salary_types as $sc_data): ?>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="salary_cycle" class="form-check-input" value="<?= $sc_data; ?>" <?= ($salary_cycle == $sc_data) ? 'checked' : '' ;?> />
                                                <label class="form-check-label" for="customRadio1"><?= $sc_data; ?></label>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>  

                                    <div class="clearfix"></div>
                                    
                                    <div class="salary" <?= ($user_type != 8) ? 'style="display : block;"' : 'style="display : none"'; ?> >
                                        <div class="form-group col-6">
                                            <label>Salary</label>
                                            <input type="text" name="salary" class="form-control" placeholder="$0.00" value="<?= $salary; ?>" />
                                        </div>        

                                        <div class="form-group col-6">
                                            <label>Shift Hours (Total No Of Hours)</label>
                                            <input type="text" name="shift_hours" class="form-control" value="<?= $shift_hours; ?>" />
                                        </div>   
                                    </div>

                                    <div class="clearfix"></div>
                                </div>

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                                        <?php if($id == '') { ?>
                                        Create 
                                        <?php } else { ?>
                                        Update
                                        <?php } ?>    
                                        User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>