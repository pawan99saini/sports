<div class="dso-main">
	<div class="team-recruit-banner">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-md-5">
	                <div class="dso-lg-content">
	                    <h1>
	                        Account
	                        <span>Settings</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">Mannage your account settings</p>
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
                        Account Settings
                    </h1>
                </div>

                <div class="dso-col-light">
                	<div class="nav-tabs">
		                <a href="#general" class="dso-nav-tabs dso-nav-current">General</a>
		                <a href="#password" class="dso-nav-tabs">Account Password</a>
		                <a href="#contact" class="dso-nav-tabs">Contact</a>
		            </div>

		            <div class="dso-tab-wrapper active-nav-tab" id="general">
		            	<div class="content-box">
		                    <div class="dso-lg-content m-b-20">
		                        <h3>General</h3>
		                    </div>

		                    <form method="POST" action="<?= base_url(); ?>account/general_info">
	                            <div class="row">
	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname">First name</label>
	                                        <input type="text" class="form-control" name="fname" value="<?= $profileData[0]->first_name; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname">Last name</label>
	                                        <input type="text" class="form-control" name="lname" value="<?= $profileData[0]->last_name; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-12">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="Email">Email</label>
	                                        <input type="email" class="form-control" name="email" value="<?= $profileData[0]->email; ?>" readonly >
	                                    </div>
	                                </div>

	                                <div class="col-md-12">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname">Platform (i.e. xbox - pc)</label>
	                                        <input type="text" class="form-control" name="platform" value="<?= $profileData[0]->platform; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="Email">Discord Username</label>
	                                        <input type="text" class="form-control" name="discord_username" value="<?= $profileData[0]->discord_username; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="Email">Username On Console</label>
	                                        <input type="text" class="form-control" name="console_username" value="<?= $profileData[0]->console_username; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-12 team-info" id="team" style="display: <?= $profileData[0]->type == 'team' ? 'block' : 'none'; ?>"> 
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname">Platform Play On</label>
	                                        <input type="text" class="form-control" name="game_platform" value="<?= $profileData[0]->game_platform; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-12">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="Email">Country</label>
	                                        <input type="text" class="form-control" name="country" value="<?= $profileData[0]->country; ?>" >
	                                    </div>
	                                </div>

	                                <div class="col-md-12">
	                                	<?php 
	                                		$games = @unserialize($profileData[0]->interested_game);
	                                		if($games !== false) {
	                                			$games = $games;
	                                		} else {
	                                			$games = array($profileData[0]->interested_game);
	                                		}
	                                	?>
	                                    <div class="form-group">
	                                        <label class="text-white text-lg-2">Game Interested</label>
	                                        <select class="select2 select2-multiple" multiple="multiple" data-placeholder=" -- Select Game -- " style="width: 100%;" name="interested_game[]" >
	                                            <?php foreach($gamesData as $game): ?>   
	                                                <option value="<?= $game->game_id; ?>"
	                                                	<?php if(in_array($game->game_id, $games)) {
	                                                		echo ' selected';
	                                                	}
	                                                	?>
	                                                	><?= $game->game_name; ?></option>
	                                            <?php endforeach; ?>
	                                        </select>
	                                    </div>
	                                </div>

	                                <div class="col-md-12">
	                                     <div class="dso-btn-row">
	                                        <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Update Details</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>

	                                        <div class="loader-sub" id="login-load">
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
	                        </form>
		                </div>
		            </div>

		            <div class="dso-tab-wrapper" id="password">
		            	<div class="content-box">
		                    <div class="dso-lg-content m-b-20">
		                        <h3>Account Password</h3>
		                    </div>

		            		<form action="<?= base_url(); ?>account/account_password">
	                            <div class="row">
	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname">Old Password</label>
	                                        <input type="password" class="form-control" name="old" >
	                                    </div>
	                                </div>

	                                <div class="col-md-6"></div>

	                                <div class="col-md-6">
	                                   <div class="form-group dso-animated-field-label">
	                                        <label for="fname">New Password</label>
	                                        <input type="password" class="form-control" name="new" >
	                                    </div>
	                                </div>

	                                <div class="col-md-6">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="Email">Confirm Password</label>
	                                        <input type="password" class="form-control" name="confirm" >
	                                    </div>
	                                </div>		                                

	                                <div class="col-md-12">
	                                	<div class="dso-btn-row">
	                                        <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Update Password</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>

	                                        <div class="loader-sub" id="login-load">
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
	                        </form>
	                    </div>
		            </div>

		            <div class="dso-tab-wrapper" id="contact">
		            	<div class="content-box">
		                    <div class="dso-lg-content m-b-20">
		                        <h3>Contact</h3>
		                    </div>

		            		<form action="<?= base_url(); ?>account/update_contact" method="POST">
	                            <div class="row">
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <label for="fname">Who can Contact Me</label>
	                                        <?php 
	                                        	$user_contact = $meta->get_user_meta('user_contact', $profileData[0]->id);
	                                        ?>
	                                        <div class="inline-item">
		                                        <div class="inline-radio">
			                                        <input type="radio" class="form-control" name="contact_method" value="all" <?= ($user_contact == 'all') ? 'checked' : ''; ?> />
			                                        <span>Everyone</span>
			                                    </div>

			                                    <div class="inline-radio">
			                                        <input type="radio" class="form-control" name="contact_method" value="team" <?= ($user_contact == 'team') ? 'checked' : ''; ?> />
			                                        <span>Team Members</span>
			                                    </div>
			                                </div>
	                                    </div>
	                                </div>

	                                <div class="dso-lg-content m-b-20">
				                        <h3>Social Media</h3>
				                    </div>

	                                <?php 
	                                	$user_social = $meta->get_user_meta('user_social_contact', $profileData[0]->id);
	                                	$user_social = unserialize($user_social);
	                                	$social_platform = array('facebook', 'twitter', 'twitch', 'youtube', 'instagram', 'discord');
	                                ?>

	                                <?php foreach($social_platform as $platform): ?>
	                                <div class="col-md-12">
	                                    <div class="form-group dso-animated-field-label">
	                                        <label for="fname"><?= ucfirst($platform); ?></label>
	                                        <input type="text" class="form-control" name="social_url[]" value="<?= isset($user_social[$platform]) ? $user_social[$platform] : ''; ?>" />
	                                    </div>
	                                    <input type="hidden" class="form-control" name="social_platform[]" value="<?= $platform; ?>" />
	                                </div>
	                                <?php endforeach; ?>

	                                <div class="col-md-12">
	                                    <div class="dso-btn-row">
	                                        <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Update Contact Details</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>

	                                        <div class="loader-sub" id="login-load">
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
	                        </form>
	                    </div>
		            </div>
	            </div>
            </div>
        </div>
    </div>
</div>