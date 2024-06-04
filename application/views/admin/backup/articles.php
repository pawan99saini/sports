<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Articles</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Articles</li>
                    </ol>

                    <a href="<?php echo base_url(); ?>admin/articles/create" class="btn btn-info d-none d-lg-block m-l-15">
                        <i class="fa fa-plus-circle"></i> Create Article
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Articles</h4>
                        
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Question</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($articlesData as $article): ?>    
                                    <tr>
                                        <td><?= $article->id; ?></td>
                                        <td><?= $article->title; ?></td>
                                        <td><?= $article->category_name; ?></td>
                                        <td>
                                        <?php 
                                            if($article->status == 0) {
                                                echo "<label class='badge badge-danger'>Inactive</label>";
                                            } else {
                                                echo "<label class='badge badge-success'>Interested</label>";
                                            }
                                        ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>admin/articles/create/<?= $article->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/articles/delete/<?php echo $article->id; ?>" onclick="return confirm('Want to delete the Article');" data-toggle="tooltip" data-placement="top" title="Delete">
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
        </div>
        <!-- End Page Content -->
    </div>
</div>