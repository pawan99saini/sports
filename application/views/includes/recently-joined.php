<div class="avatar-block">
	<?php $i = 1; ?>
	<?php foreach($recentJoined as $recent_member): ?>
	<?php if($this->session->userdata('user_id') != $recent_member->id) { ?> 
	<?php if($i <= 8) { ?>
	<div class="item-avatar">
		<a href="<?= base_url() . 'profile/' . $recent_member->username; ?>" class="bp-tooltip" data-bp-tooltip="James Smith">
			<?php 
        		$get_image = $meta->get_user_meta('user_image', $recent_member->id);
        		
        		if($get_image == null) {
        			$image_url = base_url() . 'assets/frontend/images/default.png';
        		} else {
        			$image_url = base_url() . 'assets/uploads/users/user-' . $recent_member->id . '/' . $get_image;
        		}
        	?>
			<img loading="lazy" src="<?= $image_url; ?>" class="avatar user-57-avatar avatar-50 photo entered lazyloaded" width="50" height="50" alt="Profile picture of James Smith" data-lazy-src="<?= $image_url; ?>" data-ll-status="loaded">
		</a>
	</div>
	<?php } ?>
	<?php $i++; ?>
	<?php } ?>
	<?php endforeach; ?>
</div>