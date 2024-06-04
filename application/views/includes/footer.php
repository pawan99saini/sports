    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logo-ft">
                            <img src="<?= base_url(); ?>assets/frontend/images/logo.png" />
                        </div>

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
                    <div class="col-md-9">
                        <ul class="footer-nav">
                            <li><a href="<?= base_url(); ?>">
                                Home
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>community">
                                Community
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>team">
                                DSO Teams
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>our-players">
                                DSO Players
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>support">
                                Support
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>careers">
                                Careers
                                </a>
                            </li>

                            <li><a href="<?= base_url(); ?>valorant-recruitment">
                                Valorant Recruitment
                                </a>
                            </li>
                        </ul>
                    </div>             
                </div>

                <div class="footer-btm">
                    <div class="row">
                        <div class="col-md-6">
                            <p>© 2021 DSO Esports, All Rights Reserved</p>
                        </div>
                        <div class="col-md-6">
                            <p class="align-right pwrd-by">
                                <span>Powered BY:</span>
                                <a href="https://arma.gg/collections/dso"><img src="<?= base_url(); ?>assets/frontend/images/arma_logo.png"></a>
                                <a href="https://www.dubby.gg/?ref=RBHefL6gHr1lN"><img src="<?= base_url(); ?>assets/frontend/images/dubby.png"></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
    
    <!-- jQuery library -->
    <script type="text/javascript">var site_url = '<?= base_url(); ?>';</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/lib.js?ver=1.0.3"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-simple-upload.js"></script>
    <script src="<?= base_url(); ?>assets/frontend/js/main.js?ver=1.2.0"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/frontend/js/jquery.gracket.js"></script>
    <script type="text/javascript">
        (function(win, doc, $){

            console.warn("Make sure the min-width of the .gracket_h3 element is set to width of the largest name/player. Gracket needs to build its canvas based on the width of the largest element. We do this my giving it a min width. I'd like to change that!");

            if(typeof bracketData !== 'undefined') {
                win.tournamentBracket = bracketData;

                // initializer
                $(".tournament_bracket").gracket({ src : win.tournamentBracket });
            }

        })(window, document, jQuery);

        $(function () {
            $(".select2").select2();
        });
    </script>
</html>