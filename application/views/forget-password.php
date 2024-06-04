<div class="dso-recruitment banner-login">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="dso-lg-content">
                    <h1>
                        Having Trouble
                        <span>Signing In</span>
                    </h1>
                    <p data-aos-delay="300" data-aos="fade-up">Don't Worry Let Us Help You With getting Your Password Back.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dso-main-form">
                    <form action="<?= base_url(); ?>home/forget" class="reset-password" onsubmit="return false;">
                        <div id="msg-login"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group dso-animated-field-label">
                                    <label for="Email">Email</label>
                                    <input type="email" class="form-control" value="&nbsp;" name="email" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="dso-btn-row">
                                    <button type="submit" class="btn dso-ebtn dso-ebtn-solid register-btn">Reset My Password</button>

                                    <div class="loader-sub" id="login-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row content-space-between mg-t-60">
                                    <a href="<?= base_url(); ?>login" class="text-lg-1 text-white">Know Your Password? Login</a>
                                    <a href="<?= base_url(); ?>register" class="text-lg-1 text-white">Don't Have An Account? Signup Now!</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>