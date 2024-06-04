<div class="dso-main">
	<div class="dso-banner-overlay dso-teams">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="dso-lg-content">
	                    <h1>
	                        DSO 
	                        <span>Official Members</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">We have <?= count($membersData); ?>+ players registered with us</p>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="box-row player-box-descriptive" id="players">
						<?php foreach($membersData as $profile): ?>
						<?php 
							$dso_member = $meta->get_user_meta('dso_member', $profile->id);
							if($dso_member == 1) {
						?>
	                    <?php if($this->session->userdata('user_id') != $profile->id) { ?> 
	                    <div class="player-box">
	                    	<div class="player_badge">
	                    		<?php if($profile->role == 1) { ?>
                                <label class='badge badge-info'>Admin</label>     
                                <?php } elseif($profile->role == 2) { ?>
                                <label class='badge badge-warning'>Spectator</label> 
                                <?php } elseif($profile->role == 3) { ?>
                                <label class='badge badge-success'>Tournament Operator</label> 
                                <?php } elseif($profile->role == 4) { ?>
                                <label class='badge badge-dark'>Player</label> 
                                <?php } elseif($profile->role == 5) { ?>
                                <label class='badge badge-dark'>Team Owner</label> 
                                <?php } elseif($profile->role == 6) { ?>
                                <label class='badge badge-primary'>CFO</label>
                                <?php } elseif($profile->role == 8) { ?>
                                <label class='badge badge-warning'>Minecraft Builder</label> 
                                <?php } elseif($profile->role == 9) { ?>
                                <label class='badge badge-warning'>Minecraft Programmer</label>    
                                <?php } elseif($profile->role == 10) { ?> 
                                <label class='badge badge-warning'>Video Editor</label>    
                                <?php } else { ?>   
                                <label class='badge badge-danger'>Support</label>  
                                <?php } ?> 
                            </div>

	                        <div class="player-tumb">
	        					<?php 
	                        		$get_image = $meta->get_user_meta('user_image', $profile->id);
	                        		
	                        		if($get_image == null) {
	                        			$image_url = base_url() . 'assets/uploads/users/default.jpg';
	                        		} else {
	                        			$image_url = base_url() . 'assets/uploads/users/user-' . $profile->id . '/' . $get_image;
	                        		}
	                        	?>
	                            <img src="<?= $image_url; ?>">
	                        </div>

	                        <div class="player-content">
		                        <h3><?= $profile->username; ?></h3>

		                        <?php 
		                        	$get_description = $meta->get_user_meta('user_description', $profile->id);
        		
					        		$description = '';
					        		
					        		if($get_description != '') {
					        			$description  = $get_description;
					        			$countDescrip = strlen($description);

					        			if($countDescrip > 150) {
					        				$description = substr($description, 0, 150);
					        				$description .= '...';
					        			} 
					        		}
		                        ?>

		                        <p>
		                        	<?= nl2br($description); ?>
		                        </p>

		                        <a href="<?= base_url() . 'dso-members/profile/'.$profile->username; ?>"  class="btn dso-ebtn dso-ebtn-solid">
		                        	<span class="dso-btn-text">View Profile</span>
                                    <div class="dso-btn-bg-holder"></div>
		                        </a>
		                    </div>

		                    <div class="dso-live-stream-player">
		                    	<div class="stream-offline">
		                    		<div class="dso-inner-404">
										<img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
										<h2>No Streams Found</h2>
									</div>
									
		                    		<h3>Memeber is not currently sreaming</h3>
		                    	</div>
		                    </div>
	                    </div>
	                    <?php } ?>
	                	<?php } ?>
	                	<?php endforeach; ?>
	                </div>
				</div>	
			</div>
		</div>
	</div>
</div>