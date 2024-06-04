<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('verify_user');
        $this->load->model('process_data');
    }

    public function index() {
        $data = array(
            'title' => 'DsoEsports - The World Of eSports',
            'class' => 'home' 
        );

        $data['page_active'] = 'home';
        $data['categoriesData'] = $this->process_data->get_data('categories');
        $data['gamesData']      = $this->process_data->get_games();
        $data['meta']           = $this->process_data;

        $this->load->view('includes/header-new', $data);
        $this->load->view('home-new', $data);
        $this->load->view('includes/footer-new');
    }

    public function getEmojione() {
        $data['shortname']  = ':slight_smile:';
        

        echo $this->load->view('test', $data);
    }

    public function home_old() {
        $data = array(
            'title' => 'Dashboard',
            'class' => 'home' 
        );

        $data['categoriesData'] = $this->process_data->get_data('categories');
        $data['gamesData']      = $this->process_data->get_games();
        $data['meta']           = $this->process_data;

        $this->load->view('includes/header', $data);
        $this->load->view('home', $data);
        $this->load->view('includes/footer');
    }

    public function about_us() {
        $data = array(
            'title' => 'About Us',
            'class' => 'inner' 
        );

        $data['page_active'] = 'about-us';
        $data['activeMembers'] = count($this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online')));  
        $data['activeTournaments'] = count($this->process_data->get_data('tournament', array('status' => 1))); 
        $data['totalTeams'] = count($this->process_data->get_data('users', array('role' => 5))); 

        $sql_country = "SELECT DISTINCT country  FROM `users` group by country";
        $get_country = $this->db->query($sql_country)->result();
        $data['countriesTotal'] = count($get_country);

        $this->load->view('includes/header-new', $data);
        $this->load->view('about-us', $data);
        $this->load->view('includes/footer-new');
    }

    public function checkUsername() {
        $username = $this->input->post('username');
        $check    = $this->process_data->get_data('users', array('username' => $username));

        if(count($check) > 0) {
            $dataReturn = array(
                'status'  => 0,
                'message' => '<div class="message-inputs"><i class="fa fa-times-circle"></i> Username Already Exist</div>', 
            );
        } else {
            $dataReturn = array(
                'status'  => 1,
            );
        }

        echo json_encode($dataReturn);
    }

    public function register($method = null, $affiliateID = null) {
        $data = array(
            'title' => 'Signup',
            'class' => 'inner',
            'page_active' => 'register'
        );

        $data['email'] = '';
        $data['affiliateID'] = 0;

        $data['gamesData'] = $this->process_data->get_games();

        if($method != null) {
            $affiliateID = str_replace('KSRCVR', '', $affiliateID);
            $team = $this->process_data->get_data('team_members', array('id' => $affiliateID));
            $data['teamID'] = $team[0]->teamID;
            $data['email']  = $team[0]->email;
            $data['affiliateID'] = 1;
        }

        $this->load->view('includes/header-new', $data);
        $this->load->view('register', $data);
        $this->load->view('includes/footer-new');
    }

    public function processSignup() {
        $fname            = $this->input->post('fname');
        $lname            = $this->input->post('lname');
        $username         = $this->input->post('username');
        $email            = $this->input->post('email');
        $affiliateID      = $this->input->post('affiliateID');
        $platform         = $this->input->post('platform');
        $discord_username = $this->input->post('discord_username');
        $console_username = $this->input->post('console_username');
        $type             = 'individual';
        $country          = $this->input->post('country');
        $interested_game  = serialize($this->input->post('interested_game'));
        
        $role = 4;

        $dataCreate = array(
            'first_name'       => $fname,
            'last_name'        => $lname,
            'username'         => $username,
            'email'            => $email,
            'platform'         => $platform,
            'discord_username' => $discord_username,
            'console_username' => $console_username,
            'type'             => $type,
            'game_platform'    => 'N/A',
            'country'          => $country,
            'interested_game'  => $interested_game,
            'role'             => $role
        );

        $checkData = $this->process_data->get_data('users', array('email' => $email));

        if(count($checkData) == 0) {
            $userID = $this->process_data->create_data('users', $dataCreate);

            if($this->input->post('team_name') != null) {
                $this->process_data->update_user_meta('team_name', $this->input->post('team_name'), $userID);
                $this->process_data->update_user_meta('team_slug', $this->process_data->slugify(strtolower($this->input->post('team_name'))), $userID);
            }

            if($affiliateID == 1) {
                $teamID = $this->input->post('teamID');

                $dataUpdate = array(
                    'user_id' => $userID,
                    'request' => 1,
                    'status'  => 1
                );

                $this->process_data->create_data('team_members', $dataUpdate, array('email' => $email, 'teamID' => $teamID));
            }

            $status = true;
        } else {
            $status = false;
        }

        if($status == false) {
            $dataReturn = array(
                'status'  => 0,
                'message' => '<div class="message"><i class="fa fa-times-circle"></i> User Already Exist</div>', 
            );
        } else {
            $dataReturn = array(
                'status'  => 1,
                'message' => '<div class="message"><i class="fa fa-check-circle"></i> Success</div>', 
                'userID'  => $userID
            );
        }

        echo json_encode($dataReturn);
    }

    public function processPassword() {
        $password = $this->input->post('confirmPassword');
        $userID   = $this->input->post('userID');

        $this->db->where('id', $userID)->update('users', array('password' => md5($password)));

        $checkUser = $this->db->get_where('users', array(
            'id' => $userID
        ));

        $dataSession = array(
            'is_logged_in' => true,
            'user_id'      => $checkUser->row()->id,
            'name'         => $checkUser->row()->first_name . ' ' . $checkUser->row()->last_name,
            'username'     => $checkUser->row()->username,
            'user_role'    => $checkUser->row()->role
        );

        $this->session->set_userdata($dataSession);

        $data['message'] = '<div class="message-block"><i class="fa fa-check-circle"></i> <h4>Success</h4><p>Redirecting in few moments</p></div>';
        $data['url']     = base_url() . 'my-account';

        echo json_encode($data);
    }

    public function my_account() {
        if($this->session->userdata('is_logged_in') != true) {
            redirect('login');
        }

        $data = array(
            'title' => 'My Account',
            'class' => 'inner',
            'page_active' => 'my_account' 
        );

        $data['meta']     = $this->process_data;
        $data['userdata'] = $this->process_data->get_data('users', array('id' => $this->session->userdata('user_id'))); 
        $data['teamData'] = $this->process_data->get_data('team_profile', array('userID' => $this->session->userdata('user_id')));
        
        if($data['userdata'][0]->membership > 0) {
            $data['package'] = $this->process_data->get_data('packages', array('id' => $data['userdata'][0]->membership));
        } else {
            $data['package'] = '';
        }

        $teamProfileData = $this->process_data->get_data('team_profile', array('userID' => $this->session->userdata('user_id'))); 

        $data['teamProfileStatus'] = (count($teamProfileData) > 0) ? 1 : 0;

        $this->load->view('includes/header-new', $data);
        $this->load->view('my-account', $data);
        $this->load->view('includes/footer-new');
    }

    public function profile($user = null) {
        $data = array(
            'title' => 'My Profile',
            'class' => 'inner',
            'page_active' => 'profile' 
        );

        $data['user_profile'] = 0;
        $data['edit']         = 0;

        if($user == null) {
            $user_id = $this->session->userdata('user_id');
        } else {
            if($user == 'edit') {
                $user_id      = $this->session->userdata('user_id');
                $data['edit'] = 1;
            } else {
                $get_user = $this->process_data->get_data('users', array('username' => $user));     
                $user_id = $get_user[0]->id;
                $data['user_profile'] = 1;

                $viewsData = $this->process_data->get_user_meta('profile_views', $user_id);

                //Creating Profile Views
                $dataProfileView = array(
                    'profileID' => $user_id
                );

                //Check if user is logged in if not use ip address
                if($this->session->userdata('user_id') == true) {
                    $dataProfileView['userID'] = $this->session->userdata('user_id');

                    $getViewsCheck = $this->process_data->get_data('profile_views', array('profileID' => $user_id, 'userID' => $dataProfileView['userID']));

                    if(count($getViewsCheck) == 0) {
                       $viewsCount = empty($viewsData) ? 1 : $viewsData + 1; 
                       $this->process_data->create_data('profile_views', $dataProfileView);
                    }     
                } else {
                    $dataProfileView['ipAddr'] = $_SERVER['REMOTE_ADDR'];

                    $getViewsCheck = $this->process_data->get_data('profile_views', array('profileID' => $user_id, 'ipAddr' => $dataProfileView['ipAddr']));

                    if(count($getViewsCheck) == 0) {
                       $viewsCount = empty($viewsData) ? 1 : $viewsData + 1; 
                       $this->process_data->create_data('profile_views', $dataProfileView);
                    }
                }

                if(isset($viewsCount)) {
                    $this->process_data->update_user_meta('profile_views', $viewsCount, $user_id);
                }
            }
        }

        $getFollowersData = $this->process_data->get_data('user_meta', array(
            'user_id'    => $user_id, 
            'meta_title' => 'user_followers'
        ));

        $getFollowingData = $this->process_data->get_data('user_meta', array(
            'user_id'    => $user_id, 
            'meta_title' => 'user_following'
        ));

        $followersData = (count($getFollowersData) > 0) ? unserialize($getFollowersData[0]->meta_value) : '';
        $followingData = (count($getFollowingData) > 0) ? unserialize($getFollowingData[0]->meta_value) : '';

        $data['followers']     = $followersData;
        $data['following']     = $followingData;
        $data['profileViews']  = $this->process_data->get_user_meta('profile_views', $user_id);
        $data['assocTeam']     = $this->process_data->get_team_data($user_id);
        $data['profileData']   = $this->process_data->get_data('users', array('id' => $user_id));     
        $data['meta']          = $this->process_data;
        $data['videoData']     = $this->process_data->get_data('videos', array('user_id' => $user_id));
        $data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));    
        $data['recentJoined']  = $this->process_data->get_recently_joined();

        $this->load->view('includes/header-new', $data);
        $this->load->view('my-profile', $data);
        $this->load->view('includes/footer-new');
    }

    public function login() {
        $data = array(
            'title' => 'Login',
            'class' => 'inner',
            'page_active' => 'login'
        );

        $this->load->view('includes/header-new', $data);
        $this->load->view('login', $data);
        $this->load->view('includes/footer-new');
    }

    public function processLogin() {
        $email    = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));

        $status = $this->verify_user->login_user(array(
            'email'     => $email,
            'password'  => md5($password) 
        ));

        $url = base_url() . 'my-account';

        if($status == false) {
            $data_return = array(
                'status'  => 0,
                'message' => '<div class="message"><i class="fa fa-times-circle"></i> Invalid username / password provided</div>', 
            );
        } else {
            $data_return = array(
                'status'  => 1,
                'url'     => $url, 
                'message' => '<div class="message"><i class="fa fa-check-circle"></i> Success</div>', 
            );
        }

        echo json_encode($data_return);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("/");
    }

    public function reset_password() {
        $data = array(
            'title' => 'Recover Password',
            'class' => 'inner',
            'page_active' => 'forget_password'
        );

        $this->load->view('includes/header-new', $data);
        $this->load->view('forget-password', $data);
        $this->load->view('includes/footer-new');
    }

    public function forget() {
        $user_email = $this->input->post('email');
        $check_email = $this->db->get_where('users', array('email' => $user_email));

        if($check_email->num_rows() > 0) {
            $email = $this->db->get_where('email_notification', array('id' => 3));
            $subject = $email->row()->subject;

            $reset_link = 'KSRCVR' . $check_email->row()->id; 
            $reset_link = 'https://dsoesports.org/reset-password/'.$reset_link;

            $shortcodes    = array('{reset_link}');
            $dataChange    = array($reset_link);
            $email_message = str_replace($shortcodes, $dataChange, $email->row()->message);  
            $from          = "no-reply@dsoesports.org";
            $headers       = 'MIME-Version: 1.0' . "\r\n";
            $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers      .= "From:" . $from;

            mail($user_email,$subject,$email_message,$headers);   
            $message = '<div class="message"><i class="fa fa-check-circle"></i> Password reset email has been sent to your registered email.</div>';  
        } else {
            $message = '<div class="message"><i class="fa fa-times-circle"></i> Email does not exist in our database.</div>';
        }

        echo $message;
    }

    public function resetPassword($id = null) {
        $data['title'] = 'Reset Password';
        $data['class'] = 'inner';

        $user_id = str_replace('KSRCVR', '', $id);
        $data['user_Id'] = $user_id;
        $data['userCode'] = $id;

        if($this->input->post('updatePassword') == true) {
            $new_password     = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if($new_password == $confirm_password) {
                $this->db->where('id', $this->input->post('user_id'));
                $this->db->update('users', array('password' => md5($confirm_password)));
                $this->session->set_flashdata('success_msg', '<i class="fa fa-check-circle"></i> Your password has been successfully updated');
                $this->session->set_flashdata('success', 'true');
                redirect('reset-password');
            } else {
                $userCode = $this->input->post('userCode');
                $this->session->set_flashdata('success_msg', '<i class="fa fa-times-circle"></i> Your password does not matched');
                redirect('reset-password/'.$userCode);
            }
        } else {
            $this->load->view('includes/header', $data);
            $this->load->view('reset-password', $data);
            $this->load->view('includes/footer');   
        }
    }

    public function setPassword() {
        $new_password     = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if($new_password == $confirm_password) {
            $this->db->where('id', $this->input->post('user_id'));
            $this->db->update('users', array('password' => md5($confirm_password)));

            $data['message'] = '<div class="message"><i class="fa fa-check-circle"></i> Your password has been successfully updated</div>';
            $data['status']  = 1;
        } else {
            $data['message'] = '<div class="message"><i class="fa fa-times-circle"></i> Your password does not matched</div>';
            $data['status']  = 0;
        }

        echo json_encode($data);
    }

    public function videos($method = null, $id = null) {
        if($this->session->userdata('is_logged_in') == true) {
            $data = array(
                'title' => 'Login',
                'class' => 'inner'
            );

            $data_cond = array(
                'user_id' => $this->session->userdata('user_id')
            );

            if($id != null) {
                $data_cond['id'] = $id;
            }
            
            $dataVideo = $this->db->get_where('videos', $data_cond);
            
            if($method == 'create' && $id == null) {
                $data['id']         = '';
                $data['title']      = '';
                $data['video_url']  = '';
                $data['video_type'] = '';
                $data['user_id']    = '';
                
                $page = 'create-video';
            } elseif($method == 'create' && $id != null) {
                $data['id']         = $id;
                $data['title']      = $dataVideo->row()->title;
                $data['video_url']  = $dataVideo->row()->video_url;
                $data['video_type'] = $dataVideo->row()->video_type;
                $data['user_id']    = $this->session->userdata('user_id');
                
                $page = 'create-video';
            } elseif($method == 'delete' && $id != null) {
                if($dataVideo->row()->video_type == 'custom') {
                    $folderPath = getcwd() . '/assets/frontend/videos/users/user-' . $dataVideo->row()->user_id . '/'.$dataVideo->row()->video_url;
                    unlink($folderPath);
                }

                $this->db->where('id', $id)->delete('videos');
            } else {
                $data['videoData'] = $dataVideo->result();
                $page = 'videos';
            }

            $this->load->view('includes/header', $data);
            $this->load->view($page, $data);
            $this->load->view('includes/footer');
        } else {
            redirect('login');
        }
    }

    public function processVideo() {
        $id  = $this->input->post('id');
        $title      = $this->input->post('title');
        $video_type = $this->input->post('video_type');
        $video_url  = $this->input->post('video_url');
        $userID     = $this->session->userdata('user_id');

        if($video_type == 'custom') {
            $folderPath = getcwd() . '/assets/frontend/videos/users/user-' . $userID;

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true); 
            }           
            
            //About Us Image Upload
            $filename = $_FILES['video_file']['name'];
            $file_tmp = $_FILES['video_file']['tmp_name'];

            // move_uploaded_file($file_tmp, $folderPath . "/".$filename);
        }

        // $data = array(
        //  'title'      => $title,
        //  'video_url'  => $video_url,
        //  'video_type' => $video_type,
        //  'user_id'    => $userID
        // );

        // if($id == '') {
        //  $this->db->insert('videos', $data);
        // } else {
        //  $this->db->where('id', $id)->update('videos', $data);   
        // }

        // redirect('videos');
    }

    public function spectator($method = null, $id = null) {
        $data = array(
            'title' => 'Apply For Spectator',
            'class' => 'inner',
            'page_active' => 'spectator'
        );

        $data['id'] = $id;
        
        $page = 'spectator-aplication';

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function processSpectatorApplication($tournamentID = null) {
        $userID = $this->session->userdata('user_id');

        //Check Application
        $application = $this->db->get_where('tournament_spectators', array(
            'specID'        => $userID,
            'tournamentID'  => $tournamentID
        ));

        if($application->num_rows() == 0 ) {
            $dataUpload = array(
                'tournamentID' => $tournamentID,
                'specID' => $userID,
                'status' => 2
            );

            $this->db->insert('tournament_spectators', $dataUpload);
            
            $dataReturn = array(
                'status'  => 1,
                'message' => '<div class="message"><i class="fa fa-check-circle"></i> Thank you for applying we have received your application and will be notified once we review your application. You will be notified via email so keep an eye on it.</div>', 
            );
        } else {
            $dataReturn = array(
                'status'  => 0,
                'message' => '<div class="message"><i class="fa fa-times-circle"></i> You have allready applied if you are curently a spectator please contact us to get your account details </div>', 
            );
        }

        echo json_encode($dataReturn);
    }

    public function tournaments($category = null, $game = null, $slug = null, $method = null) {
        $data = array(
            'title' => 'Tournaments',
            'class' => 'inner',
        );

        $data['page_active'] = 'tournaments';

        date_default_timezone_set("America/Los_Angeles");
        $data['ci'] = $this->process_data; 
        
        if($slug != null) {
            $data_tournament = array(
                'tournament.slug' => $slug
            );

            $data['tournamentData'] = $this->process_data->get_tournaments_by_cond($data_tournament);
            $data['id']         = $data['tournamentData'][0]->id;
            $data['title']      = $data['tournamentData'][0]->title;
            $data['video_url']  = '';
            $data['video_type'] = '';
            $data['categorySlug'] = $category;
            $data['game']       = $game;
            $data['slug']       = $slug;

            if($method == null) {
                $data['stats_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $data['id'], 'meta_type' => 'stats_data'))->result();
                $data['joinStatus'] = $this->db->get_where('team_members', array('user_id' => $this->session->userdata('user_id')))->result();
                $data['participentCheck']  = $this->process_data->get_data('tournament_players', array(
                    'tournamentID'  => $data['id'],
                    'participantID' => $this->session->userdata('user_id') 
                ));  
                $data['participents'] = $this->process_data->get_participents($data['id']);  
                
                //Matches Data
                $data['tournamentMatches'] =  $this->process_data->get_data(
                    'tournament_matches', 
                    array(
                        'tournamentID'  => $data['id']
                    )
                );

                $data['totalRounds']  = $this->process_data->get_rounds($data['id']);
                $data['bracketsData'] = $this->process_data->get_bracket($data['id']); 

                if($data['tournamentData'][0]->type == 4) {
                    $data['loosersBracketsData'] = $this->process_data->get_looser_bracket($data['id']);
                }

                $query = "SELECT * FROM tournament_notice WHERE tournamentID = '".$data['id']."' ORDER BY id DESC";
                $data['announcmentsData'] = $this->db->query($query)->result();
                 
                $page = 'tournament-details';   
            } else {
                if($this->session->userdata('user_id') == true) {
                    $data['stats_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $data['id'], 'meta_type' => 'stats_data'))->result();
                    $data['user_data']  = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->result();
                    $page = 'join-tournament';  
                } else {
                    redirect('login');
                }
            }
        } else {
            $data['gamesData']  = $this->process_data->get_games();

            $tournamentCond['tournament.category_type'] = 'dso';

            $data['category_slug'] = '';
            $data['game_slug'] = '';

            if($category != null && $game == null) {
                $tournamentCond['categories.slug'] = $category;
                $data['category_slug'] = $category;

                $data['tournamentsData'] = $this->process_data->get_tournaments_by_cond($tournamentCond);                
            } elseif($game != null) {
                $tournamentCond['categories.slug'] = $category;
                $data['category_slug'] = $category;
                $tournamentCond['games.slug'] = $game;
                $data['game_slug'] = $game;

                $data['tournamentsData'] = $this->process_data->get_tournaments_by_cond($tournamentCond);
            } else {
                $data['tournamentsData'] = $this->process_data->get_tournaments($tournamentCond);
            }    

            if($data['tournamentsData'][0]->title == null) {
                $data['tournamentsData'] = array();
            } 
            
            if(count($data['tournamentsData']) == true) {
                $data['tournamentMatches'] = $this->process_data->get_matches($data['tournamentsData'][0]->id);    
            }
            
            if(count($data['tournamentsData']) > 0) {
                $data['participents'] = $this->process_data->get_participents($data['tournamentsData'][0]->id);
            } else {
                $data['participents'] = 0;
            }

            $page = 'tournaments';
        } 

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function getTournaments($category_type = null) {
        date_default_timezone_set("America/Los_Angeles");

        $category_slug = $this->input->post('category');
        $game_slug     = $this->input->post('game');

        if($category_slug != null) {
            $tournamentCond['categories.slug'] = $category_slug;
        }

        if($game_slug != null) {
            $tournamentCond['games.slug'] = $game_slug;
        }

        if($category_type == 'community') {
             $tournamentCond['tournament.category_type'] = $category_type;
        } else {
            $tournamentCond['tournament.category_type'] = 'dso';
        }

        if($category_slug != null) {
            $tournamentsData = $this->process_data->get_tournaments_by_cond($tournamentCond);
        } elseif($game_slug != null) {
            $tournamentsData = $this->process_data->get_tournaments_by_cond($tournamentCond);
        } else {
            $tournamentsData = $this->process_data->get_tournaments($tournamentCond);
        }
        
        $data['ci'] = $this->process_data;

        if(count($tournamentsData) > 0) {
            $data['participents'] = $this->process_data->get_participents($tournamentsData[0]->id);
        }

        $data['tournamentsData'] = $tournamentsData;

       /* $tournamentQuery = "SELECT `tournament`.*, `categories`.`title` AS `category`, `categories`.`slug` AS `category_slug`, `games`.`game_name`, `games`.`slug` AS `game_slug`, count(tournament_players.id) AS total_players FROM `tournament` LEFT JOIN `categories` ON `categories`.`id` = `tournament`.`category_id` LEFT JOIN `games` ON `games`.`game_id` = `tournament`.`game_id` LEFT JOIN `tournament_players` ON `tournament_players`.`tournamentID` = tournament.id";


        if(empty($tournamentCond)) {
            $tournamentQuery .= " WHERE ";
            $i = 0;
            foreach($tournamentCond as $key => $cond) {
                $tournamentQuery .= $key . " = '" . $cond . "'";    
                
                if(count($tournamentCond) < $i) {
                    if($i > 0) {
                        $tournamentQuery .= ' AND';
                    }
                }

                $i++;
            }
        }

        $tournamentQuery .= " GROUP BY tournament.id";


        echo $tournamentQuery;*/

        $this->load->view('tournament/getTournaments', $data);       
    }

    public function dso_members($slug = null, $member_username = null) {
        $data = array(
            'title' => 'DSO Members',
            'class' => 'inner',
            'page_active' => 'dso-members'
        );

        if($slug == null) {
            $data['membersData'] = $this->process_data->get_data('users');      
            $data['meta']        = $this->process_data;

            $data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));    
            $data['recentJoined']  = $this->process_data->get_recently_joined();

            $page = 'dso-members';
        } else {
            $data['user_profile'] = 0;
            $data['edit']         = 0;

            if($member_username == null) {
                $user_id = $this->session->userdata('user_id');
            } else {
                if($member_username == 'edit') {
                    $user_id      = $this->session->userdata('user_id');
                    $data['edit'] = 1;
                } else {
                    $get_user = $this->process_data->get_data('users', array('username' => $member_username));     
                    $user_id = $get_user[0]->id;
                    $data['user_profile'] = 1;
                }
            }

            $data['assocTeam']   = $this->process_data->get_team_data($user_id);
            $data['profileData'] = $this->process_data->get_data('users', array('id' => $user_id));     
            $data['meta']        = $this->process_data;
            $data['videoData']   = $this->process_data->get_data('videos', array('user_id' => $user_id));
            $data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));    
            $data['recentJoined']  = $this->process_data->get_recently_joined();

            $page = 'dso-member-profile';
        }

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function pricing($method = null, $slug = null) {
        $data = array(
            'title' => 'Pricing Plan',
            'class' => 'inner'
        );

        $data['userData'] = $this->process_data->get_data('users', array('id' => $this->session->userdata('user_id')));

        if($method != null) {
            $data_tournament = array(
                'tournament.slug' => $slug
            );

            $data['tournamentData'] = $this->process_data->get_tournaments_by_cond($data_tournament);
            $data['id']         = $data['tournamentData'][0]->id;
            $data['title']      = '';
            $data['video_url']  = '';
            $data['video_type'] = '';
            $data['game']       = $game;
            $data['slug']       = $slug;
            
            if($method == null) {
                $page = 'tournament-details';   
            } else {
                $page = 'join-tournament';  
            }
        } else {
                
            $page = 'pricing-plan';
        } 

        $this->load->view('includes/header', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer');
    }

    public function careers($slug = null) {
        $data = array(
            'title' => 'Careers',
            'class' => 'inner',
            'page_active' => 'carers'
        );

        $data['type'] = 'careers';
        $data['ci']   = $this->process_data;

        if($slug != null) {
            $data['jobsData']   = $this->process_data->get_data('jobs', array('slug' => $slug));
            $data['jobsMeta']   = $this->process_data->get_data('job_meta', array('jobID' => $data['jobsData'][0]->id));
            
            $page = 'job-details';   
        } else {  
            $data['jobsData']   = $this->process_data->get_data('jobs');              
            $page = 'careers';
        } 

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function jobs($slug = null) {
        $data = array(
            'title' => 'Team Recruitment',
            'class' => 'inner'
        );

        $data['type'] = 'team-recruitment';

        if($slug != null) {
            $data['jobsData']   = $this->process_data->get_data('jobs', array('slug' => $slug, 'type' => 'team-recruitment'));
            
            $page = 'job-details';   
        } else {  
            $data['jobsData']   = $this->process_data->get_data('jobs', array('type' => 'team-recruitment'));              
            $page = 'careers';
        } 

        $this->load->view('includes/header', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer');
    }

    public function support($method = null, $article = null) {
        $data = array(
            'title' => 'Support Center',
            'class' => 'inner' 
        );

        $data['page_active'] = 'support';

        if($method == null && $article == null) {
            $data['categoriesData'] = $this->process_data->get_data('article_categories');
            
            $page = 'support-main';
        }

        if($method != null && $article == null) {
            if($method == 'search') {
                $query = $this->input->post('query');
                $data['userSearch'] = $query;
                $sql   = "SELECT support_articles.*, article_categories.slug AS category_slug FROM support_articles LEFT JOIN article_categories ON support_articles.category_id = article_categories.id WHERE support_articles.title LIKE '%".$query."%'";
                $dataResponse = $this->db->query($sql)->result();
                $data['articlesData'] = $dataResponse;

                $page = 'support-search-result';
            } else {
                $categoriesData       = $this->process_data->get_data('article_categories', array('slug' => $method));
                $data['ct_slug']      = $categoriesData[0]->slug;
                $data['ct_name']      = $categoriesData[0]->title;
                $data['ct_desc']      = $categoriesData[0]->description;
                $data['articlesData'] = $this->process_data->get_data('support_articles', array('category_id' => $categoriesData[0]->id));
                
                $page = 'support-questions';
            }            
        }

        if($article != null) {
            if($method == 'requests' && $article == 'new') {
                $page = 'contact-support';
            } else {
                $categoriesData       = $this->process_data->get_data('article_categories', array('slug' => $method));
                $data['ct_slug']      = $categoriesData[0]->slug;
                $data['ct_name']      = $categoriesData[0]->title;
                $data['ct_desc']      = $categoriesData[0]->description;
                $data['articlesData'] = $this->process_data->get_data('support_articles', array('slug' => $article));
                $data['allArticles']  = $this->process_data->get_data('support_articles', array('category_id' => $categoriesData[0]->id));
                
                $page = 'support-details';
            }
        }


        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function team($slug = null, $method = null, $id = null, $request = null) {
        $data = array(
            'title' => 'Team Profile',
            'class' => 'inner' 
        );

        $data['page_active'] = 'teams';

        if($slug == null) {
            $data['teamsData'] = $this->process_data->get_data('team_profile'); 
            $data['meta']      = $this->process_data;
            $page = 'teams';
        } else {
            if($slug == 'profile' && $method == 'create') {
                $data['title']          = 'Create Team Profile';
                $data['meta']           = $this->process_data;
                $data['getPlayers']     = $this->process_data->get_data('users');
                $data['getTeamMembers'] = $this->process_data->get_data('team_members');  

                $page = 'create-team-profile';
            } else {
                $data['joinRequest'] = false;

                if($slug == 'profile') {
                    $data['edit'] = true;
                    $userID   = $this->session->userdata('user_id');  
                    $teamData = $this->process_data->get_data('team_profile', array('userID' => $userID));            
                } else {
                    $data['edit'] = false;
                    $teamData = $this->process_data->get_data('team_profile', array('slug' => $slug));        
                    $userID   = $teamData[0]->userID;
                }

                $teamID = $teamData[0]->ID;
                $meta   = $this->process_data;

                $data['profileData'] = $this->process_data->get_data('users', array('id' => $userID));      
                $data['meta']        = $meta;
                $data['method']      = $method;

                $data['teamName']        = $teamData[0]->team_name;
                $data['team_name_show']  = $meta->get_team_meta('team_name_show', $teamID);
                $data['team_logo_show']  = $meta->get_team_meta('team_logo_show', $teamID);
                $data['get_description'] = $meta->get_team_meta('description', $teamID);
                $data['wonTournament']   = count($this->process_data->get_data('tournament_matches', array('winnerID' => $teamID, 'playerType' => 1)));            
                
                $get_image = $meta->get_team_meta('team_logo', $teamID);
                $get_cover = $meta->get_team_meta('team_cover_picture', $teamID);
                        
                if($get_cover == null) {
                    $cover_url = '';
                } else {
                    $cover_url = "background: url('". base_url() . "assets/uploads/teams/" . $get_cover . "');";
                }

                $data['team_members']     = $this->process_data->get_team_memebers_request($teamID);
                $data['team_membersData'] = $this->process_data->get_team_memebers($teamID);

                $data['post_topics']  = $this->process_data->get_data('discussion', array('teamID' => $teamID)); 
                $data['cover_photo']  = $cover_url;
                $data['get_image']    = $get_image;
                $data['teamID']       = $teamID;

                $data['ci'] = $this->process_data;

                if($method == 'processRrequest') {
                    $memberID = $id;
                    $status   = ($request == 'accept') ? 1 : 2; 

                    $dataUpdate = array('status' => $status);

                    $this->process_data->create_data('team_members', $dataUpdate, array(
                            'user_id' => $memberID,
                            'teamID'  => $userID
                        ));

                    //Creating Notification
                    $current_status = ($request == 'accept') ? 'Accepted' : 'Declined'; 
                    $username    = $this->process_data->get_username($memberID);
                    $description = $username . ' ' . $current_status . " to join your team.";

                    $date_time = date('Y-m-d H:i:s');

                    $data_notify = array(
                        'userID'      => $userID,
                        'submitBy'    => $memberID,
                        'description' => $description,
                        'time_posted' => $date_time,
                        'url'         => 'N/A',
                        'type'        => 'team_join_request',
                        'status'      => 1
                    );

                    $this->process_data->create_data('notification', $data_notify);

                    redirect('team/' . $slug);
                }

                if($method == 'join') {
                    //Check if already accepted
                    $data['requestData'] = $this->process_data->get_data('team_members', array('teamID' => $teamData[0]->ID, 'user_id' => $id));
                    
                    if($data['requestData'][0]->status == 0) {
                        $data['joinRequest'] = true;
                        $data['userIDJoin']  = $id;
                        $data['slug']        = $slug;
                    } else {
                        redirect('team/' . $slug);
                    }
                }

                if($method == 'cancel-request') {
                    //Creating Notification
                    $description  = $data['teamName'] . " Cancelled Your Request to join their team.";

                    $date_time = date('Y-m-d H:i:s');

                    $data_notify = array(
                        'userID'      => $id,
                        'submitBy'    => $teamID,
                        'description' => $description,
                        'time_posted' => $date_time,
                        'url'         => '',
                        'type'        => 'team_join_request',
                        'status'      => 0
                    );

                    $this->process_data->create_data('notification', $data_notify);
                    $this->db->where(array('teamID' => $teamID, 'user_id' => $id))->delete('team_members');

                    redirect('team/profile');
                }

                if($method == 'remove-member') {
                    //Creating Notification
                    $description  = $data['teamName'] . " Removed you from their team.";

                    $date_time = date('Y-m-d H:i:s');

                    $data_notify = array(
                        'userID'      => $id,
                        'submitBy'    => $teamID,
                        'description' => $description,
                        'time_posted' => $date_time,
                        'url'         => '',
                        'type'        => 'team_join_request',
                        'status'      => 0
                    );

                    $this->process_data->create_data('notification', $data_notify);
                    $this->db->where(array('teamID' => $teamID, 'user_id' => $id))->delete('team_members');

                    redirect('team/profile');
                }

                $page = 'team-details';
            }
        }

        $data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));    
        $data['recentJoined']  = $this->process_data->get_recently_joined();

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function community() {
        $data = array(
            'title' => 'Community',
            'class' => 'inner' 
        );

        $data['page_active'] = 'community';

        $this->load->view('includes/header-new', $data);
        $this->load->view('coming-soon', $data);
        $this->load->view('includes/footer-new');
    }

    public function live() {
        $data = array(
            'title' => 'Live Now',
            'class' => 'inner' 
        );

        $data['page_active'] = 'live';

        $this->load->view('includes/header-new', $data);
        $this->load->view('coming-soon', $data);
        $this->load->view('includes/footer-new');
    }

    public function checkout() {
        $data = array(
            'title' => 'Checkout',
            'class' => 'inner' 
        );

        $data['package_name']  = $this->input->post('pkg_name');
        $data['package_price'] = $this->input->post('pkg_price');
        $data['pkg_code']      = $this->input->post('pkg_code');

        $this->load->view('includes/header', $data);
        $this->load->view('checkout', $data);
        $this->load->view('includes/footer');
    }

    public function checkout_process() { 
        $fname   = $this->input->post('fname');
        $lname   = $this->input->post('lname');
        $email   = $this->input->post('email');
        $phone   = $this->input->post('phone');
        $pkg_id  = $this->input->post('pkg_id');
        $user_id = $this->session->userdata('user_id');

        $data_donation = array(
            'user_id'      => $user_id,
            'first_name'   => $fname,
            'last_name'    => $lname,
            'email'        => $email,
            'phone'        => $phone,
            'pkg_id'       => $pkg_id,
            'trans_status' => 'Pending',
            'date_trans'   => date('Y-m-d')
        );

        $trans_id = $this->process_data->create_data('transaction', $data_donation);        

        $item_number = 'DSOE-'.$trans_id;
        echo json_encode(array(
            'return_url' => 'https://www.dsoesports.org/thankyou/success/'.$trans_id,
            'cancel_url'  => 'https://www.dsoesports.org/thankyou/cancel/'.$trans_id,
            'item_number' => $item_number,
        ));
    }

    public function thankyou($request = null, $id = null) {
        $trans_id    = $this->input->get('PayerID');
        $campaign_id = $id; 
        
        if($request == 'success') {
            $data = array(
                'title' => 'Checkout',
                'class' => 'inner' 
            );

            $data_update = array(
                'txn_id'       => $trans_id,
                'trans_status' => 'Confirmed'
            );

            $this->process_data->create_data('transaction', $data_update, array('id' => $id));

            $get_data = $this->process_data->get_data('transaction', array('id' => $id));
            $pkg      = $this->process_data->get_data('packages', array('id' => $get_data[0]->pkg_id));

            $data_memeber = array(
                'credit'     => $pkg[0]->credits_limit,
                'membership' => $pkg[0]->id,
                'start_date' => date('Y-m-d'),
                'end_date'   => date('Y-m-d', strtotime('+'.$pkg[0]->time_duration.' months')),
            );

            $this->process_data->create_data('users', $data_memeber, array('id' => $this->session->userdata('user_id')));

            $this->load->view('includes/header', $data);
            $this->load->view('thankyou', $data);
            $this->load->view('includes/footer');
        } else {
            redirect('my-account');
        }
    }

    public function our_players() {
        $data = array(
            'title' => 'DSO Players',
            'class' => 'inner',
            'page_active' => 'players'
        );

        $limit = 10;
        $offset = 0;

        $data['profileData'] = $this->db->limit($limit, $offset)->get_where('users', array('role' => 4))->result();      
        $data['meta']        = $this->process_data;

        $data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));    
        $data['recentJoined']  = $this->process_data->get_recently_joined();

        $this->load->view('includes/header-new', $data);
        $this->load->view('players', $data);
        $this->load->view('includes/footer-new');
    }

    public function getMorePlayers() {
        $limit  = 10;
        $offset = $this->input->post('offset');

        $userProfiles = $this->db->limit($limit, $offset)->get_where('users', array('role' => 4))->result();

        $playersData = '';

        foreach($userProfiles as $profile):
            if($this->session->userdata('user_id') != $profile->id) {
                $playersData .= '<div class="player-box">';
                    $playersData .= '<div class="player-tumb">';
                    $get_image = $this->process_data->get_user_meta('user_image', $profile->id);

                    if($get_image == null) {
                        $image_url = base_url() . 'assets/uploads/users/default.jpg';
                    } else {
                        $image_url = base_url() . 'assets/uploads/users/user-' . $profile->id . '/' . $get_image;
                    }

                    $playersData .= '<img src="' . $image_url . '">';
                    $playersData .= '</div>';

                    $playersData .= '<div class="player-content">';
                    $playersData .= '<h3>' . $profile->username . '</h3>';
                    $playersData .= '<p>';
                    $playersData .= '<i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>';
                    $playersData .= '0 Tournaments Won';
                    $playersData .= '</p>';
                    $playersData .= '<a href="' . base_url() . 'profile/'.$profile->username . '" class="channel-btn-red">VIEW CHANNEL</a>';
                    $playersData .= '</div>';
                $playersData .= '</div>';
            }
        endforeach;

        echo $playersData;
    }

    public function valorant_recruitment() {
        $data = array(
            'title' => 'Valorant Recruitment',
            'class' => 'inner' 
        );

        $data['page_active'] = 'valorant-recruitment';

        $this->load->view('includes/header-new', $data);
        $this->load->view('valorant-recruitment', $data);
        $this->load->view('includes/footer-new');
    }

    public function team_recruitment($slug = null) {
        $data = array(
            'title' => 'Team Recruitment',
            'class' => 'inner' 
        );

        $data['page_active'] = 'team-recruitment';

        $data['ci' ] = $this->process_data;

        if($slug == null) {
            $data['teamsData'] = $this->process_data->get_data('teams', array('status' => 1));
            $page = 'team-recruitment-main';
        } else {
            $data['teamData'] = $this->process_data->get_data('teams', array('slug' => $slug));
            $data['fieldsData'] = $this->process_data->get_data('team_application_fields', array('teamID' => $data['teamData'][0]->ID));
            
            $page = 'team-recruitment';
        }

        $this->load->view('includes/header-new', $data);
        $this->load->view($page, $data);
        $this->load->view('includes/footer-new');
    }

    public function processApplication() {
        $teamID = $this->input->post('team');
        $fieldsData = $this->process_data->get_data('team_application_fields', array('teamID' => $teamID));
        $appID = $this->process_data->create_data('team_application', array(
            'teamID' => $teamID,
            'date_created' => date('Y-m-d H:i:s')
        ));

        foreach($fieldsData as $fields):
            $dataCreate = array(
                'appID'    => $appID,
                'meta_key' => $fields->field_name,
            );

            $meta_value = $this->input->post($fields->field_name);

            if($fields->field_type == 'checkbox') {
                $meta_value = serialize($this->input->post($fields->field_name));
            }

            if($fields->field_type == 'file') {
                $upload_path = getcwd() . '/assets/uploads/teams-recruitment/team-' . $teamID; 

                $file     = $_FILES[$fields->field_name]['name'];
                $location = $upload_path . '/' . $file;

                $return_arr = array();

                /* Upload file */
                if(!empty($file)) {
                    if(move_uploaded_file($_FILES[$fields->field_name]['tmp_name'],$location)){
                        $meta_value = $file;
                    }
                } 
            }

            $dataCreate['meta_value'] = $meta_value;

            $this->process_data->create_data('team_application_field_values', $dataCreate);            
        endforeach;
        
        $dataReturn = '<div class="message"><i class="fa fa-check-circle"></i> We have successfully received your application and wil be contacted soon</div>';

        echo $dataReturn;
    }

    public function applyJob() {
        $fname    = $this->input->post('first_name');
        $lname    = $this->input->post('last_name');
        $username = $this->input->post('discord_username');
        $email    = $this->input->post('email');
        $phone    = $this->input->post('phone');
        $type     = $this->input->post('type');

        $job_id   = $this->input->post('job_id');
        $data_job = $this->process_data->get_data('jobs', array('id' => $job_id));

        $previous_work = '';
        $dataCreate = array(
            'first_name'    => $fname,
            'last_name'     => $lname,
            'username'      => $username,
            'email'         => $email,
            'phone'         => $phone,
            'job_title'  => $data_job[0]->title,
            'previous_work' => $previous_work,
            'job_id'    => $job_id
        );
        
        $dataCreate['drivers_liscence'] = '';
        $dataCreate['birth_certficate'] = '';

        if($type == 'careers') {
            $previous_work   = $this->input->post('previous_work');
            
            $config['upload_path'] = getcwd() . '/assets/uploads/job-applications/';         

            $file     = $_FILES['drivers_liscence']['name'];
            $location = $config['upload_path'].$file;

            $return_arr = array();

            /* Upload file */
            if(!empty($file)) {
                if(move_uploaded_file($_FILES['drivers_liscence']['tmp_name'],$location)){
                    $dataCreate['drivers_liscence'] = $file;
                }
            } else {
                $dataCreate['drivers_liscence'] = '';
            }

            $birth_certficate     = $_FILES['birth_certficate']['name'];
            $location = $config['upload_path'].$birth_certficate;

            if(!empty($birth_certficate)) {
                if(move_uploaded_file($_FILES['birth_certficate']['tmp_name'],$location)){
                    $dataCreate['birth_certficate'] = $file;
                }
            } else {
                $dataCreate['birth_certficate'] = '';
            }
        } else {
            $dataCreate['ps5'] = $this->input->post('ps5');
            $dataCreate['xbox'] = $this->input->post('xbox');
            $dataCreate['battlenet'] = $this->input->post('battlenet');
            $dataCreate['steam_profile'] = $this->input->post('steam_profile');
            $dataCreate['age'] = $this->input->post('age');
            $dataCreate['why_join'] = $this->input->post('why_join');
        }

        $this->process_data->create_data('job_application', $dataCreate);

        $email_message = $this->process_data->notificationJobApplication($dataCreate);
        $from          = "no-reply@dsoesports.org";
        $headers       = 'MIME-Version: 1.0' . "\r\n";
        $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers      .= "From:" . $from;

        mail('danker-games@dsoesports.org','Job Application Received',$email_message,$headers); 
        mail('joshuadouglashenshaw@gmail.com','Job Application Received',$email_message,$headers);

        //$this->process_data->create_data('valorant_applciation', $dataCreate);
        if($type == 'careers') {
            $dataReturn = '<div class="message"><i class="fa fa-check-circle"></i> We have successfully received your application and wil be contacted soon</div>';
        } else {
            $dataReturn = '<div class="message"><i class="fa fa-check-circle"></i> We have successfully received your application please join our hiscor community in order to get your application reviewed. <a href="https://discord.gg/QjvZRSEKzV" target="_blank"><strong>Join Our Discord</strong></a></div>';
        }

        echo $dataReturn;
    }

    public function submitSupportRequest() {
        $fname    = $this->input->post('first_name');
        $lname    = $this->input->post('last_name');
        $email    = $this->input->post('email');
        $question = $this->input->post('question');
        
        $dataCreate = array(
            'first_name' => $fname,
            'last_name'  => $lname,            
            'email'      => $email,
            'question'   => $question
        );

        $email_message = $this->process_data->notificationContactSupport($dataCreate);
        $from          = "no-reply@dsoesports.org";
        $headers       = 'MIME-Version: 1.0' . "\r\n";
        $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers      .= "From:" . $from;

        mail('support@dsoesports.org','New Support Received',$email_message,$headers); 
        
        $dataReturn['redirect_url'] = base_url() . 'support';
        $dataReturn['message'] = '<div class="message"><i class="fa fa-check-circle"></i> We have successfully received your query and soon wil be in contact with you</div>';

        echo json_encode($dataReturn);
    }

    public function loadGames() {
        $offset = $this->input->post('offset');
        $limit  = 6;

        $countGames = $this->process_data->get_data('games');

        if(count($countGames) == $offset) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
            $gamesData  = $this->process_data->get_games_offset($offset, $limit);
            $html = '';
            foreach($gamesData as $game):
                $html .= '<li>';
                $html .= '<a href="' . base_url() . 'tournaments/' . $game->slug . '">';
                $html .= '<img src="' . base_url() . 'assets/frontend/images/games/' . $game->game_image .'">';
                $html .= '</a>';
                $html .= '</li>';
            endforeach; 

            $data['data_games'] = $html;
            $data['offset']     = $offset + count($gamesData);

            if($data['offset'] == count($countGames)) {
                $data['nextPage'] = false;
            } else {
                $data['nextPage'] = true;
            }
        }

        echo json_encode($data);
    }

    public function searchUser() {
        $search   = $this->input->post('search');
        $getData  = $this->db->query("SELECT * FROM users WHERE username LIKE '%".$search."%' ")->result();
        $response = array();

        foreach($getData as $data) {
            if($data->role == 4 || $data->role == 5) {
                $name = $data->username;
             
                if($data->role == 4) {
                    $url = 'profile/' . $data->username;
                } else {
                    $get_slug = $this->process_data->get_user_meta('team_slug', $data->id);
                    $url = 'team/' . $get_slug;
                }

                $response[] = array("value" => $data->username, "label" => $name, 'urlSet' => $url);
            }
        }

        echo json_encode($response);
    }

    public function searchData() {
        $type     = $this->input->post('type');
        $search   = $this->input->post('search');

        if($type == 'players') {
            $search_query = "SELECT * FROM users WHERE (username LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' OR first_name LIKE '%" . $search . "%' OR last_name LIKE '%" . $search . "%')";
            $searchData  = $this->db->query($search_query)->result();

            $search_results = '';   
            
            $image_url  = base_url() . 'assets/uploads/users/default.jpg';
            $userID     = 0;

            if($this->session->userdata('user_id') == true) {
                $userID = $this->session->userdata('user_id');
            }

            if(count($searchData) > 0) {
                foreach($searchData as $user):
                    if($user->id != $userID) {
                        $get_image = $this->process_data->get_user_meta('user_image', $user->id);
                                        
                        if($get_image == null) {
                            $image_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $image_url = base_url() . 'assets/uploads/users/user-' . $user->id . '/' . $get_image;
                        }

                        $search_results .= '<div class="user-data">';
                            $search_results .= '<div class="user-thumb">';
                            $search_results .= '<img src="' . $image_url . '" />';
                            $search_results .= '</div>';

                            $search_results .= '<div class="inner-player-data">';
                                $search_results .= '<h2>' . $user->email . '</h2>';
                                $search_results .= '<span>@' . $user->username . '</span>';

                                $search_results .= '<div class="add-player-btn-row">';
                                $search_results .= '<a href="' . base_url() . 'profile/' . $user->username . '" class="btn btn-curved btn-small">View Profile</a>';
                                $search_results .= '</div>';
                            $search_results .= '</div>';
                        $search_results .= '</div>';
                    }
                endforeach;
            } else {    
                $search_results .= '<div class="user-data">';
                $search_results .= '<span>No Players Found</span>';
                $search_results .= '</div>';
            }
        }

        if($type == 'teams') {
            $search_query = "SELECT * FROM team_profile WHERE team_name LIKE '%" . $search . "%'";
            $searchData   = $this->db->query($search_query)->result();

            $search_results = '';   

            if(count($searchData) > 0) {
                foreach($searchData as $team):
                    $get_image = $this->process_data->get_team_meta('team_logo', $team->ID);
                                        
                    if($get_image == null) {
                        $image_url = base_url() . 'assets/frontend/images/team-logo.png';
                    } else {
                        $image_url = base_url() . 'assets/uploads/teams/' . $get_image;
                    }

                    $search_results .= '<div class="user-data">';
                        $search_results .= '<div class="user-thumb">';
                        $search_results .= '<img src="' . $image_url . '" />';
                        $search_results .= '</div>';

                        $search_results .= '<div class="inner-player-data">';
                            $search_results .= '<h2>' . $team->team_name . '</h2>';

                            $search_results .= '<div class="add-player-btn-row">';
                            $search_results .= '<a href="' . base_url() . 'team/' . $team->slug . '" class="btn btn-curved btn-small">View Channel</a>';
                            $search_results .= '</div>';
                        $search_results .= '</div>';
                    $search_results .= '</div>';
                endforeach;
            } else {    
                $search_results .= '<div class="user-data">';
                $search_results .= '<span>No Teams Found</span>';
                $search_results .= '</div>';
            }
        }

        if($type == 'tournaments') {
            $search_query = "SELECT tournament.*, categories.title AS category, categories.slug AS category_slug, games.game_name, games.slug AS game_slug FROM tournament LEFT JOIN categories ON categories.id = tournament.category_id LEFT JOIN games ON games.game_id = tournament.game_id WHERE (tournament.title LIKE '%" . $search . "%' OR categories.title LIKE '%" . $search . "%' OR games.game_name LIKE '%" . $search . "%') GROUP BY tournament.id";
            $searchData   = $this->db->query($search_query)->result();

            $search_results = '';   

            if(count($searchData) > 0) {
                foreach($searchData as $tournament):
                    if(empty($tournament->image)) {
                        $image_url = base_url() . 'assets/frontend/images/tournaments/no-image.jpg';
                    } else {
                        $image_url = base_url() . 'assets/frontend/images/tournaments/' . $tournament->image;
                    }

                    if($tournament->mode == 1) {
                        $status = 'Online';
                    } else {
                        $status = 'Offline';
                    }

                    $search_results .= '<div class="user-data">';
                        $search_results .= '<div class="status-box '.strtolower($status).'">';
                        $search_results .= '<span clss="status-marker">'.$status.'</span>';
                        $search_results .= '</div>';

                        $search_results .= '<div class="user-thumb">';
                        $search_results .= '<img src="' . $image_url . '" />';
                        $search_results .= '</div>';

                        $search_results .= '<div class="inner-player-data">';
                            $search_results .= '<h2>' . $tournament->title . '</h2>';

                            $search_results .= '<div class="add-player-btn-row">';
                            $search_results .= '<a href="' . base_url() . 'tournaments/' . $tournament->category_slug . '/' . $tournament->game_slug . '/' . $tournament->slug . '" class="btn btn-curved btn-small">View Tournament</a>';
                            $search_results .= '</div>';
                        $search_results .= '</div>';
                    $search_results .= '</div>';
                endforeach;
            } else {    
                $search_results .= '<div class="user-data">';
                $search_results .= '<span>No Tournaments Found</span>';
                $search_results .= '</div>';
            }
        } 

        echo $search_results;
    }

    public function getMatches($tournamentID, $round) {
        $data = $this->process_data->get_matches_data($tournamentID, $round);

        echo $data;
    }

    public function create_match_test() {
        $tournamentID = 71;
        $matchID = 422;
        $winnerID = 112;
        $getTournamentQuery = "SELECT tournament.* FROM tournament LEFT JOIN tournament_matches ON tournament_matches.tournamentID = tournament.id WHERE tournament_matches.id = '" . $matchID . "'";
        $tournamentData     = $this->db->query($getTournamentQuery)->result();
        $getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));

        $totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount = count($totalPlayers);

        $totalRounds =  strlen(decbin($playersCount - 1));

        $round    = $getMatchDetails[0]->round;
        $newRound = $round + 1;

        /*
         * Create Round For Winning Player
         */

        //Check if any free slot is available in same round if it is then match current player with free slot player
        $freeSlotMatchQuery  = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND round = '" . $round . "'";
        $freeSlotMatchQuery .= " AND (player_1_ID = 0 OR player_2_ID = 0)";

        if($tournamentData[0]->type == 4 && $getMatchDetails[0]->seed == 1) {
            $freeSlotMatchQuery .= " AND seed = 1";
        } else {
            $freeSlotMatchQuery .= " AND seed = 0";
        }

        $getFreeSlotMatch = $this->db->query($freeSlotMatchQuery)->result();

        if($round < $totalRounds) {
            if(count($getFreeSlotMatch) > 0) {
                if($getFreeSlotMatch[0]->player_1_ID == 0) {
                    $assignPlayer['player_1_ID'] = $winnerID;
                    $playerSlot = 1;
                } else {
                    $assignPlayer['player_2_ID'] = $winnerID;
                    $playerSlot = 2;
                }

                $this->process_data->create_data('tournament_matches', $assignPlayer, array('id' => $getFreeSlotMatch[0]->id));

                $this->process_data->create_match_chat_group($tournamentID, $getFreeSlotMatch[0]->id, $winnerID);
            } else {
                if($round < $totalRounds) {
                    $getMatchDataCond = array(
                        'tournamentID' => $tournamentID,
                        'round'   => $newRound
                    );

                    //Check if current match is for winner bracket or looser bracket
                    //Winner Bracket Seed 0
                    //Looser Bracket Seed 1

                    if($getMatchDetails[0]->seed == 1) {
                        $getMatchDataCond['seed'] = 1;
                    } else {
                        $getMatchDataCond['seed'] = 0;
                    }

                    if($newRound == $totalRounds) {
                        $getMatchData = $this->process_data->get_data('tournament_matches', $getMatchDataCond);
                    } else {
                        $getMatchDataCond['player_2_ID'] = 0;
                        $getMatchData = $this->process_data->get_data('tournament_matches', $getMatchDataCond);
                    }

                    if(count($getMatchData) > 0) {
                        $dataInsert = array(
                            'player_2_ID'  => $winnerID
                        );

                        $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $getMatchData[0]->id));

                        $this->process_data->create_match_chat_group($tournamentID, $getMatchData[0]->id, $winnerID, 2);
                    } else {
                        //Creating match 
                        $dataInsert = array(
                            'tournamentID' => $tournamentID,
                            'groupID'      => $getMatchDetails[0]->groupID,
                            'player_1_ID'  => $winnerID,
                            'player_2_ID'  => 0,
                            'round'        => $newRound,
                            'winnerID'     => 0,
                            'status'       => 1
                        );

                        if($getMatchDetails[0]->seed == 1) {
                            $dataInsert['seed'] = 1;
                        }

                        echo "I am here";

                        // $newMatchID = $this->process_data->create_data('tournament_matches', $dataInsert);

                        // $this->process_data->create_match_chat_group($tournamentID, $newMatchID, $winnerID);
                    }
                }               
            }
        }
    }

    public function test() {
        // echo "<pre>";
        // print_r($_SERVER);
        // echo "</pre>";

        // $email_message = $this->process_data->notificationEmailSpectator();
        // $from          = "no-reply@dsoesports.org";
        // $headers       = 'MIME-Version: 1.0' . "\r\n";
        // $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // $headers      .= "From:" . $from;

        // mail('bluevisionary3@gmail.com','test',$email_message,$headers);  

        //Check participents for matches
        /*$tournamentID = 30;
        $getPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));

        if(count($getPlayers) == 8) {
            echo 'Tournament Started <br />';
            $totalRounds = count($getPlayers) / 2;

            echo 'Total Rounds : ' . $totalRounds . '<br />';

            foreach($getPlayers as $players):
                //Check if player exist
                $checkPlayer = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));

                if(count($checkPlayer) == 0) {
                    //Creating match 
                    $dataInsert = array(
                        'tournamentID' => $tournamentID,
                        'player_1_ID'  => $players->participantID,
                        'player_2_ID'  => 0,
                        'round'        => 1,
                        'winnerID'     => 0,
                        'status'       => 1
                    );

                    $this->process_data->create_data('tournament_matches', $dataInsert);
                } else {
                    $checkMatch = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'player_2_ID' => 0));

                    if(count($checkMatch) > 0) {
                        $matchID = $checkMatch[0]->id;
                        $dataInsert = array(
                            'player_2_ID'  => $players->participantID
                        );

                        $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
                    } else {
                        $dataInsert = array(
                            'tournamentID' => $tournamentID,
                            'player_1_ID'  => $players->participantID,
                            'player_2_ID'  => 0,
                            'round'        => 1,
                            'winnerID'     => 0,
                            'status'       => 1
                        );

                        $this->process_data->create_data('tournament_matches', $dataInsert);
                    }
                }
            endforeach;
        } else {
            echo 'Players are not ready ';
        }*/

        // $totalPlayers = '1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6';       
        // $totalPlayers = explode(' ', $totalPlayers); 
        // $rounds       = 0;
        // $matches      = 0;
        // $countPlayers = count($totalPlayers);
        // $pairs        = 0;

        // foreach($totalPlayers as $players) {
        //     $pairs = ($pairs == 0) ? ($countPlayers  / 2) : $pairs / 2;
        //     $rounds += 1;
        //     if($pairs < 2) {
        //         break;
        //     }
        // }

        // echo 'Rounds : ' . $rounds . ' | Matches : ' . $matches;
                                                                                                                                                                                                                                                                                                                                                                                                                             
        /*//Check min required players
        $getTournament = $this->process_data->get_data('tournament', array('id' => $tournamentID)); 
        
        $maxPlayers = $getTournament[0]->max_allowed_players;
        $getPlayers = $this->db->query("SELECT * FROM tournament_players WHERE tournamentID = '" . $tournamentID . "' ORDER BY id ASC");

        if(count($getPlayers) <= $maxPlayers) {
            $totalRounds = count($getPlayers) / 2;

            foreach($getPlayers as $players):
                //Check if player exist
                $checkPlayer = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));

                if(count($checkPlayer) == 0) {
                    //Creating match 
                    $dataInsert = array(
                        'tournamentID' => $tournamentID,
                        'player_1_ID'  => $players->participantID,
                        'player_2_ID'  => 0,
                        'round'        => 1,
                        'winnerID'     => 0,
                        'status'       => 1
                    );

                    $this->process_data->create_data('tournament_matches', $dataInsert);
                } else {
                    $checkMatch = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'player_2_ID' => 0));

                    if(count($checkMatch) > 0) {
                        $matchID = $checkMatch[0]->id;
                        $dataInsert = array(
                            'player_2_ID'  => $players->participantID
                        );

                        $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
                    } else {
                        $dataInsert = array(
                            'tournamentID' => $tournamentID,
                            'player_1_ID'  => $players->participantID,
                            'player_2_ID'  => 0,
                            'round'        => 1,
                            'winnerID'     => 0,
                            'status'       => 1
                        );

                        $this->process_data->create_data('tournament_matches', $dataInsert);
                    }
                }
            endforeach;      
        }*/

        //Get new lists of players 
        $tournamentID = 71;
        $bracket = $this->process_data->get_bracket($tournamentID);
        /*$getPlayers = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));
        $totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount = count($totalPlayers);

        $totalRounds =  strlen(decbin($playersCount - 1));
        $key = 0;
        $playerCount = 0;
        $previousMatchCount = 0;

        for($i = 1; $i <= $totalRounds; $i++) {
            $dataWinner   = array();
            $winner       = 0;
            $roundbracket = array();
            $roundData    = array();
            $roundDataItems = array();
            $round = $i;
            
            $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' ORDER BY groupID ASC";
            $matchesData = $this->db->query($query)->result();
            $roundTitle  = 'Round ' . $round;
            $bracket[$key] = array(
                    'round_title' => $roundTitle,
                    'round' => $round,
                );
            $previousMatchCount = $playerCount;
            $playerCount = (count($matchesData) > 0) ? count($matchesData) : $playerCount;
            $countBracketMatches = 0;
            $key_count_match = 0;
            $slotPosition = array();
            if(count($matchesData) > 0) {
                foreach($matchesData as $match):
                    // Player 1 User Details
                    $player_1_get_image = $this->process_data->get_user_meta('user_image', $match->player_1_ID);
                    
                    if($player_1_get_image == null) {
                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                    } else {
                        $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                    }
                    
                    $username_player_1 = $this->process_data->get_username($match->player_1_ID);

                    // Player 2 User Details
                    $player_2_get_image = $this->process_data->get_user_meta('user_image', $match->player_2_ID);
                                
                    if($player_2_get_image == null) {
                        $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                    } else {
                        $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_2_ID . '/' . $player_2_get_image;
                    }
                    
                    $username_player_2 = $this->process_data->get_username($match->player_2_ID);

                    $player_1_result = '';
                    $player_2_result = '';

                    if($match->winnerID > 0) {
                        $player_1_result = ($match->winnerID == $match->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                        $player_2_result = ($match->winnerID == $match->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                    }

                    $player_1_scrore = $match->player_1_scrore;
                    $player_2_scrore = $match->player_2_scrore;

                    echo $query1 = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . ($round - 1)  . "' AND (winnerID = '".$match->player_1_ID."' OR winnerID = '".$match->player_2_ID."') ORDER BY groupID ASC";
                    $matchesDataPrev = $this->db->query($query1)->result();
                    $position = array();
                    $pmatch = 0;
                    foreach($matchesDataPrev as $numb => $prevMatch) {
                        if($prevMatch->winnerID > 0) {
                            $key_count_match = $prevMatch->groupID - 1; 
                            $pmatch = $prevMatch->groupID ;
                            $slotPosition[]  = $key_count_match;
                        }
                    }

                    echo $key_count_match . ' = ' .  $pmatch . '- 1' . '<br />';

                    $bracket[$key]['bracketData'][$key_count_match] = array(
                                "name_1"      => $username_player_1,
                                'class_1'     => $player_1_result,
                                'img_src_1'   => $player_1_thumnail_url,
                                'score_1'     => $player_1_result,
                                "name_2"      => $username_player_2,
                                'class_2'     => $player_2_result,
                                'img_src_2'   => $player_2_thumnail_url,
                                'score_2'     => $player_1_result,
                                'WinnerID'    => $match->winnerID,
                                'keyID'       => 0
                            )
                    ;

                    $countBracketMatches += 1;
                    $key_count_match++;
                    // $roundDataItems[$round] = $bracket;
                endforeach;

                // $roundbracket[] = $bracket;
                // if($winner == 1) {
                //     $roundbracket[] = $dataWinner;
                // }

                // $bracket = null;
                //Current Matches
                $currentRoundMatches = (($previousMatchCount / 2) < 1) ? 0 : ($previousMatchCount / 2) - $countBracketMatches;

                /*echo 'Round : ' . $round . '<br />';
                echo 'Previous Match Count : ' . $previousMatchCount . '<br />';
                echo 'Matches Count : ' . $playerCount . '<br />';
                echo 'Left Matches Count : ' . $currentRoundMatches;
                echo '<hr />';
           
                $setKey = count($bracket[$key]['bracketData']);
                for($j = 1; $j <= $currentRoundMatches; $j++) {
                    $keySet = $j - 1;

                    if(in_array($keySet, $slotPosition)) {
                        $keySet = $keySet + 1;                        
                    }

                    $bracket[$key]['bracketData'][$keySet] = array(
                            "name_1"      => '',
                            'class_1'     => '',
                            'img_src_1'   => base_url() . 'assets/uploads/users/default.jpg',
                            'score_1'     => '',
                            "name_2"      => '',
                            'class_2'     => '',
                            'img_src_2'   => base_url() . 'assets/uploads/users/default.jpg',
                            'score_2'     => '',
                            'WinnerID'    => '',
                            'keyID'       => ''
                    );          

                    $keySet = 0;
                }

                ksort($bracket[$key]['bracketData']);
                // echo "<pre>";
                //     print_r($bracket[$key]['bracketData']);
                //     echo "</pre>";

                //Check Previous Round Winner Position
                /*$query1 = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . ($round - 1)  . "' ORDER BY id ASC";
                $matchesDataPrev = $this->db->query($query1)->result();
                $position = array();
                foreach($matchesDataPrev as $numb => $prevMatch) {
                    if($prevMatch->winnerID > 0) {
                        $position[] = $numb; 
                    }
                }
                
                if($currentRoundMatches > 0) {
                    foreach($position as $key) {
                        $key = $key - 1;
                    }

                    echo "<pre>";
                    print_r($position);
                    echo "</pre>";

                    echo '<br />';

                    echo "<pre>";
                    print_r($bracket[$key]['bracketData']);
                    echo "</pre>";
                }
            } else {
                $playerCount = (($playerCount / 2) < 1) ? 1 : $playerCount / 2;
                
                for($j = 1; $j <= $playerCount; $j++) {
                    $bracket[$key]['bracketData'][] = array(
                            "name_1"      => '',
                            'class_1'     => '',
                            'img_src_1'   => base_url() . 'assets/uploads/users/default.jpg',
                            'score_1'     => '',
                            "name_2"      => '',
                            'class_2'     => '',
                            'img_src_2'   => base_url() . 'assets/uploads/users/default.jpg',
                            'score_2'     => '',
                            'WinnerID'    => ''
                    );           
                }
            }

            $key++;
        }*/

 /*       if($tournamentData[0]->type == 2) {
            $getPlayers = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));

            $totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
            $playersCount = count($totalPlayers);
            $key = 0;
            $totalRounds =  strlen(decbin($playersCount - 1));

            for($i = 1; $i <= $totalRounds; $i++) {
                $dataWinner   = array();
                $winner       = 0;
                $roundbracket = array();
                $roundData    = array();
                $roundDataItems = array();
                $round = $i;
                
                $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' ORDER BY id ASC";
                $matchesData = $this->db->query($query)->result();
                $roundTitle  = 'Round ' . $round;
                
                if(count($matchesData) > 0) {
                    $bracket[$key] = array(
                            'round_title' => $roundTitle,
                            'round' => $round,
                        );

                    foreach($matchesData as $match):
                        // Player 1 User Details
                        $player_1_get_image = $this->process_data->get_user_meta('user_image', $match->player_1_ID);
                        
                        if($player_1_get_image == null) {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                        }
                        
                        $username_player_1 = $this->process_data->get_username($match->player_1_ID);

                        $player_1_result = '';

                        if($match->status == 0) {
                            $player_result = 'badge-danger';
                            $player_result_message = " Eliminated";
                        }

                        if($match->status == 1) {
                            $player_result = 'badge-warning';
                            $player_result_message = " Playing";
                        }

                        if($match->status == 2) {
                            $player_result = 'badge-success';
                            $player_result_message = " Qualified";
                        }

                        $player_1_scrore = $match->player_1_score;

                        $bracket[$key]['bracketData'][] = array(
                            "username"       => $username_player_1,
                            'result_class'   => $player_result,
                            'result_message' => $player_result_message,
                            'img_src'        => $player_1_thumnail_url,
                            'score'          => $player_1_result
                        );
                    endforeach;
                }

                $key++;
            }
        }

        echo "<pre>";
        print_r($bracket);
        echo "</pre>";*/
/*
        foreach($bracketsData as $key => $round):
            echo $round['round_title'] . '<br />';
            foreach($round['bracketData'] as $bracketItem): 

            endforeach;
            echo '<hr />';
        endforeach;*/

        // foreach($totalPlayers as $player):
            
        // endforeach;

        /*$exclude_player = array();
        foreach($getPlayers as $player):
            $
        endforeach;
        echo "<pre>";
        print_r($exclude_player);
        echo "</pre>";
        $exclude_player = implode(',', $exclude_player);
        $query = "SELECT * FROM tournament_players WHERE participantID NOT IN (".$exclude_player.")";
        $playersList = $this->db->query($query)->result();

        foreach($playersList as $player):
            
        endforeach;*/

        $teamID = 2;
        $totalFields = 8;
        $dataFields = array();

        $fieldsDataSet = $this->process_data->get_data('team_application_fields', array('teamID' => $teamID));

        // for($i = 1; $i <= $totalFields; $i++) {
        //     $applicationsData = $this->process_data->get_data('team_application_field_values', array(
        //         'teamID' => $teamID,
        //         'fieldCount' => $i
        //     ));
        // }
        
        $lastID = 0;
        $count  = 0;


        echo "<pre>";
        print_r($bracket);
        echo "</pre>";
    }

    public function check_bracket() {
        function is_player($round, $row, $team) {
            return $row == pow(2, $round-1) + 1 + pow(2, $round)*($team - 1);
        }

        $num_teams = 16;
        $total_rounds = floor(log($num_teams, 2)) + 1;
        $max_rows = $num_teams*2;
        $team_array = array();
        $unpaired_array = array();
        $score_array = array();

        for ($round = 1; $round <= $total_rounds; $round++) {
            $team_array[$round] = 1;
            $unpaired_array[$round] = False;
            $score_array[$round] = False;
        }


        echo "<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\">\n";
        echo "\t<tr>\n";

        for ($round = 1; $round <= $total_rounds; $round++) {

            echo "\t\t<td colspan=\"2\"><strong>Round $round</strong></td>\n";

        }

        echo "\t</tr>\n";

        for ($row = 1; $row <= $max_rows; $row++) {

            echo "\t<tr>\n";

            for ($round = 1; $round <= $total_rounds; $round++) {
                $score_size = pow(2, $round)-1;
                if (is_player($round, $row, $team_array[$round])) {
                    $unpaired_array[$round] = !$unpaired_array[$round];
                    echo "\t\t<td>Team</td>\n";
                    echo "\t\t<td width=\"20\">&nbsp;</td>\n";
                    $team_array[$round]++;
                    $score_array[$round] = False;
                } else {
                    if ($unpaired_array[$round] && $round != $total_rounds) {
                        if (!$score_array[$round]) {
                            echo "\t\t<td rowspan=\"$score_size\">Score</td>\n";
                            echo "\t\t<td rowspan=\"$score_size\" width=\"20\">$round</td>\n";
                            $score_array[$round] = !$score_array[$round];
                        }
                    } else {
                        echo "\t\t<td colspan=\"2\">&nbsp;</td>\n";
                    }
                }

            }

            echo "\t</tr>\n";

        }

        echo "</table>\n";
    }

    public function doubleElimination() {
        $rounds = $this->process_data->get_rounds($tournamentID);

        $tournamentData     = $this->process_data->get_data('tournament', array('id' => $tournamentID));
        $totalPlayers       = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount       = count($totalPlayers);
        $totalRounds        = strlen(decbin($playersCount - 1));
        $key                = 0;
        $playerCount        = 0;
        $previousMatchCount = 0;
        $bracket            = array();

        if($tournamentData[0]->type == 2) {
            $getPlayers = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));

            $totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
            $playersCount = count($totalPlayers);
            $key = 0;
            $totalRounds =  strlen(decbin($playersCount - 1));

            for($i = 1; $i <= $totalRounds; $i++) {
                $dataWinner   = array();
                $winner       = 0;
                $roundbracket = array();
                $roundData    = array();
                $roundDataItems = array();
                $round = $i;
                
                $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' ORDER BY id ASC";
                $matchesData = $this->db->query($query)->result();
                $roundTitle  = 'Round ' . $round;
                
                if(count($matchesData) > 0) {
                    $bracket[$key] = array(
                            'round_title' => $roundTitle,
                            'round' => $round,
                        );

                    foreach($matchesData as $match):
                        // Player 1 User Details
                        $player_1_get_image = $this->get_user_meta('user_image', $match->player_1_ID);
                        
                        if($player_1_get_image == null) {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                        }
                        
                        $username_player_1 = $this->get_username($match->player_1_ID);

                        $player_1_result = '';

                        if($match->status == 0) {
                            $player_result = 'badge-danger';
                            $player_result_message = " Eliminated";
                        }

                        if($match->status == 1) {
                            $player_result = 'badge-warning';
                            $player_result_message = " Playing";
                        }

                        if($match->status == 2) {
                            $player_result = 'badge-success';
                            $player_result_message = " Qualified";
                        }

                        $player_1_score = $match->player_1_score;

                        $bracket[$key]['bracketData'][] = array(
                            'player_1_ID'    => $match->player_1_ID,
                            "username"       => $username_player_1,
                            'result_class'   => $player_result,
                            'result_message' => $player_result_message,
                            'img_src'        => $player_1_thumnail_url,
                            'score'          => $player_1_score,
                        );
                    endforeach;
                }

                $key++;
            }
        } else {
            $previousMatchesCount = 0;

            for($i = 1; $i <= $totalRounds; $i++) {
                $dataWinner     = array();
                $winner         = 0;
                $roundbracket   = array();
                $roundData      = array();
                $roundDataItems = array();
                $round          = $i;
                

                $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' AND seed = 1 ORDER BY groupID ASC";
                $matchesData = $this->db->query($query)->result();
                $roundTitle  = 'Round ' . $round;
                $bracket[$key] = array(
                        'round_title' => $roundTitle,
                        'round' => $round,
                    );

                $previousMatchCount = $playerCount;

                $playerCount = (count($matchesData) > 0) ? count($matchesData) : $playerCount;
                $countBracketMatches = 0;
                $key_count_match = 0;

                $slotPosition = array();
                if(count($matchesData) > 0) {
                    foreach($matchesData as $match):
                        // Player 1 User Details
                        $player_1_get_image = $this->get_user_meta('user_image', $match->player_1_ID);
                        
                        if($player_1_get_image == null) {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                        }
                        
                        $username_player_1 = $this->get_username($match->player_1_ID);

                        // Player 2 User Details
                        $player_2_get_image = $this->get_user_meta('user_image', $match->player_2_ID);
                                    
                        if($player_2_get_image == null) {
                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                        } else {
                            $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_2_ID . '/' . $player_2_get_image;
                        }
                        
                        $username_player_2 = $this->get_username($match->player_2_ID);

                        $player_1_result = '';
                        $player_2_result = '';

                        if($match->winnerID > 0) {
                            $player_1_result = ($match->winnerID == $match->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                            $player_2_result = ($match->winnerID == $match->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                        }

                        $player_1_score = $match->player_1_score;
                        $player_2_score = $match->player_2_score;

                        $query1 = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . ($round - 1)  . "' AND (winnerID = '".$match->player_1_ID."' OR winnerID = '".$match->player_2_ID."') ORDER BY groupID ASC";
                        $matchesDataPrev = $this->db->query($query1)->result();
                        $position = array();
                        foreach($matchesDataPrev as $numb => $prevMatch) {
                            if($prevMatch->winnerID > 0) {
                                $key_count_match = $prevMatch->groupID - 1; 
                                $slotPosition[]  = $key_count_match;
                            }
                        }

                        $bracket[$key]['bracketData'][$key_count_match] = array(
                            'player_1_ID' => $match->player_1_ID,
                            "name_1"      => $username_player_1,
                            'class_1'     => $player_1_result,
                            'img_src_1'   => $player_1_thumnail_url,
                            'score_1'     => $player_1_score,
                            'player_2_ID' => $match->player_2_ID,
                            "name_2"      => $username_player_2,
                            'class_2'     => $player_2_result,
                            'img_src_2'   => $player_2_thumnail_url,
                            'score_2'     => $player_2_score
                        );

                        $countBracketMatches = $countBracketMatches + 1;
                        $key_count_match++;
                    endforeach;

                    $currentRoundMatches = (($previousMatchCount / 2) < 1) ? 0 : ($previousMatchCount / 2) - $countBracketMatches;

                    for($j = 1; $j <= $currentRoundMatches; $j++) {
                        $keySet = $j - 1;
                        if(in_array($keySet, $slotPosition)) {
                            $keySet = $keySet + 1;                   
                        }

                        $bracket[$key]['bracketData'][$key_count_match] = array(
                                'player_1_ID' => '',
                                "name_1"      => '',
                                'class_1'     => '',
                                'img_src_1'   => base_url() . 'assets/uploads/users/default.jpg',
                                'score_1'     => '',
                                'player_2_ID' => '',
                                "name_2"      => '',
                                'class_2'     => '',
                                'img_src_2'   => base_url() . 'assets/uploads/users/default.jpg',
                                'score_2'     => ''
                        ); 

                        $keySet = 0;
                        $key_count_match++;         
                    }

                    $previousMatchesCount = $key_count_match;
                    
                    ksort($bracket[$key]['bracketData']);
                } else {
                    //Previous Round Matches
                    if($previousMatchesCount > 0) {
                        $playerCount = $previousMatchesCount / 2;
                    } else {
                        $playerCount = (($playerCount / 2) < 1) ? 1 : $playerCount / 2;
                    }
                    
                    for($j = 1; $j <= $playerCount; $j++) {
                        $bracket[$key]['bracketData'][] = array(
                                'player_1_ID' => '',
                                "name_1"      => '',
                                'class_1'     => '',
                                'img_src_1'   => base_url() . 'assets/uploads/users/default.jpg',
                                'score_1'     => '',
                                'player_2_ID' => '',
                                "name_2"      => '',
                                'class_2'     => '',
                                'img_src_2'   => base_url() . 'assets/uploads/users/default.jpg',
                                'score_2'     => ''
                        );           
                    }

                    $previousMatchesCount = $playerCount;
                }

                $key++;
            }
        }
        
        return $bracket;
    }

    public function bracket_system() {
        $tournamentID = 71;
        $rounds = $this->process_data->get_rounds($tournamentID);

        $tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
        $totalPlayers   = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount   = count($totalPlayers);
        $totalRounds    = ceil(log($playersCount, 2));
        $key            = 0;
        $bracket        = array();
        
        $matchesCount = $playersCount;
function multisort (&$array, $key) {
         $valsort=array();
         $ret=array();
         reset($array);
         foreach ($array as $ii => $va) {
            $valsort[$ii]=$va[$key];
         }
         asort($valsort);
         foreach ($valsort as $ii => $va) {
             $ret[$ii]=$array[$ii];
         }
         $array=$ret;
     }

        // Loop through each round
        for ($round = 1; $round <= $totalRounds; $round++) {
            $roundTitle = 'Round ' . $round;
            $currentPlayersCount = $matchesCount;
            // Determine the number of matches for this round
            $matchesCount = $currentPlayersCount / 2;
        
            // Initialize bracketData array for this round
            $roundData = array(
                'round_title' => $roundTitle,
                'round' => $round,
                'bracketData' => array()
            );
        
            // Fetch matches for this round
            $matchesQuery = array(
                'tournamentID'  => $tournamentID,
                'round'         => $round,
                'seed'          => 0
            );

            $matches = $this->process_data->get_data('tournament_matches', $matchesQuery);
        
            // Populate slots with match data
            foreach ($matches as $match) {
                // Player 1 User Details
                $player_1_get_image = $this->process_data->get_user_meta('user_image', $match->player_1_ID);
                
                if($player_1_get_image == null) {
                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                } else {
                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                }
                
                $username_player_1 = $this->process_data->get_username($match->player_1_ID);

                // Player 2 User Details
                $player_2_get_image = $this->process_data->get_user_meta('user_image', $match->player_2_ID);
                            
                if($player_2_get_image == null) {
                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                } else {
                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_2_ID . '/' . $player_2_get_image;
                }
                
                $username_player_2 = $this->process_data->get_username($match->player_2_ID);

                $player_1_result = '';
                $player_2_result = '';

                if($match->winnerID > 0) {
                    $player_1_result = ($match->winnerID == $match->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                    $player_2_result = ($match->winnerID == $match->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                }

                $roundData['bracketData'][] = array(
                    'groupID' => $match->groupID,
                    'player_1_ID' => $match->player_1_ID,
                    "name_1"      => $username_player_1,
                    'class_1'     => $player_1_result,
                    'img_src_1'   => $player_1_thumnail_url,
                    'score_1' => $match->player_1_score,
                    'player_2_ID' => $match->player_2_ID,
                    "name_2"      => $username_player_2,
                    'class_2'     => $player_2_result,
                    'img_src_2'   => $player_2_thumnail_url,
                    'score_2' => $match->player_2_score
                );
            }
        
            // Add empty slots if needed
            $emptySlots = $matchesCount - count($matches);
        
            if($emptySlots > 0) {
                for ($i = 0; $i < $emptySlots; $i++) {
                    $roundData['bracketData'][] = array(
                        'groupID' => $i + 1,
                        'player_1_ID' => '',
                        "name_1" => '',
                        'class_1' => '',
                        'img_src_1' => 'assets/uploads/users/default.jpg',
                        'score_1' => '',
                        'player_2_ID' => '',
                        "name_2" => '',
                        'class_2' => '',
                        'img_src_2' => 'assets/uploads/users/default.jpg',
                        'score_2' => ''
                    );
                }
            }
            
            multisort ($roundData['bracketData'], 'groupID');
            // Add round data to bracketData
            $bracketData[] = $roundData;
        }

        /*for($i = 1; $i <= $totalRounds; $i++) {
            $round      = $i;
            $roundTitle = 'Round ' . $round;
        
            $currentRoundPlayers = $playersCount / pow(2, $round - 1);
            $noOfMatches         = $currentRoundPlayers / 2;
        
            $bracketData[$key] = array(
                'round_title' => $roundTitle,
                'round' => $round,
            );
            
            $loopCheck  = 1;
            $groupID    = 1;
        
            //Create Empty Slots For Bracket
            for($matchNo = 1; $matchNo <= $noOfMatches; $matchNo++) {
                if($round == 1) {
                    if ($loopCheck == 3) {
                        $loopCheck = 1;
                        $groupID = $groupID + 1;
                    }
                } 
        
                $bracketData[$key]['bracketData'][] = array(
                    'groupID'     => $groupID,
                    'player_1_ID' => '',
                    "name_1"      => '',
                    'class_1'     => '',
                    'img_src_1'   => 'assets/uploads/users/default.jpg',
                    'score_1'     => '',
                    'player_2_ID' => '',
                    "name_2"      => '',
                    'class_2'     => '',
                    'img_src_2'   => 'assets/uploads/users/default.jpg',
                    'score_2'     => ''
                );       
                
                if($round > 1) {
                    $groupID = $groupID + 1;
                }
                $loopCheck++; 
            }
        
            $key++;
        }
        
        $lastkeyID = 0;
        foreach($bracketData as $itemKey => $bracket):
            foreach($bracket['bracketData'] as $bracketKey => $bracketMatches):
                $matchQuery = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND seed = 0 AND round = '" . $bracket['round'] . "' AND groupID = '" . $bracketMatches['groupID'] . "'";
                
                if($lastkeyID > 0 ) {
                    $matchQuery .= " AND id > '" . $lastkeyID . "'";
                }
        
                $matchQuery .= "ORDER BY id ASC";
        
                $matchesSql = $pdo->prepare($matchQuery);
                $matchesSql->execute();
                
                // Fetch the data
                $result = $matchesSql->fetchAll(PDO::FETCH_ASSOC);
                
                if(count($result) > 0) {
                    $countIrretation = 0;
                    foreach($result as $key => $match):
                        if($countIrretation <= 2) {
                            $bracketData[$itemKey]['bracketData'][$bracketKey]['player_1_ID'] = $match['player_1_ID'];
                            $bracketData[$itemKey]['bracketData'][$bracketKey]['player_2_ID'] = $match['player_2_ID'];
                            $lastkeyID = $match['id'];
                            break;
                        }
                        $countIrretation++;
                    endforeach;
                }
            endforeach;
        endforeach;*/
        
        

        
        echo "<pre>";
        print_r($bracketData);
        echo "</pre>";
    } 

    public function test_email() {
        $from          = "support@dsoesports.org";
        // $headers       = 'MIME-Version: 1.0' . "\r\n";
        // $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // $headers      .= "From:" . $from;
        $receiver = 'bluevisionary3@gmail.com';
        $subject = 'This is a test email'; 
        $emailMessage = '<h1>hello world this is a test email</h1>';


        // Load Library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();


         // SMTP configuration
        // $mail->isSMTP();
        // $mail->Host         = 'smtp.gmail.com';
        // $mail->SMTPAuth     = true;
        // $mail->Username     = 'support@dsoesports.org';
        // $mail->Password     = 'DSO@@-=-.;fefdg;epg,';
        // $mail->SMTPSecure   = 'tls';
        // $mail->Port         = '587';

        $mail->setFrom($from, 'Dso eSports');
        $mail->addAddress($receiver);
        // Email subject
        $mail->Subject      = 'Send Email via SMTP using PHPMailer in CodeIgniter';

        // Set email format to HTML
        $mail->isHTML(true);
        // $mail->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/aos/assets/img/login_logo.png', 'logo');
        $mail->Body = $emailMessage;

        // Send email
        if(!$mail->send()){
            echo '{"status":"failed","message":"'.$mail->ErrorInfo.'"}';
        }else{
            echo '{"status":"success","message":"Message has been sent"}';
        }
    }

    public function notificationEmail($receiver, $subject, $emailMessage) {
        $from          = "support@dsoesports.org";

        // Load Library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->SMTPSecure   = "tls";
        $mail->Host         = "smtp.gmail.com";
        $mail->Port         = 587;
        $mail->Username     = 'support@dsoesports.org';
        $mail->Password     = 'DSO@@-=-.;fefdg;epg,';

        $mail->setFrom($from, 'Dso eSports');
        $mail->addAddress($receiver);
        // Email subject
        $mail->Subject      = $subject;

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = $emailMessage;

        // Send email
        if(!$mail->send()) {
            return array("status" => false, "message" => $mail->ErrorInfo);
        }else{
            return array("status" => true);
        }
    }

    public function testLooserBracket() {
        $tournamentID = 71;
        $rounds = $this->process_data->get_rounds($tournamentID);

        $tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
        $totalPlayers   = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount   = count($totalPlayers);
        $playersCount   = $playersCount / 2;
        $matchesCount   = $playersCount;

        $totalRounds =  strlen(decbin($playersCount - 1));
        $bracket     = array();
        $key         = 0;

        $nextRoundPlayers = $playersCount;

        for($round = 1; $round <= $totalRounds; $round++) {
            $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' AND seed = 1 ORDER BY groupID ASC";
            $matchesData = $this->db->query($query)->result();
            $roundTitle  = 'Round ' . $round;
            $roundData = array(
                    'round_title' => $roundTitle,
                    'round' => $round,
                    'bracketData' => array()
                );
            
            $currentPlayersCount = $matchesCount;
            // Determine the number of matches for this round
            $matchesCount = $currentPlayersCount / 2;


            if($round == $totalRounds) {
                $finalRound = true;
            }

            // Fetch matches for this round
            $matchesQuery = array(
                'tournamentID'  => $tournamentID,
                'round'         => $round,
                'seed'          => 1
            );

            $matches = $this->process_data->get_data('tournament_matches', $matchesQuery);

            foreach($matchesData as $match):
                // Player 1 User Details
                $player_1_get_image = $this->process_data->get_user_meta('user_image', $match->player_1_ID);
                
                if($player_1_get_image == null) {
                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                } else {
                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_1_ID . '/' . $player_1_get_image;
                }
                
                $username_player_1 = $this->process_data->get_username($match->player_1_ID);

                // Player 2 User Details
                $player_2_get_image = $this->process_data->get_user_meta('user_image', $match->player_2_ID);
                            
                if($player_2_get_image == null) {
                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
                } else {
                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->player_2_ID . '/' . $player_2_get_image;
                }
                
                $username_player_2 = $this->process_data->get_username($match->player_2_ID);

                $player_1_result = '';
                $player_2_result = '';

                if($match->winnerID > 0) {
                    $player_1_result = ($match->winnerID == $match->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                    $player_2_result = ($match->winnerID == $match->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
                }

                $player_1_score = $match->player_1_score;
                $player_2_score = $match->player_2_score;

                
                $roundData['bracketData'][] = array(
                    'groupID' => $match->groupID,
                    'player_1_ID' => $match->player_1_ID,
                    "name_1"      => $username_player_1,
                    'class_1'     => $player_1_result,
                    'img_src_1'   => $player_1_thumnail_url,
                    'score_1'     => $player_1_score,
                    'player_2_ID' => $match->player_2_ID,
                    "name_2"      => $username_player_2,
                    'class_2'     => $player_2_result,
                    'img_src_2'   => $player_2_thumnail_url,
                    'score_2'     => $player_2_score
                );
            endforeach; 
            // Add empty slots if needed
            echo count($matches) . '<br />';
            echo $matchesCount . '<br />';
            $emptySlots = $matchesCount - count($matches);
            echo '<hr />';
            if($emptySlots > 0) {
                for ($i = 0; $i < $emptySlots; $i++) {
                    $roundData['bracketData'][] = array(
                        'groupID' => $i + 1,
                        'player_1_ID' => '',
                        "name_1" => '',
                        'class_1' => '',
                        'img_src_1' => base_url() . 'assets/uploads/users/default.jpg',
                        'score_1' => '',
                        'player_2_ID' => '',
                        "name_2" => '',
                        'class_2' => '',
                        'img_src_2' => base_url() . 'assets/uploads/users/default.jpg',
                        'score_2' => ''
                    );
                }
            }

            $this->process_data->multisort($roundData['bracketData'], 'groupID');
            // Add round data to bracketData
            $bracket[] = $roundData;
            $key++;
        }

        echo "<pre>";
        print_r($bracket);
        echo "</pre>";
    }
}