<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Team Recruitment Application</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Team Recruitment Application</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/teams/recruitment?teamID=<?= $teamID; ?>" class="btn btn-info d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Application Details</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <div class="staff-id">Application ID : DES-<?php echo $applicationData[0]->id; ?></div>
                                                    <div class="small doj text-muted">
                                                        Date Applied : <?php echo date('F, d Y', strtotime($applicationData[0]->date_created)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="personal-info">
                                                <?php foreach($fieldsData as $field): ?>
                                                <?php 
                                                	$fieldLabel = $meta->get_recruitment_fields_meta($field->meta_key, $teamID);

                                                	if(empty($fieldLabel)) {
                                                		$fieldLabel = ucwords(str_replace('_', ' ', $field->meta_key));
                                                	} 
                                                ?>
                                                    <li>
                                                        <div class="title"><?= $fieldLabel; ?></div>
                                                        <div class="text">
                                                            <a href=""><?php echo $field->meta_value; ?></a>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
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
                                <form method="POST" action="<?php echo base_url(); ?>admin/updateTeamAppliaction" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Action</label>
                                        <select name="status" class="form-control">
                                            <option value="">Set Status</option>
                                            <option value="2" <?= ($applicationData[0]->status == 2) ? 'selected': ''; ?>>Accept</option>
                                            <option value="3" <?= ($applicationData[0]->status == 3) ? 'selected': ''; ?>>Reject</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-12">
                                        <label>Comment</label>
                                        <textarea name="comment" class="form-control"  rows="6"></textarea>
                                    </div>

                                    <input type="hidden" name="id" value="<?= $applicationData[0]->id ?>" />
                                
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit" disabled>
                                            Update
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>