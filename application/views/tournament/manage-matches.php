<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/messeging.css?ver=1.0.2">
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
                    <h1>Matches</h1>

                    <?php if(count($matchesData) == 0) { ?>  
                    <div class="item-right">
                        <a href="<?php echo base_url(); ?>account/tournaments/matches/<?= $tournamentData[0]->slug; ?>/create" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Start Match</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a> 
                    </div>
                    <?php } ?>
                </div>

                <div class="dso-col-light">
                    <div class="content-box overflow-inherit">
                        <div class="row">
                            <?php 
                                $allowed_players = $tournamentData[0]->max_allowed_players;
                                $active_players  = count($playersData);
                                $get_players_per = (100 / $allowed_players) * $active_players;

                                $prgress_bar_class = 'bg-danger';

                                if($get_players_per > 60) {
                                    $prgress_bar_class = 'bg-warning';
                                }

                                if($get_players_per == 100) {
                                    $prgress_bar_class = 'bg-success';
                                }
                            ?>

                            <div class="col-md-6">
                                <div class="dso-main-info-box">
                                    <div class="d-flex align-items-center content-space-between">
                                        <div>
                                            <h3><i class="ion-ios-people-outline"></i></h3>
                                            <p class="text-muted">PLAYERS</p>
                                        </div>
                                        <div class="ms-auto">
                                            <h2 class="counter players-count" data-players="<?= $active_players; ?>" data-total="<?= $allowed_players; ?>"><?= $active_players . ' / ' . $allowed_players; ?></h2>
                                        </div>
                                    </div>

                                    <div class="progress-bar players-progress <?= $prgress_bar_class; ?>" style="width: <?= $get_players_per; ?>%; height: 6px;"></div>
                                </div>
                            </div>

                            <?php 
                                $allowed_spectators = $tournamentData[0]->max_allowed_spectators;
                                $active_spectators  = count($spectatorsCount);
                                $get_applications_per = (100 / $allowed_spectators) * $active_spectators;

                                $prgress_bar_class = 'bg-danger';

                                if($get_applications_per > 60) {
                                    $prgress_bar_class = 'bg-warning';
                                }

                                if($get_applications_per == 100) {
                                    $prgress_bar_class = 'bg-success';
                                }
                            ?>

                            <div class="col-md-6">
                                <div class="dso-main-info-box">
                                    <div class="d-flex align-items-center content-space-between">
                                        <div>
                                            <h3><i class="ion-ios-eye-outline"></i></h3>
                                            <p class="text-muted">Spectators</p>
                                        </div>
                                        <div class="ms-auto">
                                            <h2 class="counter spec-counter"><?= $active_spectators . ' / ' . $allowed_spectators; ?></h2>
                                        </div>
                                    </div>

                                    <div class="progress-bar spec-progress <?= $prgress_bar_class; ?>" role="progressbar" style="width: <?= $get_applications_per; ?>%; height: 6px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="nav-tabs mg-t-40">
                            <?php 
                                $navTabText = 'Participants';
                                $matchesUrl = '#players';
                                $matchesUrlClass = 'dso-nav-tabs';

                                $faceoffMatchesUrl = $active_url . '/faceoff-matches';
                                $faceoffMatchesClass = 'dso-nav-tabs-button';

                                if($tournamentData[0]->status > 1) { 
                                    $navTabText = 'Matches';
                                } 
                                
                                if($arrg == 'faceoff-matches') {
                                    $matchesUrl = $active_url;
                                    $matchesUrlClass = 'dso-nav-tabs-button';
                                    $faceoffMatchesUrl = '#players';
                                    $faceoffMatchesClass = 'dso-nav-tabs';
                                }
                            ?>
                            <a href="<?= $matchesUrl; ?>" class="<?= $matchesUrlClass; ?> <?= ($arrg != 'faceoff-matches') ? 'dso-nav-current': ''; ?>"><?= $navTabText; ?></a>
                            <?php if($tournamentData[0]->type == 4 && $tournamentData[0]->status > 1) {  ?>
                            <a href="<?= $faceoffMatchesUrl; ?>" class="<?= $faceoffMatchesClass; ?> <?= ($arrg == 'faceoff-matches') ? 'dso-nav-current': ''; ?>">Face Off Matches</a>   
                            <?php } ?>
                            <a href="#spectators" class="dso-nav-tabs">Spectators</a>
                            <a href="<?= $active_url; ?>/reset-match" class="dso-nav-tabs-button">Reset Match</a>
                            <?php if(count($matchesData) > 0) { ?> 
                                <?php if($tournamentData[0]->type == 2) {  ?>
                                    <a href="<?= base_url(); ?>account/matches/nextRound/<?= $tournamentData[0]->id . '/' . count($totalRounds); ?>" class="btn dso-ebtn dso-ebtn-solid m-r-15">
                                        <span class="dso-btn-text">Start Next Round</span>
                                        <div class="dso-btn-bg-holder"></div>                            
                                    </a>
                                <?php if(count($totalRounds) > 1) { ?>
                                    <a href="<?= base_url(); ?>account/matches/completeMatch/<?= $tournamentData[0]->id . '/' . count($totalRounds); ?>" class="btn dso-ebtn dso-ebtn-outline">
                                        <span class="dso-btn-text">Mark Completed</span>
                                        <div class="dso-btn-bg-holder"></div>
                                    </a>
                                <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <?php 
                            if($this->session->flashdata('message') == true) { 
                                echo $this->session->flashdata('message');
                            }   
                        ?>

                        <div class="dso-tab-wrapper active-nav-tab" id="players">
                            <?php 
                                //Check if matches has been started 
                                if($tournamentData[0]->status > 1) { 
                            ?> 
                                    <div class="dso-tabs"> 
                                    <?php foreach($totalRounds as $round): ?> 
                                        <?php 
                                            $param = '';

                                            if($arrg == 'faceoff-matches') {
                                                $param = '/faceoff-matches';
                                            }

                                            if($round->round > 1) {
                                                $param .= '/round/' . $round->round;
                                            } 
                                        ?>   
                                            <a href="<?= $active_url . $param; ?>" class="btn dso-ebtn <?= ($round->round == $activeRound) ? 'dso-ebtn-solid' : 'dso-ebtn-outline'; ?>">
                                                <span class="dso-btn-text">Round <?= $round->round; ?></span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </a>
                                        <?php $param = ''; ?>
                                    <?php 
                                        endforeach; 
                                        //End of rounds loop
                                    ?>
                                    </div>

                                    <div class="loader-sub" id="spec-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>

                                    <?php 
                                        //If this system does not requires bracket system set manual matches
                                        if($tournamentData[0]->brackets == 0) {
                                    ?>
                                            <div class="matches-manage-table">    
                                            <?php 
                                                //If this match is based on manual elimination
                                                if($tournamentData[0]->type == 1) { 
                                            ?>
                                                    <form method="POST" action="<?= base_url(); ?>admin/create_manual_match" onsubmit="return false;" class="create-manual-match">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Select Round (Please add numeric values)</label>
                                                                <select name="set_round" class="form-control">
                                                                <?php for($i = 1; $i <= $getRound; $i++) { ?>    
                                                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                                                <?php } ?>
                                                                </select>
                                                                <input type="hidden" name="round" value="<?= $getRound; ?>" />
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>

                                                        <div class="match-row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Player 1</label>
                                                                    <select class="form-control player-select" name="player_1" <?= ($setDisabled == 1) ? 'disabled' : ''; ?>>
                                                                        <option value="">Select Player</option>
                                                                    <?php 
                                                                    if($setDisabled == 1) { 
                                                                        $playersData = $playersList2; 
                                                                    } else {    
                                                                        $playersData = $playersList; 
                                                                    }

                                                                    foreach($playersData as $player) {
                                                                        $player_username = $meta->get_username($player->participantID); 
                                                                    ?>    
                                                                        <option value="<?= $player->participantID; ?>" <?= ($playerID == $player->participantID) ? 'selected' : ''; ?>>
                                                                            <?= $player_username; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <span>VS</span>

                                                            <div class="col-6 player-2">
                                                            <?php if($setDisabled == 1) { ?>
                                                                <div class="form-group">
                                                                    <label>Player 2</label>
                                                                    <select class="form-control player-select" name="player_2">
                                                                        <option value="">Select Player</option>
                                                                        <?php foreach($playersList as $player) { ?>
                                                                        <?php $player_username = $meta->get_username($player->participantID); ?>    
                                                                            <option value="<?= $player->participantID; ?>">
                                                                                <?= $player_username; ?>
                                                                            </option>
                                                                        <?php } ?>   
                                                                    </select>
                                                                </div>
                                                            <?php } ?>    
                                                            </div>
                                                        </div>
                                                    </form>
                                            <?php 
                                                } //End of manual match system
                                            ?>
                                                <div class="loader-sub" id="match-load">
                                                    <div class="lds-ellipsis">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php 
                                        } //End of non Bracket Match System
                                    ?>

                                    <input type="hidden" name="tournamentID" value="<?= $tournamentData[0]->id; ?>" />

                                    <div class="players-match-table">
                                    <?php 
                                        // If matches has been started but no match created
                                        if(count($matchesData) == 0) { 
                                    ?>              
                                        <div class="dso-inner-404">
                                            <img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
                                            <h2>No Matches Found Start Creating Matches Above</h2>
                                        </div>
                                    <?php 
                                        } else { //End of 0 matches
                                    ?>  
                                            <div class="matches-table manage-matches">
                                            <?php 

                                                //Matches Data
                                                foreach($matchesData as $match):
                                                    if($match->round == $activeRound) {
                                                        // Player 1 User Details
                                                        $player_1_get_image = $meta->get_user_meta('user_image', $match->player_1_ID);
                                                                    
                                                        if($player_1_get_image == null) {
                                                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                                                        } else {
                                                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                                                        }
                                                        
                                                        $username_player_1 = $meta->get_username($match->player_1_ID);

                                                        // Player 2 User Details
                                                        $player_2_get_image = $meta->get_user_meta('user_image', $match->player_2_ID);
                                                                    
                                                        if($player_2_get_image == null) {
                                                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                                                        } else {
                                                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_2_ID . '/' . $player_2_get_image;
                                                        }
                                                        
                                                        $username_player_2 = $meta->get_username($match->player_2_ID);

                                                        $player_1_result = '';
                                                        $player_2_result = '';

                                                        if($match->winnerID > 0) {
                                                            $player_1_result = ($match->winnerID == $match->player_1_ID) ? 'dso-winner' : 'dso-looser';
                                                            $player_2_result = ($match->winnerID == $match->player_2_ID) ? 'dso-winner' : 'dso-looser';
                                                        }

                                                        $result_class = ($match->winnerID == 0) ? '-outline' : ''; 
                                            ?> 
                                                    <?php 
                                                        //If this is manual or auto matches system
                                                        $matchTypeManual = array(1, 4);
                                                        if(in_array($tournamentData[0]->type, $matchTypeManual)) { 
                                                    ?>
                                                            <div class="d-flex align-items-center justify-content-between" id="match-row-info-<?= $match->id; ?>">
                                                                <h2 class="text-md text-light">Match Status</h2>

                                                                <?php 
                                                                    $matchTime = $meta->get_tournament_match_meta($match->id, 0, 'match_result_time');
                                                                    $matchTime = date('M d, Y H:i:s', strtotime($matchTime));

                                                                    $clockStatus = '';

                                                                    if($match->match_status == 4) {
                                                                        $clockStatus = 'pause-clock';
                                                                        $matchTime = '';
                                                                    }
                                                                ?>

                                                                <div class="match-status">
                                                                    <?php 
                                                                        if($match->match_status == 0) {
                                                                            $matchStatus = 'Awaiting For Both Opponenets To Be Ready To Get Started';
                                                                            $matchStatusClass = 'warning';
                                                                        }

                                                                        if($match->match_status == 1) {
                                                                            $matchStatus = 'Both Opponenets Ready. Waiting For Spectator To Start Match';
                                                                            $matchStatusClass = 'info';
                                                                        }

                                                                        if($match->match_status == 2) {
                                                                            $matchStatus = 'Match Started';
                                                                            $matchStatusClass = 'success';
                                                                        }

                                                                        if($match->match_status == 3) {
                                                                            $matchStatus = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
                                                                            $matchStatusClass = 'info';
                                                                        }

                                                                        if($match->match_status == 4) {
                                                                            $matchStatus = 'Match In Dispute';
                                                                            $matchStatusClass = 'danger';
                                                                        }

                                                                        if($match->match_status == 5) {
                                                                            if($match->player_1_ID == $match->winnerID) {
                                                                                $winnerUsername = $username_player_1;
                                                                            } else {
                                                                                $winnerUsername = $username_player_2;
                                                                            }

                                                                            $matchStatus = 'Match Completed. ' . $winnerUsername . ' Won The Match';
                                                                            $matchStatusClass = 'success';
                                                                        }

                                                                        $timeStart = '';

                                                                        if($matchStatus == 3) {
                                                                            $timeStart = date('M d, Y H:i:s');
                                                                        }
                                                                    ?>
                                                                    <span id="match-<?= $match->id; ?>" class="badge badge-<?= $matchStatusClass; ?>"><?= $matchStatus; ?></span>
                                                                    <div id="messageBox<?= $match->id; ?>"></div>
                                                                </div>

                                                                <div class="match-timer-box multi-match-timer">
                                                                    <input type="hidden" name="timeStart" value="<?= $timeStart; ?>" />
                                                                    <input type="hidden" name="matchTimeEnd" value="<?= $matchTime; ?>" />
                                                                    <input type="hidden" name="matchRowID" value="<?= $match->id; ?>" />
                                                                    <input type="hidden" name="matchStatusUrl" value="<?= base_url(); ?>account/matches/assignResult/<?= $match->id; ?>" />
                                                                    <input type="hidden" name="matchStatus" value="<?= $match->match_status; ?>" />
                                                                    <span class="match-timer <?= $clockStatus; ?>">00:00:00</span>
                                                                </div>
                                                            </div>

                                                            <?php 
                                                                $player_1_decision = $meta->get_tournament_match_meta($match->id, $match->player_1_ID, 'player_1_decision');
                                                                $player_2_decision = $meta->get_tournament_match_meta($match->id, $match->player_2_ID, 'player_2_decision');
                                                                $player_1_status = $match->player_1_status;
                                                                $player_2_status = $match->player_2_status;
                                                                            
                                                            ?>

                                                            <div class="match-row" id="match-<?= $match->id; ?>">
                                                                <a href="<?= base_url(); ?>account/getPlayerMatchChat" class="btn btn-match-chat" data-match-id="<?= $match->id; ?>" data-player="1" data-id="<?= $match->player_1_ID; ?>">
                                                                    <i class="fa fa-commenting"></i>
                                                                    <span>Message</span>
                                                                </a>
                                                                
                                                                <div class="match-player" id="slot-1" data-player-status="<?= $player_1_status; ?>" data-player-dec="<?= $player_1_decision; ?>">
                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_1_thumnail_url; ?>" />
                                                                    </div>

                                                                    <label class="player-<?= $match->player_1_ID; ?>">
                                                                        <?= ($match->player_1_ID > 0) ? $username_player_1 : 'Free Slot'; ?>
                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_1_ID) { ?>                 
                                                                        <label class="badge badge-success">Winner</label>
                                                                        <?php } ?>

                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_2_ID) { ?>                 
                                                                        <label class="badge badge-danger">Looser</label>
                                                                        <?php } ?> 

                                                                        <?php 
                                                                            if($match->match_status < 5) {
                                                                                if($player_1_decision != '') {
                                                                                    echo '<span class="start-match">';
                                                                                    
                                                                                    if($player_1_decision == 0) {
                                                                                        echo 'Waiting For Player\'s Decision';
                                                                                    }

                                                                                    if($player_1_decision == 1) {
                                                                                        echo 'Player Accepted The Results';
                                                                                    }

                                                                                    if($player_1_decision == 2) {
                                                                                        echo 'Player Filed Dispute';
                                                                                    }

                                                                                    echo '</span>';
                                                                                }
                                                                            }
                                                                        ?>

                                                                        <?php if($player_1_decision == 2) { ?>
                                                                            <a href="<?= base_url(); ?>account/matches/viewDispute/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>
                                                                        <?php } ?>
                                                                            
                                                                        <?php if($match->player_1_status == 1) { ?>
                                                                            <?php if($match->match_status == 2 || $match->match_status == 4) { ?>
                                                                            <?php if($match->winnerID == 0 && $match->player_1_ID > 0) { ?>   
                                                                            <a href="<?= base_url(); ?>account/matches/setWinner/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
                                                                            <?php } ?>
                                                                            <?php } ?>
                                                                            <?php if($match->match_status == 0) { ?>
                                                                            <span class="start-match">Player Is Ready</span>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <span class="start-match">Player Is Not Ready</span>
                                                                        <?php } ?>
                                                                    </label>
                                                                </div>

                                                                <div class="mid-vs">
                                                                    <?php if($match->match_status == 1) { ?>
                                                                    <div class="match-start-wrapper">
                                                                        <p>Players Are Ready To Play The Match</p>
                                                                        <a href="<?= base_url(); ?>account/matches/startPlayerMatch/<?= $match->id; ?>" class="btn dso-ebtn-sm btn-dark btn-start-match">Start Match</a>
                                                                    </div>
                                                                    <?php } ?>
                                                                    <div class="user-score" id="slot-1-score">
                                                                        <h2>
                                                                            <?= $match->player_1_score; ?>
                                                                        </h2>
                                                                        <?php if($match->player_1_status == 1 && $match->player_2_status == 1) { ?>
                                                                        <div class="setScore-form">
                                                                            <form method="POST" action="<?= base_url(); ?>account/matches/setScore/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="setScore" onsubmit="return false;">
                                                                                <div class="inline-field">
                                                                                    <input type="text" name="player_score" value="<?= $match->player_1_score; ?>" class="form-control" />
                                                                                    <input type="hidden" name="player" value="1" />

                                                                                    <div class="inline-sm-btns">
                                                                                        <button type="submit" class="btn-small-circle btn-dark">
                                                                                            <i class="fa fa-check"></i>
                                                                                        </button>
                                                                                        <button type="button" class="btn-small-circle btn-dark btn-cancel-score-set">
                                                                                            <i class="fa fa-times"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <a href="javascript:void(0);" class="add-score">Set Score</a>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>

                                                                    <span>VS</span>

                                                                    <div class="user-score" id="slot-2-score">
                                                                        <h2>
                                                                            <?= $match->player_2_score; ?>
                                                                        </h2>
                                                                        <?php if($match->player_1_status == 1 && $match->player_2_status == 1) { ?>
                                                                        <div class="setScore-form">
                                                                            <form method="POST" action="<?= base_url(); ?>account/matches/setScore/<?= $match->id; ?>/<?= $match->player_2_ID; ?>" class="setScore" onsubmit="return false;">
                                                                                <div class="inline-field">
                                                                                    <input type="text" name="player_score" value="<?= $match->player_2_score; ?>" class="form-control" />
                                                                                    <input type="hidden" name="player" value="2" />
                                                                                    <div class="inline-sm-btns">
                                                                                        <button type="submit" class="btn-small-circle btn-dark">
                                                                                            <i class="fa fa-check"></i>
                                                                                        </button>
                                                                                        <button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">
                                                                                            <i class="fa fa-times"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <a href="javascript:void(0);" class="add-score">Set Score</a>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>

                                                                    <div class="loader-full"  id="load-match-row">
                                                                        <div class="laoder-inner">
                                                                            <div class="lds-ellipsis">
                                                                                <div></div>
                                                                                <div></div>
                                                                                <div></div>
                                                                                <div></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="match-player match-right" id="slot-2"  data-player-status="<?= $player_2_status; ?>" data-player-dec="<?= $player_2_decision; ?>">
                                                                    <label class="player-<?= $match->player_2_ID; ?>">
                                                                        <?= ($match->player_2_ID > 0) ? $username_player_2 : 'Free Slot'; ?>
                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_2_ID) { ?>                 
                                                                        <label class="badge badge-success">Winner</label>
                                                                        <?php } ?>

                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_1_ID) { ?>                 
                                                                        <label class="badge badge-danger">Looser</label>
                                                                        <?php } ?>
                                                                        
                                                                        <?php    
                                                                            if($match->match_status < 5) {                                                                      
                                                                                if($player_2_decision != '') {
                                                                                    echo '<span class="start-match">';
                                                                                    
                                                                                    if($player_2_decision == 0) {
                                                                                        echo 'Waiting For Player\'s Decision';
                                                                                    }

                                                                                    if($player_2_decision == 1) {
                                                                                        echo 'Player Accepted The Results';
                                                                                    }

                                                                                    if($player_2_decision == 2) {
                                                                                        echo 'Player Filed Dispute';
                                                                                    }

                                                                                    echo '</span>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        
                                                                        <?php if($player_2_decision == 2) { ?>
                                                                            <a href="<?= base_url(); ?>account/matches/viewDispute/<?= $match->id; ?>/<?= $match->player_2_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>
                                                                        <?php } ?>

                                                                        <?php if($match->player_2_status == 1) { ?>
                                                                            <?php if($match->match_status == 2 || $match->match_status == 4) { ?>
                                                                            <?php if($match->winnerID == 0 && $match->player_2_ID > 0) { ?>
                                                                            <a href="<?= base_url(); ?>account/matches/setWinner/<?= $match->id; ?>/<?= $match->player_2_ID; ?>" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
                                                                            <?php } ?>
                                                                            <?php } ?>

                                                                            <?php if($match->match_status == 0) { ?>
                                                                            <span class="start-match">Player Is Ready</span>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <span class="start-match">Player Is Not Ready</span>
                                                                        <?php } ?>
                                                                    </label>
                                                                    
                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_2_thumnail_url; ?>" />
                                                                    </div>

                                                                </div>
                                                                <a href="<?= base_url(); ?>account/getPlayerMatchChat" class="btn btn-match-chat" data-match-id="<?= $match->id; ?>" data-player="2" data-id="<?= $match->player_2_ID; ?>">
                                                                    <i class="fa fa-commenting"></i>
                                                                    <span>Message</span>
                                                                </a>
                                                            </div>
                                                
                                                    <?php 
                                                        } // End of manual / auto match system

                                                        // If this is an Elimination Match
                                                        if($tournamentData[0]->type == 2) {
                                                            $player_1_decision = $meta->get_tournament_match_meta($match->id, $match->player_1_ID, 'player_1_decision');
                                                    ?>      
                                                            <div class="d-flex align-items-center justify-content-between" id="match-row-info-<?= $match->id; ?>">
                                                                <h2 class="text-md text-light">Match Status</h2>

                                                                <?php 
                                                                    $matchTime = $meta->get_tournament_match_meta($match->id, 0, 'match_result_time');
                                                                    $matchTime = date('M d, Y H:i:s', strtotime($matchTime));

                                                                    $clockStatus = '';

                                                                    if($match->match_status == 4) {
                                                                        $clockStatus = 'pause-clock';
                                                                        $matchTime = '';
                                                                    }
                                                                ?>

                                                                <div class="match-timer-box multi-match-timer">
                                                                    <input type="hidden" name="timeStart" value="<?= date('M d, Y H:i:s'); ?>" />
                                                                    <input type="hidden" name="matchTimeEnd" value="<?= $matchTime; ?>" />
                                                                    <input type="hidden" name="matchRowID" value="<?= $match->id; ?>" />
                                                                    <input type="hidden" name="matchStatusUrl" value="<?= base_url(); ?>account/matches/assignResult/<?= $match->id; ?>" />
                                                                    <input type="hidden" name="matchStatus" value="<?= $match->match_status; ?>" />
                                                                    <span class="match-timer <?= $clockStatus; ?>"></span>
                                                                </div>
                                                            </div>

                                                            <div class="match-row match-elimination">
                                                                <div class="match-player">
                                                                    <span class="dso-match-icon ion-ios-star<?= $result_class; ?> <?= $player_1_result; ?>"></span>

                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_1_thumnail_url; ?>" />
                                                                    </div>

                                                                    <label>
                                                                        <?= $username_player_1; ?>
                                                                    </label>
                                                                </div>

                                                                <div class="match-data-set">
                                                                    <div class="user-score">
                                                                        <h2><?= $match->player_1_score; ?></h2>

                                                                        <?php if($match->status == 1) { ?>
                                                                        <div class="setScore-form">
                                                                            <form method="POST" action="<?= base_url(); ?>account/matches/setScore/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="setScore" onsubmit="return false;">
                                                                                <div class="inline-field">
                                                                                    <input type="text" name="player_score" value="<?= $match->player_1_score; ?>" class="form-control" />

                                                                                    <div class="inline-sm-btns">
                                                                                        <button type="submit" class="btn-small-circle btn-dark">
                                                                                            <i class="fa fa-check"></i>
                                                                                        </button>
                                                                                        <button type="button" class="btn-small-circle  btn-dark btn-cancel-score-set">
                                                                                            <i class="fa fa-times"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <a href="javascript:void(0);" class="add-score">Set Score</a>
                                                                        </div>

                                                                        <div class="loader-full"  id="load-match-row">
                                                                            <div class="laoder-inner">
                                                                                <div class="lds-ellipsis">
                                                                                    <div></div>
                                                                                    <div></div>
                                                                                    <div></div>
                                                                                    <div></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>

                                                                    <div class="btn-action">
                                                                        <div class="elimination-player-status">
                                                                        <?php if($match->player_1_status == 1) { ?>
                                                                            <?php if($match->status == 1) { ?>
                                                                                <span class="start-match">Player Is Ready</span>                                                                      
                                                                                <a href="<?= base_url(); ?>account/matches/eliminate/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="btn dso-ebtn-sm eliminate-player-btn">
                                                                                    <span>Eliminate Player</span>
                                                                                    <div class="btn-loader">
                                                                                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                                                    </div>
                                                                                </a>
                                                                            <?php } ?>

                                                                            <?php 
                                                                                if($match->match_status == 3) {                                                                      
                                                                                    echo '<span class="start-match">';
                                                                                    if($player_1_decision != '') {                                                                                        
                                                                                        if($player_1_decision == 0) {
                                                                                            echo 'Waiting For Player\'s Decision';
                                                                                        }
                                                                                    }
                                                                                    echo '</span>';
                                                                                }

                                                                                if($match->match_status == 4) {                                                                      
                                                                                    echo '<span class="start-match">';
                                                                                    if($player_1_decision != '') {                                                                                        
                                                                                        
                                                                                        if($player_1_decision == 2) {
                                                                                            echo 'Player Filed Dispute';
                                                                                        }    
                                                                                        
                                                                                        if($player_1_decision == 2) {
                                                                                            echo '<a href="' . base_url() . 'account/matches/viewDispute/' . $match->id . '/' .  $match->player_2_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
                                                                                        }
                                                                                    }
                                                                                    echo '</span>';
                                                                                }

                                                                                if($player_1_decision != '') {       
                                                                                    if($player_1_decision == 1) {
                                                                                        echo '<span class="start-match">Player Accepted The Result</span>';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        <?php } else { ?>
                                                                            <span class="start-match">Player Is Not Ready</span>
                                                                        <?php } ?>

                                                                        <?php if($match->status == 2) { ?>
                                                                        <span class="badge badge-success">Qualified</span>
                                                                        <?php } ?>

                                                                        <?php if($match->status == 0) { ?>
                                                                        <span class="badge badge-danger">Eliminated</span>
                                                                        <?php } ?>
                                                                        </div>   
                                                                    </div>
                                                                </div>

                                                                <a href="<?= base_url(); ?>account/getPlayerMatchChat" class="btn btn-match-chat" data-match-id="<?= $match->id; ?>" data-player="2" data-id="<?= $match->player_2_ID; ?>">
                                                                    <i class="fa fa-commenting"></i>
                                                                    <span>Message</span>
                                                                </a>
                                                            </div>
                                                    <?php 
                                                        } //End of Elimination Match
                                                    ?>
                                            <?php
                                                    } //End Round 1
                                                endforeach; //End Of Matches Data
                                            ?> 
                                            </div>
                                    <?php 
                                        } //End Of Matches greater then 0
                                    ?>
                            <?php 
                                //End Matches Area
                                } else { //If No Matches started show participents
                            ?>
                                <div class="team-row team-participants">
                                <?php if(count($playersData) > 0) { ?>
                                    <?php foreach($playersData as $player): ?>      
                                        <div class="select-player-box">
                                            <div class="player-btn-row">
                                                <a href="<?= base_url(); ?>account/kick_player/<?= $tournamentData[0]->id; ?>" class="btn dso-ebtn-sm kick-player" data-id="<?= $player->participantID; ?>">
                                                    <span class="dso-btn-text">Kick</span>
                                                    <div class="btn-loader">
                                                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php 
                                                $player_username = $meta->get_username($player->participantID);
                                                $player_data     = $meta->get_user_data($player->participantID);
                                                $get_image       = $meta->get_user_meta('user_image', $player->participantID);
                                            ?>

                                            <div class="thumbnail-circle <?= strtolower($player_data->log_status); ?>">
                                            <?php 
                                                if($get_image == null) {
                                                    $image_url = base_url() . 'assets/uploads/users/default.jpg';
                                                } else {
                                                    $image_url = base_url() . 'assets/uploads/users/user-' . $player->participantID . '/' . $get_image;
                                                }
                                            ?>
                                                <img loading="lazy" src="<?= $image_url; ?>" />
                                            </div>

                                            <div class="select-player-content">
                                                <h5 class="text-truncate">
                                                    <a href="<?= base_url(); ?>profile/<?= $player_data->username; ?>" target="_blank">
                                                        @<?= $player_data->username; ?>
                                                    </a>
                                                </h5>
                                                <div class="player-statistics">
                                                    <?php 
                                                        $userData = $meta->get_data('users', array('id' => $player->participantID));
                                                    ?>
                                                    <div class="player-data">
                                                        <p>
                                                            <i class="dso-tournament-meta-icon fab fa-discord" style="font-size: 12px;"></i>
                                                            <span>Discord</span>
                                                        </p>

                                                        <h6><?= $userData[0]->discord_username; ?></h6>
                                                    </div>
                                                    <div class="player-data">
                                                        <p>
                                                            <i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>
                                                            <span>Tournaments Played</span>
                                                        </p>

                                                        <h6>0</h6>
                                                    </div>

                                                    <div class="player-data">
                                                        <p>
                                                            <i class="dso-tournament-meta-icon ion-trophy"></i>
                                                            <span>Win Rate</span>
                                                        </p>

                                                        <h6>0.00%</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>  
                                <?php } else { ?>
                                    <div class="dso-inner-404">
                                        <img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
                                        <h2>Sorry No Participants Found</h2>
                                    </div>
                                <?php } ?>
                                </div>
                            <?php } ?>
                            
                            <div class="match-log-wrapper">
                                <div class="chat-wrapper">
                                    <div class="chat-inner-wrapper">
                                        <div class="chat-header">
                                            <h2>User Chat</h2>
                                            <a href="#" class="close-chat">
                                                <span></span><span></span>
                                            </a>
                                        </div>

                                        <div class="chat-area individual-match-chat">
                                            <ul id="chat"></ul>
                                            <a href="javascript:void(0);" class="jump-bottom" style="display: none;">You Have New Message</a>   
                                            <div class="loader-full"  id="load-chat-wrapper">
                                                <div class="laoder-inner">
                                                    <div class="lds-ellipsis">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form method="POST" action="<?= base_url(); ?>account/sendMatchMessage" class="sendMessage" onsubmit="return false;">
                                            <div class="chat-text-wrap">
                                                <textarea placeholder="Type your message" name="message"></textarea>
                                                <input type="hidden" name="thread" value="0" />
                                                <input type="hidden" name="chatCount" value="0" />
                                                <div id="basic_message"></div>
                                                <div class="chat-btn-row">
                                                    <div class="btn-box">
                                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_picture.png" alt="">
                                                    </div>

                                                    <div class="file-upload-init">
                                                        <div class="fileUploader">
                                                            <input type="file" name="file" multiple="true" id="basic" />
                                                            <div id="basic_drop_zone" class="dropZone">
                                                                <h4>
                                                                    <i class="fa fa-upload"></i>
                                                                    <span>Drop files here</span>
                                                                </h4>
                                                            </div>
                                                            <div id="basic_progress"></div>                            
                                                        </div>
                                                    </div>  

                                                    <button type="submit" class="sendMessageButton">Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="dispute-form" style="height: auto;">
                                <div class="chat-header">
                                    <h2>View Dispute</h2>
                                    <a href="#" class="close-dispute-form">
                                        <span></span><span></span>
                                    </a>
                                </div>

                                <div class="dispute-form-inner">
                                    <form method="POST" action="<?= base_url(); ?>account/processDisputeResponse" class="process-dispute-response" onsubmit="return false;" enctype="multipart/form-data">
                                        <div class="form-group text-white">
                                            <label>Dispute Details</label>
                                            <p class="dispute-description"></p>
                                        </div>

                                        <div class="form-group text-white">
                                            <label>Provided Screenshot</label>
                                            <div class="dispute-screeshot">
                                                <img src="" style="width: 100%;" />
                                            </div>
                                        </div>

                                        <div class="form-group text-white">
                                            <label>Resolution Response</label>
                                            <select class="form-control select-action" name="setaction">
                                                <option value="1">Approve</option>
                                                <option value="2">Reject</option>
                                            </select>
                                        </div>

                                        <div class="match-details"></div>
                                        
                                        <div class="form-group text-white">
                                            <label>Additional Comments</label>
                                            <textarea class="form-control" rows="6" name="comments"></textarea>
                                        </div>

                                        <input type="hidden" name="slot" />
                                        <input type="hidden" name="matchID" />
                                        <input type="hidden" name="playerID" />
                                        
                                        <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                            <span class="dso-btn-text">Submit</span>
                                            <div class="dso-btn-bg-holder"></div>
                                        </button>
                                    </form>

                                    <div class="loader-full"  id="load-dispute-form">
                                        <div class="laoder-inner">
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
                        </div>

                        <div class="dso-tab-wrapper" id="spectators">
                            <a href="javascript:void(0);" class="btn dso-ebtn dso-ebtn-solid add-spectator wd-200">Add Spectator</a>
                            <a href="javascript:void(0);" class="btn dso-ebtn dso-ebtn-solid btn-cancel-spectator  wd-200" style="display: none;">Back</a>

                            <div class="add-spectators" style="display: none;">
                                <div class=" d-flex justify-content-center">
                                    <div class="dso-col-light"> 
                                        <div class="dso-lg-content m-b-20">
                                            <h3>Add New Spectator</h3>
                                        </div>

                                        <form method="POST" action="<?= base_url(); ?>account/add_spectator_request" onsubmit="return false;" class="add-member-process">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group dso-animated-field-label">
                                                        <label for="Email">Email / Username</label>
                                                        <input type="text" class="form-control search-invite-user" data-location="<?= base_url(); ?>account/search_member" data-type="add_spectator" name="email" />
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
                                        </form>
                                    </div>
                                </div>

                                <input type="hidden" name="tournamentID" value="<?= $tournamentID; ?>" />
                            </div>

                            <div class="team-row current-spectators m-t-40">
                                <?php foreach($trounamentSpectators as $spectator): ?>
                                <div class="select-player-box dso-spec-application">
                                   <div class="select-player-content">
                                        <div class="dso-btn-abs">
                                            <div class="d-flex align-items-center gap-1">
                                                <label>Normal Spectator</label>
                                                <?php 
                                                    $roleStatus = '';

                                                    if($spectator->role == 1) {
                                                        $roleStatus = 'checked';
                                                    }
                                                ?>

                                                <div class="toggle-btn">
                                                    <input type="checkbox" id="switch<?= $spectator->id; ?>" name="spectatorRole" value="<?= $spectator->id; ?>" data-url="<?= base_url() . 'account/update_spectator_role/' . $tournamentID; ?>" <?= $roleStatus; ?> />
                                                    <label for="switch<?= $spectator->id; ?>">Toggle</label>
                                                </div>

                                                <label>Super Admin</label>
                                            </div>
                                        </div>
                                        
                                        <div class="select-player-data">
                                            <h5>@<?= $spectator->username; ?></h5>
                                            <p>
                                                <strong>Email : </strong>
                                                <span><?= $spectator->email; ?></span>
                                            </p>

                                            <?php
                                            $user_social = $meta->get_user_meta('user_social_contact', $spectator->id);
                                            ?>
                                            
                                            <div class="player-social">
                                                <p>
                                                    <strong>Social : </strong>
                                                    <?php if($user_social) { ?>
                                                    </p>
                                                    <?php $social_data = unserialize($user_social); ?>
                                                
                                                    <ul class="ft-social">
                                                    <?php foreach($social_data as $platform => $url):
                                                        if($url != null) {
                                                
                                                            echo '<li>';
                                                                echo '<a href="' . $url . '" target="_blank">';
                                                                    echo '<i class="fab fa-'. $platform . '"></i>';
                                                                echo '</a>';
                                                            echo '</li>';
                                                         } 
                                                        endforeach; 
                                                    ?>
                                                    </ul>
                                                    <?php } else { ?>
                                                    <span>Socialy Inactive</span>
                                                </p>
                                            <?php } ?>
                                            </div>

                                            <p>
                                                <strong>Discord : </strong>
                                                <span><?= $spectator->discord_username; ?></span>
                                            </p>
                                        </div>

                                        <div class="player-btn-row">
                                            <?php if($spectator->status == 2) { ?>
                                            <a href="<?= base_url(); ?>account/processSpectator" class="btn dso-ebtn-sm spectator-request" data-id="<?= $spectator->id; ?>" data-status="1">
                                                <span class="dso-btn-text">Accept</span>
                                                <div class="btn-loader">
                                                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                </div>
                                            </a>

                                            <a href="<?= base_url(); ?>account/processSpectator" class="btn dso-ebtn-sm spectator-request" data-id="<?= $spectator->id; ?>" data-status="3">
                                                <span class="dso-btn-text">Reject</span>
                                                <div class="btn-loader">
                                                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                </div>
                                            </a>
                                            <?php } else { ?>
                                            <a href="<?= base_url(); ?>account/processSpectator" class="btn dso-ebtn-sm spectator-request" data-id="<?= $spectator->id; ?>" data-status="3">
                                                <span class="dso-btn-text">Remove</span>
                                                <div class="btn-loader">
                                                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                </div>
                                            </a>
                                            <?php } ?>
                                        </div>
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
</div>
<input type="hidden" name="chatMainUrl" value="<?= base_url(); ?>account/updateMatchChat" />

<script>
    var chatFileUrl = '<?= base_url(); ?>account/processChatFile';
    var chatMainUrl = '<?= base_url(); ?>account/updateMatchChat';
</script>