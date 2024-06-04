<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Categories</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="/admin/games">Games</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Basic DataTable</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
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
                                                <img src="<?= base_url(); ?>assets/frontend/images/games/categories/<?= $category->image; ?>" />
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
                                            <a href="javascript:void(0);" class="edit-category" data-id="<?= $category->id; ?>" status="<?= $category->status; ?>" image="<?= $category->image; ?>" desc="<?= $category->description; ?>" title="<?= $category->title; ?>">
                                                <i class="si si-note"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/deleteGameCategory/<?php echo $category->id; ?>" onclick="return confirm('Want to delete the department');">
                                                <i class="ti-trash"></i>
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Category</h4>
                    </div>

                    <div class="card-body">    
                        <form method="POST" action="<?php echo base_url(); ?>admin/create_category" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <input type="text" name="title" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Icon</label>
                                <input type="file" name="icon" class="form-control" value="" />
                                <input type="hidden" name="icon_filename" value="" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="" />

                            <button type="submit" class="btn btn-primary row-inline m-r-10 cat-submit">Create Category</button>
                            <div class="btn-reset row-inline"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>