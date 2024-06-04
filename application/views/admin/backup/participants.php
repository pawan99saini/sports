<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tournaments</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                        <li class="breadcrumb-item active">Participants</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View Tournament Participants</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Image</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($participents as $participent): ?>  
                                <?php               
                                    $get_image = $ci->get_user_meta('user_image', $participent->participantID);
                                    if($get_image == null) {
                                        $image_url = base_url() . 'assets/frontend/images/default.png';
                                    } else {
                                        $image_url = base_url() . 'assets/uploads/users/user-' . $participent->participantID . '/' . $get_image;
                                    }
                                ?>        
                                    <tr>
                                        <td><?= $participent->id; ?></td>
                                        <td>
                                            <div class="table-icon-img">
                                                <img src="<?= $image_url; ?>">
                                            </div>
                                        </td>
                                        <td><?= $participent->username; ?></td>
                                        <td>
                                            <a href="<?= base_url() ?>admin/deleteParticipent/<?= $participent->tournamentID; ?>/<?php echo $participent->id; ?>" onclick="return confirm('Want to delete the tournament participent');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
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