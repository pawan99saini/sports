<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Daily Status Report</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item active">Submit Work</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Work</h4>
                         
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Date Posted</th>
                                        <th>Admin Comment</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($reportData as $report): ?>    
                                    <tr>
                                        <td><?= $report->id; ?></td>
                                        <td><?= date('F d, Y', strtotime($report->date_posted)); ?></td>
                                        <td><?= $report->comments; ?></td>
                                        <td>
                                            <?php if($report->status == 0) { ?>
                                            <label class='badge badge-warning'>Pending</label> 
                                            <?php } elseif($report->status == 1) { ?>
                                            <label class='badge badge-danger'>Rejected</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Approved</label> 
                                            <?php } ?>                                       
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
                        <h4 class="card-title">Submit Work</h4>

                        <form method="POST" action="<?php echo base_url(); ?>member/submitDailyReport" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-12">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" required />
                                </div>

                                <div class="form-group col-12">
                                    <label>Attach File</label>
                                    <input type="file" name="attachment" class="form-control" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="6"></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
                                        Submit Report
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>