<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Newsletter</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Send Newsletter</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/sendNewsletter" enctype="multipart/form-data">
                            <div class="wrapper">
                                <?php 
                                    $message = $this->session->flashdata('message');

                                    if(isset($message)) {
                                        echo $message;
                                    }
                                ?>

                                <div class="form-group col-6">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" value="<?php echo $emailTemplate[0]->subject; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label>Email Content</label>
                                    <textarea name="email_content" class="summernote form-control" rows="12"><?= $emailTemplate[0]->message; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 
                                
                                <div class="form-group col-12">
                                    <label>Receiver Email</label>

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
                                    <label>Email</label>
                                    <input type="text" name="email_user_single" class="form-control" />
                                </div>   

                                <div class="form-group col-12 email_type multiple" style="display: none;">
                                    <label>Email</label>
                                    <div class="field-wrapper">
                                        <div class="field-row">
                                            <input type="text" name="email_user[]" class="form-control" />
                                            <a class="add-field"><i class="icon-plus"></i></a>
                                        </div>
                                    </div>
                                </div>                                

                                <div class="form-group col-12 email_type upload" style="display: none;">
                                    <label>Email File</label>
                                    <input type="file" name="email_user_file" class="form-control" />
                                </div> 

                                <div class="clearfix"></div>                                    

                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
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