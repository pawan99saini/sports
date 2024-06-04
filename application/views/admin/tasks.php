<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Employee Tasks</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tasks</li>
                    </ol>

                     <a href="<?php echo base_url(); ?>admin/tasks/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Task
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Assigned Tasks</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Title</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($projectsData as $task): ?>
                                    <tr>
                                        <td><?= $task->id; ?></td>
                                        <td><?= $task->title; ?></td>
                                        <?php 
                                        	$username = $meta->get_username($task->agentID);
                                        ?>
                                        <td><?= $username; ?></td>
                                        <td>
                                        <?php 
                                            if($task->status == 1) { 
                                                $status = "<label class='badge badge-warning'>New Project</label>";     
                                            } elseif($task->status == 2) { 
                                                $status = "<label class='badge badge-info'>In Progress</label>";
                                            } elseif($task->status == 3) { 
                                                $status = "<label class='badge badge-warning'>Available To Review</label>"; 
                                            } elseif($task->status == 4) { 
                                                $status = "<label class='badge badge-warning'>Revision Requested</label>";
                                            } else { 
                                                $status = "<label class='badge badge-success'>Completed</label>"; 
                                            } 

                                            echo  $status ;
                                        ?>                                       
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/tasks/create/<?= $task->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/tasks/view/<?php echo $task->id; ?>" data-toggle="tooltip" data-placement="top" title="View Lead">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/tasks/delete/<?php echo $task->id; ?>" onclick="return confirm('Want to delete the task');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o"></i>
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
        </div>
        <!-- End Page Content -->
    </div>
</div>