<div class="dso-team-recruit-main">
	<div class="team-recruit-banner">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="dso-lg-content">
	                    <h1>
	                        DSO 
	                        <span>Wants You</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">We are looking to recruiting the best team players. Do you believe you are the best?</p>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
		<div class="container">
			<div class="dso-tournaments">
				<?php if(count($teamsData) == 0) { ?>
			 	<div class="not-found">
		            <img src="<?= base_url(); ?>assets/frontend/images/no-tournaments.png">
		            <span>No Teams Found</span>
		        </div>
		        <?php } else { ?>
		        	<?php foreach($teamsData as $team): ?>
		        	<div class="dso-tournament-wrapper dso-recruitment-box">
		                <div class="dso-tournament-thumbnail">
		                    <?php 
		                        $image = 'frontend/images/tournaments/no-image.jpg';

		                        if(!empty($team->thumbnail)) {
		                            $image = 'uploads/teams-recruitment/team-'. $team->ID . '/' .$team->thumbnail;
		                        }
		                    ?>
		                    <img src="<?= base_url(); ?>assets/<?= $image; ?>">

		                    <svg width="129" height="211" viewBox="0 0 167 269" fill="none" xmlns="http://www.w3.org/2000/svg">
		                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25412 0.814453C1.68125 2.62384 0 5.61553 0 8.99991V269H167C167 269 47 269 66.5 112.171C75.5581 39.3209 20.2679 8.22409 4.25412 0.814453Z" fill="#0c080e"></path>
		                    </svg>

		                    <div class="dso-tournament-info">
		                    	<h3>
		                            <a href="<?= base_url(); ?>team-recruitment/<?= $team->slug; ?>">
		                                <?= $team->title; ?>
		                            </a>
		                        </h3>

			                    <a href="<?= base_url(); ?>team-recruitment/<?= $team->slug; ?>" class="btn dso-ebtn dso-ebtn-solid">
	                                <span class="dso-btn-text">Apply Now</span>
	                                <div class="dso-btn-bg-holder"></div>
	                            </a>
		                    </div>
		                </div>
		            </div>
		        	<?php endforeach; ?>
		        <?php } ?>	
			</div>
		</div>
	</div>
</div>