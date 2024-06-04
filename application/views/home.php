<section>
    <div class="games">
        <div class="container">
            <div class="row">
                <div class="col-md-12 gm">
                    <h2>GAMES</h2>
                </div>
                
                <div class="game-row">
                    <ul class="game-slide">
                        <li>
                            <a href="<?= base_url(); ?>tournaments">
                                <div class="game">
                                    <div class="game-icon">
                                        <img src="<?= base_url(); ?>assets/frontend/images/allgames.png">
                                    </div>

                                    <div class="game-content">
                                        <h2 class="allgames">ALL GAMES</h2>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php foreach($gamesData as $game): ?>  
                        <?php if($game->status == 1) { ?> 
                        <li>
                            <a href="<?= base_url(); ?>tournaments/<?= $game->category_slug . '/' . $game->slug; ?>">
                                <div class="game">
                                    <div class="game-icon">
                                        <img src="<?= base_url(); ?>assets/frontend/images/games/<?= $game->game_image; ?>">
                                    </div>
                                    <?php
                                        $totalTournaments = $meta->get_active_tournaments($game->game_id);
                                    ?>
                                    <div class="game-content">
                                        <h2><?= $game->game_name; ?></h2>
                                        <p>
                                            <?= $totalTournaments; ?> 
                                            <?= ($totalTournaments > 1) ? 'Tournaments' : 'Tournament'; ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="ctg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>CATEGORIES</h2>

                    <div class="categories-wrapper">
                        <div class="categories-slider">
                            <?php foreach($categoriesData as $category): ?>  
                                <?php if($category->status == 1) { ?>  
                                    <div class="item">
                                        <a href="<?= base_url() . 'tournaments/' . $category->slug; ?>">
                                            <div class="thumb-wrapper">
                                                <div class="img-box">
                                                    <img src="<?= base_url(); ?>assets/frontend/images/games/categories/<?= $category->image; ?>" class="img-fluid" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4><?php echo $category->title; ?>
                                                    <span><?php echo $category->description; ?></span>
                                                </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="stream">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Top Streamers System Coming Soon</h2>
                
                    <div class="middleban">
                        <div class="ib-content">
                            <!-- <img src="<?= base_url(); ?>assets/frontend/images/01.png"> -->
                            <!-- <h2>Coming Soon</h2> -->

                            <!-- <div class="ft-pat">
                                <div class="ft-pat-item">
                                    <h3>25k views</h3>
                                    <p>(this week)</p>
                                </div>
                                <div class="ft-pat-item">
                                    <h3>1 Million+</h3>
                                    <p>(total views)</p>
                                </div>
                                <div class="ft-pat-item">
                                    <h3>185</h3>
                                    <p>(videos)</p>
                                </div>
                            </div>

                            <a href="#" class="channel-btn">VIEW CHANNEL</a> -->
                        </div>
                    </div>

                    <div class="players">
                        <div class="player-box">
                            <div class="player-tumb">
                                <img src="<?= base_url(); ?>assets/frontend/uploads/users/user-4.jpg" />
                            </div>

                            <h3>MemeRegion</h3>
                            
                            <!-- <div class="ft-pat">
                                <div class="ft-pat-item">
                                    <h3>20k views</h3>
                                    <p>(this week)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>750,000</h3>
                                    <p>(total views)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>201</h3>
                                    <p>(videos)</p>
                                </div>
                            </div>-->

                            <a href="https://www.twitch.tv/memeregion" class="channel-btn-red">VIEW CHANNEL</a> 
                        </div>                       

                        <div class="player-box">
                            <div class="player-tumb">
                                <img src="<?= base_url(); ?>assets/frontend/images/jax-profile-photo.png" />
                            </div>

                            <h3>1TapJax </h3>

                            <!-- <div class="ft-pat">
                                <div class="ft-pat-item">
                                    <h3>20k views</h3>
                                    <p>(this week)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>750,000</h3>
                                    <p>(total views)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>201</h3>
                                    <p>(videos)</p>
                                </div>
                            </div> -->
                            
                            <a href="https://www.twitch.tv/1TapJax" class="channel-btn-red">VIEW CHANNEL</a> 
                        </div>

                        <div class="player-box">
                            <div class="player-tumb">
                                <img src="<?= base_url(); ?>assets/frontend/uploads/users/slpt_logo.png" />
                            </div>

                            <h3>Slpt</h3>

                            <!-- <div class="ft-pat">
                                <div class="ft-pat-item">
                                    <h3>25k views</h3>
                                    <p>(this week)</p>
                                </div>
                                <div class="ft-pat-item">
                                    <h3>1 Million+</h3>
                                    <p>(total views)</p>
                                </div>
                                <div class="ft-pat-item">
                                    <h3>185</h3>
                                    <p>(videos)</p>
                                </div>
                            </div>-->

                            <a href="https://www.twitch.tv/slpt" class="channel-btn-red">VIEW CHANNEL</a> 
                        </div>

                        <div class="player-box">
                            <div class="player-tumb">
                                <img src="<?= base_url(); ?>assets/frontend/uploads/users/user-2.jpg" />
                            </div>

                            <h3>fluffy_ghostx</h3>

                            <!-- <div class="ft-pat">
                                <div class="ft-pat-item">
                                    <h3>20k views</h3>
                                    <p>(this week)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>750,000</h3>
                                    <p>(total views)</p>
                                </div>

                                <div class="ft-pat-item">
                                    <h3>201</h3>
                                    <p>(videos)</p>
                                </div>
                            </div> -->
                            
                             <a href="https://www.twitch.tv/fluffy_ghostx" class="channel-btn-red">VIEW CHANNEL</a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="sign">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Sign up for <br> tournament</h2>
                    <p>Join us today to play exciting tournaments and get rewards for your self as we provide best leagues.</p>
                </div>
                <div class="col-md-6">
                    <div class="frm">
                        <div class="table-box">
                            <div class="cell-box">
                                <form action="<?= base_url(); ?>home/processSignup" class="signup-home" onsubmit="return false;">
                                    <div id="msg-login"></div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fname">First name</label>
                                                <input type="text" class="form-control" name="fname" required >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fname">Last name</label>
                                                <input type="text" class="form-control" name="lname" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username" required />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Email">Email</label>
                                                <input type="email" class="form-control" name="email" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fname">Platform (i.e. xbox - pc)</label>
                                                <input type="text" class="form-control" name="platform" required >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Email">Discord Username</label>
                                                <input type="text" class="form-control" name="discord_username" required >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Email">Username On Console</label>
                                                <input type="text" class="form-control" name="console_username" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="btn-inline-row">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input signup-type" name="type" type="radio" id="inlineCheckbox1" value="individual">
                                                    <label class="form-check-label" for="inlineCheckbox1">Sign Up As Individual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input signup-type" name="type" type="radio" id="inlineCheckbox2" value="team">
                                                    <label class="form-check-label" for="inlineCheckbox2">Sign Up As Team</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="team-info" id="team" style="display: none;">
                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label for="fname">Platform Play On</label>
                                                    <input type="text" class="form-control" name="game_platform" >
                                                </div>
                                            </div>

                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label for="fname">Team Name</label>
                                                    <input type="text" class="form-control" name="team_name" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Email">Country</label>
                                                <input type="text" class="form-control" name="country" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Email">Game Interested</label>
                                                <select class="select2 select2-multiple" multiple="multiple" data-placeholder=" -- Select Game -- " style="width: 100%;" name="interested_game[]" >
                                                    <?php foreach($gamesData as $game): ?>   
                                                        <option value="<?= $game->game_id; ?>"><?= $game->game_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-curved">
                                                    Submit
                                                </button>

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
                                    </div>
                                </form>

                                <div id="msg-password"></div>
                                
                                <form action="<?= base_url(); ?>home/processPassword" class="signup-password" onsubmit="return false;" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Email">Set Password</label>
                                                <input type="password" class="form-control cl_password" name="password" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fname">Confirm Password</label>
                                                <input type="password" class="form-control confirm_cl_password" name="confirmPassword" required />
                                            </div>
                                        </div>

                                        <input type="hidden" name="userID" value="0">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-curved cl_process">Submit</button>

                                                <div class="loader-sub" id="password-load">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="event">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Upcoming Tournaments</h2>
    
                    <div class="img-collage">
                        <div class="colg-left">
                            <img src="<?= base_url(); ?>assets/frontend/images/event.png" class="evt" />
                        </div>
                        
                        <div class="img-colg">
                            <img src="<?= base_url(); ?>assets/frontend/images/event1.png" />
                            <img src="<?= base_url(); ?>assets/frontend/images/event2.png" class="hlf" />
                            <img src="<?= base_url(); ?>assets/frontend/images/event3.png" class="hlf" />
                        </div>
                    </div>
                    
                    <!-- <a href="#">VIEW ALL UPCOMING EVENTS</a> -->
                </div>
            </div>
        </div>
    </div>
</section>