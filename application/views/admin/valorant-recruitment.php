<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Valorant Application</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Valorant Application</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php if(empty($id)) { ?>
                        <h4 class="card-title">Manage Applications</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="valorantApplication" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Discord Username</th>
                                        <th>Valorant Rank</th>
                                        <th>Valorant Name</th>
                                        <th>Age</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($valorantData as $data): ?>  
                                    <tr>
                                        <td><?= $data->id; ?></td>
                                        <td><?= $data->first_name . ' ' . $data->last_name; ?></td>
                                        <td><?= $data->username; ?></td>
                                        <td><?= $data->valorant_rank; ?></td>
                                        <td><?= $data->valorant_name; ?></td>
                                        <td><?= $data->age; ?></td>
                                        <td><?= $data->email; ?></td>
                                        <td class="phoneNumb-<?= $data->id; ?>">
                                            <a href="<?= base_url(); ?>admin/getPhoneValorant" data-id="<?= $data->id; ?>" class="btn btn-curved btn-sm btn-info get-valorant-phone">
                                                View Phone
                                            </a>
                                            <div class="loader-sub" id="data-load-<?= $data->id; ?>">
                                                <div class="lds-ellipsis">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>                 
                                        <td>
                                            <a href="<?= base_url(); ?>admin/valorant-recruitment/edit/<?= $data->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/valorant-recruitment/delete/<?php echo $data->id; ?>" onclick="return confirm('Want to delete the Application');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>                   
                                    </tr>
                                <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                        <h4 class="card-title"><?= ($id == '') ? 'Create' : 'Edit'; ?> Application</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/updateRCapplicaiton" enctype="multipart/form-data">
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
                                    <label>Discord Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Valorant Rank</label>
                                    <input type="text" name="valorant_rank" class="form-control" value="<?php echo $valorant_rank; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Valorant Name</label>
                                    <input type="text" name="valorant_name" class="form-control" value="<?php echo $valorant_name; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Age</label>
                                    <input type="text" name="age" class="form-control" value="<?php echo $age; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                                        <?php if($id == '') { ?>
                                        Create 
                                        <?php } else { ?>
                                        Update
                                        <?php } ?>    
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>

<input type="hidden" name="passwordVerify" value="false" />

<div id="confirmPassword" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?= base_url(); ?>admin/confirmAdminPassword" class="password-confirm" onsubmit="return false;">
                <div class="modal-body">
                    <div class="user-message"></div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>

                    <input type="hidden" name="rowID" value="" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                        Confirm Password  
                    </button>
                    <button type="button" class="btn btn-info row-inline waves-effect text-white" data-bs-dismiss="modal">Cancel</button>
                    <div class="loader-sub" id="data-load">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->