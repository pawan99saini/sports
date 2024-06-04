<div class="dso-main">
	<div class="dso-page-bannner dso-banner-overlay dso-videos-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1>
                        	Manage My
                        	<span>Videos</span>
                        </h1>
                        <p data-aos-delay="300" data-aos="fade-up">Manage your channel these videos will be seen by all other users on this website</p>
                    </div>
                </div>

                <div class="col-md-3">
                    
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
                <div class="dso-lg-content dso-flex align-items-center">
                    <h1>
                        Create Video
                    </h1>

                    <div class="item-right">
                        <a href="<?= base_url(); ?>account/videos/" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Back</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a> 
                    </div>
                </div>

                <div class="dso-col-light">
					<div class="content-box">
                        <div class="dso-main-form">
							<form method="POST" action="<?= base_url() . 'account/processVideo'; ?>" class="create-tournament-form" enctype="multipart/form-data">
								<div class="message-box" style="display: none;">
									<div class="message"></div>
								</div>

                                <div class="form-group dso-animated-field-label">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="<?= $title; ?>" />
                                </div>

                                <div class="form-group">
                                    <label>Video Thumbnail</label>
                                    <input type="file" name="thumbnail" class="form-control" />
                                    <input type="hidden" name="thumbnail_file" class="form-control" value="<?= $thumbnail_file; ?>" />
                                </div>

                                <div class="form-group">
                                    <label>Video Source</label>
                                    <select name="video_type" class="form-control" required>
                                        <option value="">Select Source</option>
                                        <option value="youtube" <?= ($video_type == 'youtube') ? 'selected' : ''; ?>>Youtube</option>
                                        <option value="vimeo" <?= ($video_type == 'vimeo') ? 'selected' : ''; ?>>Vimeo</option>
                                        <option value="dailymotion" <?= ($video_type == 'dailymotion') ? 'selected' : ''; ?>>Dailymotion</option>
                                        <option value="custom" <?= ($video_type == 'custom') ? 'selected' : ''; ?>>Upload Video</option>
                                    </select>
                                </div>

                                <div class="form-group url_video" style="display: <?= ($video_type == 'youtube') ? 'block' : 'none'; ?>;">
                                    <label>Video Url</label>
                                    <div class="inline-input">
                                        <input type="text" name="video_text" class="form-control" readonly />
                                        <input type="text" name="video_url" class="form-control" value="<?= $video_url; ?>" />
                                    </div>
                                </div>	

                                <div class="form-group upload_video" style="display: <?= ($video_type == 'custom') ? 'block' : 'none'; ?>;">
                                    <label>Video File</label>
                                    <input type="file" name="video_file" class="form-control" />
                                </div>						

                                <div class="video-player" style="display: <?= ($video_type == 'custom') ? 'block' : 'none'; ?>;">
                                    <video width="320" height="240" controls>
                                        <source src="<?= base_url() . 'assets/frontend/videos/users/user-'.$user_id.'/'. $video_url; ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>

                                <input type="hidden" name="id" value="<?= $id; ?>" />

                                <div class="dso-btn-row">
									<button type="submit" class="btn dso-ebtn dso-ebtn-solid ">
	                                    <span class="dso-btn-text">Submit</span>
	                                    <div class="dso-btn-bg-holder"></div>
	                                </button>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>