<?php
	$region = '';
	$game_map = '';
	$date = '';
	$time = '';
	$format = '';
	$rules = '';
	$schedule = '';
	
	if(count($tournamentData) > 0) {
		$region = $tournamentData[0]->region;
		$game_map = $tournamentData[0]->game_map;
		$date = $tournamentData[0]->organized_date;
		$time = $tournamentData[0]->time;
		$format = $tournamentData[0]->format;
		$rules = $tournamentData[0]->rules;
		$schedule = $tournamentData[0]->schedule;
	} 
?>
<div class="form-process-step form-step-2">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group dso-animated-field-label">
		        <label class="form-label">Region</label>
		        <input type="text" name="region" class="form-control" value="<?= $region; ?>" required />
		    </div>
		</div>

		<div class="col-md-6">
			<div class="form-group dso-animated-field-label">
		        <label class="form-label">Game Map</label>
		        <input type="text" name="game_map" class="form-control" value="<?= $game_map; ?>" required />
		    </div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
		        <label class="form-label text-white text-lg-2">Date</label>
		        <input type="date" name="date" class="form-control" value="<?= $date; ?>" required />
		    </div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
		        <label class="form-label text-white text-lg-2">Time</label>
		        <input type="time" name="time" class="form-control" value="<?= $time; ?>" required />
		    </div>
		</div>

		<div class="col-md-6">
			<div class="form-group dso-animated-field-label">
		        <label class="form-label">Format</label>
		        <input type="text" name="format" class="form-control" value="<?= $format; ?>" required />
		    </div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
                <label class="form-label text-white text-lg-2">Rules & regulations</label>
                <textarea name="rules" id="editorRichText" class="content3 form-control" data-target="content3" rows="12"><?= $rules; ?></textarea>
            </div>
        </div>

        <div class="col-md-12">
			<div class="form-group">
                <label class="form-label text-white text-lg-2">Schedule</label>
                <textarea name="schedule" id="editorRichText" class="content4 form-control" data-target="content4" rows="12"><?= $schedule; ?></textarea>
            </div>
        </div>
	</div>
</div>