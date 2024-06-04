<?php 
    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= isset($title) ? $title : 'DsoEsports'; ?></title>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/style.css?ver=1.1.4">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/ionicons.min.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/magnific-popup.css">
        <?php if($this->session->userdata('is_logged_in') == true) { ?>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/emojionearea.min.css?ver=0.0.2">
        <?php } ?>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/main-new.css?ver=2.12.1">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/responsive.css?ver=1.4.1">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Favion -->
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/frontend/images/favicon.png">
        <!-- Apple touch icon -->
        <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/frontend/images/favicon.png">
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153801526-2"></script>
        
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-153801526-2');
        </script>
    </head>
    <body>

    <div class="page-loader">
        <div class="cssload-loader">
            <div class="cssload-inner cssload-one"></div>
            <div class="cssload-inner cssload-two"></div>
            <div class="cssload-inner cssload-three"></div>
        </div>
    </div>

    <header class="<?= isset($class) ? $class : ''; ?>">
        <div class="dso-header-wrapper">
            <div class="dso-header-inner">
                <div class="dso-header-lg-wrapper">
                    <div class="dso-left-hamburger">
                        <a href="javascript:void(0);" class="dso-hamburger-menu hamburger-menu-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>

                    <div class="dso-menu-top">
                        <ul>
                            <li><a href="<?= base_url(); ?>" class="<?= ($page_active == 'home') ? 'page-active' : ''; ?>">Home</a></li>
                            <li><a href="<?= base_url(); ?>community" class="<?= ($page_active == 'community') ? 'page-active' : ''; ?>">Community</a></li>
                            <li><a href="<?= base_url(); ?>tournaments" class="<?= ($page_active == 'tournaments') ? 'page-active' : ''; ?>">Tournaments</a></li>
                        </ul>
                    </div>
                </div>

                <div class="dso-header-center">
                    <a href="<?= base_url(); ?>" class="logo">
                        <?php if(isset($class) && $class == 'home') { ?>
                        <img src="<?= base_url(); ?>assets/frontend/images/logo-3d.png">
                        <?php } else { ?>
                        <img src="<?= base_url(); ?>assets/frontend/images/logo.png">
                        <?php } ?>
                    </a>
                </div>

                <div class="dso-header-lg-wrapper">
                    <div class="dso-menu-top">
                        <ul>
                            <li><a href="<?= base_url(); ?>dso-members" class="<?= ($page_active == 'dso-members') ? 'page-active' : ''; ?>">DSO Members</a></li>
                            <li><a href="<?= base_url(); ?>about-us" class="<?= ($page_active == 'about-us') ? 'page-active' : ''; ?>">About</a></li>
                            <li><a href="<?= base_url(); ?>support">Support</a></li>
                        </ul>
                    </div>

                    <div class="dso-widget-top">
                        <?php if($this->session->userdata('is_logged_in') != true) { ?>
                            <a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text">Register / Login</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a>
                        <?php } else { ?>
                        <?php 
                            $userID    = $this->session->userdata('user_id');
                            $user_role = $this->session->userdata('user_role');
                            $userimage = $this->db->get_where('user_meta', array(
                                'user_id'    => $this->session->userdata('user_id'),
                                'meta_title' => 'user_image' 
                            ));

                            if($userimage->num_rows() == 0) {
                                $image_url = base_url() . 'assets/frontend/images/default.png';
                            } else {
                                $image_url = base_url() . 'assets/uploads/users/user-' . $userID . '/' . $userimage->row()->meta_value;
                            }

                          
                            $profile_url = 'profile';
                            $chatNotificationQuery = "SELECT * FROM messages WHERE receiver_id = '" . $userID . "' AND status = 1 GROUP BY sender_id ORDER BY id";
                            $chatNotificationData = $this->db->query($chatNotificationQuery)->result();
                            $notificationCount    = count($chatNotificationData);
                            $notificationBubble   = '';

                            if(count($chatNotificationData) > 0) {
                                $notificationBubble .= '<div class="notify-contact-bubble">';
                                $notificationBubble .= '<span class="bubbleCount">' . $notificationCount . '</span>';
                                $notificationBubble .= '</div>';
                            }
                        ?>
                        
                        <div class="widget-btns">
                            <a href="<?= base_url(); ?>account/messages" class="user-chat-url" data-count="<?= $notificationCount; ?>">
                                <i class="ion-chatbox-working"></i>
                                <?= $notificationBubble; ?>
                            </a>

                            <div class="notify-btn">
                                <a href="/account/messages">
                                    <i class="ion-ios-bell"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile">
                            <div class="profile-icon">
                                <img src="<?= $image_url; ?>" />
                            </div>

                            <p><?= $this->session->userdata('username'); ?></p>
                            <div class="drop-down">
                                <i class="fas fa-chevron-circle-down"></i>
                                <div class="dropdown-wrapper">
                                    <ul>
                                        <li>
                                            <a href="<?= base_url(); ?>my-account">
                                                <i class="far fa-user"></i>
                                                My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() . $profile_url; ?>">
                                                <i class="far fa-user"></i>
                                                My Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url(); ?>account/settings">
                                                <i class="fas fa-cogs"></i>
                                                Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url(); ?>home/logout">
                                                <i class="fas fa-sign-out-alt"></i>
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="dso-left-hamburger mobile-hamburger">
                        <a href="javascript:void(0);" class="dso-hamburger-menu mobile-menu">
                            <h3>Menu</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dso-mobile-menu">
                <a href="javascript:void(0);" class="close-menu-btn">
                    <i class="ti-close"></i>
                </a>
                <div class="dso-menu-top">
                    <ul>
                        <li><a href="<?= base_url(); ?>" class="<?= ($page_active == 'home') ? 'page-active' : ''; ?>">Home</a></li>
                        <li><a href="<?= base_url(); ?>community" class="<?= ($page_active == 'community') ? 'page-active' : ''; ?>">Community</a></li>
                        <li><a href="<?= base_url(); ?>tournaments" class="<?= ($page_active == 'tournaments') ? 'page-active' : ''; ?>">Tournaments</a></li>

                        <li><a href="<?= base_url(); ?>live" class="<?= ($page_active == 'live') ? 'page-active' : ''; ?>">Live Now</a></li>
                        <li><a href="<?= base_url(); ?>about-us" class="<?= ($page_active == 'about-us') ? 'page-active' : ''; ?>">About</a></li>
                        <li><a href="<?= base_url(); ?>support">Support</a></li>
                    </ul>
                </div>

                <div class="dso-widget-top">
                    <?php if($this->session->userdata('is_logged_in') != true) { ?>
                        <a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                            <span class="dso-btn-text">Register / Login</span>
                            <div class="dso-btn-bg-holder"></div>
                        </a>
                    <?php } else { ?>
                    <?php 
                        $userID    = $this->session->userdata('user_id');
                        $userimage = $this->db->get_where('user_meta', array(
                            'user_id'    => $this->session->userdata('user_id'),
                            'meta_title' => 'user_image' 
                        ));

                        if($userimage->num_rows() == 0) {
                            $image_url = base_url() . 'assets/frontend/images/default.png';
                        } else {
                            $image_url = base_url() . 'assets/uploads/users/user-' . $userID . '/' . $userimage->row()->meta_value;
                        }
                    ?>
                    
                    <div class="profile">
                        <div class="profile-icon">
                            <img src="<?= $image_url; ?>" />
                        </div>

                        <p><?= $this->session->userdata('username'); ?></p>
                        <div class="drop-down">
                            <i class="fas fa-chevron-circle-down"></i>
                            <div class="dropdown-wrapper">
                                <ul>
                                    <li>
                                        <a href="<?= base_url(); ?>my-account">
                                            <i class="far fa-user"></i>
                                            My Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() . $profile_url; ?>">
                                            <i class="far fa-user"></i>
                                            My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>account/settings">
                                            <i class="fas fa-cogs"></i>
                                            Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>home/logout">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
         </div>
    </header>