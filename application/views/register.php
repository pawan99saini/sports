<div class="dso-recruitment banner-register">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="dso-lg-content">
                    <h1>
                        Signup With Us
                        <span>Today</span>
                    </h1>
                    <p data-aos-delay="300" data-aos="fade-up">Join us today to play exciting tournaments and get rewards for your self as we provide best leagues.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dso-main-form">
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
                                                <input type="text" class="form-control username-valid" name="username" required />
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
        </div>
    </div>
</div>