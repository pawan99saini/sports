<div class="dso-main">
    <div class="dso-page-bannner dso-banner-overlay dso-videos-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1>
                            Manage Tournament
                            <span>Matches</span>
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
                    <?php $this->load->view('includes/sidebar'); ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="dso-lg-content dso-flex align-items-center">
                    <h1>Assigned Tournaments</h1>
                </div>

                <div class="dso-col-light">
                    <div class="content-box">
                        <div class="table-responsive m-t-40">
                            <table class="table table-bordered text-nowrap border-bottom" id="basicDataTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Tournament</th>
                                        <th>Number Of Players</th>
                                        <th>Match Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($spectatorsData as $spectator): ?>
                                <?php 
                                	$tournamentData = $meta->get_tournaments(array('tournament.id' => $spectator->tournamentID));
                                ?>
                        			<tr>
                        				<td><?= $spectator->id; ?></td>
                        				<td><?= $tournamentData[0]->title; ?></td>
                        				<td><?= $tournamentData[0]->total_players; ?></td>
                        				<td>
                    					<?php if($tournamentData[0]->status == 1) { ?>
                    						<label class='badge badge-warning'>Match Not Started</label> 
                    					<?php } elseif($tournamentData[0]->status == 2) { ?>
                    						<label class='badge badge-success'>Match Started</label> 
                    					<?php } else { ?>
                    						<label class='badge badge-danger'>Tournament Offline</label> 
                    					<?php } ?>
                        				</td>
                        				<td>
                        					<?php if($tournamentData[0]->status == 2) { ?>
                        					<a href="<?= base_url(); ?>account/spectate-tournament/<?= $tournamentData[0]->slug; ?>" class="btn btn-red btn-curved btn-small">Manage Match</a>
                        					<?php } ?>
                        				</td>
                        			</tr>
                        		<?php endforeach; ?>
                        		</tbody>
                        	</table>
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>