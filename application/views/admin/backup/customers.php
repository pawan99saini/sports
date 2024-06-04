<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">All Customers</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>

                    <a href="<?php echo base_url(); ?>admin/customers/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Customers
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customers</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Source</th>
                                        <th>Customer Status</th>
                                        <th>Active Orders</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($customersData as $customer): ?>	
                                    <tr>
                                    	<td><?= $customer->id; ?></td>
                                    	<td><?= $customer->first_name . ' ' . $customer->last_name; ?></td>
                                    	<td><?= $customer->email; ?></td>
                                    	<td><?= $customer->phone; ?></td>
                                    	<td><?= $customer->source_link; ?></td>
                                    	<td>
                                		<?php 
                                			if($customer->customer_status == 0) {
												echo "<label class='badge badge-danger'>Inactive</label>";
                                			} else {
                                				echo "<label class='badge badge-success'>Interested</label>";
                                			}
                                		?>
                                    	</td>
                                    	<td><?= $customer->total_orders; ?></td>
                                    	<td>
                                    		<a href="<?= base_url(); ?>admin/customers/create/<?= $customer->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/customers/view/<?php echo $customer->id; ?>" data-toggle="tooltip" data-placement="top" title="View Lead">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/customers/delete/<?php echo $customer->id; ?>" onclick="return confirm('Want to delete the Customer');" data-toggle="tooltip" data-placement="top" title="Delete">
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
</div