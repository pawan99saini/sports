<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Games</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/games">Games</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Game</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/games" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Game</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/createGame" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Game Title</label>
                                    <input type="text" name="game_title" class="form-control" value="<?php echo $game_title; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" name="game_image" class="form-control" />
                                    <input type="hidden" name="filename" value="<?php echo $filename; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($categoriesData as $category): ?>    
                                        <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $categoryID) ? 'selected' : ''; ?>><?php echo $category->title; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
                                        <?php if($id == '') { ?>
                                        Create Game
                                        <?php } else { ?>
                                        Update Game
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
