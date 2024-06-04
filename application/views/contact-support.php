<div class="dso-main">
    <div class="dso-support-header">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="dso-lg-content">
                        <h1>
                            Hello!
                            <span>Let Us Help You</span>
                        </h1>
                        <p data-aos-delay="300" data-aos="fade-up">Write us Down and our representative will be with you..</p>
                    </div>
                </div>

                <div class="col-md-5">
                </div>
            </div>
        </div>
    </div>

    <div class="pad-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="dso-lg-content">
                        <h1>
                            Create
                            <span>New Request</span>
                        </h1>
                        <p data-aos-delay="300" data-aos="fade-up">We Will surely Help You Out</p>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="dso-main-form">
                        <form method="POST" action="<?= base_url(); ?>home/submitSupportRequest" onsubmit="return false;" class="process-suppport">
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
                                    <div class="form-group">
                                        <select class="form-control" name="department">
                                            <option value=""> -- Select Department --</option>
                                            <option value="support">Customer Support</option>
                                            <option value="report">Bug Report</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" name="email" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="fname">Question</label>
                                        <textarea class="form-control" name="question" rows="8"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="dso-btn-row">
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
</div>