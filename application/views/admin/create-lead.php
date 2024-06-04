<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">All Leads</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/leads">Leads</a></li>
                        <li class="breadcrumb-item active">Create Leads</li>
                    </ol>

                    <a href="<?= base_url(); ?>admin/leads" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Lead</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createLead">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="<?php echo $company_name; ?>" required />
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group col-6">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" required />
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" autocomplete="off"  required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" autocomplete="off"  required />
                                </div>

                                <div class="clearfix"></div>                                

                                <div class="form-group col-6">
                                    <label>Country</label>
                                    <select name="country" class="select2 form-control custom-select" required>
                                        <option value="">Select Country</option>    
                                        <?php foreach($countryData as $data): ?>                                        
                                        <option value="<?php echo $data->country_name; ?>" <?= ($country == $data->country_name) ? 'selected' : ''; ?>><?php echo $data->country_name; ?></option>                                           
                                        <?php endforeach; ?> 
                                    </select>
                                </div>      

                                <div class="form-group col-6">
                                    <label>Lead Source</label>
                                    <select name="lead_source" class="form-control" required="">
                                        <option>PPC</option>
                                        <option>FB</option>
                                        <option>Email Marketing</option>
                                        <option>BARK</option>
                                        <option>SMS</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Lead Status</label>
                                    <select name="lead_status" class="form-control">
                                        <option value="0">Not Contacted</option>
                                        <option value="1">Contacted</option>
                                    </select>
                                </div>

                                <div class="form-group col-6">
                                    <label>User Assigned</label>
                                    <select name="assigned_user" class="form-control">
                                        <option value="">Select User</option> 
                                        <?php foreach($agentsData as $data): ?>      
                                        <option value="<?= $data->id; ?>"><?= $data->id . ' - ' . $data->name; ?> (<?= $data->designation; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                                

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
                                        <?php if($id == '') { ?>
                                        Create Lead
                                        <?php } else { ?>
                                        Update Lead
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