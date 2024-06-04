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
                        <li class="breadcrumb-item active">Tournaments</li>
                    </ol>
                    
                    <a href="<?php echo base_url(); ?>admin/tournaments/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Tournament
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Tournament</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Game</th>
                                        <th>Participents</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($tournamentsData as $tournament): ?>  
                                    <tr>
                                        <td><?= $tournament->id; ?></td>
                                        <td>
                                            <div class="table-icon-img">
                                                <img src="<?= base_url(); ?>assets/frontend/images/tournaments/<?= $tournament->image; ?>">" />
                                            </div>
                                        </td>
                                        <td><?= $tournament->title; ?></td>
                                        <td><?= $tournament->category; ?></td>
                                        <td><?= $tournament->game_name; ?></td>
                                        <td>
                                            <?= $tournament->total_players . ' / ' . $tournament->max_allowed_players; ?>
                                            &nbsp;
                                            <a href="<?= base_url(); ?>admin/tournaments/participants/<?= $tournament->id; ?>" class="btn-sm-curved">View</a>
                                        </td>
                                        <td>
                                            <?php 
                                                $checked = '';

                                                if($tournament->status == 1) {
                                                    $checked = ' checked';
                                                }
                                            ?>  
                                            <div class="uael-rbs-toggle">
                                                <div class="uael-sec-1">
                                                    <h5 class="uael-rbs-head-1" data-elementor-inline-editing-toolbar="basic">Offline</h5>
                                                </div>
                                                
                                                <div class="uael-main-btn" data-switch-type="round_1">
                                                    <label class="uael-rbs-switch-label">
                                                        <input class="uael-rbs-switch uael-switch-round-1 elementor-clickable" type="checkbox" <?= $tournament->status . ' ' . $checked; ?> value="<?= $tournament->id; ?>">
                                                        <span class="uael-rbs-slider uael-rbs-round elementor-clickable"></span>
                                                    </label>
                                                </div>
                                                
                                                <div class="uael-sec-2">
                                                    <h5 class="uael-rbs-head-2" data-elementor-inline-editing-toolbar="basic">Online</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/tournaments/create/<?= $tournament->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>tournaments/<?= $tournament->category_slug; ?>/<?php echo $tournament->slug; ?>" data-toggle="tooltip" data-placement="top" title="View Lead" target="_blank">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/tournaments/delete/<?php echo $tournament->id; ?>" onclick="return confirm('Want to delete the tournament');" data-toggle="tooltip" data-placement="top" title="Delete">
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