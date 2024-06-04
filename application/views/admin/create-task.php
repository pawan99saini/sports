<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Employee Tasks</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/tasks">tasks</a></li>
                        <li class="breadcrumb-item active">Create Task</li>
                    </ol>

                    <a href="<?= base_url(); ?>admin/tasks" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Task</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createTask" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Attach File</label>
                                    <input type="file" name="attachment" class="form-control" />
                                    <input type="hidden" name="filename" value="<?php echo $filename; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label>Task Details</label>
                                    <textarea name="description" class="summernote form-control" rows="12"><?= $description; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Assign To</label>
                                    <select name="userID" class="form-control" required>
                                        <option value="">Select Category</option> 
                                        <option value="builder">Minecraft Builder</option>
                                        <option value="programmer">Minecraft Programmer</option>   
                                        <?php foreach($usersData as $user): ?>
                                        <?php $username = $meta->get_username($user->id); ?>    
                                        <option value="<?= $user->id; ?>" <?= ($user->id == $userID) ? 'selected' : ''; ?>><?= $username; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>
                                
                                <div class="form-group col-6">
                                    <label>Price Of Project</label>
                                    <input type="text" name="price" class="form-control" value="<?php echo $price; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
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
