<?php
	$title = '';
	$category_id = '';
	$game_id = '';
	$description = '';
	$contact = '';
	$current_file = '';
	
	if(count($tournamentData) > 0) {
		$title = $tournamentData[0]->title;
		$category_id = $tournamentData[0]->category_id;
		$game_id = $tournamentData[0]->game_id;
		$description = $tournamentData[0]->description;
		$contact = $tournamentData[0]->contact;
		$current_file = $tournamentData[0]->image;
			
	} 
?>

<div class="dso-main">
	<div class="dso-page-bannner dso-banner-overlay dso-videos-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1>
                        	Manage
                        	<span>Tournaments</span>
                        </h1>
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
                        Create Tournament
                    </h1>

                    <div class="item-right">
                        <a href="<?= base_url(); ?>account/tournaments"class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Back</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a> 
                    </div>
                </div>

                <div class="dso-col-light">
					<div class="content-box">
						<div class="form-progress">
							<ul id="progressbar">
							    <li class="active step-1">Overview</li>
							    <li class="step-2">Basic Details</li>
							    <li class="step-3">Prize Pool</li>
							    <li class="step-4">Statistics</li>
							    <li class="step-5">Settings</li>
							    <li class="step-6">Confirmation</li>
							 </ul>
						</div>

						<div class="dso-main-form">
							<form method="POST" action="<?= base_url() . 'account/processTournament'; ?>" class="create-tournament-form" onsubmit="return false;" enctype="multipart/form-data">
								<div class="message-box" style="display: none;">
									<div class="message"></div>
								</div>
								<div class="form-steps">
									<div class="form-process-step form-step-1">
										<div class="row">
											<div class="col-md-12">
	                                            <div class="form-group dso-animated-field-label">
	                                                <label for="fname">Title</label>
	                                                <input type="text" class="form-control" name="title" value="<?= $title; ?>"  required >
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
				                                    <label class="form-label text-white text-lg-2">Select Category</label>
				                                    <select name="category_id" class="form-control" required>
				                                        <option value="">Select Category</option>    
				                                        <?php foreach($categoriesData as $category): ?>  
				                                        <?php
				                                        	$selected = '';

				                                        	if($category->id == $category_id) {
				                                        		$selected = 'selected';
				                                        	}
				                                        ?>  
				                                        <option value="<?php echo $category->id; ?>" <?= $selected; ?>><?php echo $category->title; ?></option>
				                                        <?php endforeach; ?> 
				                                    </select>
				                                </div>
	                                        </div>

	                                        <div class="col-md-6">
		                                        <div class="form-group">
				                                    <label class="form-label text-white text-lg-2">Select Game</label>
				                                    <select name="game_id" class="form-control" required>
				                                        <option value="">Select Game</option>    
				                                        <?php foreach($gamesData as $game): ?>   
				                                        <?php
				                                        	$selected = '';

				                                        	if($game->game_id == $game_id) {
				                                        		$selected = 'selected';
				                                        	}
				                                        ?> 
				                                        <option value="<?php echo $game->game_id; ?>" <?= $selected; ?>><?php echo $game->game_name; ?></option>
				                                        <?php endforeach; ?> 
				                                    </select>
				                                </div>
				                            </div>

				                            <div class="col-md-12">
					                            <div class="form-group">
				                                    <label class="form-label text-white text-lg-2">Overview</label>
				                                    <textarea name="description" id="editorRichText" class="content1 form-control" data-target="content1" rows="12"><?= $description; ?></textarea>
				                                </div>
				                            </div>

				                            <div class="col-md-12">
					                            <div class="form-group">
				                                    <label class="form-label text-white text-lg-2">Contact</label>
				                                    <textarea name="contact" id="editorRichText" class="content2 form-control" data-target="content2" rows="12"><?= $contact; ?></textarea>
				                                </div>
				                            </div>

			                                <div class="form-group col-md-6">
			                                    <label class="form-label text-white text-lg-2">Featured Image</label>
			                                    <input type="file" name="tournament_image" class="form-control" <?= empty($current_file) ? ' required' : ''; ?> />
			                                    <?php if(!empty($current_file)) { ?>
			                                    <input type="hidden" name="current_file" value="<?= $current_file; ?>">
			                                    <?php } ?>
			                                </div>
			                            </div>
									</div>
								</div>

								<input type="hidden" name="tournamentID" value="<?= $tournamentID; ?>" />

								<div class="dso-btn-row">
									<div class="btn-wrap-prev"></div>
									<button type="button" class="btn dso-ebtn dso-ebtn-solid process-next" data-target="2">
	                                    <span class="dso-btn-text">Next</span>
	                                    <div class="dso-btn-bg-holder"></div>
	                                </button>
								</div>

								<div class="loader-full"  id="login-tournament">
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

							<div class="confirmation-tournament"></div>
						</div>
	                </div>
	            </div>
            </div>
        </div>
    </div>
</div>
