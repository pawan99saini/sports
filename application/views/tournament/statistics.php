<div class="form-process-step form-step-4">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
            	<div class="row-box-spacer">
            		<div class="dso-lg-content dso-flex align-items-center m-b-20">
	                    <h3>Tournament Stats</h3>

	                    <div class="item-right">
	                        <a href="javascript:void(0);"class="btn dso-ebtn dso-ebtn-solid add-stats">
	                            <span class="dso-btn-text">Create Stat</span>
	                            <div class="dso-btn-bg-holder"></div>
	                        </a> 
	                    </div>
	                </div>
                
	                <div class="stats-row">
	                	<?php if(isset($stats_meta[0]) && $stats_meta[0] != '') { ?>
                        <?php $meta_title = unserialize($stats_meta[0]->meta_title); ?>
                        <?php $meta_value = unserialize($stats_meta[0]->meta_description); ?>
                        <?php $i = 0; ?>
                        <?php foreach($meta_title as $meta): ?>
                            <div class="input-row mg-b-20">
                                <input type="text" name="stat_title[]" class="form-control" value="<?= $meta; ?>" value="" autocomplete="off" />
                                <input type="text" name="stat_value[]" class="form-control" value="<?= $meta_value[$i]; ?>" value="" autocomplete="off" />
                                <a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>
                            </div>
                        <?php $i++; ?>    
                        <?php endforeach; ?>
                        <?php } else { ?>
                            <div class="input-row mg-b-20">
                                <input type="text" name="stat_title[]" class="form-control" placeholder="Heading" value="" autocomplete="off" value="Tournament Operator" />
                                <input type="text" name="stat_value[]" class="form-control" placeholder="Value" value="<?= $username; ?>" autocomplete="off" />
                            </div>
                        <?php } ?>
	                </div>
	            </div>
            </div>
        </div>
	</div>
</div>