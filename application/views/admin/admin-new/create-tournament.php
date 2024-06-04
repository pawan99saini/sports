<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Create Tournament</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin/tournaments">Tournaments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Tournament</li>
                </ol>

                <a href="<?php echo base_url(); ?>admin/tournaments" class="btn btn-primary d-none d-lg-block m-l-15">
                    <i class="fa fa-plus-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> Tournament</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url(); ?>admin/createTournament" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" name="tournament_image" class="form-control" />
                                    <input type="hidden" name="filename" value="<?php echo $filename; ?>" />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="editorRichText" class="content1 form-control" data-target="content1" rows="12"><?= $description; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Select Category</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>    
                                        <?php foreach($categoriesData as $category): ?>    
                                        <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $category_id) ? 'selected' : ''; ?>><?php echo $category->title; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Select Game</label>
                                    <select name="game_id" class="form-control" required>
                                        <option value="">Select Game</option>    
                                        <?php foreach($gamesData as $game): ?>    
                                        <option value="<?php echo $game->game_id; ?>" <?php echo ($game->game_id == $game_id) ? 'selected' : ''; ?>><?php echo $game->game_name; ?></option>
                                        <?php endforeach; ?> 
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Region</label>
                                    <input type="text" name="region" class="form-control" value="<?php echo $region; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Tournament Status</label>
                                    <?php $statusData = array('Inactive', 'Active', 'In Progress', 'Completed', 'Cancelled'); ?>
                                    <select class="form-control" name="tournament_status">
                                        <?php foreach($statusData as $value_stat => $tournamentStatus): ?>
                                        <?php 
                                            $select = '';
                                            if($status == $value_stat) {
                                                $select = 'selected'; 
                                            }
                                        ?>    
                                        <option value="<?= $value_stat; ?>" <?= $select; ?>><?= $tournamentStatus; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" value="<?php echo $date; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Time</label>
                                    <input type="time" name="time" class="form-control" value="<?php echo $time; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Format</label>
                                    <input type="text" name="format" class="form-control" value="<?php echo $format; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Game Map</label>
                                    <input type="text" name="game_map" class="form-control" value="<?php echo $game_map; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <div class="row-box-spacer">
                                        <h5 class="card-subtitle clearfix col-12">
                                            Reward & Prize

                                            <a href="javascript:void(0);" class="add-desc btn btn-info btn-right">
                                                <i class="fa fa-plus-square-o"></i> 
                                                Add Row
                                            </a>
                                        </h5>
                                        
                                        <div class="pkg-desc-row">
                                            <?php 
                                            if($tournament_meta != '') { 
                                                $meta_title = unserialize($tournament_meta[0]->meta_title);
                                                $meta_value = unserialize($tournament_meta[0]->meta_description); 
                                                $i = 0;
                                                foreach($meta_title as $meta): 
                                            ?>
                                                <div class="input-row mg-b-20">
                                                    <input type="text" name="placement[]" class="form-control" value="<?= $meta; ?>" value="" autocomplete="off" />
                                                    <input type="text" name="prize[]" class="form-control" value="<?= $meta_value[$i]; ?>" value="" autocomplete="off" />
                                                    <a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>
                                                </div>
                                            <?php $i++; ?>    
                                            <?php endforeach; ?>
                                            <?php } else { ?>
                                                <div class="input-row mg-b-20">
                                                    <input type="text" name="placement[]" class="form-control" placeholder="Placement" value="" autocomplete="off" />
                                                    <input type="text" name="prize[]" class="form-control" placeholder="Prize" value="" autocomplete="off" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Rules & regulations</label>
                                    <textarea name="rules" id="editorRichText" class="content2 form-control" data-target="content2" rows="12"><?= $rules; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Schedule</label>
                                    <textarea name="schedule" id="editorRichText" class="content3 form-control" data-target="content3" rows="12"><?= $schedule; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <label class="form-label">Contact</label>
                                    <textarea name="contact" id="editorRichText" class="content4 form-control" data-target="content4" rows="12"><?= $contact; ?></textarea>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-12">
                                    <div class="row-box-spacer">
                                        <h5 class="card-subtitle clearfix col-12">
                                            Tournament Stats

                                            <a href="javascript:void(0);" class="add-stats btn btn-info btn-right">
                                                <i class="fa fa-plus-square-o"></i> 
                                                Create
                                            </a>
                                        </h5>
                                        
                                        <div class="stats-row">
                                            <?php if(isset($stats_meta[0]) && $stats_meta[0] != '') { ?>
                                            <?php $meta_title = unserialize($stats_meta[0]->meta_title); ?>
                                            <?php $meta_value = unserialize($stats_meta[0]->meta_description); ?>
                                            <?php $i = 0; ?>
                                            <?php foreach($meta_title as $meta): ?>
                                                <div class="input-row mg-b-20">
                                                    <input type="text" name="stat_title[]" class="form-control" value="<?= $meta; ?>" value="" autocomplete="off" />
                                                    <input type="text" name="stat_value[]" class="form-control" value="<?= $meta_value[$i]; ?>" value="" autocomplete="off" />
                                                    <a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>
                                                </div>
                                            <?php $i++; ?>    
                                            <?php endforeach; ?>
                                            <?php } else { ?>
                                                <div class="input-row mg-b-20">
                                                    <input type="text" name="stat_title[]" class="form-control" placeholder="Heading" value="" autocomplete="off" />
                                                    <input type="text" name="stat_value[]" class="form-control" placeholder="Value" value="" autocomplete="off" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Bracket Tournament</label>
    
                                    <div class="inline-radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="bracket_req" class="form-check-input" value="1" <?= $bracket_system == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">Yes</label>
                                        </div>
                                        
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="bracket_req" class="form-check-input" value="0" <?= $bracket_system == 0 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Tournament Type</label>
                                    <div class="inline-radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="type" class="form-check-input" value="1" <?= $type == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">Matches</label>
                                        </div>
                                        
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="type" class="form-check-input" value="2" <?= $type == 2 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">Elimination</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="type" class="form-check-input" value="3" <?= $type == 3 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">King Of The Hill</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Match Type</label>
                                    <div class="inline-radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="match_type" class="form-check-input" value="1" <?= $match_type == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">Team Tournament</label>
                                        </div>
                                        
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="match_type" class="form-check-input" value="2" <?= $match_type == 2 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="customRadio1">Individual Player</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 team-members" <?= $match_type == 1 ? '' : 'style="display: none"'; ?> >
                                    <label class="form-label">Allowed Players Per Team</label>
                                    <input type="text" name="max_team_players" class="form-control" value="<?php echo $max_team_players; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Max Allowed Players</label>
                                    <input type="text" name="max_players" class="form-control" value="<?php echo $max_players; ?>" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Max Allowed Spectators</label>
                                    <input type="text" name="max_spectators" class="form-control" value="<?php echo $max_spectators; ?>" required />
                                </div>

                                <div class="clearfix"></div> 

                                <div class="form-group col-md-6">
                                    <label class="form-label">Credits Required To Join Tournament</label>
                                    <input type="text" name="req_credits" class="form-control" value="<?php echo $req_credits; ?>" required />
                                </div>
                                
                                <div class="clearfix"></div> 

                                <input type="hidden" name="id" value="<?= $id ?>" />
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 emp-submit">
                                        <?php if($id == '') { ?>
                                        Create Tournament
                                        <?php } else { ?>
                                        Update Tournament
                                        <?php } ?>    
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>