<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="<?= base_url(); ?>admin/getApplications" class="btn btn-info d-none d-lg-block m-l-15 back-applications">
                            <i class="fa fa-plus-circle"></i> Back
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <div class="staff-id">Application ID : DES-<?php echo $spectatorData[0]->id; ?></div>
                                            <div class="small doj text-muted">
                                                Date Applied : <?php echo date('F, d Y', strtotime($spectatorData[0]->date_applied)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text">
                                                    <a href=""><?php echo $spectatorData[0]->phone; ?></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text">
                                                    <a href=""><?php echo $spectatorData[0]->email; ?></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Social Media ID:</div>
                                                <div class="text"><?php echo $spectatorData[0]->sm_id; ?></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="activity" role="tabpanel">
                        <h4 class="card-title">
                            Document
                        </h4>

                        <div class="image-full">
                            <img src="<?= base_url() . 'assets/uploads/' .$spectatorData[0]->photoID; ?>" />
                        </div>

                        <form method="POST" action="<?php echo base_url(); ?>admin/updateSpectator" onsubmit="return false;" class="updateSpectator">
                            <div class="form-group col-6">
                                <label>Action</label>
                                <select name="status" class="form-control">
                                    <option value="">Set Status</option>
                                    <option value="2" <?= ($spectatorData[0]->status == 2) ? 'selected': ''; ?>>Approve</option>
                                    <option value="3" <?= ($spectatorData[0]->status == 3) ? 'selected': ''; ?>>Reject</option>
                                </select>
                            </div>

                            <div class="clear"></div>

                            <div class="form-group col-12">
                                <label>Comment</label>
                                <textarea name="comment" class="form-control"  rows="6"></textarea>
                            </div>

                            <input type="hidden" name="id" value="<?= $spectatorData[0]->id ?>" />
                        
                            <div class="col-12">
                                <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>