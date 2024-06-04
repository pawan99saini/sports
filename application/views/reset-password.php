<section class="bg-dark">
	<div class="container">
		<div class="login-box">
			<form action="<?= base_url(); ?>home/setPassword" class="recover-password" onsubmit="return false;">
                <div id="msg-login"></div>
                <h3>Reset Password</h3>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password" >
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" >
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="code" value="<?= $userCode; ?>">
                    <input type="hidden" class="form-control" name="user_id" value="<?= $user_Id; ?>">

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-curved">Reset Password</button>                            

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
</section>