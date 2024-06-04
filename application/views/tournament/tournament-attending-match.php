<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/messeging.css?ver=1.0.2">
<div class="dso-main">
    <div class="dso-page-bannner dso-banner-overlay dso-videos-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1>
                            Tournament Attending
                            <span>Match</span>
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
                    <h1>Manage Attending Tournaments</h1>
                </div>

                <div class="dso-col-light">
                    <div class="content-box overflow-inherit">
                        <div class="match-log-wrapper">
                            <div class="match-log">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>
                                        <strong>Current Round : </strong> <span class="current-round"><?= $currentMatch[0]->round; ?></span>
                                        <?php if($currentMatch[0]->seed == 1) { ?>
                                        (Face Off Match)
                                        <?php } ?>
                                    </h4>
                                    <a href="javascript:void(0);" class="btn dso-ebtn dso-ebtn-solid chat-now">
                                        <span class="dso-btn-text">Support</span>
                                        <div class="dso-btn-bg-holder"></div>
                                    </a>
                                </div>

                                <h2>Spectators</h2>

                                <div class="box-flex-row">
                                <?php foreach($tournamentSpectators as $spectator): ?>
                                    <div class="dso-article-box">
                                        <div class="icon-wrap">
                                            <img src="<?= base_url(); ?>assets/frontend/images/categories/icon-account.png">
                                        </div>
                                        <div class="dso-article-content">
                                            <h2>Spectator</h2>
                                            <p><?= $spectator->username; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2>Match Status</h2>

                                    <?php 
                                        $matchTime = $meta->get_tournament_match_meta($currentMatch[0]->id, 0, 'match_result_time');
                                        $matchTime = date('M d, Y H:i:s', strtotime($matchTime));

                                        $clockStatus = '';

                                        if($currentMatch[0]->match_status == 4) {
                                            $clockStatus = 'pause-clock';
                                            $matchTime = '';
                                        }
                                    ?>
                                    <div class="match-timer-box">
                                        <input type="hidden" name="timeStart" value="<?= date('M d, Y H:i:s'); ?>" />
                                        <input type="hidden" name="matchTimeEnd" value="<?= $matchTime; ?>" />
                                        <span class="match-timer <?= $clockStatus; ?>"></span>
                                    </div>
                                </div>

                                <div class="players-match-table">
                                <?php 
                                    //If this is manual or auto matches system
                                    $matchTypeManual = array(1, 4);
                                    if(in_array($tournamentData[0]->type, $matchTypeManual)) { 
                                ?>
                                <?php
                                    // Player 1 User Details
                                    $player_1_get_image = $meta->get_user_meta('user_image', $currentMatch[0]->player_1_ID);
                                                                        
                                    if($player_1_get_image == null) {
                                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $currentMatch[0]->player_1_ID . '/' . $player_1_get_image;
                                    }
                                    
                                    $username_player_1 = $meta->get_username($currentMatch[0]->player_1_ID);

                                    // Player 2 User Details
                                    $player_2_get_image = $meta->get_user_meta('user_image', $currentMatch[0]->player_2_ID);
                                                
                                    if($player_2_get_image == null) {
                                        $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $currentMatch[0]->player_2_ID . '/' . $player_2_get_image;
                                    }
                                    
                                    $username_player_2 = $meta->get_username($currentMatch[0]->player_2_ID);

                                    $player_1_result = '';
                                    $player_2_result = '';

                                    if($currentMatch[0]->winnerID > 0) {
                                        $player_1_result = ($currentMatch[0]->winnerID == $currentMatch[0]->player_1_ID) ? 'dso-winner' : 'dso-looser';
                                        $player_2_result = ($currentMatch[0]->winnerID == $currentMatch[0]->player_2_ID) ? 'dso-winner' : 'dso-looser';
                                    }

                                    $result_class = ($currentMatch[0]->winnerID == 0) ? '-outline' : ''; 
                                ?>  
                                    <div class="match-status">
                                        <?php 
                                            if($currentMatch[0]->match_status == 0) {
                                                $matchStatus = 'Awaiting For Both Opponenets To Be Ready To Get Started';
                                                $matchStatusClass = 'warning';
                                            }

                                            if($currentMatch[0]->match_status == 1) {
                                                $matchStatus = 'Both Opponenets Ready. Waiting For Spectator To Start Match';
                                                $matchStatusClass = 'info';
                                            }

                                            if($currentMatch[0]->match_status == 2) {
                                                $matchStatus = 'Match Started';
                                                $matchStatusClass = 'success';
                                            }

                                            if($currentMatch[0]->match_status == 3) {
                                                $matchStatus = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
                                                $matchStatusClass = 'info';
                                            }

                                            if($currentMatch[0]->match_status == 4) {
                                                $matchStatus = 'Match In Dispute';
                                                $matchStatusClass = 'danger';
                                            }

                                            if($currentMatch[0]->match_status == 5) {
                                                if($currentMatch[0]->player_1_ID == $currentMatch[0]->winnerID) {
                                                    $winnerUsername = $username_player_1;
                                                } else {
                                                    $winnerUsername = $username_player_2;
                                                }

                                                $matchStatus = 'Match Completed. ' . $winnerUsername . ' Won The Match';
                                                $matchStatusClass = 'success';
                                            }

                                            $player_1_decision = $meta->get_tournament_match_meta($currentMatch[0]->id, $currentMatch[0]->player_1_ID, 'player_1_decision');
                                            $player_2_decision = $meta->get_tournament_match_meta($currentMatch[0]->id, $currentMatch[0]->player_2_ID, 'player_2_decision');
                                                    
                                        ?>
                                        <span id="match-<?= $currentMatch[0]->id; ?>" class="badge badge-<?= $matchStatusClass; ?>"><?= $matchStatus; ?></span>
                                        <div id="messageBox"></div>
                                    </div>
                                    <div class="match-row" id="match-<?= $currentMatch[0]->id; ?>">
                                        <?php if($currentMatch[0]->player_2_ID == $userID) { ?>
                                            <a href="<?= base_url(); ?>account/getPlayerMatchChat" class="btn btn-match-chat" data-match-id="<?= $currentMatch[0]->id; ?>" data-player="2" data-id="<?= $currentMatch[0]->player_1_ID; ?>" data-type="2">
                                                <i class="fa fa-commenting"></i>
                                                <span>Message</span>
                                            </a>
                                        <?php } ?>
                                        <div class="match-player" id="slot-1" data-player-status="<?= $currentMatch[0]->player_1_status; ?>" data-player-dec="<?= $player_1_decision; ?>">
                                            <div class="user-thumb">
                                                <img src="<?= $player_1_thumnail_url; ?>" />
                                            </div>

                                            <label class="player-<?= $currentMatch[0]->player_1_ID; ?>">
                                                <?= ($currentMatch[0]->player_1_ID > 0) ? $username_player_1 : 'Free Slot'; ?>
                                                <?php if($currentMatch[0]->winnerID > 0 && $currentMatch[0]->winnerID == $currentMatch[0]->player_1_ID) { ?>                 
                                                <label class="badge badge-success">Winner</label>
                                                <?php } ?>

                                                <?php if($currentMatch[0]->winnerID > 0 && $currentMatch[0]->winnerID == $currentMatch[0]->player_2_ID) { ?>                 
                                                <label class="badge badge-danger">Looser</label>
                                                <?php } ?>
                                                <?php 
                                                $startMatchText = '';
                                                $startMatchdiv = '<span class="start-match">';
                                                    if($currentMatch[0]->match_status < 5) {
                                                        if($currentMatch[0]->player_1_ID != $userID) {    
                                                            if($player_1_decision != '') {    
                                                                if($player_1_decision == 0) {
                                                                    $startMatchText =  'Waiting For Your Opponent Decision';
                                                                }

                                                                if($player_1_decision == 1) {
                                                                    $startMatchText =  'Your Oppenent Accepeted The Results';
                                                                }

                                                                if($player_1_decision == 2) {
                                                                    $startMatchText =  'Your Oppenent Filed Dispute';
                                                                }
                                                            }
                                                        } else {
                                                            if($player_1_decision == 1) {
                                                                $startMatchText =  'You Accepeted The Results';
                                                            }

                                                            if($player_1_decision == 2) {
                                                                $startMatchText = 'You Filed Dispute';
                                                            }
                                                        }
                                                    }
                                                ?>

                                                <?php 
                                                    if($currentMatch[0]->match_status < 3) { 
                                                       if($currentMatch[0]->player_1_ID != $userID) { 
                                                            if($currentMatch[0]->player_1_ID == 0) { 
                                                                $startMatchText = 'No opponent assigned'; 
                                                            } else { 
                                                                if($currentMatch[0]->player_1_status > 0) { 
                                                                    if($currentMatch[0]->match_status == 2) { 
                                                                        $startMatchText = 'Match Inprogress';
                                                                    } else { 
                                                                        $startMatchText = 'Your Opponent Is Ready';
                                                                    } 
                                                                } else {
                                                                    $startMatchText = 'Your Opponent Is Not Ready';
                                                                }
                                                            } 
                                                        } else { 
                                                            if($currentMatch[0]->player_1_status > 0) { 
                                                                if($currentMatch[0]->match_status == 2) { 
                                                                    $startMatchText = 'Match Inprogress';
                                                                } else { 
                                                                    $startMatchText = 'You Are Ready To Play';
                                                                }
                                                            } else {
                                                                if($currentMatch[0]->player_2_ID > 0) {
                                                                    $startMatchText = '<a href="'. base_url() . 'account/matches/setReady/'. $currentMatch[0]->id . '/1" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
                                                                } 
                                                            }
                                                        }
                                                    } 

                                                    if($currentMatch[0]->match_status == 5) {
                                                        if($currentMatch[0]->player_1_ID != $userID) {    
                                                            if($player_1_decision == 1) {
                                                                $startMatchText =  'Your Oppenent Accepeted The Results';
                                                            }
                                                        } else {
                                                            if($player_1_decision == 1) {
                                                                $startMatchText =  'You Accepeted The Results';
                                                            }
                                                        }
                                                    }
                                                    
                                                    $startMatchdiv .= $startMatchText;
                                                    $startMatchdiv .= '</span>';

                                                    if(isset($startMatchText) && $startMatchText != '') {
                                                        echo $startMatchdiv;
                                                    }
                                                ?>

                                                <?php if($currentMatch[0]->match_status == 3) { ?>
                                                    <?php if($currentMatch[0]->player_1_ID == $userID) { ?>
                                                        <?php if($player_1_decision != ''  && $player_1_decision == 0) { ?>
                                                        <div class="btn-row">
                                                            <a href="<?= base_url(); ?>account/matches/acceptMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_1_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>
                                                            <a href="<?= base_url(); ?>account/matches/disputeMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_1_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>
                                                        </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </label>
                                        </div>

                                        <div class="mid-vs">
                                            <div class="user-score" id="slot-1-score">
                                                <h2>
                                                    <?= $currentMatch[0]->player_1_score; ?>
                                                </h2>
                                                <?php if($currentMatch[0]->match_status < 5) { ?>
                                                <?php if($currentMatch[0]->player_1_status == 1 && $currentMatch[0]->player_2_status == 1) { ?>
                                                <?php if($currentMatch[0]->player_1_ID == $userID) { ?>
                                                <div class="setScore-form">
                                                    <form method="POST" action="<?= base_url(); ?>account/matches/setScore/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_1_ID; ?>" class="setScore" onsubmit="return false;">
                                                        <div class="inline-field">
                                                            <input type="text" name="player_score" value="<?= $currentMatch[0]->player_1_score; ?>" class="form-control" />
                                                            <input type="hidden" name="player" value="1" />
                                                            <input type="hidden" name="userType" value="0" />

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
                                                    <a href="javascript:void(0);" class="add-score">Submit Score</a>
                                                </div>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php } ?>
                                            </div>

                                            <span>VS</span>

                                            <div class="user-score" id="slot-2-score">
                                                <h2>
                                                    <?= $currentMatch[0]->player_2_score; ?>
                                                </h2>
                                                <?php if($currentMatch[0]->match_status < 5) { ?>
                                                <?php if($currentMatch[0]->player_1_status == 1 && $currentMatch[0]->player_2_status == 1) { ?>
                                                <?php if($currentMatch[0]->player_2_ID == $userID) { ?>
                                                <div class="setScore-form">
                                                    <form method="POST" action="<?= base_url(); ?>account/matches/setScore/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_2_ID; ?>" class="setScore" onsubmit="return false;">
                                                        <div class="inline-field">
                                                            <input type="text" name="player_score" value="<?= $currentMatch[0]->player_2_score; ?>" class="form-control" />
                                                            <input type="hidden" name="player" value="2" />
                                                            <input type="hidden" name="userType" value="0" />
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
                                                    <a href="javascript:void(0);" class="add-score">Submit Score</a>
                                                </div>
                                                <?php } ?>
                                                <?php } ?>
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

                                        <div class="match-player match-right" id="slot-2" data-player-status="<?= $currentMatch[0]->player_2_status; ?>" data-player-dec="<?= $player_2_decision; ?>">
                                            <label class="player-<?= $currentMatch[0]->player_2_ID; ?>">
                                                <?= ($currentMatch[0]->player_2_ID > 0) ? $username_player_2 : 'Free Slot'; ?>
                                                <?php if($currentMatch[0]->winnerID > 0 && $currentMatch[0]->winnerID == $currentMatch[0]->player_2_ID) { ?>                 
                                                <label class="badge badge-success">Winner</label>
                                                <?php } ?>

                                                <?php if($currentMatch[0]->winnerID > 0 && $currentMatch[0]->winnerID == $currentMatch[0]->player_1_ID) { ?>                 
                                                <label class="badge badge-danger">Looser</label>
                                                <?php } ?>

                                                <?php 
                                                    $startMatchText2 = '';
                                                    $startMatchdiv2 = '<span class="start-match">'; 
                                         
                                                    if($currentMatch[0]->match_status < 5) {
                                                        if($currentMatch[0]->player_2_ID != $userID) {    
                                                            if($player_2_decision != '') {

                                                                if($player_2_decision == 0) {
                                                                    $startMatchText2 = 'Waiting For Your Opponent Decision';
                                                                }

                                                                if($player_2_decision == 1) {
                                                                    $startMatchText2 = 'Your Oppenent Accepeted The Results';
                                                                }

                                                                if($player_2_decision == 2) {
                                                                    $startMatchText2 = 'Your Oppenent Filed Dispute';
                                                                }
                                                            }
                                                        } else {
                                                                
                                                            if($player_2_decision == 1) {
                                                                $startMatchText2 = 'You Accepeted The Results';
                                                            }

                                                            if($player_2_decision == 2) {
                                                                $startMatchText2 = 'You Filed Dispute';
                                                            }
                                                        }
                                                    }
                                                    
                                                    if($currentMatch[0]->match_status < 3) { 
                                                        if($currentMatch[0]->player_2_ID != $userID) { 
                                                            if($currentMatch[0]->player_2_ID == 0) { 
                                                                $startMatchText2 = 'No opponent assigned';
                                                            } else {
                                                                if($currentMatch[0]->player_2_status > 0) { 
                                                                    if($currentMatch[0]->match_status == 2) { 
                                                                        $startMatchText2 = 'Match Inprogress';
                                                                    } else { 
                                                                        $startMatchText2 = 'Your Opponent Is Ready';
                                                                    }
                                                                } else {
                                                                    $startMatchText2 = 'Your Opponent Is Not Ready';
                                                                }
                                                            }
                                                        } else { 
                                                            if($currentMatch[0]->player_2_status > 0) { 
                                                                if($currentMatch[0]->match_status == 2) {
                                                                    $startMatchText2 = 'Match Inprogress';
                                                                } else { 
                                                                    $startMatchText2 = 'You Are Ready To Play';
                                                                }
                                                            } else {
                                                                if($currentMatch[0]->player_1_ID > 0) {
                                                                    $startMatchText2 = '<a href="' . base_url() . 'account/matches/setReady/' . $currentMatch[0]->id . '/2" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
                                                                } 
                                                            } 
                                                        } 
                                                    } 

                                                    if($currentMatch[0]->match_status == 5) {
                                                        if($currentMatch[0]->player_2_ID != $userID) {    
                                                            if($player_2_decision == 1) {
                                                                $startMatchText2 =  'Your Oppenent Accepeted The Results';
                                                            }
                                                        } else {
                                                            if($player_2_decision == 1) {
                                                                $startMatchText2 =  'You Accepeted The Results';
                                                            }
                                                        }
                                                    }

                                                    $startMatchdiv2 .= $startMatchText2;
                                                    $startMatchdiv2 .= '</span>';

                                                    if(isset($startMatchText2) && $startMatchText2 != '') {
                                                        echo $startMatchdiv2;
                                                    }
                                                ?>

                                                <?php if($currentMatch[0]->match_status == 3) { ?>
                                                    <?php if($currentMatch[0]->player_2_ID == $userID) { ?>
                                                        <?php if($player_2_decision != ''  && $player_2_decision == 0) { ?>
                                                        <div class="btn-row">
                                                            <a href="<?= base_url(); ?>account/matches/acceptMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_2_ID; ?>" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>
                                                            <a href="<?= base_url(); ?>account/matches/disputeMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_2_ID; ?>" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>
                                                        </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </label>
                                            
                                            <div class="user-thumb">
                                                <img src="<?= $player_2_thumnail_url; ?>" />
                                            </div>
                                        </div>

                                        <?php if($currentMatch[0]->player_1_ID == $userID) { ?>
                                            <a href="<?= base_url(); ?>account/getPlayerMatchChat" class="btn btn-match-chat" data-match-id="<?= $currentMatch[0]->id; ?>" data-player="2" data-id="<?= $currentMatch[0]->player_2_ID; ?>" data-type="2">
                                                <i class="fa fa-commenting"></i>
                                                <span>Message</span>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    

                                    <?php if($currentMatch[0]->match_status < 5) { ?>
                                    <div class="btn-center" id="decisionBtn">
                                    <?php if($currentMatch[0]->player_1_score > 0 && $currentMatch[0]->player_2_score > 0) { ?>
                                        <a href="<?= base_url(); ?>account/matches/setWinner/<?= $currentMatch[0]->id; ?>/<?= $userID; ?>/0" class="btn dso-ebtn dso-ebtn-solid btn-match-complete">
                                            <span class="dso-btn-text">Submit Results</span>
                                            <div class="dso-btn-bg-holder"></div>
                                        </a>
                                    <?php } ?>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($tournamentData[0]->type == 2) { ?>
                                <?php 
                                    $player_1_get_image = $meta->get_user_meta('user_image', $currentMatch[0]->player_1_ID);
                                                                        
                                    if($player_1_get_image == null) {
                                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $currentMatch[0]->player_1_ID . '/' . $player_1_get_image;
                                    }
                                    
                                    $username_player_1 = $meta->get_username($currentMatch[0]->player_1_ID);

                                    $result_class = ($currentMatch[0]->winnerID == 0) ? '-outline' : ''; 
                                    $player_1_result = '';
                                    if($currentMatch[0]->winnerID > 0) {
                                        $player_1_result = ($currentMatch[0]->winnerID == $currentMatch[0]->player_1_ID) ? 'dso-winner' : 'dso-looser';
                                    }
                                ?>
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
                                        <div class="user-score" id="slot-1-score">
                                            <h2><?= $currentMatch[0]->player_1_score; ?></h2>
                                        </div>

                                        <div class="btn-action">
                                            <div class="elimination-player-status">
                                            <?php if($currentMatch[0]->player_1_status == 1) { ?>
                                                <?php if($currentMatch[0]->status == 1) { ?>
                                                    <span class="start-match">Playing</span> 
                                                <?php } ?>

                                                <?php 
                                                    if($currentMatch[0]->match_status == 3) {  
                                                        if($player_1_decision != '') {                       
                                                            if($player_1_decision == 0) {
                                                ?>
                                                                <div class="btn-row">
                                                                    <a href="<?= base_url(); ?>account/matches/acceptMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_1_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>
                                                                    <a href="<?= base_url(); ?>account/matches/disputeMatch/<?= $currentMatch[0]->id; ?>/<?= $currentMatch[0]->player_1_ID; ?>" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>
                                                                </div>
                                                <?php 
                                                            }
                                                        }
                                                    }

                                                    if($currentMatch[0]->match_status == 4) {  
                                                        echo '<span class="start-match">';
                                                        if($player_1_decision != '') {
                                                            if($player_1_decision == 2) {
                                                                echo 'You Filed Dispute';
                                                            }    
                                                        }
                                                        echo '</span>';
                                                    }

                                                    if($player_1_decision != '') {       
                                                        if($player_1_decision == 1) {
                                                            echo '<span class="start-match">You Accepted The Result</span>';
                                                        }
                                                    }
                                                ?>
                                            <?php } else { ?>
                                                <a href="<?= base_url(); ?>account/matches/setReady/<?= $currentMatch[0]->id; ?>/1" class="btn dso-ebtn-sm btn-dark btn-set-ready">I'm Ready</a>
                                            <?php } ?>

                                            <?php if($currentMatch[0]->status == 2) { ?>
                                            <span class="badge badge-success">Qualified</span>
                                            <?php } ?>

                                            <?php if($currentMatch[0]->status == 0) { ?>
                                            <span class="badge badge-danger">Eliminated</span>
                                            <?php } ?>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                </div>
                                
                                <input type="hidden" name="tournamentID" value="<?= $tournamentData[0]->id; ?>" />
                                <input type="hidden" name="matchID" value="<?= $currentMatch[0]->id; ?>" />
                                <input type="hidden" name="matchStatusUrl" value="<?= base_url(); ?>account/matches/assignResult/<?= $currentMatch[0]->id; ?>" />
                                <input type="hidden" name="matchStatus" value="<?= $currentMatch[0]->match_status; ?>" />
                            </div>

                            <div class="chat-wrapper">
                                <div class="chat-inner-wrapper">
                                    <div class="chat-header">
                                        <h2>User Chat</h2>
                                        <a href="#" class="close-chat">
                                            <span></span><span></span>
                                        </a>
                                    </div>

                                    <div class="chat-area individual-match-chat">
                                        <ul id="chat">  
                                        <?php
                                            if(count($messagesData) > 0) { 
                                            foreach($messagesData as $message):
                                        ?>
                                        <li class="<?= ($message->senderID != $userID) ? 'you' : 'me'; ?>">
                                            <div class="entete">
                                            <?php 
                                                $username = $meta->get_username($message->senderID);
                                                
                                                if($message->senderID == $userID) {
                                                    echo "<h3>" . date('l h:i A', strtotime($message->timeStamp)) . "</h3>";
                                                    echo "<h2>" . $username . "</h2>";
                                                    echo '<span class="status blue"></span>';                           
                                                } else {
                                                    echo '<span class="status green"></span>';
                                                    echo "<h2>" . $username . "</h2>";
                                                    echo "<h3>" . date('l h:i A', strtotime($message->timeStamp)) . "</h3>";
                                                }
                                            ?>
                                            </div>
                                        
                                            
                                            <?php if($message->message != null) { ?>
                                            <div class="message">
                                                <?= $message->message; ?>
                                            </div>
                                            <?php } ?>

                                            <?php
                                                if($message->fileData != null) {
                                                    echo '<div class="fileData zoom-gallery">';

                                                    $fileData    = unserialize($message->fileData);
                                                    $folderPath  = base_url() . 'assets/uploads/messages/tournament-match-chat-' . $message->chatID . '/';
                                                    
                                                    foreach($fileData as $file):
                                                        echo '<div class="chat-image">';
                                                        echo '<a href="'.$folderPath.'/'.$file.'" data-effect="mfp-move-horizontal">';
                                                        echo '<img src="'.$folderPath.'/'.$file.'" />';
                                                        echo '</a>';
                                                        echo '</div>';
                                                    endforeach;

                                                    echo '</div>';
                                                }
                                            ?>
                                        </li>
                                        <?php
                                                endforeach;
                                            }
                                        ?>  
                                        </ul>
                                        <a href="javascript:void(0);" class="jump-bottom" style="display: none;">You Have New Message</a>   
                                    </div>

                                    <div class="chat-text-wrap">
                                        <form method="POST" action="<?= base_url(); ?>account/sendMatchMessage" class="sendMessage" onsubmit="return false;">
                                            <textarea placeholder="Type your message" name="message"></textarea>
                                            <input type="hidden" name="thread" value="<?= $chatID; ?>" />
                                            <input type="hidden" name="tournamentMatchID" value="<?= $currentMatch[0]->id; ?>" />
                                            <input type="hidden" name="chatCount" value="<?= count($messagesData); ?>" />
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
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="dispute-form">
                                <div class="chat-header">
                                    <h2>File Dispute</h2>
                                    <a href="#" class="close-dispute-form">
                                        <span></span><span></span>
                                    </a>
                                </div>

                                <div class="dispute-form-inner">
                                    <form method="POST" action="" class="process-dispute-request" onsubmit="return false;" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <textarea name="description" class="form-control" rows="6" placeholder="Please describe the reason for declining the results"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Please Provide A Screenshot</label>
                                            <input type="file" name="fileimage" class="form-control" />
                                        </div>

                                        <input type="hidden" name="slot" class="form-control" />
                                        
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
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="chatMainUrl" value="<?= base_url(); ?>account/updateMatchChat" />
<script>
    var threadID    = '<?= $chatID; ?>';
    var chatFileUrl = '<?= base_url(); ?>account/processChatFile';
    var chatMainUrl = '<?= base_url(); ?>account/updateMatchChat';
</script>