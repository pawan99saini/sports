<?php if(count($tournamentsData) == 0) { ?>
<div class="dso-inner-404">
    <img src="<?= base_url() . 'assets/frontend/images/nothing-found.png'; ?>" />
    <h2>Sorry No Tournaments Found</h2>
</div>
<?php } else { ?>
<?php $j = 1; ?>
<?php foreach($tournamentsData as $tournament): ?>
<?php if($tournament->status != 0 && $tournament->status != 4) { ?> 
<?php if($j <= 9) { ?>   
<div class="dso-tournament-wrapper">
    <div class="dso-tournament-thumbnail">
        <a href="<?= base_url(); ?>tournaments/<?= $tournament->category_slug . '/' . $tournament->game_slug . '/' . $tournament->slug; ?>" class="link-holder"></a>
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
                            $tournament_prize = unserialize($ci->tournament_meta('prize_data', $tournament->id)[0]->meta_description);
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
                        <h4><?= count($ci->get_participents($tournament->id)); ?> Enrolled</h4>
                    </div>
                </div>

                <?php 
                    if($tournament->mode == 1) {
                        $status = 'Online';
                    } else {
                        $status = 'Offline';
                    }
                
                    $checkTournament = $ci->checkTournamentRegistration($tournament->id, $this->session->userdata('user_id'));

                if(count($participents) < $tournament->max_allowed_players) { 
                    //Check If User is logged in 
                    if($this->session->userdata('is_logged_in') == true) {
                        if($checkTournament == 0) { 
                ?>
                            <a href="<?= base_url(); ?>tournaments/<?= $tournament->category_slug . '/' . $tournament->game_slug . '/' . $tournament->slug; ?>/join" class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Register</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a>
                        <?php } else { ?>
                            <a class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Registered</span>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="<?= base_url(); ?>tournaments/<?= $tournament->category_slug . '/' . $tournament->game_slug . '/' . $tournament->slug; ?>/join" class="btn dso-ebtn dso-ebtn-solid">
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

        <span class="status-box <?= strtolower($status); ?>">
            <?= $status; ?>
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