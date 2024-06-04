<div class="form-process-step form-step-6">
	<div class="row">
		<div class="col-md-12">
			<div class="success-content">
				<div class="img-top">
					<img src="<?= base_url(); ?>assets/frontend/images/success.png" />
				</div>

				<?php if(count($tournamentData) > 0) { ?>
				<h2>All Set!</h2>
				<p>your changes have been successfully updated you cna now publish your changes</p>
				<?php } else { ?> 
				<h2>Congratulations</h2>
				<p>You Are All Set To Publish Your Tournament</p>
				<?php } ?> 

				<button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                    <span class="dso-btn-text">Publish</span>
                    <div class="dso-btn-bg-holder"></div>
                </button>
			</div>
		</div>
	</div>
</div>