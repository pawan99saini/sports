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
				<div class="dso-lg-content">
                    <h1>Tournaments</h1>
                </div>

                <div class="dso-col-light">
					<div class="content-box">
						<div class="dso-tournaments dso-manage-tournaments">
			                <?php count($tournamentsData); ?>
			                <?php if(count($tournamentsData) == 0) { ?>
			                <div class="not-found">
			                    <img src="<?= base_url(); ?>assets/frontend/images/no-tournaments.png">
			                    <span>No Tournament Found</span>
			                </div>
			                <?php } else { ?>
			                <?php $j = 1; ?>
			                <?php foreach($tournamentsData as $tournament): ?>
			                <?php if($tournament->status != 0 && $tournament->status != 4) { ?> 
                            <?php 
                                //Get Tournament Matches
                                $matchesData = $this->db->query("SELECT * FROM `tournament_matches` WHERE tournamentID = '" . $tournament->id . "' AND WinnerID = 0 GROUP BY round ORDER BY id ASC")->result();
                                $activeRound = (count($matchesData) > 0) ? $matchesData[0]->round : 0; 
                                $setRoundUrl = '';
                                
                                if($activeRound > 0) {
                                    $setRoundUrl = ($activeRound == 1) ? '' : '/round/' . $activeRound;
                                }
                            ?>
			                <?php if($j <= 9) { ?>   
			                <div class="dso-tournament-wrapper">
			                	<div class="dso-btn-actions">
									<a href="<?= base_url() . 'account/tournaments/create/' . $tournament->id; ?>">
										<div class="dso-manage-icon ion-edit"></div>
									</a>
									<a href="<?= base_url() . 'account/tournaments/delete/' . $tournament->id; ?>">
										<div class="dso-manage-icon ion-ios-trash-outline"></div>
									</a>
									<a href="<?= base_url(); ?>tournaments/<?= $tournament->category_slug . '/' . $tournament->game_slug . '/' . $tournament->slug; ?>" target="_blank">
										<div class="dso-manage-icon ion-ios-eye-outline"></div>
									</a>
								</div>
			                    <div class="dso-tournament-thumbnail">
			                        <?php 
			                            $image = 'no-image.jpg';

			                            if(!empty($tournament->image)) {
			                                $image = $tournament->image;
			                            }
			                        ?>
			                        <img src="<?= base_url(); ?>assets/frontend/images/tournaments/<?= $image; ?>">

			                        <svg width="129" height="211" viewBox="0 0 167 269" fill="none" xmlns="http://www.w3.org/2000/svg">
			                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25412 0.814453C1.68125 2.62384 0 5.61553 0 8.99991V269H167C167 269 47 269 66.5 112.171C75.5581 39.3209 20.2679 8.22409 4.25412 0.814453Z" fill="#0c080e"></path>
			                        </svg>

			                        <div class="dso-tournament-info">
			                            <div class="dso-tournament-meta">
			                                <span><?= date('D, M dS', strtotime($tournament->organized_date)); ?></span> 
			                                <span><?= date('H:i A T', strtotime($tournament->time)); ?></span>
			                                <span><?= $tournament->game_name; ?></span>
			                            </div>
			                            <?php 
			                                $title_length = strlen($tournament->title);
			                                $title = ($title_length > 24) ? substr($tournament->title, 0, 24) . '...' : $tournament->title;
			                            ?>

			                            <h3><?= $title; ?></h3>

			                            <div class="dso-flex-row">
			                                <div class="dso-trounament-meta-info">
			                                    <div class="dso-tournament-meta-item">
			                                        <div class="dso-tournament-meta-icon ion-cash"></div>
			                                        <?php 
			                                            $tournament_prize = unserialize($meta->tournament_meta('prize_data', $tournament->id)[0]->meta_description);
			                                        ?>
			                                        <h4><?= $tournament_prize[0]; ?> - <?= end($tournament_prize); ?></h4>
			                                    </div>

			                                    <div class="dso-tournament-meta-item">
			                                        <div class="dso-tournament-meta-icon ion-ios-game-controller-b"></div>
			                                        <h4>
			                                        <?php 
			                                            $allowed_players = $tournament->max_allowed_players / 2;
			                                            echo $allowed_players . 'v' . $allowed_players;
			                                        ?>
			                                        </h4>
			                                    </div>

			                                    <div class="dso-tournament-meta-item">
			                                        <div class="dso-tournament-meta-icon ion-android-people"></div>
			                                        <h4><?= count($meta->get_participents($tournament->id)); ?> Enrolled</h4>
			                                    </div>
			                                </div>

			                                <?php 
			                                    if($tournament->mode == 1) {
			                                        $status = 'Online';
			                                    } else {
			                                        $status = 'Offline';
			                                    }
			                                ?>
			                                
			                                <a href="<?= base_url(); ?>account/tournaments/notice-board/<?= $tournament->slug; ?>"  class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Notice Board</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </a> 
                                            
			                                <a href="<?= base_url(); ?>account/tournaments/matches/<?= $tournament->slug . $setRoundUrl; ?>"  class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Manage Match</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </a>                                            
			                            </div>
			                        </div>

			                        <span class="status-box">
			                            <?php 
                                            $checked = ' checked';
                                            $checked_status = ' active';

                                            if($tournament->mode == 0) {
                                                $checked = '';
                                                $checked_status = ' ';
                                            }
                                        ?> 
                                        <label class="switch">
				                            <input class="tournament-set-mode" type="checkbox" <?= $checked; ?> value="<?= $tournament->id; ?>" />
				                            <span class="async-slider <?= $checked_status; ?> round"></span>
				                        </label>
			                        </span>
			                    </div>
			                </div>
			                <?php 
			                        } else {
			                            break;
			                        } 
			                        $j++;
			                    }
			                ?>
			                <?php endforeach; ?>
			                <?php } ?>
			            </div>
	                </div>
	            </div>
            </div>
        </div>
    </div>
</div>