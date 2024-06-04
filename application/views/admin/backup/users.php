<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Users</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/users/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create User
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Users</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>username</th>
                                        <th>Emaile</th>
                                        <th>User Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($userData as $user): ?>
                                <?php if($user->id != $this->session->userdata('user_id')) { ?>    
                                    <tr>
                                        <td><?= $user->id; ?></td>
                                        <td><?= $user->first_name; ?></td>
                                        <td><?= $user->last_name; ?></td>
                                        <td><?= $user->username; ?></td>
                                        <td><?= $user->email; ?></td>
                                        <td>
                                            <?php if($user->role == 1) { ?>
                                            <label class='badge badge-info'>Admin</label>     
                                            <?php } elseif($user->role == 2) { ?>
                                            <label class='badge badge-warning'>Spectator</label> 
                                            <?php } elseif($user->role == 3) { ?>
                                            <label class='badge badge-success'>Tournament Operator</label> 
                                            <?php } elseif($user->role == 4) { ?>
                                            <label class='badge badge-dark'>Player</label> 
                                            <?php } elseif($user->role == 5) { ?>
                                            <label class='badge badge-dark'>Team Owner</label> 
                                            <?php } elseif($user->role == 6) { ?>
                                            <label class='badge badge-primary'>CFO</label>
                                            <?php } elseif($user->role == 8) { ?>
                                            <label class='badge badge-warning'>Minecraft Builder</label> 
                                            <?php } elseif($user->role == 9) { ?>
                                            <label class='badge badge-warning'>Minecraft Programmer</label>     
                                            <?php } else { ?>   
                                            <label class='badge badge-danger'>Support</label>  
                                            <?php } ?>         
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/users/create/<?= $user->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/users/delete/<?php echo $user->id; ?>" onclick="return confirm('Want to delete the user');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>