<div class="table-responsive m-t-40">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Discord Username</th>
                <th>Photo ID</th>
                <th>Status Aplication</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($applicationData as $data): ?>
            <tr>
                <td><?= $data->id; ?></td>
                <td><?= $data->email; ?></td>
                <td><?= $data->phone; ?></td>
                <td><?= $data->sm_id; ?></td>
                <td>
                    <div class="thumb-img">
                        <img src="<?= base_url() . 'assets/admin/images/confidential-image.png'; ?>" />
                    </div>
                </td>
                <td>
                    <?php if($data->status == 2) { ?>
                    <label class='badge badge-success'>Approved</label> 
                    <?php } elseif($data->status == 3) { ?>
                    <label class='badge badge-danger'>Rejected</label>
                    <?php } else { ?>
                    <label class='badge badge-warning'>Pending</label> 
                    <?php } ?>         
                </td>
                <td>
                    <a href="<?= base_url(); ?>member/viewSpectatorApplication/<?= $data->id; ?>" data-toggle="tooltip" data-placement="top" title="View" class="view-application">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>    
        </tbody>
    </table>
</div>