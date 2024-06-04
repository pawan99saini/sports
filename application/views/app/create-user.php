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

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <?php if($id == '') { ?>
	                                <div class="form-group col-6">
	                                    <label>Password</label>
	                                    <input type="password" name="password" class="form-control" value="" required />
	                                </div>

	                                <div class="form-group col-6">
	                                    <label>Confirm Password</label>
	                                    <input type="password" name="confirm_password" class="form-control" required />
	                                </div>

	                                <div class="clearfix"></div>
	                            <?php } ?>

                                <div class="form-group col-6">
                                    <label>country</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>User Type</label>
                                    <select name="user_type" class="form-control">
                                    	<option value="">Select Type</option>
                                    	<option value="2" <?= ($user_type == 2) ? 'selected': ''; ?>>Spectator</option>
                                    	<option value="3" <?= ($user_type == 3) ? 'selected': ''; ?>>Tournament Operator</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit" disabled>
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