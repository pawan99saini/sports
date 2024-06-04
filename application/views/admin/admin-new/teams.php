<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Teams</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teams</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Manage Teams</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($teamsData as $team): ?>    
                                    <tr>
                                        <td><?php echo $team->ID; ?></td>
                                        <td>
                                            <div class="table-icon-img">
                                                <img src="<?= base_url(); ?>assets/uploads/teams-recruitment/team-<?= $team->ID; ?>/<?= $team->thumbnail; ?>" />
                                            </div>
                                        </td>
                                        <td><?php echo $team->title; ?></td>
                                        <td>
                                            <?php if($team->status == 0) { ?>
                                            <label class='badge badge-warning'>Inactive</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Active</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-team" data-id="<?= $team->ID; ?>" status="<?= $team->status; ?>" image="<?= $team->thumbnail; ?>" title="<?= $team->title; ?>">
                                                <i class="si si-note"></i>
                                            </a> 
                                            &nbsp; | &nbsp;
                                            <a href="<?= base_url() ?>admin/teams/fields/<?php echo $team->ID; ?>">
                                                <i class=" ti-check-box"></i>
                                                Manage Form
                                            </a>
                                            &nbsp; | &nbsp;
                                            <a href="<?= base_url() ?>admin/teams/delete/<?php echo $team->ID; ?>" onclick="return confirm('Want to delete the team');">
                                                <i class="ti-trash"></i>
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Team</h4>
                    </div>

                    <div class="card-body">    
                        <form method="POST" action="<?php echo base_url(); ?>admin/create_team" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Thumbnail</label>
                                <input type="file" name="icon" class="form-control" value="" />
                                <input type="hidden" name="icon_filename" value="" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="" />

                            <button type="submit" class="btn btn-primary row-inline m-r-10 cat-submit">Create Team</button>
                            <div class="btn-reset row-inline"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>