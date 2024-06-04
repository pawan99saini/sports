<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Newsletter</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
                </ol>

            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Send Newsletter</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/sendNewsletter" enctype="multipart/form-data">
                            <div class="row">
                                <?php 
                                    $message = $this->session->flashdata('message');

                                    if(isset($message)) {
                                        echo $message;
                                    }
                                ?>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" value="<?php echo $emailTemplate[0]->subject; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-12">
                                    <label class="form-label">Email Content</label>
                                    <textarea name="email_content" class="summernote form-control" rows="12"><?= $emailTemplate[0]->message; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <div class="form-group col-md-12">
                                    <label class="form-label">Receiver Email</label>

                                    <div class="inline-radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="email_type" class="form-check-input" value="single" />
                                            <label class="form-check-label" for="customRadio1">Send Single Email</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="email_type" class="form-check-input" value="multiple" />
                                            <label class="form-check-label" for="customRadio1">Send Multiple</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="email_type" class="form-check-input" value="upload" />
                                            <label class="form-check-label" for="customRadio1">Upload Csv</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group col-12 email_type single" style="display: none;">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email_user_single" class="form-control" />
                                </div>   

                                <div class="form-group col-12 email_type multiple" style="display: none;">
                                    <label class="form-label">Email</label>
                                    <div class="field-wrapper">
                                        <div class="field-row">
                                            <input type="text" name="email_user[]" class="form-control" />
                                            <a class="add-field"><i class="icon-plus"></i></a>
                                        </div>
                                    </div>
                                </div>                                

                                <div class="form-group col-12 email_type upload" style="display: none;">
                                    <label class="form-label">Email File</label>
                                    <input type="file" name="email_user_file" class="form-control" />
                                </div> 

                                <div class="clearfix"></div>                                    

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary row-inline m-r-10 emp-submit">
                                        Process Email   
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