<?php if($joinRequest == true) { ?>
<div class="sticky-right">
    <form method="POST" action="<?= base_url(); ?>team/<?= $slug; ?>/processRrequest/<?= $userIDJoin; ?>">
        <h4>Willing To Join <?= $teamName; ?></h4>
        <div class="btn-row">
            <a href="<?= base_url(); ?>team/<?= $slug; ?>/processRrequest/<?= $userIDJoin; ?>/accept" class="btn btn-red">
            <i class="fa fa-thumbs-up"></i> Accept
            </a>
            <a href="<?= base_url(); ?>team/<?= $slug; ?>/processRrequest/<?= $userIDJoin; ?>/decline" class="btn btn-red btn-light">
            <i class="fa fa-thumbs-down"></i> Decline
            </a>
        </div>
    </form>
</div>
<?php } ?>

<div class="dso-main">
    <?= $cover_photo; ?>
    <div class="dso-profile-header dso-banner-overlay" <?= ($cover_photo != '') ? 'style="' . $cover_photo . '"' : ''; ?>>
        <div class="container">
            <?php if($edit == 1) { ?> 
            <div class="btn-pos-absol pos-top pos-right">
                <a href="javascript:void(0);" class="edit-p edit-header btn dso-ebtn dso-ebtn-solid">
                    <span class="dso-btn-text">Edit Header</span>
                    <div class="dso-btn-bg-holder"></div>
                </a>
            </div>
            <?php } ?>

            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="team-logo-center">
                        <div class="dso-user-profile">
                            <div class="dso-thumbail-circle" style="display : <?= ($team_logo_show == 'show' || $team_logo_show == '') ? 'block' : 'none'; ?>;">
                                <?php        
                                    if($get_image == null) {
                                        $image_url = base_url() . 'assets/frontend/images/team-logo.png';
                                    } else {
                                        $image_url = base_url() . 'assets/uploads/teams/' . $get_image;
                                    }
                                ?>
                                <img loading="lazy" src="<?= $image_url; ?>" />
                                <?php if($edit == 1) { ?>   
                                    <a href="javascript:void(0);" class="edit-dp edit-cp" data-value="Profile Photo">
                                        <i class="fa fa-camera"></i>
                                    </a>
                                    <div class="overwrap"></div>
                                <?php } ?>
                            </div>

                            <div class="dso-user-info">
                                <?php if($edit == 1) { ?>  
                                <div class="edit-form" style="display: none;">
                                    <form method="POST" action="<?= base_url(); ?>account/update_header" onsubmit="return false;" class="update_header">
                                        <div class="form-group">
                                            <input type="text" name="teamName" class="form-control" value="<?= $teamName; ?>" />
                                        </div>

                                        <div class="dso-btn-row">
                                            <div class="form-group">
                                                <label class="text-white text-lg-2">Header team name Display</label>
                                                <div class="inline-item">
                                                    <div class="inline-radio">
                                                        <input type="radio" name="team_name_show" value="show" <?= ($team_name_show == 'show') ? 'checked' : ''; ?> />
                                                        <span>Show</span>
                                                    </div>
                                                    <div class="inline-radio">
                                                        <input type="radio" name="team_name_show" value="hide" <?= ($team_name_show == 'hide') ? 'checked' : ''; ?> />
                                                        <span>Hide</span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="team_title" value="<?= $team_name_show; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-white text-lg-2">Header Team Logo</label>
                                                <div class="inline-item">
                                                    <div class="inline-radio">
                                                        <input type="radio" name="team_logo_show" value="show" <?= ($team_logo_show == 'show') ? 'checked' : ''; ?> />
                                                        <span>Show</span>
                                                    </div>
                                                    <div class="inline-radio">
                                                        <input type="radio" name="team_logo_show" value="hide" <?= ($team_logo_show == 'hide') ? 'checked' : ''; ?> />
                                                        <span>Hide</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dso-btn-row">
                                            <button type="button" class="btn dso-ebtn dso-ebtn-outline btn-cancel">
                                                <span class="dso-btn-text">Cancel</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>
                                            <button type="submit" name="name" class="btn dso-ebtn dso-ebtn-solid">
                                                <span class="dso-btn-text">Update Header</span>
                                                <div class="dso-btn-bg-holder"></div>
                                            </button>
                                            <div class="loader-sub" id="loader">
                                                <div class="lds-ellipsis">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                                <?php } ?>
                                <h2><?= $teamName; ?></h2> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dso-profile-meta-info">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="dso-main-info">
                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-ios-game-controller-b"></div>
                                <span class="dso-player-info-title">Tournaments Played</span>
                            </div>

                            <h5>0</h5>
                        </div>
                    </div>

                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-trophy"></div>
                                <span class="dso-player-info-title">Tournaments Won</span>
                            </div>

                            <h5>0</h5>
                        </div>
                    </div>

                    <div class="dso-sm-info-box">
                        <div class="top-icon-info">
                            <div class="dso-icon-sm">
                                <div class="dso-role-icon ion-trophy"></div>
                                <span class="dso-player-info-title">Win Rate</span>
                            </div>

                            <h5>0.00%</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="dso-signedup-players">
                    <div class="dso-players-info-title">
                        <span>Team Members</span>
                        <h3><?= count($team_membersData); ?></h3>
                    </div>

                    <div class="dso-sm-players-list">
                        <?php 
                        if(count($team_membersData) > 0) { 
                            $i = 1; 
                            foreach($team_membersData as $member) { 
                                if($i <= 3) {   
                                    $get_image = $ci->get_user_meta('user_image', $member->user_id);
                                    if($get_image == null) {
                                        $image_url = base_url() . 'assets/uploads/users/default.jpg';
                                    } else {
                                        $image_url = base_url() . 'assets/uploads/users/user-' . $member->user_id . '/' . $get_image;
                                    }
                        ?>    
                                    <div class="teams-thumnail-circle">
                                        <?php $url_profile = 'profile/'.$member->username; ?>

                                        <a href="<?= $url_profile; ?>">
                                            <img src="<?= $image_url; ?>" />
                                        </a>
                                    </div>
                            <?php } ?>
                        <?php $i++; ?>
                        <?php } ?>
                        <?php if(count($team_membersData) - 3 > 0) { ?>
                        <?php $remNumPlayers = count($team_membersData) - 3; ?>
                        <div class="teams-thumnail-circle">
                            <a href="javascript:void(0);" class="target-tab" data-target="#participants">
                                <h2>+<?= $remNumPlayers; ?></h2>
                            </a>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mg-t-80">
        <div class="container">
            <div class="nav-tabs">
                <a href="#about-team" class="dso-nav-tabs <?= ($method != 'team-members') ? 'dso-nav-current': ''; ?>">Overview</a>
                <a href="#discussion" class="dso-nav-tabs">Discussion Board</a>
                <?php if($edit == 1) { ?>  
                <a href="#teamMembers" class="dso-nav-tabs <?= ($method == 'team-members') ? 'dso-nav-current': ''; ?>">Manage Team Members</a>
                <?php } ?>
            </div>

            <div class="dso-tab-wrapper <?= ($method == 'team-members') ? '' : 'active-nav-tab'; ?>" id="about-team">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>About The Team</h3>
                    </div>

                    <?php 
                        if($get_description == '') {
                            $description = '';
                        } else {
                            $description = $get_description;
                        }
                    ?>
                    <?php if($edit == 1) { ?>  
                    <textarea name="p-desc" id="editorRichText" class="content1 form-control p-update" data-target="content1" data-p="update-btn" rows="8"><?= nl2br($description); ?></textarea>
                    <div class="update-btn" style="display: none;">
                        <a href="<?= base_url(); ?>account/update_description" class="upd-desc btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Update Description</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a>
                    </div>
                    <div class="loader loader-des">
                        <img src="<?= base_url(); ?>assets/frontend/images/loader.gif" />
                    </div>
                    <?php } else { ?>   
                    <div class="text-white text-lg-2">
                        <?= nl2br($description); ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3>
                            Active Team Members
                        </h3>
                    </div>
					
					<?php if(count($team_membersData) > 0) { ?> 
                    <div class="box-row" id="players">
                        <?php foreach($team_membersData as $member): ?>
                        <?php 
                            $member_get_image = $meta->get_user_meta('user_image', $member->user_id);
                            
                            if($member_get_image == null) {
                                $member_img = base_url() . 'assets/uploads/users/default.jpg';
                            } else {
                                $member_img = base_url() . 'assets/uploads/users/user-' . $member->user_id . '/' . $member_get_image;
                            }
                        ?>
                            <div class="player-box">
                                <div class="player-tumb">
                                    <img src="<?= $member_img; ?>">
                                </div>

                                <div class="player-content">
                                    <h3><?= $member->first_name . ' ' . $member->last_name; ?></h3>
                                    <?php if($edit == 1) { ?> 
                                    <a href="<?= base_url() . 'team/profile/remove-member/' . $member->id; ?>" class="channel-btn-red">Remove</a>
                                    <?php } else { ?>
                                    <a href="<?= base_url() . 'profile/' . $member->username; ?>" class="channel-btn-red">View Profile</a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
					<?php } else { ?>
					<div class="not-found">
						<img src="<?= base_url(); ?>assets/frontend/images/nothing-found.png">
						<span>No Team Members Found.</span>
					</div>
					<?php } ?>
                </div>
            </div>

            <div class="dso-tab-wrapper" id="discussion">
                <div class="dso-lg-content m-b-20">
                    <h3>Discussion Board</h3>
                </div>

                <?php if($edit == true) { ?>
                <div class="discuss-form">
                    <form method="POST" action="<?= base_url(); ?>account/create_topic" class="create_topic" onsubmit="return false;">
                        <div class="form-group">
                            <input type="text" class="form-control" name="post_title" placeholder="Topic Title" required />
                        </div>

                        <div class="form-group">
                            <textarea name="topic_description" class="form-control" placeholder="Topic Description" rows="8"></textarea>
                        </div>
                        
                        <div class="btn-row">
                            <button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Create Topic</span>
                                <div class="dso-btn-bg-holder"></div>
                            </button>
                            
                            <div class="loader-sub" id="loader">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php } ?>
                <div class="disscussion-board">
                    <?php foreach($post_topics as $topic) { ?>   
                    <div class="dso-post-discussion">
                        <div class="dso-post-header">
                            <div class="dso-post-meta">
                                <span><?= date('d F, Y', strtotime($topic->date_created)); ?></span>
                                <span><?= $topic->views; ?> Views</span>
                                <span><?= count($ci->get_topic_comments($topic->id)); ?> Comments</span>
                            </div>
                            <h2>
                                <a class="p-permalink" href="<?= base_url(); ?>account/get_topic" data-id="<?= $topic->id; ?>"><?= $topic->title; ?></a>
                            </h2>
                        </div>

                        <div class="dso-post-content">
                        <?php 
                            $countContent = strlen($topic->description);
                            $postContent  = ($countContent > 200) ? substr($topic->description, 0, 200) . ' ...' : $topic->description;
                            echo '<p class="text-grey text-lg-2">' . nl2br($postContent) . '</p>';
                        ?>    
                        </div>
                        <?php if($countContent > 200) { ?>
                            <a class="p-permalink" href="<?= base_url(); ?>account/get_topic" data-id="<?= $topic->id; ?>">Read More</a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="discussion-details"></div>

                <div class="loader-sub" id="post-load">
                    <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            <?php if($edit == 1) { ?>  
            <div class="dso-tab-wrapper <?= ($method == 'team-members') ? 'active-nav-tab': ''; ?>" id="teamMembers">
                <div class="content-box m-b-40">
                    <div class="dso-lg-content m-b-20">
                        <h3 class="d-flex align-items-center justify-content-between">
                            Manage Team Members
                            <a href="javascript:void(0);" class="btn dso-ebtn dso-ebtn-solid add-member">Add Member</a>
                        </h3>
                    </div>

                    <div class="players players-inner">
                    <?php foreach($team_members as $trequest): ?>
                    <?php 
                        $trmemb_get_image = $meta->get_user_meta('user_image', $trequest->user_id);
                        
                        if($trmemb_get_image == null) {
                            $trmemb_img = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $trmemb_img = base_url() . 'assets/uploads/users/user-' . $trequest->user_id . '/' . $trmemb_get_image;
                        }
                    ?>
                        <div class="player-box">
                            <div class="player-tumb">
                                <img src="<?= $trmemb_img; ?>">
                            </div>

                            <div class="player-content">
                                <h3><?= $trequest->first_name . ' ' . $trequest->last_name; ?></h3>
                                <a href="<?= base_url() . 'team/profile/cancel-request/' . $trequest->id; ?>" class="channel-btn-red">Cancel Request</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div class="add-players" style="display: none;">
                        <div class=" d-flex justify-content-center">
                            <div class="dso-col-light"> 
                                <div class="dso-lg-content m-b-20">
                                    <h3>Add New member</h3>
                                </div>

                                <form method="POST" action="<?= base_url(); ?>account/add_member" onsubmit="return false;" class="add-member-process">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group dso-animated-field-label">
                                                <label for="Email">Email / Username</label>
                                                <input type="text" class="form-control search-invite-user" data-location="<?= base_url(); ?>account/search_member" data-type="add_member" name="email" />
                                                <a href="javascript:void(0);" class="empty-invite-field"><i class="fa fa-times-circle"></i></a>
                                            </div>

                                            <div class="btn-row">
                                                <div class="loader-sub" id="invite-player-load">
                                                    <div class="lds-ellipsis">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="users-list"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="container">
        <div class="dsoreg-banner">
            <div class="dsoreg-inner-banner">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="dso-lg-content">
                            <span class="sm-text">Excited To Join</span>
                            <h1>
                                <span>Let's Not Wait</span>
                                Enroll Today and Start Gaming
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Register</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<?php if($edit == 1) { ?>
<div id="updateImage" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update <span class="p-title"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url(); ?>account/update_team_profile_picture" enctype="multipart/form-data">
                	<p>Minimum Required Dimensions <span class="dimension"></span></p>
                    <div class="form-group">
                        <label>Select Image</label>
                        <input type="file" name="update_image" class="form-control">
                    </div>
                    <input type="hidden" name="update_value" class="form-control" value="">
                    <input type="hidden" name="target_loc" value="team" />
                    <input type="hidden" name="teamID" value="<?= $teamID; ?>" />
                    <div class="btn-row justify-content-end">
						<button type="submit" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Update Photo</span>
                            <div class="dso-btn-bg-holder"></div>
                        </button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>