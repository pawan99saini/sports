<div class="add-players">
    <div class=" d-flex justify-content-center">
        <div class="dso-col-light"> 
            <div class="dso-lg-content m-b-20">
                <h3>Start Adding Members To Your Profile</h3>
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

                <input type="hidden" name="teamID" value="<?= $teamID; ?>" /> 
                <input type="hidden" name="teamProfile" value="1" /> 
                <input type="hidden" name="playersCount" value="0" />
                <div class="selected-users">

                </div>
            </form>

            <div class="btn-row d-flex justify-center dso-ninterst">
                <a href="<?= base_url() . 'team/profile/'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                    <span class="dso-btn-text text-btn">Will Decide Later</span>
                    <div class="dso-btn-bg-holder"></div>
                </a>
            </div>
        </div>
    </div>
</div>