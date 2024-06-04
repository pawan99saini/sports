<div class="dso-main">
	<div class="team-recruit-banner">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-md-5">
	                <div class="dso-lg-content">
	                    <h1>
	                        Tournament
	                        <span>Notice Board</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up"><?= $tournamentData[0]->title; ?></p>
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
                        Manage Announcement
                    </h1>
                </div>

				<div class="dso-col-light">
					<div class="content-box">
	                    <div class="acc-summary"> 
	                    	<?php 
	                            $messageUser = $this->session->flashdata('message');

	                            if(isset($messageUser)) {
	                                echo $messageUser;
	                                $this->session->unset_userdata( 'message' );
	                            }
	                        ?>

	                    	<?php if($notice == true) { ?>   
	                    	<div class="table-responsive m-t-40">
                                <table class="table table-bordered text-nowrap" id="basicDataTable">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Notice</th>
                                            <th>Date Posted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($announcmentsData as $announcment): ?>  
                                        <tr>
                                            <td><?= $announcment->id; ?></td>
                                            <td>
                                                <?= $announcment->message; ?>
                                            </td>
                                            <td>
                                                <?= $announcment->date_posted; ?> 
                                            </td>
                                            <td>
                                            <a href="<?= base_url(); ?>account/tournaments/notice-board/<?= $slug; ?>/create/<?= $announcment->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url(); ?>account/tournaments/notice-board/<?= $slug; ?>/delete-notice/<?= $announcment->id; ?>" onclick="return confirm('Want to delete the tournament');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>

                            <div class="btn-row m-t-40">
                            	<a href="<?= base_url(); ?>account/tournaments/notice-board/<?= $tournamentData[0]->slug; ?>/create"class="btn dso-ebtn dso-ebtn-solid">
		                            <span class="dso-btn-text">Create Notice</span>
		                            <div class="dso-btn-bg-holder"></div>
		                        </a>
                            </div>
                       	 	<?php } else { ?>
                       	 	<form method="POST" action="<?= base_url(); ?>account/createTournamentNotice">

                       	 		<div class="row">
	                       	 		<div class="col-md-12">
			                            <div class="form-group">
		                                    <label class="form-label text-white text-lg-2">Message</label>
		                                    <textarea name="message" id="editorRichText" class="content1 form-control" data-target="content1" rows="12"><?= $message; ?></textarea>
		                                </div>
		                            </div>
		                        </div>

                       	 		<input type="hidden" name="id" value="<?= $id; ?>" />
                       	 		<input type="hidden" name="tournamentID" value="<?= $tournamentData[0]->id; ?>" />

                       	 		<div class="dso-btn-row">
									<button type="submit" class="btn dso-ebtn dso-ebtn-solid">
	                                    <span class="dso-btn-text">Submit</span>
	                                    <div class="dso-btn-bg-holder"></div>
	                                </button>
								</div>
                       	 	</form>
                        	<?php } ?>
			            </div>
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>