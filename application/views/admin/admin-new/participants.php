<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Tournaments</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Participants</li>
                </ol>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">View Tournament Participants</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
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