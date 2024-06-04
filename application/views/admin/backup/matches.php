<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tournament Matches</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                        <li class="breadcrumb-item active">Tournament Matches</li>
                    </ol>
                    
                    <?php if(isset($tournamentID)) { ?>
                        <?php if(count($matchesData) == 0) { ?>  
                        <a href="<?php echo base_url(); ?>admin/matches/manage/<?= $tournamentID; ?>/create" class="btn btn-info d-none d-lg-block m-l-15">
                            <i class="fa fa-plus-circle"></i> Start Match
                        </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Tournament Matches</h4>
                        <?php 
                            $message = $this->session->flashdata('message');

                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <?php if(isset($tournamentID)) { ?>
                            <div class="row">
                                <!-- column -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <?php 
                                                    $allowed_players = $tournamentData[0]->max_allowed_players;
                                                    $active_players  = count($playersData);
                                                    $get_players_per = (100 / $allowed_players) * $active_players;

                                                    $prgress_bar_class = 'bg-primary';
                                                    $text_class = 'text-primary';

                                                    if($get_players_per > 60) {
                                                        $prgress_bar_class = 'bg-warning';
                                                        $text_class = 'text-warning';
                                                    }

                                                    if($get_players_per == 100) {
                                                        $prgress_bar_class = 'bg-success';
                                                        $text_class = 'text-success';
                                                    }
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="d-flex no-block align-items-center justify-space">
                                                        <div>
                                                            <h3><i class="icon-people"></i></h3>
                                                            <p class="text-muted">PLAYERS</p>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <h2 class="counter <?= $text_class; ?>"><?= $active_players . ' / ' . $allowed_players; ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar <?= $prgress_bar_class; ?>" role="progressbar" style="width: <?= $get_players_per; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- column -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <?php 
                                                    $allowed_spectators = $tournamentData[0]->max_allowed_spectators;
                                                    $active_applciations  = count($specApplication);
                                                    $get_applications_per = (100 / $allowed_spectators) * $active_applciations;

                                                    $prgress_bar_class = 'bg-primary';
                                                    $text_class = 'text-primary';

                                                    if($get_applications_per > 60) {
                                                        $prgress_bar_class = 'bg-warning';
                                                        $text_class = 'text-warning';
                                                    }

                                                    if($get_applications_per == 100) {
                                                        $prgress_bar_class = 'bg-success';
                                                        $text_class = 'text-success';
                                                    }
                                                ?>

                                                <div class="col-md-12">
                                                    <div class="d-flex no-block align-items-center justify-space">
                                                        <div>
                                                            <h3><i class="ti-eye"></i></h3>
                                                            <p class="text-muted">Active Spectators</p>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <h2 class="counter <?= $text_class; ?>"><?= $active_applciations . ' / ' . $allowed_spectators; ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar <?= $prgress_bar_class; ?>" role="progressbar" style="width: <?= $get_applications_per; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- column -->
                            </div>    
                            <?php if($tournamentData[0]->status > 1) { ?> 
                                <?php if($tournamentData[0]->type != 2) { ?>
                                <div class="p-nav-tab">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                    <?php foreach($totalRounds as $round): ?> 
                                    <?php 
                                        $param = '';
                                        if($round->round > 1) {
                                            $param = '/round/' . $round->round;
                                        } 
                                    ?>   
                                        <li class="nav-item"> 
                                            <a class="nav-link <?= ($round->round == $activeRound) ? 'active' : ''; ?>" href="<?= $active_url . $param; ?>" >
                                                <span class="hidden-sm-up">
                                                    <i class="ti-cup"></i>
                                                </span> 
                                                <span class="hidden-xs-down">Round <?= $round->round; ?></span>
                                            </a> 
                                        </li>
                                    <?php $param = ''; ?>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>          
                                <?php } ?>                   
                                <div class="loader-sub" id="spec-load">
                                    <div class="lds-ellipsis">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>

                                <?php if($tournamentData[0]->brackets == 0) { ?>
                                <div class="card">
                                    <div class="card-body">    
                                        <?php if($tournamentData[0]->type == 1) { ?>
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
                                        <div class="loader-sub" id="match-load">
                                            <div class="lds-ellipsis">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="tournamentID" value="<?= $tournamentData[0]->id; ?>" />
                                <?php if(count($matchesData) == 0) { ?>
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Player 1</th>
                                                    <th>Player 2</th>
                                                    <th>Round</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <?php } ?>
                                <?php if(count($matchesData) > 0) { ?>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <?php if($tournamentData[0]->type < 2) { ?>
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Player 1</th>
                                                <th>Player 2</th>
                                                <th>Round</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($matchesData as $match): ?>  
                                            <tr class="row-match-<?= $match->id; ?>">
                                                <td><?= $match->id; ?></td>
                                                <?php 
                                                    $player_1_username = $meta->get_username($match->player_1_ID);
                                                    $player_2_username = $meta->get_username($match->player_2_ID);
                                                ?>
                                                <td>
                                                    <span><?= $player_1_username; ?></span>
                                                    <?php 
                                                        if($match->winnerID > 0) {
                                                            if($match->winnerID == $match->player_1_ID) {
                                                                echo "<label class='badge badge-success'>Winner</label>";
                                                            } else {
                                                                echo "<label class='badge badge-danger'>Loser</label>";
                                                            }
                                                        }
                                                    ?>  
                                                </td>
                                                <td>
                                                    <?php if($match->player_2_ID > 0) { ?>
                                                        <span><?= $player_2_username; ?></span>
                                                    <?php 
                                                        if($match->winnerID > 0) {
                                                            if($match->winnerID == $match->player_2_ID) {
                                                                echo "<label class='badge badge-success'>Winner</label>";
                                                            } else {
                                                                echo "<label class='badge badge-danger'>Loser</label>";
                                                            }
                                                        }
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>  
                                                </td>
                                                <td><?= $match->round; ?></td>
                                                <td>
                                                <?php if($match->winnerID == 0) { ?>
                                                    <?php if($match->player_2_ID > 0) { ?>
                                                        <select class="form-control setWinner">
                                                            <option value="0">Select Winner</option>
                                                            <?php if($match->player_2_ID > 0) { ?>
                                                                <option value="<?= $match->player_1_ID; ?>" data-id="<?= $match->id; ?>" data-round="<?= $match->round; ?>"><?= $player_1_username; ?></option>
                                                                <option value="<?= $match->player_2_ID; ?>" data-id="<?= $match->id; ?>" data-round="<?= $match->round; ?>"><?= $player_2_username; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } else { ?>    
                                                        <label class='badge badge-warning'>Opponent Player Not Assigned</label>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <label class='badge badge-info'>Match Completed</label>
                                                <?php } ?>    
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>    
                                        </tbody>
                                        <?php } else { ?>
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Player</th>
                                                <th>Score</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($matchesData as $match): ?>  
                                            <tr class="row-match-<?= $match->id; ?>">
                                            <?php 
                                                $player_username = $meta->get_username($match->player_1_ID);
                                            ?>
                                                <td><?= $match->id; ?></td>
                                                <td><?= $player_username; ?></td>
                                                <td>
                                                    <div class="row-inline score">
                                                        <span><?= $match->points; ?></span>
                                                        <a href="javascript:void(0);" class="set-new-score btn btn-info btn-curved">Set Score</a>
                                                    </div>

                                                    <div class="row-inline set-score">
                                                        <input type="text" class="form-control" name="score" value="<?= $match->points; ?>" />

                                                        <a href="<?= base_url(); ?>admin/setScore" data-batchID="<?= $match->id; ?>" class="update-score btn btn-info btn-circle">
                                                            <i class="ti-check-box"></i>
                                                        </a>
                                                        
                                                        <a href="javascript:void(0);" class="cancel-score btn btn-info btn-circle">
                                                            <i class="ti-close"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="el-st">
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
                                                    <div class="status-messg">
                                                        <span class="badge <?= $class; ?>"><?= $statusMesg; ?></span>
                                                    </div>
                                                    <?php if($match->status == 1) { ?>
                                                        <a href="<?= base_url(); ?>admin/eliminatePlayer" class="btn btn-info row-inline waves-effect waves-light eliminate-player btn-curved" data-id="<?= $match->id; ?>">Eliminate</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>        
                                        </tbody>

                                        <?php } ?>
                                    </table>

                                    <div class="laoder-warp-cover" id="row-load">
                                        <div class="loader-sub">
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
                            <?php } else { ?>
                            <div class="table-responsive m-t-40">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Player Username</th>
                                            <th>Player Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($playersData as $player): ?>  
                                        <tr>
                                            <td><?= $player->id; ?></td>
                                            <?php 
                                                $player_username = $meta->get_username($player->participantID);
                                                $player_data     = $meta->get_user_data($player->participantID);
                                            ?>
                                            <td>
                                                <?= $player_username; ?>
                                            </td>
                                            <td>
                                                <?= $player_data->first_name . ' ' . $player_data->last_name; ?> 
                                            </td>
                                            <td><?= $player_data->email; ?></td>
                                        </tr>
                                    <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        <?php } else { ?>
                        <form method="POST" action="<?php echo base_url(); ?>admin/matches/manage" onsubmit="return false;" class="tr-form">
                            <div class="wrapper">
                                <div class="form-group col-6">
                                    <label>Select Tournament</label>
                                    <select name="select_tournament" class="form-control">
                                        <option value="">Tournament</option>
                                        <?php foreach($tournamentData as $tournament): ?>  
                                        <option value="<?= $tournament->id; ?>" ><?= $tournament->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
</div>