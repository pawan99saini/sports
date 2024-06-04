<div class="avatar-block">
	<?php $i = 1; ?>
	<?php $count = 0; ?>
	<?php foreach($activeMembers as $atc_member): ?>
	<?php if($this->session->userdata('user_id') != $atc_member->id) { ?> 
	<?php if($i <= 8) { ?>
	<div class="item-avatar">
		<a href="<?= base_url() . 'profile/' . $atc_member->username; ?>" class="bp-tooltip" data-bp-tooltip="James Smith">
			<?php 
        		$get_image = $meta->get_user_meta('user_image', $atc_member->id);
        		
        		if($get_image == null) {
        			$image_url = base_url() . 'assets/frontend/images/default.png';
        		} else {
        			$image_url = base_url() . 'assets/frontend/uploads/users/user-' . $atc_member->id . '/' . $get_image;
        		}
        	?>
			<img loading="lazy" src="<?= $image_url; ?>" class="avatar user-57-avatar avatar-50 photo entered lazyloaded" width="50" height="50" alt="Profile picture of James Smith" data-lazy-src="<?= $image_url; ?>" data-ll-status="loaded">
		</a>
	</div>
	<?php $count = $count + 1; ?>
	<?php } ?>
	<?php $i++; ?>
	<?php } ?>
	<?php endforeach; ?>

	<?php if($count == 0) { ?>
	<div class="not-found">
		<h2>No One Active At The Moment!</h2>
	</div>
	<?php } ?>
</div>