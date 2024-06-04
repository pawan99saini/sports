<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Create Game</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/games">Games</a></li>
                        <li class="breadcrumb-item active">Create Game</li>
                    </ol>

                    <a href="/admin/employees" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Game</h4>

                        <form method="POST" action="<?php echo base_url(); ?>admin/createGame" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Game Title</label>
                                    <input type="text" name="game_title" class="form-control" value="<?php echo $game_title; ?>" required />
                                </div>

                                <div class="form-group col-6">
                                    <label>Featured Image</label>
                                    <input type="file" name="game_image" class="form-control" required />
                                    <input type="hidden" name="filename" value="<?php echo $filename; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-6">
                                    <label>Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($categoriesData as $category): ?>    
                                        <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $categoryID) ? 'selected' : ''; ?>><?php echo $category->title; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit" disabled>
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