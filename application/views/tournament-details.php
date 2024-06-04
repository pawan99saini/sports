<div class="dso-main">
    <div class="dso-page-bannner dso-banner-overlay dso-tournament-banner" style="background-image: url('<?= base_url(); ?>assets/frontend/images/games/<?= $ci->game_name($tournamentData[0]->game_slug)[0]->game_image; ?>');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1><?= $tournamentData[0]->title; ?></h1>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="item-right">
                    <?php 
                    $checkTournament = $ci->checkTournamentRegistration($tournamentData[0]->id, $this->session->userdata('user_id'));
                    if(count($participents) < $tournamentData[0]->max_allowed_players) { 
                        //Check If User is logged in 
                        if($this->session->userdata('is_logged_in') == true) {
                            if($checkTournament == 0) { 
                    ?>
                                <a href="<?= base_url(); ?>tournaments/<?= $tournamentData[0]->category_slug . '/' . $tournamentData[0]->game_slug . '/' . $tournamentData[0]->slug; ?>/join" class="btn dso-ebtn dso-ebtn-solid">
                                    <span class="dso-btn-text">Register</span>
                                    <div class="dso-btn-bg-holder"></div>
                                </a>
                            <?php } else { ?>
                                <a class="btn dso-ebtn dso-ebtn-solid">
                                    <span class="dso-btn-text">Registered</span>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="<?= base_url(); ?>tournaments/<?= $tournamentData[0]->category_slug . '/' . $tournamentData[0]->game_slug . '/' . $tournamentData[0]->slug; ?>/join" class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Register</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <a class="btn dso-ebtn dso-ebtn-solid dso-ebtn-disabled">
                            <span class="dso-btn-text">Registration Closed</span>
                        </a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
        $meta_prize       = unserialize($tournamentData[0]->meta_title); 
        $meta_prize_price = unserialize($tournamentData[0]->meta_description); 
    ?>

    <div class="dso-profile-meta-info">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="dso-main-info">
                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-trophy"></div>
                                <span class="dso-player-info-title"><?= $meta_prize_price[0]; ?></span>
                            </div>

                            <h5>Total Prize Pool</h5>
                        </div>
                    </div>

                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-clock"></div>
                                <span class="dso-player-info-title"><?= $tournamentData[0]->time; ?></span>
                            </div>

                            <h5>Tournament Time</h5>
                        </div>
                    </div>

                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-android-calendar"></div>
                                <span class="dso-player-info-title"><?= date('F d, Y', strtotime($tournamentData[0]->organized_date)); ?></span>
                            </div>

                            <h5>Tournament Date</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="dso-signedup-players">
                    <div class="dso-players-info-title">
                        <?php 
                            if($tournamentData[0]->allowed_participants == 1) {
                                $participents_text = 'Teams';
                            } else {
                                $participents_text = 'Players';
                            }
                        ?>
                        <span><?= $participents_text; ?> Joined</span>
                        <h3><?= count($participents); ?></h3>
                    </div>

                    <div class="dso-sm-players-list">
                        <?php 
                        if(count($participents) > 0) { 
                            $i = 1; 
                            foreach($participents as $participent) { 
                                if($i <= 3) {   
                                    $get_image = $ci->get_user_meta('user_image', $participent->participantID);
                                    $participentUsername = $ci->get_username($participent->participantID);
                                    if($get_image == null) {
                                        $image_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $image_url = base_url() . 'assets/uploads/users/user-' . $participent->participantID . '/' . $get_image;
                                    }
                        ?>    
                                    <div class="teams-thumnail-circle">
                                        <?php 
                                            if($participent->type == 5) {
                                                $url_profile = base_url() . 'team';
                                            } else {
                                                $url_profile = base_url() . 'profile';
                                            } 
                                        ?>

                                        <a href="<?= $url_profile . '/' . $participentUsername; ?>">
                                            <img src="<?= $image_url; ?>" />
                                        </a>
                                    </div>
                            <?php } ?>
                        <?php $i++; ?>
                        <?php } ?>
                            <?php $remNumPlayers = count($participents) - 3; ?>
                            <?php if($remNumPlayers > 0) { ?>
                            <div class="teams-thumnail-circle">
                                <a href="javascript:void(0);" class="target-tab" data-target="#participants">
                                    <h2>+<?= $remNumPlayers; ?></h2>
                                </a>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dso-tournament-details-wrapper">
        <div class="container">
            <div class="nav-tabs">
                <a href="#overview" class="dso-nav-tabs dso-nav-current">Overview</a>
                <a href="#participants" class="dso-nav-tabs">Participants</a>
                <a href="#matches" class="dso-nav-tabs">Matches</a>
                <?php if($tournamentData[0]->brackets == 1) { ?>
                <a href="#brackets" class="dso-nav-tabs">Brackets</a>
                <?php } ?>
                <a href="#stats" class="dso-nav-tabs">Stats</a>
                <a href="#announcements" class="dso-nav-tabs">
                    Announcements
                    <?php 
                        if(count($announcmentsData) > 0) {
                            echo '<span class="bubble-notify">' . count($announcmentsData) . '</span>';
                        }
                    ?>
                </a>
            </div>

            <div class="loader-wrapper load-tournament">
                <div class="loader-sub" id="login-load" style="display: block;">
                    <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            <div class="dso-tab-wrapper" id="overview">
                <?php if(!empty($tournamentData[0]->image)) { ?>
                <div class="dso-full-img m-b-60">
                    <img src="<?= base_url(); ?>assets/frontend/images/tournaments/<?= $tournamentData[0]->image; ?>">
                </div>
                <?php } ?>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Overview</h3>
                    </div>

                    <div class="text-white text-lg-2"><?= $ci->clean_content($tournamentData[0]->description); ?></div>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Details</h3>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="dso-player-meta player-meta-sm m-b-20">
                                <div class="dso-icon-sm">
                                    <div class="dso-role-icon ion-ios-game-controller-b"></div>
                                    <span class="dso-player-info-title">Game</span>
                                </div>
                                <p><?= $tournamentData[0]->game_name; ?></p>
                            </div>

                            <div class="dso-player-meta player-meta-sm m-b-20">
                                <div class="dso-icon-sm">
                                    <div class="dso-role-icon ion-ios-location"></div>
                                    <span class="dso-player-info-title">Region</span>
                                </div>
                                <p><?= $tournamentData[0]->region; ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="dso-player-meta player-meta-sm m-b-20">
                                <div class="dso-icon-sm">
                                    <div class="dso-role-icon ion-ios-game-controller-a"></div>
                                    <span class="dso-player-info-title">Format</span>
                                </div>
                                <p><?= $tournamentData[0]->format; ?></p>
                            </div>

                            <div class="dso-player-meta player-meta-sm m-b-20">
                                <div class="dso-icon-sm">
                                    <div class="dso-role-icon ion-map"></div>
                                    <span class="dso-player-info-title">Game Map</span>
                                </div>
                                <p><?= $tournamentData[0]->game_map; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Prize Pool</h3>
                    </div>

                    <div class="prize-inner-body">
                    <?php 
                        $i       = 0;
                        $row     = 5;
                        $divider = round(count($meta_prize) / 2);
                        $remain  = count($meta_prize) - $divider; 
                        
                        $meta_prizes_division =  array_chunk($meta_prize, ceil(count($meta_prize) / 2));
                        
                        echo '<ul class="prize-item-list">';
                        echo '<li class="item-header">
                                 <h4>Placement</h4>
                                 <h4>Prize</h4>
                              </li>';
                        foreach($meta_prizes_division[0] as $prize) {
                            echo '<li class="rank">
                                <div class="pol"><div class="dso-role-icon ion-trophy"></div><span>'.$prize.'</span></div>
                                <span>'.$meta_prize_price[$i].'</span>
                            </li>';
                            $i++;

                        }
                        echo '</ul>';

                        if(isset($meta_prizes_division[1])) {
                            echo '<ul class="prize-item-list">';
                            echo '<li class="item-header">
                                     <h4>Placement</h4>
                                     <h4>Prize</h4>
                                  </li>';
                            foreach($meta_prizes_division[1] as $prize) {
                                echo '<li class="rank">
                                    <div class="pol"><div class="dso-role-icon ion-trophy"></div><span>'.$prize.'</span></div>
                                    <span>'.$meta_prize_price[$i].'</span>
                                </li>';
                                $i++;
                            }
                            echo '</ul>';
                        }
                    ?>    
                    </div>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Rules & regulations</h3>
                    </div>

                    <div class="text-white text-lg-2"><?= $ci->clean_content($tournamentData[0]->rules); ?></div>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Schedule</h3>
                    </div>

                    <div class="text-white text-lg-2"><?= $ci->clean_content($tournamentData[0]->schedule); ?></div>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Contact</h3>
                    </div>

                    <div class="text-white text-lg-2"><?= $ci->clean_content($tournamentData[0]->contact); ?></div>
                </div>
            </div>

            <div class="dso-tab-wrapper" id="participants">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Participants</h3>
                    </div>
                </div>

                <div class="box-row" id="players">
                    <?php if(count($participents) > 0) { ?>
                        <?php foreach($participents as $participent): ?>
                        <div class="player-box">
                            <div class="player-tumb">
                                <?php 
                                    $get_image = $ci->get_user_meta('user_image', $participent->participantID);
                                    
                                    if($get_image == null) {
                                        $image_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $image_url = base_url() . 'assets/uploads/users/user-' . $participent->participantID . '/' . $get_image;
                                    }
                                ?>
                                <img src="<?= $image_url; ?>">
                            </div>

                            <div class="player-content">
                                <h3><?= $participent->username; ?></h3>

                                <p>
                                    <i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>
                                    0 Tournaments Won
                                </p>

                                <?php 
                                    if($participent->type == 4) {
                                        $url_profile = 'team/';
                                    } else {
                                        $url_profile = 'profile/';
                                    } 
                                ?>

                                <a href="<?= base_url() . $url_profile . $participent->username; ?>" target="_blank" class="channel-btn-red">View Profile</a>
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
            </div>

            <div class="dso-tab-wrapper" id="matches">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Matches</h3>
                    </div>
                </div>

                <?php if($tournamentData[0]->max_allowed_players == count($participents) && count($tournamentMatches) > 0) { ?>
                <?php 
                    $matches = count($tournamentMatches);
                ?>
                <div class="row">
                <?php foreach($totalRounds as $round): ?> 
                <?php 
                    if($round->round == 1) {
                        $active_class = ' active-btn';
                    } else {
                        $active_class = '';
                    }
                ?>   
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="bracket-menu <?= $active_class; ?>">
                            <a href="<?= base_url(); ?>home/getMatches/<?= $tournamentData[0]->id . '/' . $round->round; ?>" class="getMatchRound">
                                <div class="single-item text-center">
                                    <h5>Round <?= $round->round; ?></h5>
                                    <p><?= $round->total_matches; ?> Matches</p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>    
                </div>

                <div class="matches-table">
                    <?php foreach($tournamentMatches as $matches): ?>
                    <?php 
                        if($matches->round == 1) {
                        // Player 1 User Details
                        $player_1_get_image = $ci->get_user_meta('user_image', $matches->player_1_ID);
                                    
                        if($player_1_get_image == null) {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $matches->player_1_ID . '/' . $player_1_get_image;
                        }
                        
                        $username_player_1 = $ci->get_username($matches->player_1_ID);

                        // Player 2 User Details
                        $player_2_get_image = $ci->get_user_meta('user_image', $matches->player_2_ID);
                                    
                        if($player_2_get_image == null) {
                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $matches->player_2_ID . '/' . $player_2_get_image;
                        }
                        
                        $username_player_2 = $ci->get_username($matches->player_2_ID);

                        $player_1_result = '';
                        $player_2_result = '';

                        if($matches->winnerID > 0) {
                            $player_1_result = ($matches->winnerID == $matches->player_1_ID) ? 'dso-winner' : 'dso-looser';
                            $player_2_result = ($matches->winnerID == $matches->player_2_ID) ? 'dso-winner' : 'dso-looser';
                        }

                        $result_class = ($matches->winnerID == 0) ? '-outline' : '';
                    ?>    
                        <?php if($tournamentData[0]->type == 2) { ?>
                            <?php 
                                if($matches->status == 0) {
                                    $player_result = 'badge-danger';
                                    $player_result_message = " Eliminated";
                                }

                                if($matches->status == 1) {
                                    $player_result = 'badge-warning';
                                    $player_result_message = " Playing";
                                }

                                if($matches->status == 2) {
                                    $player_result = 'badge-success';
                                    $player_result_message = " Qualified";
                                }
                            ?>
                            <div class="matches-table manage-matches">
                                <div class="match-row match-elimination">
                                    <div class="match-player">
                                        <div class="user-thumb">
                                            <img src="<?= $player_1_thumnail_url; ?>" />
                                        </div>

                                        <label>
                                            <?= $username_player_1; ?>
                                            <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                            <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $matches->player_1_ID; ?>">View Players</a>
                                            <?php } ?>
                                        </label>
                                    </div>

                                    <div class="match-data-set">
                                        <div class="user-score">
                                            <h2><?= $matches->player_1_score; ?></h2>
                                        </div>

                                        <div class="btn-action">
                                            <span class="badge <?= $player_result ; ?>">
                                                <?= $player_result_message; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>    
                            <div class="match-row">
                                <div class="match-player">
                                    <span class="dso-match-icon ion-ios-star<?= $result_class; ?> <?= $player_1_result; ?>"></span>

                                    <div class="user-thumb">
                                        <img src="<?= $player_1_thumnail_url; ?>" />
                                    </div>

                                    <label>
                                        <?= $username_player_1; ?>
                                        <?= ($matches->winnerID == $matches->player_1_ID) ? '<label class="badge badge-success">Winner</label>' : '' ;?>    
                                        <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                        <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $matches->player_1_ID; ?>">View Players</a>
                                        <?php } ?>
                                    </label>
                                </div>

                                <div class="mid-vs">
                                    <h2><?= $matches->player_1_score; ?></h2>
                                    <span>VS</span>
                                    <h2><?= $matches->player_2_score; ?></h2>
                                </div>

                                <div class="match-player match-right">
                                    <label>
                                        <?= ($matches->winnerID == $matches->player_2_ID) ? '<label class="badge badge-success">Winner</label>' : '' ;?>
                                        <?= $username_player_2; ?>         
                                        <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                        <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $matches->player_2_ID; ?>">View Players</a>
                                        <?php } ?>                                   
                                    </label>
                                    
                                    <div class="user-thumb">
                                        <img src="<?= $player_2_thumnail_url; ?>" />
                                    </div>

                                    <span class="dso-match-icon ion-ios-star<?= $result_class; ?> <?= $player_2_result; ?>"></span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php endforeach; ?>
                </div>
                <?php } else { ?>
                <div class="dso-inner-404">
                    <img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
                    <h2>Sorry No Matches Found</h2>
                </div>
                <?php } ?>            
            </div>

            <?php if($tournamentData[0]->brackets == 1) { ?>
            <div class="dso-tab-wrapper active-nav-tab" id="brackets">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Brackets</h3>
                    </div>
                </div>

                <?php $deClass = ''; ?>
                <?php if($tournamentData[0]->type == 4) { ?>
                <?php $deClass = 'mb-100'; ?>
                <?php } ?>

                <div class="brackets">
                    <?php if($tournamentData[0]->max_allowed_players == count($participents)) { ?>
                    <div class="bracket-wrapper">
                        <?php if($tournamentData[0]->type == 4) { ?>
                        <h4>Winner's Bracket</h4>
                        <?php } ?>
                        <div class="tournament_bracket <?= ($tournamentData[0]->type == 2) ? 'elimination-bracket' : ''; ?> <?= $deClass; ?>">
                        <?php foreach($bracketsData as $key => $round): ?>    
                            <?php
                                $finalistClass = '';
                                if($round['round_title'] == 'Final Round') {
                                    $finalistClass = 'grand-final';
                                }
                            ?>
                            <div class="round-structure <?= $finalistClass; ?>">
                                <div class="bracket-round-title">
                                    <h4><?= $round['round_title']; ?></h4>
                                </div>
                                <?php if($tournamentData[0]->type == 2) { ?>
                                    <div class="elimination-bracket-box">
                                        <div class="matches-table manage-matches">
                                        <?php foreach($round['bracketData'] as $bracketItem): ?>  
                                             <div class="match-row match-elimination">
                                                <div class="match-player">
                                                    <div class="user-thumb">
                                                        <img src="<?= $bracketItem['img_src']; ?>" />
                                                    </div>

                                                    <label>
                                                        <?= $bracketItem['username']; ?>
                                                        <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                                        <?php if(!empty($bracketItem['name_1'])) { ?>
                                                        <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $bracketItem['player_1_ID']; ?>">View Players</a>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </label>
                                                </div>

                                                <div class="match-data-set">
                                                    <div class="user-score">
                                                        <h2><?= $bracketItem['score']; ?></h2>
                                                    </div>

                                                    <div class="btn-action">
                                                        <span class="badge <?= $bracketItem['result_class']; ?>">
                                                            <?= $bracketItem['result_message']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                             </div>
                                        <?php endforeach;?>
                                        </div>   
                                    </div>
                                <?php } else { ?>
                                    <ul class="bracket-list matchRond<?= $round['round']; ?>">
                                    <?php foreach($round['bracketData'] as $bracketItem): ?>    
                                        <li class="bracket-item matchID-<?= $bracketItem['matchID']; ?>" id="group-<?= $bracketItem['groupID']; ?>">
                                            <div class="bracket-match <?= $bracketItem['class_1']; ?> slot-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="bracket-tem-info">
                                                        <div class="bracket-item-thumbnail">
                                                            <img src="<?= $bracketItem['img_src_1']; ?>" />
                                                        </div>

                                                        <h5 class="bracket-team-name text-truncate">
                                                            <?= $bracketItem['name_1']; ?>
                                                            <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                                            <?php if(!empty($bracketItem['name_1'])) { ?>
                                                            <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $bracketItem['player_1_ID']; ?>">View Players</a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </h5>
                                                    </div>
                                                    <?php $score_player_1 = ($bracketItem['score_1'] != '') ? $bracketItem['score_1'] : '0'; ?>
                                                    <span class="winner-brackets" data-score="<?= $score_player_1; ?>"><?= $score_player_1; ?></span>
                                                </div>
                                            </div>

                                            <div class="bracket-match <?= $bracketItem['class_2']; ?>  slot-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="bracket-tem-info">
                                                        <div class="bracket-item-thumbnail">
                                                            <img src="<?= $bracketItem['img_src_2']; ?>" />
                                                        </div>

                                                        <h5 class="bracket-team-name text-truncate">
                                                            <?= $bracketItem['name_2']; ?>
                                                            <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                                            <?php if(!empty($bracketItem['name_2'])) { ?>
                                                            <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $bracketItem['player_2_ID']; ?>">View Players</a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </h5>
                                                    </div>
                                                    <?php $score_player_2 = ($bracketItem['score_2'] != '') ? $bracketItem['score_2'] : '0'; ?>
                                                    <span class="winner-brackets" data-score="<?= $score_player_2; ?>"><?= $score_player_2; ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                        </div>

                        <?php if($tournamentData[0]->type == 4) { ?>
                        <h4>Looser's Bracket</h4>
                        <div class="tournament_bracket looser-bracket">
                        <?php $counter = 0; ?>
                        <?php foreach($loosersBracketsData as $key => $round): ?>
                            <?php
                                $looserBracketClass = '';
                                if($counter == count($loosersBracketsData) - 1) {
                                    $looserBracketClass = ' looser-finalist';
                                }
                            ?>
                            <div class="round-structure <?= $looserBracketClass; ?>">
                                <?php if(isset($round['round_title'])) { ?>
                                <div class="bracket-round-title">
                                    <h4><?= $round['round_title']; ?></h4>
                                </div>
                                <?php } ?>

                                <ul class="bracket-list">
                                <?php foreach($round['bracketData'] as $bracketItem): ?>    
                                    <li class="bracket-item"  id="group-<?= $bracketItem['groupID']; ?>">
                                        <div class="bracket-match <?= $bracketItem['class_1']; ?>">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="bracket-tem-info">
                                                    <div class="bracket-item-thumbnail">
                                                        <img src="<?= $bracketItem['img_src_1']; ?>" />
                                                    </div>

                                                    <h5 class="bracket-team-name text-truncate">
                                                        <?= $bracketItem['name_1']; ?>
                                                        <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                                        <?php if(!empty($bracketItem['name_1'])) { ?>
                                                        <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $bracketItem['player_1_ID']; ?>">View Players</a>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </h5>
                                                </div>
                                                <?php $score_player_1 = ($bracketItem['score_1'] != '') ? $bracketItem['score_1'] : '0'; ?>
                                                <span class="winner-brackets"><?= $score_player_1; ?></span>
                                            </div>
                                        </div>
                                        <?php if(isset($bracketItem['class_2'])) { ?>
                                        <div class="bracket-match <?= $bracketItem['class_2']; ?>">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="bracket-tem-info">
                                                    <div class="bracket-item-thumbnail">
                                                        <img src="<?= $bracketItem['img_src_2']; ?>" />
                                                    </div>

                                                    <h5 class="bracket-team-name text-truncate">
                                                        <?= $bracketItem['name_2']; ?>
                                                        <?php if($tournamentData[0]->allowed_participants == 1) { ?>
                                                        <?php if(!empty($bracketItem['name_2'])) { ?>
                                                        <a href="<?= base_url(); ?>account/getTeamPlayers" class="btn btn-small view-players" data-id="<?= $tournamentData[0]->id; ?>" data-team="<?= $bracketItem['player_2_ID']; ?>">View Players</a>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </h5>
                                                </div>
                                                <?php $score_player_2 = ($bracketItem['score_2'] != '') ? $bracketItem['score_2'] : '0'; ?>
                                                <span class="winner-brackets"><?= $score_player_2; ?></span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php $counter = $counter + 1; ?>
                        <?php endforeach; ?>
                        </div>
                        <?php } ?>
                    </div>
                     <?php } else { ?>
                    <div class="dso-inner-404">
                        <img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
                        <h2>Sorry No Brackets Found</h2>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <div class="dso-tab-wrapper" id="stats">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Stats</h3>
                    </div>
                </div>

                <?php 
                    if(isset($stats_meta[0]->meta_title)) {
                    $stats_title = unserialize($stats_meta[0]->meta_title);
                    $stas_description = unserialize($stats_meta[0]->meta_description);
                ?>

                <div class="box-flex-row">
                    <?php foreach($stats_title as $key => $statics): ?>
                    <div class="dso-article-box">
                        <div class="icon-wrap">
                            <img src="<?= base_url(); ?>assets/frontend/images/categories/icon-account.png">
                        </div>
                        <div class="dso-article-content">
                            <h2><?= $statics;?></h2>
                            <p><?= $stas_description[$key]; ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php } ?>
            </div>

            <div class="dso-tab-wrapper" id="announcements">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>Announcements</h3>
                    </div>
                </div>

                <?php foreach($announcmentsData as $announcment): ?>  
                <div class="announcements-row">
                    <?php 
                        $get_image = $ci->get_user_meta('user_image', $announcment->created_by);
                        
                        if($get_image == null) {
                            $image_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $image_url = base_url() . 'assets/uploads/users/user-' . $announcment->created_by . '/' . $get_image;
                        }
                    ?>

                    <div class="anc-thumb">
                        <img src="<?= $image_url; ?>">
                    </div>
                    <div class="anc-data">
                        <h4><?= $ci->get_username($announcment->created_by); ?> <span><?= $ci->time_ago($announcment->date_posted); ?></span></h4>
                        
                        <div class="annc-content"><?= $announcment->message; ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dsoreg-banner">
            <div class="dsoreg-inner-banner">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="dso-lg-content">
                            <span class="sm-text">Excited To Join</span>
                            <h1>
                                <span>Let's Not Wait</span>
                                Enroll Today and Start Gaming
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <?php if($this->session->userdata('user_role') == 4 || $this->session->userdata('user_role') == 5) { ?>
                            <?php if(count($participentCheck) > 0) { ?>
                            <h4 class="text-uppercase text-grey heading-lg-4">
                                Already Signed Up 
                            </h4>
                            <?php } else { ?>
                            <a href="<?= base_url(); ?>tournaments/<?= $categorySlug . '/' . $game . '/' . $slug . '/join'; ?>"class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Sign Up</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a> 
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <?php if($this->session->userdata('is_logged_in') == true) { ?>
    <div class="btn-row justify-content-center">
        <div id="msg-process"></div>
        <a href="<?= base_url(); ?>home/processSpectatorApplication/<?= $tournamentData[0]->id; ?>" class="btn dso-ebtn dso-ebtn-solid apply-spec">
            <span class="dso-btn-text">Apply As Spectator</span>
            <div class="dso-btn-bg-holder"></div>
        </a>

        <div class="dso-btn-row">
            <div class="loader-sub" id="login-load">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php if($tournamentData[0]->allowed_participants == 1) { ?>
<div class="modal" id="teamParticipents" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Team Players</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="playersData"></div>
                     <div class="loader-wrapper">
                        <div class="loader-full" id="players-load" style="display: none;">
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
<?php } ?>
<script>
 var bracketData = '';
</script>