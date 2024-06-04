<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tournament Notice Board</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                        <li class="breadcrumb-item active">Notice Board</li>
                    </ol>
                    
                    <?php if($notice == true) { ?>  
                    <a href="<?php echo base_url(); ?>admin/tournaments/notice-board/<?= $tournamentID; ?>/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Announcment
                    </a>
                    <?php } ?>                
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Notice</h4>
                        <?php 
                            $message = $this->session->flashdata('message');

                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <?php if($notice == true) { ?>
                            <div class="table-responsive m-t-40">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Notice</th>
                                            <th>Date Posted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($announcmentsData as $announcment): ?>  
                                        <tr>
                                            <td><?= $announcment->id; ?></td>
                                            <td>
                                                <?= $announcment->message; ?>
                                            </td>
                                            <td>
                                                <?= $announcment->date_posted; ?> 
                                            </td>
                                            <td>
                                            <a href="<?= base_url(); ?>admin/tournaments/notice-board/<?= $announcment->tournamentID; ?>/create/<?= $announcment->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url(); ?>admin/tournaments/notice-board/<?= $announcment->tournamentID; ?>/delete/<?= $announcment->id; ?>" onclick="return confirm('Want to delete the tournament');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                        <form method="POST" action="<?php echo base_url(); ?>admin/tournaments/notice-board" onsubmit="return false;" class="tr-form">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Select Tournament</label>
                                    <select name="select_tournament" class="form-control">
                                        <option value="">Tournament</option>
                                        <?php foreach($tournamentsData as $tournament): ?>  
                                        <option value="<?= $tournament->id; ?>" ><?= $tournament->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
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