<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Create Anouncment</span>
            </div>

            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                    </a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/tournaments/notice-board">Notice Board</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Notice</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/tournaments/notice-board/<?= $tournamentID; ?>" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Tournament Notice</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/createTournamentNotice" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" class="summernote form-control" rows="12"><?= $message; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <input type="hidden" name="tournamentID" value="<?= $tournamentID ?>" />
                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary row-inline m-r-10 emp-submit">
                                        <?php if($id == '') { ?>
                                        Create Notice
                                        <?php } else { ?>
                                        Update Notice
                                        <?php } ?>    
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>