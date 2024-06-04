<div class="dso-main">
	<div class="team-recruit-banner">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-md-5">
	                <div class="dso-lg-content">
	                    <h1>
	                        My
	                        <span>Account</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">Mannage your account</p>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="container p-120">
		<div class="row">
			<div class="col-md-4">
				<div class="sidebar">
					<?php include 'includes/sidebar.php'; ?>
				</div>
			</div>

			<div class="col-md-8">
				<div class="dso-lg-content">
                    <h1>
                        Account Summary
                    </h1>
                </div>

				<div class="dso-col-light">
					<div class="content-box">
	                    <div class="dso-lg-content m-b-20">
	                        <h3>Membership & Credits</h3>
	                    </div>

	                    <div class="acc-summary">    
	                        <div class="form-group">
	                            <label>Current Plan</label>
	                            <p><?= ($userdata[0]->membership == 0) ? 'Free Member' : $package[0]->pkg_name; ?></p>
	                        </div>
	                        
	                        <div class="form-group">
	                            <label>Billing Cycle</label>
	                            <p>
	                            	<?= ($userdata[0]->membership == 0) ? 'N/A' : $userdata[0]->start_date; ?>
	                             	 - 
	                             	<?= ($userdata[0]->membership == 0) ? 'N/A' : $userdata[0]->end_date; ?> 
	                            </p>
	                        </div>

                            <div class="form-group">
	                            <label>Membership Fees</label>
	                            <p>$<?= $userdata[0]->credit; ?></p>
	                        </div>

			                <div class="btn-row btn-left">
			                	<a href="<?= base_url(); ?>pricing" class="btn dso-ebtn dso-ebtn-solid">
        							<span class="dso-btn-text">View or Edit Membership Plan</span>
        							<div class="dso-btn-bg-holder"></div>
			                	</a>
			                </div>
			            </div>

                        <div class="dso-lg-content m-b-20">
	                        <h3>Team Profile</h3>
	                    </div>

                        <div class="acc-summary"> 
                            <?php if($teamProfileStatus == 0) { ?>   
                            <div class="not-found">
                                <img src="<?= base_url(); ?>assets/frontend/images/nothing-found.png">
                                <span>You don't have active team profile. You can still create a team profile.</span>
                            </div>
                            <?php } else { ?>
							<?php 
								$teamID   	 = $teamData[0]->ID;
								$teamLogo 	 = $meta->get_team_meta('team_logo', $teamID);
								$activeMembers = $meta->get_data('team_members', array('teamID' => $teamID, 'status' => 1));
								$inactiveMembers = $meta->get_data('team_members', array('teamID' => $teamID, 'status' => 0));

								if($teamLogo == null) {
									$image_url = base_url() . 'assets/frontend/images/team-profile-default.jpg';
								} else {
									$image_url = base_url() . 'assets/uploads/teams/' . $teamLogo;
								}
							?>
								<div class="team-profile-row team-row team-participants">
									<div class="select-player-box wd-100">
										<div class="player-btn-row">
											<a href="<?= base_url(); ?>team/profile" class="btn dso-ebtn-sm">
												<span class="dso-btn-text">View Profile</span>
											</a>
										</div>

										<div class="thumbnail-circle">
											<img loading="lazy" src="<?= $image_url; ?>">
										</div>
										
										<div class="select-player-content">
											<h5 class="text-truncate">
												<a href="<?= base_url(); ?>team/profile"><?= $teamData[0]->team_name; ?></a>
											</h5>

											<div class="player-statistics">
												<div class="player-data">
													<p>
														<i class="dso-tournament-meta-icon fas fa-users"></i>
														<span>Active Team Members</span>
													</p>

													<h6><?= count($activeMembers); ?></h6>
												</div>
												
												<div class="player-data">
													<p>
														<i class="dso-tournament-meta-icon fas fa-users"></i>
														<span>Pending For Activation</span>
													</p>

													<h6><?= count($inactiveMembers); ?></h6>
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
								</div>
                            <?php } ?>
                        </div>
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>