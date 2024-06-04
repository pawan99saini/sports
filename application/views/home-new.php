<section class="dso-main-banner">
    <div class="container">
        <h1 data-aos="fade-right">DSO ESPORTS</h1>
        <p data-aos="fade-left">Live tournaments, match highlights, and your favorite pro players all in one place</p>

        <a href="javascript:void(0);" class="text-rotate text-white text-lg text-upercase btn-navigte">Scroll Down</a>
    </div>
</section>

<section class="dso-s-2">
    <div class="container">
        <div class="dso-intro-video p-80">
            <div class="video-wrapper">
                <div class="dso-intro-video-inner">
                    <img src="<?= base_url(); ?>assets/frontend/images/dso-video-img.jpg" loading="lazy" />  
                    <div class="video-icon play-home-video">
                        <i class="fa fa-play"></i>
                    </div>  
                </div>

                <div class="video-inner-icon">
                </div>
            </div>
        </div>

        <div class="pad-120">
            <div class="verticle-heading">
                <span class="text-rotate text-white text-upercase">Gaming</span>
                <div class="dso-sec-heading">
                    <h2>Categories</h2>
                </div>
            </div>

            <div class="categories-wrapper">
                <div class="categories-slider">
                    <?php foreach($categoriesData as $category): ?>  
                        <?php if($category->status == 1) { ?>  
                            <div class="item">
                                <a href="<?= base_url() . 'tournaments/' . $category->slug; ?>">
                                    <div class="thumb-wrapper">
                                        <div class="img-box">
                                            <img src="<?= base_url(); ?>assets/frontend/images/games/categories/<?= $category->image; ?>" loading="lazy" class="img-fluid" alt="">
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

    <div class="games-slide-area">
        <div class="container">
            <div class="verticle-heading">
                <span class="text-rotate text-white text-upercase">Top</span>
                <div class="dso-sec-heading">
                    <h2>Games</h2>
                </div>
            </div>
        </div>

        <div class="game-slide">
            <?php foreach($gamesData as $game): ?>  
            <?php if($game->status == 1) { ?> 
            <div class="game-slide-box">
                <div class="game-thumb-wrapper">
                    <div class="game-thumb">
                        <img src="<?= base_url(); ?>assets/frontend/images/games/<?= $game->game_image; ?>"  loading="lazy" />
                    </div>
                    <a href="<?= base_url(); ?>tournaments/<?= $game->category_slug . '/' . $game->slug; ?>" class="game-icon-button">
                        <?php $totalTournaments = $meta->get_active_tournaments($game->game_id); ?>
                        <div class="game-title-box">
                            <h2><?= $game->game_name; ?></h2>
                            <p><?= $totalTournaments . ' ' . ($totalTournaments > 1) ? 'Tournaments' : 'Tournament'; ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="dso-s-3">
    <div class="container">
        <div class="verticle-heading">
            <span class="text-rotate text-white text-upercase">Top</span>
            <div class="dso-sec-heading">
                <h2>Streamers System</h2>
            </div>
        </div>


        <div class="streamers-wrapper">
             <div class="player-box">
                <div class="player-tumb">
                    <img src="<?= base_url(); ?>assets/frontend/uploads/users/user-4.jpg"  loading="lazy" />
                </div>

                <div class="player-content">
                    <h3>MemeRegion</h3>
                    <a href="https://www.twitch.tv/memeregion" class="channel-btn-red">VIEW CHANNEL</a> 
                </div>
            </div>                       

            <div class="player-box">
                <div class="player-tumb">
                    <img src="<?= base_url(); ?>assets/frontend/images/axlahh-profile-photo.png" loading="lazy" />
                </div>

                <div class="player-content">
                    <h3>axlahh</h3>
                    <a href="https://www.twitch.tv/axlahh" class="channel-btn-red">VIEW CHANNEL</a> 
                </div>
            </div>

            <div class="player-box">
                <div class="player-tumb">
                    <img src="<?= base_url(); ?>assets/frontend/uploads/users/spg_chaos_logo.png" loading="lazy" />
                </div>

                <div class="player-content">
                    <h3>SPG Chaos</h3>
                    <a href="https://www.twitch.tv/spg_chaos" class="channel-btn-red">VIEW CHANNEL</a> 
                </div>
            </div>

            <div class="player-box">
                <div class="player-tumb">
                    <img src="<?= base_url(); ?>assets/frontend/uploads/users/user-2.jpg" loading="lazy" />
                </div>

                <div class="player-content">
                    <h3>fluffy_ghostx</h3>                
                    <a href="https://www.twitch.tv/fluffy_ghostx" class="channel-btn-red">VIEW CHANNEL</a> 
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dso-s-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="verticle-heading">
                    <span class="text-rotate text-white text-upercase">Sign up for</span>
                    <div class="dso-sec-heading">
                        <h2>tournament</h2>
                    </div>
                </div>
                <p class="text-white text-lg-1">Join us today to play exciting tournaments and get rewards for your self as we provide best leagues.</p>
            </div>
            <div class="col-md-6">
                <div class="dso-process-form">
                    <div class="table-box">
                        <div class="cell-box">
                            <form action="<?= base_url(); ?>home/processSignup" class="signup-home" onsubmit="return false;">
                                <div id="msg-login"></div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="fname">First name</label>
                                            <input type="text" class="form-control" name="fname" required >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="fname">Last name</label>
                                            <input type="text" class="form-control" name="lname" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="Email">Email</label>
                                            <input type="email" class="form-control" name="email" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="fname">Platform (i.e. xbox - pc)</label>
                                            <input type="text" class="form-control" name="platform" required >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="Email">Discord Username</label>
                                            <input type="text" class="form-control" name="discord_username" required >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="Email">Username On Console</label>
                                            <input type="text" class="form-control" name="console_username" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="Email">Country</label>
                                            <input type="text" class="form-control" name="country" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-white">Game Interested</label>
                                            <select class="select2 select2-multiple" multiple="multiple" data-placeholder=" -- Select Game -- " style="width: 100%;" name="interested_game[]" >
                                                <?php foreach($gamesData as $game): ?>   
                                                    <option value="<?= $game->game_id; ?>"><?= $game->game_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Submit</span>
                                                <div class="dso-btn-bg-holder"></div>
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
                                        <div class="form-group dso-animated-field-label">
                                            <label for="Email">Set Password</label>
                                            <input type="password" class="form-control cl_password" name="password" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <label for="fname">Confirm Password</label>
                                            <input type="password" class="form-control confirm_cl_password" name="confirmPassword" required />
                                        </div>
                                    </div>

                                    <input type="hidden" name="userID" value="0">

                                    <div class="col-md-12">
                                        <div class="form-group dso-animated-field-label">
                                            <button type="submit" class="btn dso-ebtn dso-ebtn-solid cl_process">
                                                <span class="dso-btn-text">Submit</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>

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

        <div class="pad-120">
            <div class="verticle-heading">
                <span class="text-rotate text-white text-upercase">Featured</span>
                <div class="dso-sec-heading">
                    <h2>Tournaments</h2>
                </div>
            </div>

            <div class="dso-ft-row">
                <div class="dso-tr-full">
                    <div class="dso-tr-box dso-tr-lg">
                        <div class="dso-tr-image">
                            <img src="<?= base_url(); ?>assets/frontend/images/tournaments/trounament-1.jpg" loading="lazy" />
                        </div>

                        <div class="dso-tr-content">
                            <h2>DESTINY 2 TOURNAMENT</h2>
                            <a href="#" class="btn dso-ebtn dso-ebtn-solid">REGISTER NOW`</a>
                        </div>
                    </div>
                </div>

                <div class="dso-tr-divide">
                    <div class="dso-tr-box">
                        <div class="dso-tr-image">
                            <img src="<?= base_url(); ?>assets/frontend/images/tournaments/trounament-2.jpg" loading="lazy" />
                        </div>

                        <div class="dso-tr-content">
                            <h2>CS: GO TOURNAMENT</h2>
                            <a href="#" class="btn dso-ebtn dso-ebtn-solid">REGISTER NOW`</a>
                        </div>
                    </div>

                    <div class="dso-tr-box">
                        <div class="dso-tr-image">
                            <img src="<?= base_url(); ?>assets/frontend/images/tournaments/trounament-3.jpg" loading="lazy" />
                        </div>

                        <div class="dso-tr-content">
                            <h2>DOTA 2 TOURNAMENT</h2>
                            <a href="#" class="btn dso-ebtn dso-ebtn-solid">REGISTER NOW`</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal" id="video-player" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title video-title">&nbsp;</h5>
				<button type="button" class="close close-home-video" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
    
            <div class="modal-body">
                <div class="video-player">
                <iframe id="player" width="560" height="315" src="https://www.youtube.com/embed/MqsL4OFT7k8?si=vbi6bKLNGHKb7Hvs&enablejsapi=1" title="YouTube video player" loading="lazy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>

            <div class="loader-wrapper load-video" style="display: none;">
                <div class="loader-sub" id="login-video-player" style="display: block;">
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