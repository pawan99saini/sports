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
                        Manage Videos
                    </h1>

                    <div class="item-right">
                        <a href="<?= base_url(); ?>account/videos/create"class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Create A Video</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a> 
                    </div>
                </div>

                <div class="dso-col-light">
					<div class="content-box">
						<div class="dso-video-wrapper flex-50">
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
									<a href="<?= base_url() . 'account/getVideo'; ?>" class="btn btn-circle play-video" data-id="<?= $video->id; ?>">
										<div class="icon-full ion-ios-play-outline"></div>
									</a>
								</div>

								<div class="dso-btn-actions">
									<a href="<?= base_url() . 'account/videos/create/' . $video->id; ?>">
										<div class="dso-manage-icon ion-edit"></div>
									</a>
									<a href="<?= base_url() . 'account/videos/delete/' . $video->id; ?>">
										<div class="dso-manage-icon ion-ios-trash-outline"></div>
									</a>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
	                </div>
	            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="video-player" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title video-title">Notice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
    
            <div class="modal-body">
                <div class="video-player"></div>
            </div>

            <div class="loader-wrapper load-video" style="display: none;">
                <div class="loader-sub" id="login-video-player" style="display: block;">
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
</div>