<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Salary Management</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item active">Salary</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Salary Status Report</h4>
                        
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Date</th>
                                        <th>Basic Salary</th>
                                        <th>Comission</th>
                                        <th>Allowance</th>
                                        <th>Deduction</th>
                                        <th>Sub Total</th>                                        
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($salaryData as $salary): ?>    
                                    <tr>
                                        <td><?= $salary->id; ?></td>
                                        <td><?= date('F d, Y', strtotime($salary->date_created)); ?></td>
                                        <td><?= $salary->basic_amount; ?></td>
                                        <td><?= $salary->commission; ?></td>
                                        <td><?= $salary->allowance; ?></td>
                                        <td><?= $salary->deductions; ?></td>
                                        <td><?= $salary->sub_total; ?></td>
                                        <td>
                                            <?php if($salary->status == 0) { ?>
                                            <label class='badge badge-warning'>Unpaid</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Paid</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="view-slip" data-id="<?php echo $salary->id; ?>">
                                                <i class="fa fa-eye"></i> View Slip
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
        <!-- End PAge Content -->
    </div>
</div>