<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Designations</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/employees">Employees</a></li>
                        <li class="breadcrumb-item active">Designation</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Designation</h4>
                        
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($desgnationData as $data): ?>    
                                    <tr>
                                        <td><?php echo $data->id; ?></td>
                                        <td class="row-<?php echo $data->id; ?>"><?php echo $data->title; ?></td>
                                        <td>
                                            <?php if($data->status == 0) { ?>
                                            <label class='badge badge-warning'>Inactive</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Active</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-designation" data-id="<?php echo $data->id; ?>" data-status="<?php echo $data->status; ?>">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/deleteEmployeeProperty/<?php echo $data->id; ?>/designation" onclick="return confirm('Want to delete the designation');">
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

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Designation</h4>
                        
                        <form method="POST" action="<?php echo base_url(); ?>admin/employee_properties">
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" name="title" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="" />
                            <input type="hidden" name="type" value="designation" />
                            <input type="hidden" name="token_path" value="employees/designation" />

                            <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 cat-submit">Create Designation</button>
                            <div class="btn-reset row-inline"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
</div>