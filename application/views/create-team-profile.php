<div class="dso-main">
	<div class="team-recruit-banner">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-md-5">
	                <div class="dso-lg-content">
	                    <h1>
	                        Team
	                        <span>Mannagement</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">Mannage your team</p>
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
                        Create Team Profile
                    </h1>
                </div>

                <div class="dso-col-light">
					<div class="content-box">
                        <div class="dso-main-form">
							<form method="POST" action="<?= base_url() . 'account/processTeamProfile'; ?>" class="create-team-form" onsubmit="return false;" enctype="multipart/form-data">
								<div class="message-box" style="display: none;">
									<div class="message"></div>
								</div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="fname">Team Name</label>
                                            <input type="text" class="form-control" name="teamData[team_name]" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fname" class="form-label text-white text-lg-2">Logo</label>
                                            <input type="file" class="form-control" name="team_logo" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label text-white text-lg-2">Overview</label>
                                            <textarea name="teamMeta[description]" id="editorRichText" class="content1 form-control" data-target="content1" rows="12"></textarea>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-12">
                                        <div class="dso-lg-content m-b-20">
                                            <h3>Profile Settings</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-white text-lg-2">Header Background Image</label>
                                            <input type="file" class="form-control" name="header_background" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-white text-lg-2">Header Team Name Display</label>
                                            <div class="inline-item">
                                                <div class="inline-radio">
                                                    <input type="radio" name="teamMeta[team_name_show]" value="show" checked />
                                                    <span>Show</span>
                                                </div>
                                                <div class="inline-radio">
                                                    <input type="radio" name="teamMeta[team_name_show]" value="hide" />
                                                    <span>Hide</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-white text-lg-2">Header Team Logo</label>
                                            <div class="inline-item">
                                                <div class="inline-radio">
                                                    <input type="radio" name="teamMeta[team_logo_show]" value="show" checked />
                                                    <span>Show</span>
                                                </div>
                                                <div class="inline-radio">
                                                    <input type="radio" name="teamMeta[team_logo_show]" value="hide" />
                                                    <span>Hide</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>

                                <div class="dso-btn-row">
									<button type="submit" class="btn dso-ebtn dso-ebtn-solid">
	                                    <span class="dso-btn-text">Create Team</span>
	                                    <div class="dso-btn-bg-holder"></div>
	                                </button>
								</div>

								<div class="loader-full" id="create-team-loader">
									<div class="laoder-inner">
			                            <div class="lds-ellipsis">
			                                <div></div>
			                                <div></div>
			                                <div></div>
			                                <div></div>
			                            </div>
			                        </div>
			                    </div>
                            </form>    

                            <div class="team-members"></div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>