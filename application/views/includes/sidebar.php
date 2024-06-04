<?php
	$user_role = $this->session->userdata('user_role');
	$userID    = $this->session->userdata('user_id');
	$profileData = $this->db->get_where('users', array('id' => $userID))->result();
    $teamData = $this->db->get_where('team_profile', array('userID' => $userID))->result();
?>

<div class="profile-data">
	<div class="dso-user-profile">
		<div class="dso-thumbail-circle">
			<?php 
        		$get_image = $meta->get_user_meta('user_image', $userID);
        		
        		if($get_image == null) {
        			$image_url = base_url() . 'assets/uploads/users/default.jpg';
        		} else {
        			$image_url = base_url() . 'assets/uploads/users/user-' . $this->session->userdata('user_id') . '/' . $get_image;
        		}
        	?>
            <img loading="lazy" src="<?= $image_url; ?>" />
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
    	 	<?= ($tagline != '' ) ? '<p class="text-center">' . $tagline . '</p>' : ''; ?>
        </div>
	</div>
</div>

<ul>
	<li>
		<a href="<?= base_url(); ?>my-account" <?= ($page_active == 'my_account') ? 'class="current-menu"' : ''; ?>><i class="fas fa-tachometer-alt"></i> Dashboard</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>account/videos" <?= ($page_active == 'videos') ? 'class="current-menu"' : ''; ?>><i class="far fa-file-video"></i> My Videos</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>account/messages"><i class="fas fa-comments"></i> Messages</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>profile"><i class="far fa-user"></i> My Profile</a>
	</li>
    
    <?php if(count($teamData) == 0) { ?>
	<li>
		<a href="<?= base_url(); ?>team/profile/create"><i class="fas fa-users"></i> Create Team Profile</a>
	</li>
    <?php } else { ?>
	<li>
		<a href="<?= base_url(); ?>team/profile/"><i class="fas fa-users"></i> Team Profile</a>
	</li>
	<?php } ?>

	<li>
		<a href="<?= base_url(); ?>spectator/apply"><i class="fas fa-binoculars"></i> Apply As Spectator</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>account/spectate-tournament" <?= ($page_active == 'spectate-tournament') ? 'class="current-menu"' : ''; ?>><i class="fas fa-binoculars"></i> Spectate Panel</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>careers"><i class="fas fa-briefcase"></i> Apply For A Job</a>
	</li>
	
	<li>
		<a href="<?= base_url(); ?>account/tournaments" <?= ($page_active == 'manage-tournaments') ? 'class="current-menu"' : ''; ?>><i class="ion-trophy"></i> Manage Tournaments</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>account/tournaments/create" <?= ($page_active == 'create-tournaments') ? 'class="current-menu"' : ''; ?>><i class="ion-trophy"></i> Create Tournament</a>
	</li>

    <li>
		<a href="<?= base_url(); ?>account/tournaments/attending" <?= ($page_active == 'attending-tournaments') ? 'class="current-menu"' : ''; ?>><i class="ion-trophy"></i> Tournaments Attending</a>
	</li>

	<li>
		<a href="<?= base_url(); ?>account/settings" <?= ($page_active == 'settings') ? 'class="current-menu"' : ''; ?>><i class="fas fa-cogs"></i> Settings</a>
	</li>
	
	<li>
		<a href="<?= base_url(); ?>home/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
	</li>
</ul>