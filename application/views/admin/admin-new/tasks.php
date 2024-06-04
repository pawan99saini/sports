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
                    <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/tasks/create" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Create Task
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Assigned Tasks</h4>
                    </div>

                    <div class="card-body">    
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
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