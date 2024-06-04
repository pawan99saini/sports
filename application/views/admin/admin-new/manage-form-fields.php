<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Teams</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?= base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?= base_url(); ?>admin/teams">Teams</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Field</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Manage Form Fields - Team <?= $teamData[0]->title; ?></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Field Type</th>
                                        <th>Field Name</th>
                                        <th>Placeholder</th>
                                        <th>Field Values</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($fieldsData as $field): ?>    
                                    <tr>
                                        <td><?= $field->ID; ?></td>
                                        <td class="field-type"><?= $field->field_type; ?></td>
                                        <td class="field-label"><?= $field->field_label; ?></td>
                                        <td class="field-placeholder"><?= $field->placeholder_text; ?></td>

                                        <?php 
                                        	$arr_values = array('radio', 'select', 'checkbox');
                                        	
                                        	if(in_array($field->field_type, $arr_values)) {
                                        		$field_values = unserialize($field->field_values);
                                        		$field_values = implode('|', $field_values);
                                        	} else {
                                        		$field_values = 'N/A';
                                        	}
                                        ?>

                                        <td class="field-values"><?= $field_values; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-fields" data-id="<?= $field->ID; ?>">
                                                <i class="si si-note"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url() ?>admin/teams/fields/delete/<?php echo $field->ID . '/' . $teamData[0]->ID; ?>" onclick="return confirm('Want to delete the field');">
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
                        <h4 class="card-title">Create Field</h4>
                    </div>

                    <div class="card-body">    
                        <form method="POST" action="<?php echo base_url(); ?>admin/create_field" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="form-label">Field Type</label>
                                <select name="field_type" class="form-control">
                                	<option value="">Select Type</option>
                                	<option value="text">Text</option>
                                	<option value="email">Email</option>
                                	<option value="textarea">Textarea</option>
                                	<option value="tel">Tel</option>
                                    <option value="select">Dropdown</option>
                                	<option value="radio">Radio</option>
                                	<option value="checkbox">Checkbox</option>
                                	<option value="date">Date</option>
                                	<option value="time">Time</option>
                                	<option value="file">File Upload</option>
                                </select>
                            </div>

                            <div class="field_data_form" style="display: none;">
	                            <div class="form-group">
	                                <label class="form-label">Label</label>
	                                <input type="text" name="field_name" class="form-control" value="" required />
	                            </div>

	                        	<div class="field-info text email textarea tel">
	                        		<div class="form-group">
		                                <label class="form-label">Placeholder</label>
		                                <input type="text" name="placeholder" class="form-control" value="" />
		                            </div>
	                        	</div>

	                        	<div class="inline-switch-button">
	                        		<div class="form-group">
	                                	<label class="form-label">Required</label>
	                                </div>

	                        		<div class="elementor-control-input-wrapper">
										<label class="dso-switch dso-control-unit">
											<input type="checkbox" name="is_required" class="dso-switch-input" value="true">
											<span class="dso-switch-label" data-on="Yes" data-off="No"></span>
											<span class="dso-switch-handle"></span>
										</label>
									</div>
	                        	</div>

	                        	<div class="options radio checkbox select">
	                        		<div class="form-group">
	                                	<label class="form-label">Options</label>
	                                	<textarea name="field_values" class="form-control" rows="6"></textarea>
	                                </div>
	                        	</div>
	                        </div>

                            <input type="hidden" name="id" value="" />
                            <input type="hidden" name="teamID" value="<?= $teamData[0]->ID; ?>" />

                            <button type="submit" class="btn btn-primary row-inline m-r-10 cat-submit">Create Field</button>
                            <div class="btn-reset row-inline"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>