<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Articles</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/articles">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Article</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/articles" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Article</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/createArticle">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Question</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required />
                                </div>

                                <div class="clearfix"></div>                                

                                <div class="form-group col-md-6">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="select2 form-control custom-select" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($categoriesData as $data): ?>                                        
                                        <option value="<?php echo $data->id; ?>" <?= ($category_id == $data->id) ? 'selected' : ''; ?>><?php echo $data->title; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>      

                                <div class="form-group col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Active</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-12">
                                	<label class="form-label">Answer</label>
                                    <textarea name="answer" class="summernote form-control" rows="12"><?= $answer; ?></textarea>
                                </div>                                

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary row-inline m-r-10">
                                        <?php if($id == '') { ?>
                                        Create
                                        <?php } else { ?>
                                        Update
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