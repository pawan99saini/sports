<div class="dso-recruitment">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="dso-lg-content">
                    <h1>
                        Valorant 
                        <span>Recruitment</span>
                    </h1>
                    <p data-aos-delay="300" data-aos="fade-up">Looking forward to work with us?</p>
                </div>
            </div>

            <div class="col-md-7">
                <div class="dso-main-form">
                    <form action="<?= base_url(); ?>home/processApplication" class="apply-valorant" onsubmit="return false;">
                        <div id="msg-login"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="fname">First name</label>
                                    <input type="text" class="form-control" name="first_name" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="fname">Last name</label>
                                    <input type="text" class="form-control" name="last_name" >
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">Discord Username</label>
                                    <input type="text" class="form-control" name="discord_username" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">Valorant Name</label>
                                    <input type="text" class="form-control" name="valorant_name" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">Valorant Rank</label>
                                    <input type="text" class="form-control" name="valorant_rank" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">How old are you?</label>
                                    <input type="text" class="form-control" name="age" >
                                </div>
                            </div>
                            
                            <div class="col-md-6"></div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">Email</label>
                                    <input type="email" class="form-control" name="email" >
                                </div>
                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <label for="fname">Phone</label>
                                    <input type="text" class="form-control" name="phone" >
                                </div>
                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn dso-ebtn dso-ebtn-solid register-btn">Submit</button>

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
                </div>
            </div>
        </div>
    </div>
</div>