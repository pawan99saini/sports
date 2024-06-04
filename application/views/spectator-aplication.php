<div class="dso-team-recruit-main">
	<div class="team-recruit-banner" style="background: url('<?= base_url(); ?>assets/frontend/images/video-banner-bg.jpg');">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="dso-lg-content">
	                    <h1>
	                        Apply For a 
	                        <span>Spectator</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">You can also become a spectator if you think you are capable to do so join now!</p>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
        <div class="container">
        	<div class="row align-items-center">
        		<div class="col-md-7">
        			<div class="dso-lg-content">
                        <h3>
                           Submit Your Applicaiton
                        </h3>
                    </div>

                    <div class="dso-main-form">
                    	<form action="<?= base_url(); ?>home/processSpectatorApplication" class="spec-app" enctype="multipart/form-data" onsubmit="return false;">
			                <div id="msg-process"></div>

			                <div class="row">
			                    <div class="col-md-12">
			                        <div class="form-group dso-animated-field-label">
			                            <label for="Email">Email</label>
			                            <input type="email" class="form-control" name="email" required />
			                        </div>
			                    </div>

			                    <div class="col-md-12">
			                        <div class="form-group dso-animated-field-label">
			                            <label for="fname">Phone</label>
			                            <input type="text" class="form-control" name="phone" required />
			                        </div>
			                    </div>

			                    <div class="col-md-12">
			                        <div class="form-group dso-animated-field-label">
			                            <label for="fname">Discord Username</label>
			                            <input type="text" class="form-control" name="discord_username" required />
			                        </div>
			                    </div>

			                    <div class="col-md-12">
			                        <div class="form-group dso-animated-field-label">
			                            <label for="fname">Social Media ID (Any)</label>
			                            <input type="text" class="form-control" name="sm_id" required />
			                        </div>
			                    </div>

			                    <input type="hidden" class="form-control" name="id" value="<?= $id; ?>" />

			                    <div class="col-md-12">
			                        <div class="dso-btn-row">
			                            <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
			                            	<span class="dso-btn-text">Submit</span>
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

                <div class="col-md-5">
                    <div class="img-full">
                    	<img src="<?= base_url(); ?>assets/frontend/images/spectator-img.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>