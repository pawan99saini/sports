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
                    <h1>Manage Matches</h1>
                </div>

                <div class="dso-col-light">
                    <div class="content-box">
                        <?php if($allowed_access == true) { ?>
                        <?php if(count($matchesData) > 0 && $role == 1) { ?> 
                        <div class="nav-tabs mg-t-40">
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
                                            if($round->round > 1) {
                                                $param = '/' . $round->round;
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
                                                    if($role == 1) {
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
                                                    <?php } ?>
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
                                                        if($tournamentData[0]->type < 2) { 
                                                    ?>
                                                
                                                            <div class="match-row">
                                                                <div class="match-player">
                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_1_thumnail_url; ?>" />
                                                                    </div>

                                                                    <label class="player-<?= $match->player_1_ID; ?>">
                                                                        <?= $username_player_1; ?>
                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_1_ID) { ?>                 
                                                                        <label class="badge badge-success">Winner</label>
                                                                        <?php } ?>

                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_2_ID) { ?>                 
                                                                        <label class="badge badge-danger">Looser</label>
                                                                        <?php } ?> 
                                                                         
                                                                        <div class="btn-row"> 
                                                                            <a href="#" class="btn dso-ebtn-rounded btn-dark btn-kick-player m-r-5"><i class="ion-trash-a"></i></a>
                                                                            <a href="<?= base_url(); ?>account/matches/setWinner/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
                                                                        </div>    
                                                                    </label>
                                                                </div>

                                                                <div class="mid-vs">
                                                                    <div class="user-score">
                                                                        <h2>
                                                                            <?= $match->player_1_score; ?>
                                                                        </h2>
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
                                                                    </div>
                                                                    <span>VS</span>
                                                                    <div class="user-score">
                                                                        <h2>
                                                                            <?= $match->player_2_score; ?>
                                                                        </h2>
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

                                                                <div class="match-player match-right">
                                                                    <label class="player-<?= $match->player_2_ID; ?>">
                                                                        <?= $username_player_2; ?>
                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_2_ID) { ?>                 
                                                                        <label class="badge badge-success">Winner</label>
                                                                        <?php } ?>

                                                                        <?php if($match->winnerID > 0 && $match->winnerID == $match->player_1_ID) { ?>                 
                                                                        <label class="badge badge-danger">Looser</label>
                                                                        <?php } ?>

                                                                        <div class="btn-row"> 
                                                                            <a href="<?= base_url(); ?>account/matches/setWinner/<?= $match->id; ?>/<?= $match->player_2_ID; ?>" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
                                                                            <a href="#" class="btn dso-ebtn-rounded btn-dark btn-kick-player m-l-5"><i class="ion-trash-a"></i></a>
                                                                        </div>
                                                                    </label>
                                                                    
                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_2_thumnail_url; ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                
                                                    <?php 
                                                        } //End of manual/auto match system

                                                        //If this is an Elimination Match
                                                        if($tournamentData[0]->type == 2) {
                                                    ?>
                                                            <div class="match-row match-elimination">
                                                                <div class="match-player">
                                                                    <span class="dso-match-icon ion-ios-star<?= $result_class; ?> <?= $player_1_result; ?>"></span>

                                                                    <div class="user-thumb">
                                                                        <img src="<?= $player_1_thumnail_url; ?>" />
                                                                    </div>

                                                                    <label>
                                                                        <?= $username_player_1; ?>
                                                                        <?php 
                                                                            if($match->status == 0) {
                                                                                $class = 'badge-danger';
                                                                                $statusMesg = " Eliminated";
                                                                            }

                                                                            if($match->status == 1) {
                                                                                $class = 'badge-warning';
                                                                                $statusMesg = " Playing";
                                                                            }

                                                                            if($match->status == 2) {
                                                                                $class = 'badge-success';
                                                                                $statusMesg = " Qualified";
                                                                            }
                                                                        ?>
                                                                        <div class="status-messg player-<?= $match->id; ?>">
                                                                            <span class="badge <?= $class; ?>"><?= $statusMesg; ?></span>
                                                                        </div> 
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
                                                                        <?php if($match->status == 1) { ?>
                                                                        <a href="<?= base_url(); ?>account/matches/eliminate/<?= $match->id; ?>/<?= $match->player_1_ID; ?>" class="btn dso-ebtn-sm eliminate-player-btn">
                                                                            <span>Eliminate Player</span>
                                                                            <div class="btn-loader">
                                                                                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                                            </div>
                                                                        </a>
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
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>