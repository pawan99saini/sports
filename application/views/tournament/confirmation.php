<div class="form-process-step">
	<div class="row">
		<div class="col-md-12">
			<div class="success-content">
				<div class="img-top">
					<img src="<?= base_url(); ?>assets/frontend/images/success.png" />
				</div>

				<h2>Congratulations</h2>
				<p>You Are All Set Your Tournament is live now. <strong>What's Next!</strong></p>

                <a href="<?= $tournament_url; ?>" class="btn dso-ebtn dso-ebtn-solid">
                    <span class="dso-btn-text">View Tournament</span>
                    <div class="dso-btn-bg-holder"></div>
                </a>

                <div class="row">
                    <div class="col-md-12 m-t-40">
                        <h3>Add Spectators</h3>
                        <form method="POST" action="<?= base_url(); ?>account/add_spectators" onsubmit="return false;" class="add-spectators-process">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="Email">Email / Username</label>
                                        <input type="text" class="form-control search-invite-user" data-location="<?= base_url(); ?>account/search_member" data-type="add_spectators" name="email" />
                                        <a href="javascript:void(0);" class="empty-invite-field"><i class="fa fa-times-circle"></i></a>
                                    </div>

                                    <div class="btn-row">
                                        <div class="loader-sub" id="invite-player-load">
                                            <div class="lds-ellipsis">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="users-list"></div>
                                </div>
                            </div>

                            <input type="hidden" name="tournamentID" value="<?= $tournamentID; ?>" />
                        </form>

                        <div class="spectators-list"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>