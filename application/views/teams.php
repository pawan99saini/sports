<div class="dso-main">
	<div class="dso-banner-overlay dso-teams">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="dso-lg-content">
	                    <h1>
	                        Top 
	                        <span>Teams</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">We have currently <?= count($teamsData); ?><?= (count($teamsData) > 2) ?  ' teams' : ' team'; ?> registered with us</p>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
                    <div class="team-profile-row team-row team-participants">
					<?php $count = 0; ?>
					<?php foreach ($teamsData as $team): ?>
						<?php if($team->userID != $this->session->userdata('user_id')) { ?>		
                        <div class="select-player-box">
                            <div class="player-btn-row">
                                <a href="<?= base_url(); ?>team/<?= $team->slug; ?>" class="btn dso-ebtn-sm">
                                    <span class="dso-btn-text">View Channel</span>
                                </a>
                            </div>

                            <div class="thumbnail-circle">
                                <?php               
	                    			$get_image = $meta->get_team_meta('team_logo', $team->ID);
					                if($get_image == null) {
					                    $image_url = base_url() . 'assets/frontend/images/team-profile-default.jpg';
					                } else {
					                    $image_url = base_url() . 'assets/uploads/teams/'. $get_image;
					                }
					            ?>
			                    <img loading="lazy" src="<?= $image_url; ?>">
                            </div>
                            
                            <div class="select-player-content">
                                <h5 class="text-truncate">
                                    <a href="<?= base_url(); ?>team/<?= $team->slug; ?>">
                                        <?= $team->team_name; ?>
                                    </a>
                                </h5>
                                <div class="player-statistics">
                                    <?php 
                                        $discord_username = $meta->get_team_meta('discord_username', $team->ID);
                                        if($discord_username != '') {
                                    ?>
                                    <div class="player-data">
                                        <p>
                                            <i class="dso-tournament-meta-icon fab fa-discord" style="font-size: 12px;"></i>
                                            <span>Discord</span>
                                        </p>

                                        <h6><?= $discord_username; ?></h6>
                                    </div>
                                    <?php } ?>

                                    <div class="player-data">
                                        <p>
                                            <i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>
                                            <span>Tournaments Played</span>
                                        </p>

                                        <h6>0</h6>
                                    </div>

                                    <div class="player-data">
                                        <p>
                                            <i class="dso-tournament-meta-icon ion-trophy"></i>
                                            <span>Win Rate</span>
                                        </p>

                                        <h6>0.00%</h6>
                                    </div>
                                </div>
                            </div>
			            </div>
			                    <?php $count++; ?>	
	                	<?php } ?>
                	<?php endforeach; ?>
                	<?php if($count == 0) { ?>
                	<div class="not-found">
                		<h2>No Teams Found</h2>
                	</div>
                	<?php } ?>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>
