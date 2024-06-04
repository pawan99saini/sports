<div class="dso-main">
	<div class="dso-banner-overlay dso-teams">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="dso-lg-content">
	                    <h1>
							Top 
	                        <span>Notch Players</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">We have 100+ players registered with us</p>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="box-row" id="players">
                        <?php $playersOffset = 0; ?>
						<?php foreach($profileData as $profile): ?>
	                    <?php if($this->session->userdata('user_id') != $profile->id) { ?> 
	                    <div class="player-box">
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

		                        <p>
		                        	<i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>
		                        	0 Tournaments Won
		                        </p>

		                        <a href="<?= base_url() . 'profile/'.$profile->username; ?>" class="channel-btn-red">VIEW CHANNEL</a>
		                    </div>
	                    </div>
                        <?php $playersOffset++; ?>
	                	<?php } ?>
	                	<?php endforeach; ?>
	                </div>

                    <div class="btn-row justify-content-center mt-5">
                        <a href="<?= base_url(); ?>home/getMorePlayers" class="btn dso-ebtn dso-ebtn-solid" id="loadMorePlayers" data-offset="<?= $playersOffset; ?>">
                            <span class="dso-btn-text">View More</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a>

                        <div class="loader-sub" id="loadPlayersLoader">
                            <div class="lds-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
				</div>	
			</div>
		</div>
	</div>
</div>