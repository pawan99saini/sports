<div class="dso-main">
    <div class="dso-page-bannner dso-banner-overlay dso-tournament-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="dso-lg-content">
                        <h1><?= $tournamentData[0]->title; ?>
                            <span>Join Tournament</span>
                        </h1>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="item-right">
                    <a href="<?= base_url(); ?>tournaments/<?= $tournamentData[0]->category_slug . '/' . $tournamentData[0]->game_slug . '/' . $tournamentData[0]->slug; ?>"class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Cancel</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dso-tournament-details-wrapper pad-120">
        <div class="container">
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
                    <h3>Credits</h3>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="dso-player-meta player-meta-sm m-b-20">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-ios-game-controller-a"></div>
                                <span class="dso-player-info-title">Required</span>
                            </div>
                            <p><?= $tournamentData[0]->req_credits; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dso-player-meta player-meta-sm m-b-20">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-ios-game-controller-b"></div>
                                <span class="dso-player-info-title">Available</span>
                            </div>
                            <p><?= $user_data[0]->credit; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-box m-b-40 pos-rel">
                <div class="players-data"></div>

                <?php 
                    $reqCredits   = $tournamentData[0]->req_credits;
                    $userCredits  = $user_data[0]->credit;
                    $creditsCheck = ($reqCredits > 0) ? true : false; 
                    $userRole     = $this->session->userdata('user_role');
                    $match_type   = $tournamentData[0]->allowed_participants;
                    $max_players  = $tournamentData[0]->max_team_players;

                    $teamJoinUrl  = '<div class="align-center">';
                    $teamJoinUrl .= '<a href="'. base_url() .'account/getTeamPlayers/'. $id .'" class="btn dso-ebtn dso-ebtn-outline get-team-players">';
                    $teamJoinUrl .= '<span class="dso-btn-text">Join Now</span>';
                    $teamJoinUrl .= '<div class="dso-btn-bg-holder"></div>';
                    $teamJoinUrl .= '</a>';
                    $teamJoinUrl .= '</div>';
                    $teamJoinUrl .= '<div class="processJoin"></div>';
                    $teamJoinUrl .= '<div class="team-members"></div>';

                    $joinTournamentForm  = '<form method="POST" action="' . base_url() .'account/processJoin" class="btn-form-center processJoin" onsubmit="return false;">';
                    $joinTournamentForm .= '<input type="hidden" name="tournament_id" value="'. $id .'" />';
                    $joinTournamentForm .= '<input type="hidden" name="req_url" value="'. $game . '/' . $slug .'">';
                    $joinTournamentForm .= '<div class="btn-row-align">';
                    $joinTournamentForm .= '<button type="submit" class="btn dso-ebtn dso-ebtn-solid">';
                    $joinTournamentForm .= '<span class="dso-btn-text">Request join</span>';
                    $joinTournamentForm .= '<div class="dso-btn-bg-holder"></div>';
                    $joinTournamentForm .= '</button>';
                    $joinTournamentForm .= '</div>';
                    $joinTournamentForm .= '<div class="loader-sub" id="loader"><div class="lds-ellipsis">';
                    $joinTournamentForm .= '<div></div><div></div><div></div><div></div>';
                    $joinTournamentForm .= '</div></div>';
                    $joinTournamentForm .= '</form>';

                    if($match_type == 1) {
                        //This is a team tournament Check if joining user is a team or individual Player
                        if($userRole == 5) {
                            if($creditsCheck == true) {
                                if($userCredits < $reqCredits) {
                                    if($userData[0]->membership == 0) {
                                        echo '<div class="txt-light-centered">
                                            <span>You do not have paid membership plan please upgrade your membership to join the tournament</span>
                                            <a href="'. base_url() . 'pricing" class="btn btn-curved">Upgrade Membership</a>
                                          </div>';
                                    } else {
                                        echo '<div class="txt-light-centered">
                                            <span>You do not have enough credits in your accont to join this tournament please add credits to your account to join the tournament</span>
                                            <a href="'. base_url() . 'buy-credits" class="btn btn-curved">Buy Credits</a>
                                          </div>';
                                    }
                                } else {
                                    echo $teamJoinUrl;
                                }
                            } else {
                                echo $teamJoinUrl;
                            }
                        } else {
                            echo '<div class="txt-light-centered">
                                <span>This tournament is for teams only if you want to be a part of this tournament ask your team owner to join</span>
                              </div>';
                        }
                    } else {
                        if($creditsCheck == false) {
                            echo $joinTournamentForm;
                        } else {
                            if($userCredits < $reqCredits) {
                                if($userData[0]->membership == 0) {
                                    echo '<div class="txt-light-centered">
                                        <span>You do not have paid membership plan please upgrade your membership to join the tournament</span>
                                        <a href="'. base_url() . 'pricing" class="btn btn-curved">Upgrade Membership</a>
                                      </div>';
                                } else {
                                    echo '<div class="txt-light-centered">
                                        <span>You do not have enough credits in your accont to join this tournament please add credits to your account to join the tournament</span>
                                        <a href="'. base_url() . 'buy-credits" class="btn btn-curved">Buy Credits</a>
                                      </div>';
                                }
                            } else {
                                echo $joinTournamentForm;
                            }
                        }
                    }
                ?>

                <div class="loader-full"  id="load-join">
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