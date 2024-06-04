<div class="dso-main">
	<div class="dso-profile-header dso-banner-overlay">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-4">
					<div class="dso-user-profile">
						<div class="dso-thumbail-circle">
							<?php 
                        		$get_image = $meta->get_user_meta('user_image', $profileData[0]->id);
                        		
                        		if($get_image == null) {
                        			$image_url = base_url() . 'assets/uploads/users/default.jpg';
                        		} else {
                        			$image_url = base_url() . 'assets/uploads/users/user-' . $profileData[0]->id . '/' . $get_image;
                        		}
                        	?>
                            <img loading="lazy" src="<?= $image_url; ?>" />
                            <?php if($edit == 1) { ?>	
	                        	<a href="javascript:void(0);" class="edit-dp edit-cp" data-value="Profile Photo">
						    		<i class="fa fa-camera"></i>
						    	</a>
						    	<div class="overwrap"></div>
	                        <?php } ?>
						</div>

						<div class="dso-user-info">
							<h2>@<?= $profileData[0]->username; ?></h2>
							<?php 
                        		$get_tagline = $meta->get_user_meta('user_tagline', $profileData[0]->id);
                        		$tagline = '';
                        		if($get_tagline != '') {
                        			$tagline = $get_tagline;
                        		} 
                        	?>
                        	<?php if($edit == 1) { ?>	
                        		<div class="inner-descrip">
                            		<input type="text" class="form-control p-update p-tagline" data-p="upd-btn" name="tagline" value="<?= $tagline; ?>">
                            		<div class="upd-btn" style="display: none;">
                            			<a href="<?= base_url(); ?>account/update_tagline" class="upd-des">
                            				<i class="fa fa-check"></i>
                            			</a>

                            			<a href="javascript:void(0);" class="upd-des-c">
                            				<i class="fa fa-times"></i>
                            			</a>
                            		</div>

                            		<div class="loader loader-de">
                            			<img src="<?= base_url(); ?>assets/frontend/images/loader.gif" />
                            		</div>
                            	</div>
                        	<?php } else { ?>	
                    	 	<?= ($tagline != '' ) ? '<p class="text-center">' . $tagline . '</p>' : ''; ?>
				            <?php } ?> 	
                        </div>
					</div>
				</div>

				<div class="col-md-8">
					<div class="dso-profile-top-meta">
						<div class="dso-player-meta">
							<div class="dso-icon-sm">
								<div class="dso-role-icon ion-ios-game-controller-b"></div>
								<span class="dso-player-info-title">Tournaments Played</span>
							</div>
							<p>0</p>
						</div>

						<div class="dso-player-meta">
							<div class="dso-icon-sm">
								<div class="dso-role-icon ion-trophy"></div>
								<span class="dso-player-info-title">Win Rate</span>
							</div>
							<p>0.00%</p>
						</div>

						<div class="dso-player-meta">
							<div class="dso-icon-sm">
								<div class="dso-role-icon ion-eye"></div>
								<span class="dso-player-info-title">Profile Views</span>
							</div>
							<p><?= empty($profileViews) ? 0 : $profileViews; ?></p>
						</div>

						<div class="dso-player-meta">
							<div class="dso-icon-sm">
								<div class="dso-role-icon ion-ios-videocam"></div>
								<span class="dso-player-info-title">Videos Posted</span>
							</div>
							<p>0</p>
						</div>
					</div>

					<div class="item-right">
						<?php 
							$followersCount = 0;
							$followingCount = 0;

							if(!empty($followers)) {
								$followersCount = count($followers);
							}

							if(!empty($following)) {
								$followingCount = count($following);
							}
						?>
						<?php if($this->session->userdata('user_id') == true) { ?>
							<?php if($profileData[0]->id != $this->session->userdata('user_id')) { ?>
								<?php 
									$userText = 'Follow';
									$flparam  = '1';
									//Calculate Followers and check if current user is a follower or not
									if(!empty($followers)) {
										if(in_array($this->session->userdata('user_id'), $followers)) {
											$userText = 'Follwing';
											$flparam  = '';
										} else {
											$userText = 'Follow';
											$flparam  = '1';
										}
									}
								?>
								<a href="<?= base_url(); ?>account/followPlayer/<?= $flparam; ?>" data-player="<?= $profileData[0]->id; ?>" class="btn dso-ebtn dso-ebtn-solid m-r-15 followPlayer">
			                        <span class="dso-btn-text"><?= $userText; ?></span>
			                        <div class="dso-btn-bg-holder"></div>
			                        <div class="btn-loader">
	                                    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
	                                </div>
			                    </a>

	                        	<a href="<?= base_url(); ?>account/messages/<?= $profileData[0]->username; ?>" class="btn dso-ebtn dso-ebtn-solid">
			                        <span class="dso-btn-text">Send Message</span>
			                        <div class="dso-btn-bg-holder"></div>
			                    </a>
			                <?php } else { ?>
			                	<?php if($edit == 0) { ?>	
			                	<a href="<?= base_url(); ?>profile/edit"class="btn dso-ebtn dso-ebtn-solid">
			                        <span class="dso-btn-text">Edit Profile</span>
			                        <div class="dso-btn-bg-holder"></div>
			                    </a> 
			                    <?php } else { ?>
			                    <a href="<?= base_url(); ?>profile"class="btn dso-ebtn dso-ebtn-outline">
			                        <span class="dso-btn-text">Back</span>
			                        <div class="dso-btn-bg-holder"></div>
			                    </a> 
			                    <?php } ?>
	                        <?php } ?>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="dso-profile-meta-info">
		<div class="row align-items-center">
			<div class="col-md-5">
				<?php 
					if($assocTeam != null) {
						$teamLogo   = $assocTeam['teamLogo'];
						$teamName   = $assocTeam['team_name'];
						$profileUrl = $assocTeam['profile_url']; 
					} else { 
						$teamLogo   = base_url() . 'assets/frontend/images/team-logo.png';
						$teamName   = 'No Team Joined';
						$profileUrl = '#'; 
					}
				?>
				<div class="sm-icon-box">
					<div class="icon-thumb">
						<img src="<?= $teamLogo; ?>" />
					</div>

					<div class="dso-sm-info-team">
						<h4><a href="<?= $profileUrl; ?>"><?= $teamName; ?></a></h4>
						<p>Team</p>
					</div>
				</div>
			</div>

			<div class="col-md-7">
				<div class="d-flex align-items-center justify-content-end">
					<div class="dso-follow-profile m-r-15">
						<h4>Followers : </h4>
						<span class="playerFollowersCount m-l-5" data-count="<?= $followersCount; ?>"><?= $followersCount; ?></span>
					</div>

					<div class="dso-follow-profile m-r-15">
						<h4>Following : </h4>
						<span class="playerFollowingCount m-l-5" data-count="<?= $followingCount; ?>"><?= $followingCount; ?></span>
					</div>

					<div class="dso-follow-profile">
						<h4>Follow : </h4>

						<?php 
							$user_social = $meta->get_user_meta('user_social_contact', $profileData[0]->id);

							if($user_social) {
								$social_data = unserialize($user_social);
						?>
								<ul class="ft-social">
						<?php	foreach($social_data as $platform => $url):
									if($url != null) {
						?>	
									<li>
										<a href="<?= $url; ?>" target="_blank">
											<i class="fab fa-<?= $platform; ?>"></i>
										</a>
									</li>
								<?php } ?>
							<?php endforeach; ?>
								</ul>
						<?php } else { ?>
						<p>Socialy Inactive</p>	
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="content-box m-b-40">
			<div class="dso-lg-content m-b-20">
                <h3>About Player</h3>
            </div>

            <?php 
        		$get_description = $meta->get_user_meta('user_description', $profileData[0]->id);
        		
        		$description = '';
        		
        		if($get_description != '') {
        			$description = $get_description;
        		}
        	?>
			<?php if($edit == 1) { ?>	
				<textarea name="p-desc" class="form-control p-update" data-p="update-btn" rows="8"><?= nl2br($description); ?></textarea>
				<div class="update-btn mg-t-20 btn-row justify-content-end" style="display: none;">
					<a href="<?= base_url(); ?>account/update_description" class="upd-desc btn dso-ebtn dso-ebtn-solid">
						<span class="dso-btn-text">Update Description</span>
						<div class="dso-btn-bg-holder"></div>
					</a>
				</div>

				<div class="loader loader-des">
        			<img src="<?= base_url(); ?>assets/frontend/images/loader.gif" />
        		</div>
			<?php } else { ?>	
			<p class="text-white text-lg-2">
            	<?= nl2br($description); ?>
			</p>
            <?php } ?>	
		</div>

		<div class="content-box m-b-40">
			<div class="dso-lg-content m-b-20">
                <h3>Streams</h3>
            </div>

            <?php if($edit == 0) { ?>
			<div class="dso-video-wrapper flex-3">
				<?php if(count($videoData) == 0) { ?>
					<div class="dso-inner-404">
						<img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
						<h2>No Streams Found</h2>
					</div>
				<?php } else { ?>		
				<?php foreach($videoData as $video): ?>
					<div class="dso-video-box">
						<div class="dso-video-frame">
							<?php 
								if($video->thumbnail == '') {
									$video_thumnail = 'no-thumbnail.jpg';
								} else {
									$video_thumnail = 'user-'. $video->user_id . '/' . $video->thumbnail;
								}
							?>
							<img src="<?= base_url(); ?>assets/frontend/videos/<?= $video_thumnail; ?>" />
						</div>

						<div class="dso-video-content">
							<?= ($video->video_type != 'custom') ? '<span>' . strtoupper($video->video_type) . '</span>' : ''; ?>
							<h4><?= $video->title; ?></h4>
						</div>

						<div class="dso-icon-mid">
							<a href="javascript:void(0);" class="btn btn-circle play-video" data-url="<?= $video->video_url; ?>"><div class="icon-full ion-ios-play-outline"></div></a>
						</div>

						<?php if($edit == 1) { ?>
						<div class="dso-btn-actions">
							<a href="<?= base_url() . 'videos/create/' . $video->id; ?>">
								<div class="dso-manage-icon ion-edit"></div>
							</a>
							<a href="<?= base_url() . 'videos/delete/' . $video->id; ?>">
								<div class="dso-manage-icon ion-ios-trash-outline"></div>
							</a>
						</div>
						<?php } ?>
					</div>
				<?php endforeach; ?>
				<?php } ?>
			</div>
			<?php } else { ?>	
			<a href="<?= base_url(); ?>videos" class="btn btn-red">Edit My Videos</a>
            <?php } ?>
        </div>

        <?php if($edit == 0) { ?>
		<div class="dsoreg-banner">
			<div class="dsoreg-inner-banner">
				<div class="row align-items-center">
					<div class="col-md-7">
						<div class="dso-lg-content">
							<span class="sm-text">Excited To Join</span>
		                    <h1>
		                        <span>Let's Not Wait</span>
		                        Enroll Today and Start Gaming
		                    </h1>
		                </div>
					</div>

					<div class="col-md-5">
						<a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Register</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a>
					</div>
				</div>
			</div>	
		</div>
		<?php } ?>
	</div>
</div>


<!-- <section class="u-prof">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div id="item-header" role="complementary">
					<?php 
                		$get_cover = $meta->get_user_meta('user_cover_picture', $profileData[0]->id);
                		
                		if($get_cover == null) {
                			$cover_url = '';
                			$has_class = '';
                		} else {
                			$cover_url = "background: url('". base_url() . "assets/uploads/users/user-" . $profileData[0]->id . "/" . $get_cover . "');";
                			$has_class = ' no-overlay';
                		}
                	?>

				    <div id="header-cover-image" class="element-animated fade-in <?= $has_class; ?>" style="opacity: 1; <?= $cover_url; ?>"></div>
				    <div id="profile-header" class="profile-header profile-header--member">
				    	<?php if($user_profile == 0) { ?>
					    	<?php if($edit == 0) { ?>	
						    	<a href="<?= base_url(); ?>profile/edit" class="edit-p">
						    		<i class="fa fa-pencil"></i>
						    		 Edit Profile
						    	</a>
					    	<?php } else { ?>
					    		<a href="<?= base_url(); ?>profile" class="edit-p bck-b">Back</a>
					    		<a href="javascript:void(0);" class="edit-p edit-cp" data-value="Cover Photo">
						    		<i class="fa fa-camera"></i>
						    	</a>
				    		<?php } ?>
				    	<?php } ?>
				        <div id="profile-header-content">
				            <div class="container container--medium h-100">
				                <div class="row align-items-start align-items-lg-end h-100 pos-r">
				                    <div class="profile-header__avatar col-auto">
				                        <a class="avatar-wrapper">
				                        	<?php 
				                        		$get_image = $meta->get_user_meta('user_image', $profileData[0]->id);
				                        		
				                        		if($get_image == null) {
				                        			$image_url = base_url() . 'assets/frontend/images/default.png';
				                        		} else {
				                        			$image_url = base_url() . 'assets/uploads/users/user-' . $profileData[0]->id . '/' . $get_image;
				                        		}
				                        	?>
				                            <img loading="lazy" src="<?= $image_url; ?>" class="avatar user-25-avatar avatar-450 photo" width="450" height="450" alt="Profile picture of Andre Dubus">
				                        </a>
				                        <?php if($edit == 1) { ?>	
				                        	<a href="javascript:void(0);" class="edit-dp edit-cp" data-value="Profile Photo">
									    		<i class="fa fa-camera"></i>
									    	</a>
									    	<div class="overwrap"></div>
				                        <?php } ?>
				                    </div>

				                    <div class="profile-header__body col-12 col-md pt-4 pt-md-0">
				                        <div class="row align-items-lg-end">
				                            <div class="col-12 col-lg order-2">
				                                <div class="item-sumary">
				                                    <h2 class="user-nicename"><span class="user-nicename-at">@</span><?= $profileData[0]->username; ?></h2>
				                                    <div class="item-summary__meta">
				                                        <div class="bp-member-xprofile-custom-fields"></div>
				                                    </div>
				                                </div>

				                                <div class="item-description">
				                                	<?php 
				                                		$get_tagline = $meta->get_user_meta('user_tagline', $profileData[0]->id);

				                                		if($get_tagline == '') {
				                                			$tagline = 'Yout Tagline Goes Here';
				                                		} else {
				                                			$tagline = $get_tagline;
				                                		}
				                                	?>
				                                	<?php if($edit == 1) { ?>	
				                                		<div class="inner-descrip">
					                                		<input type="text" class="form-control p-update p-tagline" data-p="upd-btn" name="tagline" value="<?= $tagline; ?>">
					                                		<div class="upd-btn" style="display: none;">
					                                			<a href="<?= base_url(); ?>account/update_tagline" class="upd-des">
					                                				<i class="fa fa-check"></i>
					                                			</a>

					                                			<a href="javascript:void(0);" class="upd-des-c">
					                                				<i class="fa fa-times"></i>
					                                			</a>
					                                		</div>

					                                		<div class="loader loader-de">
					                                			<img src="<?= base_url(); ?>assets/frontend/images/loader.gif" />
					                                		</div>
					                                	</div>
				                                	<?php } else { ?>	
				                                    	<?= $tagline; ?>
				                                    <?php } ?>								
				                                </div>

				                                <?php if($profileData[0]->id != $this->session->userdata('user_id')) { ?>
				                                	<a href="<?= base_url(); ?>account/messages/<?= $profileData[0]->username; ?>" class="btn btn-red btn-curved">
				                                		<i class="fa fa-comment"></i> Message	
				                                	</a>
				                                <?php } ?>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>	

			<div class="col-md-8">
				<div class="main-tr-content">
					<div class="trou-counter">
						<div class="row">
							<div class="col-md-4">
								<div class="tr-info-box">
									<span class="tr-icon">
										<i class="fa fa-trophy"></i>
									</span>

									<div class="tr-content">
										<h3>0</h3>
										<p>Tournaments Played</p>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="tr-info-box">
									<span class="tr-icon">
										<i class="fa fa-eye"></i>
									</span>

									<div class="tr-content">
										<h3>0</h3>
										<p>Profile Views</p>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="tr-info-box">
									<span class="tr-icon">
										<i class="fa fa-video"></i>
									</span>

									<div class="tr-content">
										<h3><?= count($videoData); ?></h3>
										<p>Videos Posted</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="content-ar">
						<h2>Connect Me</h2>

						<?php 
							$user_social = $meta->get_user_meta('user_social_contact', $profileData[0]->id);

							if($user_social) {
								$social_data = unserialize($user_social);
								echo '<ul class="social-connect">';
								foreach($social_data as $platform => $url):
									if($url != null) {
						?>	
									<li>
										<a href="<?= $url; ?>" target="_blank">
											<i class="fab fa-<?= $platform; ?>"></i>
										</a>
									</li>
								<?php } ?>
							<?php endforeach; ?>
								</ul>
						<?php } else { ?>
						<p>Socialy Inactive</p>	
						<?php } ?>
					</div>

					<div class="content-ar">
						<h2>About Me</h2>
						<?php 
                    		$get_description = $meta->get_user_meta('user_description', $profileData[0]->id);

                    		if($get_description == '') {
                    			$description = 'Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget.';
                    		} else {
                    			$description = $get_description;
                    		}
                    	?>
						<?php if($edit == 1) { ?>	
							<textarea name="p-desc" class="form-control p-update" data-p="update-btn" rows="8"><?= nl2br($description); ?></textarea>
							<div class="update-btn" style="display: none;">
								<a href="<?= base_url(); ?>account/update_description" class="upd-desc btn btn-red">Update Description</a>
							</div>

							<div class="loader loader-des">
                    			<img src="<?= base_url(); ?>assets/frontend/images/loader.gif" />
                    		</div>
						<?php } else { ?>	
						<p>
                        	<?= $description; ?>
						</p>
                        <?php } ?>		
					</div>

					<div class="content-ar">
						<h2>My Videos</h2>
						
						<?php if($edit == 0) { ?>
						<div class="my_videos">
							<?php if(count($videoData) == 0) { ?>
								<div class="no-video">
									<h2>No Videos Posted</h2>
									<i class="fa fa-video-slash"></i>
								</div>
							<?php } else { ?>		
							<?php foreach($videoData as $video): ?>
							<div class="col-md-4">
								<div class="video-box">
									<div class="iframe">
										<?php if($video->video_type == 'custom') { ?>
											<video width="320" height="240" controls  src="<?= base_url() . 'assets/frontend/videos/users/user-'.$video->user_id.'/'. $video->video_url; ?>" type="video/mp4">
											</video>								
										<?php } ?>
										
										<?php if($video->video_type == 'youtube') { ?>
											<iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video->video_url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										<?php } ?>
									</div>

									<div class="video_details">
										<h4><?= $video->title; ?></h4>
										<p>
											<i class="fa fa-eye"></i> 
											<?php //$video->views; ?>0 Views
										</p>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
							<?php } ?>
						</div>
						<?php } else { ?>	
						<a href="<?= base_url(); ?>videos" class="btn btn-red">Edit My Videos</a>
                        <?php } ?>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="tr-sidebar">
					<div class="box-wrap-bar">
						<div class="box-wrap-content">
							<h2>Active Members</h2>

							<div class="tr-content-inner">
								<?php include  'includes/active-members.php'; ?>
							</div>
						</div>
					</div>

					<div class="box-wrap-bar">
						<div class="box-wrap-content">
							<h2>Recently Joined</h2>

							<div class="tr-content-inner">
								<?php include  'includes/recently-joined.php'; ?>
							</div>
						</div>
					</div>

					<div class="box-wrap-bar">
						<div class="box-wrap-content">
							<h2>Associated Team</h2>

							<?php if($assocTeam != null) { ?>
							<div class="teambox">
								<div class="team-icon">
	                                <img src="<?= $assocTeam['teamLogo']; ?>">
	                            </div>
	                            
	                            <div class="team-content">    
	                            	<h3><?= $assocTeam['team_name']; ?></h3>
	                                <p>15 Tournaments Win</p>
	                                <a href="<?= $assocTeam['profile_url']; ?>">VIEW CHANNEL</a>
	                            </div>
	                        </div>
	                    	<?php } else { ?>
	                    	<div class="err-404">
	                    		<h3>Not Associated With Any Team</h3>
	                    	</div>
	                    	<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->

<?php if($edit == 1) { ?>
<div id="updateImage" class="modal" role="dialog">
	<div class="modal-close js-close-modal" data-dismiss="modal" aria-label="Close">
		<img class="svg" src="<?= base_url(); ?>assets/frontend/images/modal-close.svg" />
	</div>

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update <span class="p-title"></span></h4>
			</div>

			<div class="modal-body">
				<form method="POST" action="<?= base_url(); ?>account/update_user_picture" enctype="multipart/form-data">
					<p>Minimum Required Dimensions <span class="dimension"></span></p>
					<div class="form-group">
						<label>Select Image</label>
						<input type="file" name="update_image" class="form-control" accept="image/png, image/gif, image/jpeg, , image/jpg" />
					</div>

					<input type="hidden" name="update_value" class="form-control" value="">
					<input type="hidden" name="target_loc" value="default" />

					<div class="btn-row justify-content-end">
						<button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Update Photo</span>
                            <div class="dso-btn-bg-holder"></div>
                        </button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
<?php } ?>