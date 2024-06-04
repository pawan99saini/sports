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
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Manage Applications</div>
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Select Team</label>
                                    <select name="teamID" class="form-control" onchange="this.form.submit();">
                                        <option value="">Select Team</option>
                                        <?php foreach($teamsData as $team): ?>  
                                        <option value="<?= $team->ID; ?>"
                                        <?php 
                                            $selected = '';
                                            if($teamID > 0 && $team->ID == $teamID) {
                                                $selected = ' selected';
                                            }
                                        ?>
                                         <?= $selected; ?>><?= $team->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <?php if($teamID > 0) { ?>
                        <div class="table-responsive">
                            <table id="valorantApplication" class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Date Applied</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php foreach($teamApplications as $application): ?>
                                        <td><?= $application->id; ?></td>
                                        <td><?= $application->date_created; ?></td>
                                        <td>
                                        <?php if($application->status == 0) { ?>
                                        <label class='badge badge-warning'>Unread</label>
                                        <?php } ?>

                                        <?php if($application->status == 1) { ?>
                                        <label class='badge badge-info'>Reviewed</label>
                                        <?php } ?>

                                        <?php if($application->status == 2) { ?>
                                        <label class='badge badge-success'>Accepted</label>
                                        <?php } ?>

                                        <?php if($application->status == 3) { ?>
                                        <label class='badge badge-danger'>Rejected</label>
                                        <?php } ?>
                                        </td>
                                        <td><?= $application->remarks; ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/teams/recruitment/view/<?= $application->id; ?>" data-toggle="tooltip" data-placement="top" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/teams/recruitment/delete/<?php echo $application->id; ?>" onclick="return confirm('Want to delete the application');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>