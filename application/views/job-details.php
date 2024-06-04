<div class="dso-team-recruit-main">
    <div class="team-recruit-banner" style="background: url('<?= base_url(); ?>assets/frontend/images/video-banner-bg.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dso-lg-content">
                        <h1>
                            <?= $jobsData[0]->title; ?>
                        </h1>
                        <p data-aos-delay="300" data-aos="fade-up"><?= $jobsData[0]->location; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pad-120">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dso-col-light">
                        <div class="content-box">
                            <div class="acc-summary">    
                                <div class="dso-post-discussion">
                                    <div class="dso-post-header">
                                        <div class="dso-post-meta wd-inner-3 justify-between align-items-start">
                                            <span>
                                                <strong>Company  : </strong><br />
                                                <span class="text-white text-sm"><?= $jobsData[0]->company; ?></span>
                                            </span>
                                            <span>
                                                <strong>Location : </strong><br />
                                                <span class="text-white text-sm"><?= $jobsData[0]->location; ?></span>
                                            </span>
                                            <span>
                                                <strong>Job Type : </strong><br />
                                                <span class="text-white text-sm"><?= ($jobsData[0]->type == 1) ? 'Full Time' : 'Part Time'; ?></span>
                                            </span>
                                        </div>
                                        <h2 class="text-white"><?= $jobsData[0]->title; ?></h2>
                                    </div>

                                    <div class="dso-post-content">
                                        <div class="dso-main-info wd-inner-50 justify-between align-items-start">
                                            <div class="dso-sm-info-box">
                                                <div class="top-icon-info">
                                                    <div class="dso-icon-sm">
                                                        <div class="dso-role-icon dso-role-icon ion-ios-briefcase-outline"></div>
                                                        <span class="dso-player-info-title">Experience</span>
                                                    </div>

                                                    <h5><?= $jobsData[0]->experience; ?></h5>
                                                </div>
                                            </div>

                                            <div class="dso-sm-info-box">
                                                <div class="top-icon-info">
                                                    <div class="dso-icon-sm">
                                                        <div class="dso-role-icon ion-ios-pricetag-outline"></div>
                                                        <span class="dso-player-info-title">Package</span>
                                                    </div>

                                                    <h5><?= $jobsData[0]->package; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Job Description</label>

                                    <p><?= nl2br($jobsData[0]->description); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dso-main-form">
                        <form action="<?= base_url(); ?>home/applyJob" class="apply-job" onsubmit="return false;" enctype="multipart/form-data">
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
                                
                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" name="email" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="fname">Phone</label>
                                        <input type="text" class="form-control" name="phone" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group dso-animated-field-label">
                                        <label for="fname">Link to Your Portfolio / Previous Work</label>
                                        <input type="text" class="form-control" name="previous_work" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-white">
                                        <label for="fname">Driver's Liscence Number / SSN</label>
                                        <input type="file" class="form-control" name="drivers_liscence" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-white">
                                        <label for="fname">Birth Certificate</label>
                                        <input type="file" class="form-control" name="birth_certficate" >
                                    </div>
                                </div>

                                <input type="hidden" name="job_id" value="<?= $jobsData[0]->id; ?>" />
                                <input type="hidden" name="type" value="<?= $type; ?>" />

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn dso-ebtn dso-ebtn-solid register-btn">
                                            <span class="dso-btn-text">Apply Now</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>