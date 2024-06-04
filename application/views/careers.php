<div class="dso-team-recruit-main">
    <div class="team-recruit-banner" style="background: url('<?= base_url(); ?>assets/frontend/images/video-banner-bg.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dso-lg-content">
                        <h1>
                            Careers
                        </h1>
                        <p data-aos-delay="300" data-aos="fade-up">We have some awesome opportunities to join our creative team!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pad-120">
        <div class="container">
            <?php if(count($jobsData) == 0) { ?>
            <div class="not-found full-404">
                <img src="<?= base_url(); ?>assets/frontend/images/not-found-icon.png">
                <span class="text-white">No Jobs Found</span>
            </div>
            <?php } else { ?>
                <div class="job-application" style="display: none;">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="dso-lg-content">
                                <h1>
                                    Job 
                                    <span>Application</span>
                                </h1>
                                <p data-aos-delay="300" data-aos="fade-up">Looking forward to work with us?</p>
                            </div>
                        </div>

                        <div class="col-md-7">
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

                                        <input type="hidden" name="job_id" value="" />
                                        <input type="hidden" name="type" value="<?= $type; ?>" />

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

                <div class="post-wrapper">
                    <div id="msg-login"></div>
                    <div class="disscussion-board dso-job-post-wrapper">
                    <?php foreach($jobsData as $job): ?>
                        <div class="dso-post-discussion dso-job-post-row">
                            <div class="dso-post-header">
                                <div class="dso-post-meta wd-inner-3 justify-between align-items-start">
                                    <span>
                                        <strong>Company  : </strong><br />
                                        <span class="text-white text-sm"><?= $job->company; ?></span>
                                    </span>
                                    <span>
                                        <strong>Location : </strong><br />
                                        <span class="text-white text-sm"><?= $job->location; ?></span>
                                    </span>
                                    <span>
                                        <strong>Job Type : </strong><br />
                                        <span class="text-white text-sm"><?= ($job->type == 1) ? 'Full Time' : 'Part Time'; ?></span>
                                    </span>
									<?php if(count($jobsMeta)) { ?>
									<?php foreach($metaData as $meta): ?>
									<span>
                                        <strong><?= $meta->meta_key; ?> : </strong><br />
                                        <span class="text-white text-sm"><?= $meta->meta_value; ?></span>
                                    </span>
									<?php endforeach; ?>
									<?php } ?>
                                </div>
                                <h2>
                                    <a href="<?= base_url(); ?>careers/<?= $job->slug; ?>"><?= $job->title; ?></a>
                                </h2>
                            </div>

                            <div class="dso-post-content">
                                <div class="dso-main-info">
                                    <div class="dso-sm-info-box">
                                        <div class="top-icon-info">
                                            <div class="dso-icon-sm">
                                                <div class="dso-role-icon dso-role-icon ion-ios-briefcase-outline"></div>
                                                <span class="dso-player-info-title">Experience</span>
                                            </div>

                                            <h5><?= $job->experience; ?></h5>
                                        </div>
                                    </div>

                                    <div class="dso-sm-info-box">
                                        <div class="top-icon-info">
                                            <div class="dso-icon-sm">
                                                <div class="dso-role-icon ion-ios-pricetag-outline"></div>
                                                <span class="dso-player-info-title">Package</span>
                                            </div>

                                            <h5><?= $job->package; ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-tag">
                                    <a class="btn-apply btn dso-ebtn dso-ebtn-solid" href="<?= base_url(); ?>careers/<?= $job->slug; ?>" data-id="<?= $job->id; ?>">
                                        <span class="dso-btn-text">Apply Now</span>
                                        <div class="dso-btn-bg-holder"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>                
            <?php } ?>
        </div>
    </div>
</div>