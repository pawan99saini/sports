<footer>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logo-ft">
                            <img src="<?= base_url(); ?>assets/frontend/images/logo.png" />
                        </div>
                    </div>
                    <div class="col-md-9">
                        <ul class="footer-nav">
                            <li>
                                <a href="<?= base_url(); ?>">
                                Home
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>community">
                                Community
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>team">
                                Teams
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>players">
                                Players
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>support">
                                Support
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>careers">
                                Careers
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>team-recruitment">
                                Team Recruitment
                                </a>
                            </li>
                        </ul>

                        <ul class="ft-social">
                            <li>
                                <a href="https://twitter.com/DsoEsports?t=DhV9OYsasGQQ8tbMMeX3AQ&s=09">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://youtube.com/c/DSOEsports">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://instagram.com/dsoesports?igshid=YmMyMTA2M2Y=">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://discord.gg/QjvZRSEKzV">
                                    <i class="fab fa-discord"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.twitch.tv/dsoesports">
                                    <i class="fab fa-twitch"></i>
                                </a>
                            </li>
                        </ul>
                    </div>             
                </div>
            </div>
        </div>

        <div class="footer-btm">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>© 2021 DSO Esports, All Rights Reserved</p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="align-right pwrd-by">
                            <span>Powered BY:</span>
                            <a href="https://arma.gg/collections/dso"><img src="<?= base_url(); ?>assets/frontend/images/arma_logo.png"></a>
                            <a href="https://www.dubby.gg/?ref=RBHefL6gHr1lN"><img src="<?= base_url(); ?>assets/frontend/images/dubby.png"></a>
                            <a href="https://www.skillstechinc.com" target="_blank"><img src="https://skillstechinc.com/assets/images/logo-light.png"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="burger-menu">
        <div class="burger-menu-wrapper">
            <a href="#" class="close-menu">
                <span></span><span></span>
            </a>
            
            <div class="col-wrapper-full">
                <div class="logo-box">
                    <div class="brand-col">    
                        <img src="<?= base_url(); ?>assets/frontend/images/logo.png" />
                    </div>
     
                    <div class="c-info">
                        <div class="form">
                            <form action="<?= base_url(); ?>home/searchData" class="search" onsubmit="return false;">
                                <div class="btn-inline-row d-flex justify-content-between">
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" name="type" type="radio" id="inlineCheckbox1" value="players" checked>
                                        <label class="form-check-label" for="inlineCheckbox1">Players</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" name="type" type="radio" id="inlineCheckbox2" value="teams">
                                        <label class="form-check-label" for="inlineCheckbox2">Teams</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" name="type" type="radio" id="inlineCheckbox2" value="tournaments">
                                        <label class="form-check-label" for="inlineCheckbox2">Tournaments</label>
                                    </div>
                                </div>
                                <div class="search-button">
                                    <input type="text" placeholder="SEARCH" name="search" id="search_user" />
                                    <button type="button"><i class="fa fa-search"></i></button>
                                    <a href="javascript:void(0);" class="empty-search-field"><i class="fa fa-times-circle"></i></a>
                                </div>
                            </form>

                            <div class="search-results-wrapper">
                                <div class="loader-wrapper load-search-results">
                                    <div class="loader-sub" id="login-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="search-results"></div>
                            </div>
                        </div>
                    </div>    
                </div>

                <div class="dso-p-b-descrip">
                    <h4>Follow Us On: </h4>
                    <ul class="social-media-icon">
                        <li>
                            <a href="https://twitter.com/DsoEsports?t=DhV9OYsasGQQ8tbMMeX3AQ&s=09">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://youtube.com/c/DSOEsports">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/dsoesports?igshid=YmMyMTA2M2Y=">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://discord.gg/QjvZRSEKzV">
                                <i class="fab fa-discord"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.twitch.tv/dsoesports">
                                <i class="fab fa-twitch"></i>
                            </a>
                        </li> 
                        
                        <li>
                            <a href="https://www.reddit.com/r/DSOESPORTS/comments/16gu6rj/welcome_to_the_dso_esports_community/">
                                <i class="fab fa-reddit"></i>
                            </a>
                        </li>   
                    </ul>
                </div>
            </div>  
        </div>  
    </div>

    <!-- <div class="modal" id="notice" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <h2>Scheduled Maintenance</h2>
                        <p>
                            Dear users,

                            <br /><br />
                            This notice is specially for active users with DSO Esports. You might experience some errors and difficulties while using the website as our Tech team is working on the advancment and fixing the issues with tournament Matches system this won't take so long so stay tuned and you can still explore the website

                        </p>

                        <strong>Maintenance Timeframe</strong><br />
                        <p>From : 03/08/2023 - 03/10/2023 06:00 PM Central Time</p>

                        <p>
                            Thank You For Your Cooperations
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</body>
    
    <!-- jQuery library -->
    <script type="text/javascript">var site_url = '<?= base_url(); ?>';</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/lib.js?ver=1.0.6"></script>
    <?php if($this->session->userdata('is_logged_in') == true) { ?>
    <script src="<?= base_url(); ?>assets/frontend/js/emojionearea.min.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/jquery.textcomplete.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-simple-upload.js"></script>
    <!-- INTERNAL WYSIWYG Editor JS -->
    <script src="<?= base_url(); ?>assets/admin-new/plugins/wysiwyag/jquery.richtext.js"></script>
    <script src="<?= base_url(); ?>assets/admin-new/plugins/wysiwyag/wysiwyag.js"></script>
    <?php } ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/main.js?ver=1.12.12"></script>
    <?php if($this->session->userdata('is_logged_in') == true) { ?>
    <script src="<?= base_url(); ?>assets/frontend/js/jquery.magnific-popup.min.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/jquery.magnific-popup-init.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/dashboard.js?ver=<?= time(); ?>"></script>
    <?php } ?>
</html>