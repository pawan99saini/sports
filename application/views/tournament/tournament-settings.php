<?php
    $bracket_system = '';
    $type = '';
    $match_type = '';
    $max_team_players = '';
    $max_players = '';
    $max_spectators = '';
    $advancedStageNeeded = 0;
    
    if(count($tournamentData) > 0) {
        $bracket_system = $tournamentData[0]->brackets;
        $type = $tournamentData[0]->type;
        $match_type = $tournamentData[0]->allowed_participants;
        $max_team_players = $tournamentData[0]->max_team_players;
        $max_players = $tournamentData[0]->max_allowed_players;
        $max_spectators = $tournamentData[0]->max_allowed_spectators;
        $advancedStageNeeded = $tournament[0]->advancedStageNeeded;   
    } 
?>
<div class="form-process-step form-step-5">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label text-white text-lg-2">Bracket Tournament</label>

                <div class="thumb-btn">
                    <a href="javascript:void(0);" class="select-btn-thumb <?= $bracket_system == 1 ? 'selected-thumb' : '' ?>" data-value="1" data-type="checkbox" data-target="bracket_req">
                        <img src="<?= base_url(); ?>assets/frontend/images/brackets-icon.jpg" />
                    </a>
                    <input type="hidden" name="bracket_req" class="selected-value" value="<?= $bracket_system; ?>" required />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label text-white text-lg-2">Tournament Type</label>

                <div class="theme-btn-row">
                    <div class="thumb-btn">
                        <a href="javascript:void(0);" class="select-btn-thumb <?= $type == 1 ? 'selected-thumb' : '' ?>" data-value="1" data-type="radio" data-target="type">
                            <span>Matches</span>
                            <img src="<?= base_url(); ?>assets/frontend/images/match.jpg" />
                        </a>
                    </div>

                    <div class="thumb-btn">
                        <a href="javascript:void(0);" class="select-btn-thumb <?= $type == 2 ? 'selected-thumb' : '' ?>" data-value="2" data-type="radio" data-target="type">
                            <span>Player Elimination</span>
                            <img src="<?= base_url(); ?>assets/frontend/images/elimination-icon.jpg" />
                        </a>
                    </div>

                    <div class="thumb-btn">
                        <a href="javascript:void(0);" class="select-btn-thumb <?= $type == 3 ? 'selected-thumb' : '' ?>" data-value="3" data-type="radio" data-target="type">
                            <span>Single Elimination</span>
                            <img src="<?= base_url(); ?>assets/frontend/images/single-elimination-icon.jpg" />
                        </a>
                    </div>

                    <div class="thumb-btn">
                        <a href="javascript:void(0);" class="select-btn-thumb <?= $type == 4 ? 'selected-thumb' : '' ?>" data-value="4" data-type="radio" data-target="type">
                            <span>Double Elimination</span>
                            <img src="<?= base_url(); ?>assets/frontend/images/double-elimination-icon.jpg" />
                        </a>
                    </div>
                </div>
                <input type="hidden" name="type" class="selected-value" value="<?= $type; ?>" required />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group advanceStage" style="display: none;">
                <label class="form-label text-white text-lg-2">Playoff Stage</label>

                <div class="inline-radio">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="advancedStageNeeded" class="form-check-input" value="0" <?= $advancedStageNeeded == 0 ? 'checked' : ''; ?> />
                        <label class="form-check-label">Disable</label>
                    </div>
                    
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="advancedStageNeeded" class="form-check-input" value="1" <?= $advancedStageNeeded == 1 ? 'checked' : ''; ?> />
                        <label class="form-check-label">Enable</label>
                    </div>
                </div>

                <span class="text-info">Enable this feature to add a playoff stage after the final round, where the top 8 players will compete against each other.</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label text-white text-lg-2">Match Type</label>

                <div class="inline-radio">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="match_type" class="form-check-input" value="1" <?= $match_type == 1 ? 'checked' : ''; ?> />
                        <label class="form-check-label">Team Tournament</label>
                    </div>
                    
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="match_type" class="form-check-input" value="2" <?= $match_type == 2 ? 'checked' : ''; ?> />
                        <label class="form-check-label">Individual Player</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="team-members" <?= $match_type == 1 ? '' : 'style="display: none"'; ?>>
                <div class="form-group dso-animated-field-label">
                    <label class="form-label">Allowed Players Per Team</label>
                    <input type="text" name="max_team_players" class="form-control" value="<?php echo $max_team_players; ?>" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group dso-animated-field-label">
                <label class="form-label">Max Allowed Players</label>
                <input type="text" name="max_players" class="form-control" value="<?php echo $max_players; ?>" required />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group dso-animated-field-label">
                <label class="form-label">Max Allowed Spectators</label>
                <input type="text" name="max_spectators" class="form-control" value="<?php echo $max_spectators; ?>" required />
            </div>
        </div>
    </div>
</div>