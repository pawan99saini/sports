<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Create Tournament</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member/tournaments">Tournaments</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>member/tournaments/notice-board">Notice Board</a></li>
                        <li class="breadcrumb-item active">Create Notice</li>
                    </ol>

                    <a href="<?= base_url(); ?>member/tournaments/notice-board/<?= $tournamentID; ?>" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Tournament Notice</h4>

                        <form method="POST" action="<?php echo base_url(); ?>member/createTournamentNotice" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-12">
                                    <label>Message</label>
                                    <textarea name="message" class="summernote form-control" rows="12"><?= $message; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <input type="hidden" name="tournamentID" value="<?= $tournamentID ?>" />
                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
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