<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Employee Tasks</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?= base_url(); ?>admin/tasks">tasks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Task</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/tasks" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Task</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/createTask" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Attach File</label>
                                    <input type="file" name="attachment" class="form-control" />
                                    <input type="hidden" name="filename" value="<?php echo $filename; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Task Details</label>
                                    <textarea name="description" class="summernote form-control" rows="12"><?= $description; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Assign To</label>
                                    <select name="userID" class="form-control" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($usersData as $user): ?>
                                        <?php $username = $meta->get_username($user->id); ?>    
                                        <option value="<?= $user->id; ?>" <?= ($user->id == $userID) ? 'selected' : ''; ?>><?= $username; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                                
                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary row-inline m-r-10 emp-submit">
                                        <?php if($id == '') { ?>
                                        Create Task
                                        <?php } else { ?>
                                        Update Task
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
</div>
