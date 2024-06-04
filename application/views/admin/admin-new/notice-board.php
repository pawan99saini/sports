<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Tournament Notice Board</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notice Board</li>
                </ol>

                <?php if($notice == true) { ?>  
                <a href="<?php echo base_url(); ?>admin/tournaments/notice-board/<?= $tournamentID; ?>/create" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Create Announcment
                </a>
                <?php } ?>   
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Manage Notice</div>
                    </div>
                    <div class="card-body">
                        <?php 
                            $message = $this->session->flashdata('message');

                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <?php if($notice == true) { ?>
                            <div class="table-responsive m-t-40">
                                <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
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
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Select Tournament</label>
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