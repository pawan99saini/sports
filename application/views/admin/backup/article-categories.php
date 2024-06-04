<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Article Categories</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/articles">Articles</a></li>
                        <li class="breadcrumb-item active">Article Categories</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Categories</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Icon</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($categoriesData as $category): ?>    
                                    <tr>
                                        <td><?php echo $category->id; ?></td>
                                        <td>
                                            <div class="table-icon-img">
                                                <img src="<?= base_url(); ?>assets/frontend/images/categories/<?= $category->icon_name; ?>" />
                                            </div>
                                        </td>
                                        <td><?php echo $category->title; ?></td>
                                        <td><?php echo $category->description; ?></td>
                                        <td>
                                            <?php if($category->status == 0) { ?>
                                            <label class='badge badge-warning'>Inactive</label> 
                                            <?php } else { ?>
                                            <label class='badge badge-success'>Active</label> 
                                            <?php } ?>                                       
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-article-category" data-id="<?= $category->id; ?>" status="<?= $category->status; ?>" image="<?= $category->icon_name; ?>" desc="<?= $category->description; ?>" title="<?= $category->title; ?>">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/articles/categories/delete/<?php echo $category->id; ?>" onclick="return confirm('Want to delete the Artcile Category');">
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
                        <h4 class="card-title">Create Category</h4>
                        
                        <form method="POST" action="<?php echo base_url(); ?>admin/create_article_category" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" name="title" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label>Icon</label>
                                <input type="file" name="icon" class="form-control" value="" />
                                <input type="hidden" name="icon_filename" value="" />
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="" />

                            <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 cat-submit">Create Category</button>
                            <div class="btn-reset row-inline"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
</div>