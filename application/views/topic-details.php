<div class="dso-post-discussion">
    <div class="dso-post-header">
        <div class="dso-post-meta">
            <span><?= date('d F, Y', strtotime($date_created)); ?></span>
            <span><?= $views; ?> Views</span>
            <span><?= count($postComments); ?> Comments</span>
        </div>
        <h2>
            <a><?= $post_title; ?></a>
        </h2>

        <a class="topic-back btn btn-red">Back</a>
    </div>

    <div class="dso-post-content">
    <?= '<p class="text-grey text-lg-2">' . nl2br($post_content) . '</p>'; ?>  
    </div>

    <div class="dso-post-comments">
    	<?php if(count($postComments) > 0) { ?>
		<?php foreach($postComments as $comment): ?>
		<div class="comment">
			<div class="thumb">
				<?php 
                    $get_image = $ci->get_user_meta('user_image', $comment->userID);
                    
                    if($get_image == null) {
                        $image_url = base_url() . 'assets/uploads/users/default.jpg';
                    } else {
                        $image_url = base_url() . 'assets/uploads/users/user-' . $comment->userID . '/' . $get_image;
                    }
                ?>
                <img src="<?= $image_url; ?>">
			</div>
			<div class="comment-content">
				<h4>
					<a href="<?= base_url() . 'profile/' . $comment->username; ?>"><?= $comment->first_name . ' ' . $comment->last_name; ?></a>
					<span>
						<i class="fa fa-calendar-alt"></i> 
						<?php 
							$dateMonth = date('F d', strtotime($comment->date_posted));
							$dateYear = date('Y', strtotime($comment->date_posted));
							$dateTime = date('H:i A', strtotime($comment->date_posted));
							echo $dateMonth .', '. $dateYear . ' at ' . $dateTime;
						?>
					</span>
				</h4>

				<p>
					<?= $comment->comment; ?>
				</p>
			</div>
		</div>
		<?php 
			endforeach;
			} else {
				echo '<h4>No Comments Posted</h4>';
			}
		?>
    </div>

    <div class="comment-form">
		<form method="POST" action="<?= base_url(); ?>account/post_comment" onsubmit="return false;" class="post-comment">
			<div class="form-group dso-animated-field-label">
				<label>Write Comment</label>
            	<textarea name="comment" class="form-control" rows="8"></textarea>
            </div>

            <input type="hidden" name="postID" value="<?= $postID; ?>" />
            <div class="dso-btn-row">
                <button type="submit" name="name" class="btn dso-ebtn dso-ebtn-solid">
                	<span class="dso-btn-text">Post Comment</span>
                	<div class="dso-ebtn-holder"></div>
                </button>

                <div class="loader-sub" id="loader">
                    <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
		</form>
	</div>
</div>
