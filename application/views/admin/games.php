<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Games</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Games</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/games/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Game
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Games</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Icon</th>
                                        <th>Game Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($gamesData as $game): ?>  
                                    <tr>
                                        <td><?= $game->game_id; ?></td>
                                        <td>
                                            <div class="table-icon-img">
                                                <img src="<?= base_url(); ?>assets/frontend/images/games/<?= $game->game_image; ?>">" />
                                            </div>
                                        </td>
                                        <td><?= $game->game_name; ?></td>
                                        <td><?= $game->category; ?></td>
                                        <td>
                                            <?php if($game->status == 0) { ?>
                                            <label class='badge badge-warning'>Inactive</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Active</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/games/create/<?= $game->game_id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/games/view/<?php echo $game->game_id; ?>" data-toggle="tooltip" data-placement="top" title="View Lead">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/games/delete/<?php echo $game->game_id; ?>" onclick="return confirm('Want to delete the department');" data-toggle="tooltip" data-placement="top" title="Delete">
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