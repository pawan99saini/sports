<div class="form-process-step form-step-3">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
            	<div class="row-box-spacer">
            		<div class="dso-lg-content dso-flex align-items-center m-b-20">
	                    <h3>Reward & Prize</h3>

	                    <div class="item-right">
	                        <a href="javascript:void(0);"class="btn dso-ebtn dso-ebtn-solid add-desc">
	                            <span class="dso-btn-text">Add Row</span>
	                            <div class="dso-btn-bg-holder"></div>
	                        </a> 
	                    </div>
	                </div>
                
	                <div class="pkg-desc-row">
	                	<?php 
                        if($tournament_meta != '') { 
                            $meta_title = unserialize($tournament_meta[0]->meta_title);
                            $meta_value = unserialize($tournament_meta[0]->meta_description); 
                            $i = 0;
                            foreach($meta_title as $meta): 
                        ?>
                            <div class="input-row mg-b-20">
                                <input type="text" name="placement[]" class="form-control" value="<?= $meta; ?>" value="" autocomplete="off" />
                                <input type="text" name="prize[]" class="form-control" value="<?= $meta_value[$i]; ?>" value="" autocomplete="off" />
                                <a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>
                            </div>
                        <?php $i++; ?>    
                        <?php endforeach; ?>
                        <?php } else { ?>
                            <div class="input-row mg-b-20">
                                <input type="text" name="placement[]" class="form-control" placeholder="Placement" value="" autocomplete="off" />
                                <input type="text" name="prize[]" class="form-control" placeholder="Prize" value="" autocomplete="off" />
                            </div>
                        <?php } ?>
	                </div>
	            </div>
            </div>
        </div>
	</div>
</div>