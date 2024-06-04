<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Articles</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/articles">Articles</a></li>
                        <li class="breadcrumb-item active">Create Article</li>
                    </ol>

                    <a href="<?= base_url(); ?>admin/articles" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Article</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createArticle">
                            <div class="wrapper">
                                <div class="form-group col-12">
                                    <label>Question</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required />
                                </div>

                                <div class="clearfix"></div>                                

                                <div class="form-group col-6">
                                    <label>Category</label>
                                    <select name="category" class="select2 form-control custom-select" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($categoriesData as $data): ?>                                        
                                        <option value="<?php echo $data->id; ?>" <?= ($category_id == $data->id) ? 'selected' : ''; ?>><?php echo $data->title; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>      

                                <div class="form-group col-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Active</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                	<label>Answer</label>
                                    <textarea name="answer" class="summernote form-control" rows="12"><?= $answer; ?></textarea>
                                </div>                                

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10">
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