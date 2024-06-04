<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_data extends CI_Model {
	public function time_ago($datetime, $full = false) {
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

	public function slugify($text, string $divider = '-') {
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, $divider);
		$text = preg_replace('~-+~', $divider, $text);
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	public function clean_content($html) {
          preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);

          $openedtags = $result[1];   #put all closed tags into an array

          preg_match_all('#</([a-z]+)>#iU', $html, $result);

          $closedtags = $result[1];

          $len_opened = count($openedtags);

          # all tags are closed

          if (count($closedtags) == $len_opened) {

            return $html;

          }

          $openedtags = array_reverse($openedtags);

          # close tags

          for ($i=0; $i < $len_opened; $i++) {

            if (!in_array($openedtags[$i], $closedtags)){

              $html .= '</'.$openedtags[$i].'>';

            } else {

              unset($closedtags[array_search($openedtags[$i], $closedtags)]);    }

          }  

          return  $html;

    }

	public function insert_visit($page_location) {
			date_default_timezone_set("America/Chicago");
			$ip = $this->input->ip_address();
			$ip_info = file_get_contents("http://ipinfo.io/" . $ip . "/json");
			$ip_info = json_decode($ip_info);
			// $country =  $ip_info->country . ", " . $ip_info->city;
			$country = '';	
			$data_visit = array(
				"count" 	=> 1,
				"country" 	=> '',
				"ip" 	=> $ip,
				"time_date" => date('Y-m-d H:i:s'),
				"page_location" => $page_location,
				"start_time"	=> date('H:i:s')
			);
			
			$this->db->insert('site_visits', $data_visit);
			return $this->db->insert_id();
		}

	public function get_data($table, $condition = null) {
		if(!empty($condition)) {
			$getData = $this->db->where($condition);
		}

		$getData = $this->db->get($table);

		return $getData->result();
	}

	public function get_data_by_order($table, $condition = null, $order = null, $orderID = null) {
		$getData = $this->db->order_by($order, $orderID);
		if(!empty($condition)) {
			$getData = $this->db->where($condition);
		}

		$getData = $this->db->get($table);

		return $getData->result();
	}

	public function create_data($table, $data, $data_update = null) {
		if(empty($data_update)) {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		} else {
			$this->db->where($data_update)->update($table, $data);

			return 'n/a';
		}
	}

	public function get_meta_data($slug) {
		$getData = $this->db->get_where('employee_properties', array('type' => $slug));

		return $getData->result();
	}

	public function update_user_meta($meta_field, $meta_value, $userID) {
		//Checking for current value
		$check = $this->get_data('user_meta', array('meta_title' => $meta_field, 'user_id' => $userID));
		if(count($check) == 0) {
			$this->create_data('user_meta', array(
				'meta_title' => $meta_field,
				'meta_value' => $meta_value,
				'user_id' 	 => $userID
			));
		} else {
			$this->create_data('user_meta', array(
				'meta_value' => $meta_value
			), array('meta_title' => $meta_field, 'user_id' => $userID));
		}
	}

	public function create_activity($dataActivity) {
		//Creating activity
		$this->db->insert('activity_log', $dataActivity);

		//Returning Activity Log Data
		$activityLog = $this->get_data('activity_log', array('act_id' => $dataActivity['act_id'], 'act_type' => 'leads'));

		$html = '';

		$html .= '<div class="feed-item">';
		$html .= '<div class="text">' .  $dataActivity['description'] . '</div>';
		$html .= '<div class="date">' .  $this->time_ago($dataActivity['date_activity']) . '</div>';
		$html .= '</div>'; 

		return $html;
	}

	public function notificationEmailSpectator($data = null) {
		$body    = '<!DOCTYPE html>
            <html>
            <head>
              <title>order received</title>
              <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
            <style>
                div, h1, h2, h3, h4 ,h5, span,  p {font-family: "Lato", sans-serif;}
              </style>
            </head>
            <body>
                <div style="max-width: 800px;margin: auto;">
                    <div style="text-align: center;width: 100%;background: #333;padding: 20px;box-sizing: border-box;">
                        <img src="https://dsoesports.org/assets/frontend/images/logo.png" />
                    </div>

                    <div style="text-align: center;">
                        <h2>Thank You For Your Order</h2>
                        <p>
                            Hi Mark, <br /><br />
                            You have received a spectator request for your listed tournament : Call Of Duty please you can review the reuqest by login to your account.
                        </p>
                    </div>

                    <div style="margin-top: 30px;">
                        <p style="text-align: center;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">© DsoEsports. All rights reserved.</p>
                        <p style="text-align: center;font-weight: 600;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">If you have any questions please contact us info@dsoesports.org</p>

                        <ul style="text-align: center;margin: 0; padding: 0;list-style-type: none;">
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/fb-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/linked-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/insta-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/twitter-icon.png" /></li>
                        </ul>
                    </div>
                </div>  
            </body>
            </html>
            ';

            return $body;
	}

	public function notificationJobApplication($data = null) {
		$body    = '<!DOCTYPE html>
            <html>
            <head>
              <title>order received</title>
              <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
            <style>
                div, h1, h2, h3, h4 ,h5, span,  p {font-family: "Lato", sans-serif;}
              </style>
            </head>
            <body>
                <div style="max-width: 800px;margin: auto;">
                    <div style="text-align: center;width: 100%;background: #333;padding: 20px;box-sizing: border-box;">
                        <img src="https://dsoesports.org/assets/frontend/images/logo.png" />
                    </div>

                    <div style="text-align: center;">
                        <h2>Application Received Against Job - '.$data['job_title'].'</h2>
                        <p>
                            Hi, <br /><br />
                            You have received an application for the job posted below are the details of the applicant.
                        </p>

                        <div style="margin-top: 20px;margin-bottom:15px;display: block;">
                        	<p>Name : '.$data['first_name']. ' ' . $data['last_name'] .'</p>
                        	<p>Discord Username : '.$data['username'].'</p>
                        	<p>Email : '.$data['email'].'</p>
                        	<p>Phone : '.$data['phone'].'</p>
                        	<p>Previous Work : '.$data['previous_work'].'</p>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <p style="text-align: center;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">© DsoEsports. All rights reserved.</p>
                        <p style="text-align: center;font-weight: 600;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">If you have any questions please contact us info@dsoesports.org</p>

                        <ul style="text-align: center;margin: 0; padding: 0;list-style-type: none;">
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/fb-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/linked-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/insta-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/twitter-icon.png" /></li>
                        </ul>
                    </div>
                </div>  
            </body>
            </html>
            ';

            return $body;
	}

	public function get_games($id = null) {
		$getGamesData = $this->db->select('games.*, categories.title AS category, categories.slug AS category_slug');
		$getGamesData = $this->db->join('categories', 'categories.id = games.category_id');

		if($id != null) {
			$getGamesData = $this->db->where('games.game_id', $id);
		}

		$getGamesData = $this->db->get('games');
		
		return $getGamesData->result();
	}

	public function get_games_offset($offset = 0, $limit = 10) {
		$query = "SELECT games.*, categories.title AS category, categories.slug AS category_slug FROM games LEFT JOIN categories ON categories.id = games.category_id ORDER BY games.game_id LIMIT ".$offset . ", " . $limit;
 		$sql = $this->db->query($query)->result();

 		return $sql;
	}

	public function get_tournaments($dataCond = array()) {
		$getTournamentData = $this->db->select('tournament.*, categories.title AS category, categories.slug AS category_slug, games.game_name, games.slug AS game_slug, count(tournament_players.id) AS total_players');
		$getTournamentData = $this->db->join('categories', 'categories.id = tournament.category_id', 'left');
		$getTournamentData = $this->db->join('games', 'games.game_id = tournament.game_id', 'left');
		$getTournamentData = $this->db->join('tournament_players', 'tournament_players.tournamentID = tournament.id', 'left');
		$getTournamentData = $this->db->group_by('tournament.id'); 

		if(!empty($dataCond)) {
			if(isset($dataCond['order_by_id'])) {
		        $order_by_id = $dataCond['order_by_id'];
		        unset($dataCond['order_by_id']);
		    }

			$getTournamentData = $this->db->where($dataCond);

			if(isset($order_by_id)) {
			    $getTournamentData = $this->db->order_by('tournament.id', $order_by_id);
			}
		}

		$getTournamentData = $this->db->get('tournament');

		return $getTournamentData->result();
	}

	public function get_tournaments_by_user($id = null) {
		$getTournamentData = $this->db->select('tournament.*, tournament_meta.meta_title, tournament_meta.meta_description, categories.title AS category, categories.slug AS category_slug, games.game_name, games.slug AS game_slug, count(tournament_players.id) AS total_players');
		$getTournamentData = $this->db->join('categories', 'categories.id = tournament.category_id');
		$getTournamentData = $this->db->join('games', 'games.game_id = tournament.game_id');
		$getTournamentData = $this->db->join('tournament_meta', 'tournament_meta.post_id = tournament.id');
		$getTournamentData = $this->db->join('tournament_players', 'tournament_players.tournamentID = tournament.id', 'left');


		$dataCond['created_by'] = $this->session->userdata('user_id');

		if($id != null) {
			$dataCond['tournament.id'] = $id;
		}

		$getTournamentData = $this->db->where($dataCond);
		$getTournamentData = $this->db->order_by('tournament.id', 'DESC');
		$getTournamentData = $this->db->get('tournament');
		
		return $getTournamentData->result();
	}

	public function get_tournaments_by_cond($data = array()) {
		$getTournamentData = $this->db->select('tournament.*, tournament_meta.meta_title, tournament_meta.meta_description, categories.title AS category, categories.slug AS category_slug, games.game_name, games.slug AS game_slug, count(tournament_players.id) AS total_players');
		$getTournamentData = $this->db->join('categories', 'categories.id = tournament.category_id');
		$getTournamentData = $this->db->join('games', 'games.game_id = tournament.game_id');
		$getTournamentData = $this->db->join('tournament_meta', 'tournament_meta.post_id = tournament.id');
		$getTournamentData = $this->db->join('tournament_players', 'tournament_players.tournamentID = tournament.id', 'left');

		if(!empty($data)) {
			$getTournamentData = $this->db->where($data);
		}

		$getTournamentData = $this->db->order_by('tournament.id','DESC');
		$getTournamentData = $this->db->get('tournament');
		
		return $getTournamentData->result();
	}

	public function tournament_meta($meta_type, $postID) {
		$postData = $this->db->get_where('tournament_meta', array('meta_type' => $meta_type, 'post_id' => $postID));
	
		return $postData->result();
	}	

	public function assoc_employees($id) {
		$countData = $this->db->get_where('employee_data', array('department_id' => $id));

		return $countData->num_rows();
	}

	public function get_employees_by_department($department) {
		$getDepartment = $this->db->get_where('employee_properties', array('title' => $department)); 
		$departmentID  = $getDepartment->row()->id;
		
		$getEmployee = $this->db->select('users.*, employee_data.department_id, employee_data.designation_id, employee_data.reporting_id, employee_data.emp_id, employee_data.date_joined, employee_data.phone, employee_data.user_image, employee_data.emp_status, employee_properties.title AS designation');
		$getEmployee = $this->db->join('employee_data', 'employee_data.emp_id = users.id');
		$getEmployee = $this->db->join('employee_properties', 'employee_properties.id = employee_data.designation_id');
		$getEmployee = $this->db->where('employee_data.department_id', $departmentID);
		$getEmployee = $this->db->get('users');

		return $getEmployee->result();
	}

	public function create_employee($dataInsert, $empData, $id) {
		if(empty($id)) {
			$dataInsert['created_at'] = date('Y-m-d');
			$this->db->insert('users', $dataInsert);

			$empID = $this->db->insert_id();

			$empData['emp_id'] = $empID;

			$this->db->insert('employee_data', $empData);
		} else {
			$this->db->where('id', $id)->update('users', $dataInsert);
			$this->db->where('emp_id', $id)->update('employee_data', $empData);
		}
	}

	public function get_employee($id = null) {
		$getEmployee = $this->db->select('users.*, employee_data.department_id, employee_data.designation_id, employee_data.reporting_id, employee_data.emp_id, employee_data.date_joined, employee_data.phone, employee_data.user_image, employee_data.emp_status, employee_properties.title AS designation');
		$getEmployee = $this->db->join('employee_data', 'employee_data.emp_id = users.id');
		$getEmployee = $this->db->join('employee_properties', 'employee_properties.id = employee_data.designation_id');

		if($id != null) {
			$getEmployee = $this->db->where('users.id', $id);
		}

		$getEmployee = $this->db->get('users');

		return $getEmployee->result();
	}

	public function get_department($id) {
		$get_department = $this->db->get_where('employee_properties', array('id' => $id));

		return $get_department->row()->title;
	}

	public function get_articles($slug = null) {
		$getArticles = $this->db->select('support_articles.*, article_categories.title AS category_name, article_categories.slug AS category_slug');
		$getArticles = $this->db->join('article_categories', 'support_articles.category_id = article_categories.id');

		if($slug != null) {
			$getArticles = $this->db->where('support_articles.slug', $slug);
		}

		$getEmployee = $this->db->get('support_articles');

		return $getEmployee->result();
	}

	public function get_customers($id = null) {
		if($id != null) {
			$getData = $this->db->where('customers.id', $id);
		}

		$getData = $this->db->select('customers.*, COUNT(orders.id) AS total_orders');
		$getData = $this->db->join('orders', 'orders.customer_id = customers.id', 'left');
		$getData = $this->db->get('customers');

		return $getData->result();
	} 

 	public function reserve_slot($data) {
 		//Reserving the slot for the comment for the user 
 		$this->db->insert('project_comments', array(
 			'project_id'  => $data['projectID'],
 			'user_id' 	  => $data['user_id'],
 			'comment'	  => 'N/A',
 			'date_posted' => date('Y-m-d')
 		));

 		$commentID = $this->db->insert_id();

 		// Inserting the file 
 		$this->db->insert('project_comment_files', array(
 			'comment_id' => $commentID,
 			'file_name'  => $data['file_name']
 		));
 	}
 	
 	public function get_user_meta($meta_title, $userID) {
 		$data_get = $this->get_data('user_meta', array('meta_title' => $meta_title, 'user_id' => $userID));

 		if(count($data_get) > 0) {
	 		return $data_get[0]->meta_value;
	 	} else {
	 		return '';
	 	}
 	}

 	public function get_userID($meta_key, $meta_value) {
 		$data_get = $this->get_data('user_meta', array('meta_title' => $meta_key, 'meta_value' => $meta_value));

 		if(count($data_get) > 0) {
	 		return $data_get[0]->user_id;
	 	} else {
	 		return '';
	 	}
 	}

 	public function get_username($userID) {
 		$data_get = $this->get_data('users', array('id' => $userID));

 		if(count($data_get) > 0) {
	 		return $data_get[0]->username;
	 	} else {
	 		return '';
	 	}
 	}

 	public function get_userdata($userID) {
 		$data_get = $this->get_data('users', array('id' => $userID));

 		if(count($data_get) > 0) {
	 		return $data_get[0];
	 	} else {
	 		return '';
	 	}
 	}

 	public function get_user_data($userID) {
 		$data_get = $this->get_data('users', array('id' => $userID));

 		if(count($data_get) > 0) {
	 		return $data_get[0];
	 	} else {
	 		return '';
	 	}
 	}

    public function get_team_meta($meta_key, $teamID) {
        $data_get = $this->get_data('team_meta', array('meta_key' => $meta_key, 'teamID' => $teamID));

        if(count($data_get) > 0) {
            return $data_get[0]->meta_value;
        } else {
            return '';
        }
    }

    public function get_recruitment_fields_meta($meta_key, $teamID) {
        $data_get = $this->get_data('team_application_fields', array('field_name' => $meta_key, 'teamID' => $teamID));

        if(count($data_get) > 0) {
            return $data_get[0]->field_label;
        } else {
            return '';
        }
    }

 	public function get_team_memebers_request($teamID) {
 		$sql = "SELECT team_members.*, users.first_name, users.last_name, users.username FROM team_members LEFT JOIN users ON users.id = team_members.user_id WHERE team_members.teamID = '".$teamID."'";
 		$sql = $this->db->query($sql);

 		return $sql->result();
 	}

 	public function get_team_memebers($teamID) {
 		$sql = "SELECT team_members.*, users.first_name, users.last_name, users.username FROM team_members LEFT JOIN users ON users.id = team_members.user_id WHERE team_members.teamID = '".$teamID."' AND team_members.status = '1'";
 		$sql = $this->db->query($sql);

 		return $sql->result();
 	}

 	public function get_participents($tournamentID) {
 		$sql = "SELECT tournament_players.*, users.first_name, users.last_name, users.username FROM tournament_players LEFT JOIN users ON users.id = tournament_players.participantID WHERE tournament_players.tournamentID = '".$tournamentID."' AND tournament_players.status = 1";
 		$sql = $this->db->query($sql);

 		return $sql->result();
 	}

 	public function get_topic_comments($postID) {
 		$sql = "SELECT comments.*, users.first_name, users.last_name, users.username, users.id AS userID FROM comments LEFT JOIN users ON users.id = comments.userID WHERE comments.postID = '".$postID."'";
 		$sql = $this->db->query($sql);

 		return $sql->result();
 	}

 	public function get_matches($tournamentID = null, $round = null, $seed = 0) {
 		$query = "SELECT tournament_matches.*, tournament.title AS tournament_title FROM tournament_matches LEFT JOIN tournament ON tournament_matches.tournamentID = tournament.id";

 		$query .= ' WHERE tournament_matches.seed = ' . $seed;
 		if($tournamentID != null) {
 			$query .= " AND tournament_matches.tournamentID = ". $tournamentID;
 		}

 		if($round != null) {
 			$query .= " AND tournament_matches.round = ". $round;
 		}

 		return $this->db->query($query)->result();
 	}

 	function odl_bracket () {
 		 for($i = 1; $i <= $totalRounds; $i++) {
	            $dataWinner   = array();
	            $winner       = 0;
	            $roundbracket = array();
	            $roundData    = array();
	            $roundDataItems = array();
	            $round = $i;
	  			

	            $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' AND seed = 0";

	            $query .= " ORDER BY groupID ASC";
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

	                    $query1 = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . ($round - 1)  . "' AND (winnerID = '".$match->player_1_ID."' OR winnerID = '".$match->player_2_ID."') AND seed = 0 ORDER BY groupID ASC";
	                    $matchesDataPrev = $this->db->query($query1)->result();
	                    $position = array();
	                    foreach($matchesDataPrev as $numb => $prevMatch) {
	                        if($prevMatch->winnerID > 0) {
	                            $key_count_match = $prevMatch->groupID - 1; 	
	                            $slotPosition[]  = $key_count_match;
	                        }
	                    }

	                    $bracket[$key]['bracketData'][$key_count_match] = array(
	                    	'groupID'	  => $match->groupID,
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
	                    		'groupID'	  => '',
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
	                    		'groupID'	  => '',
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

 	public function multisort(&$array, $key) {
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

 	public function get_bracket($tournamentID) {
 		$rounds = $this->get_rounds($tournamentID);

 		$tournamentData = $this->get_data('tournament', array('id' => $tournamentID));
 		$totalPlayers = $this->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount = count($totalPlayers);
        $totalRounds =  strlen(decbin($playersCount - 1));
        $matchesCount = $playersCount;
        $key = 0;
        $playerCount = 0;
        $previousMatchCount = 0;
        $bracket = array();
        $lastGroup = 0;

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
                
                $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' AND seed = 0 ORDER BY id ASC";
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
                        	'player_1_ID'	 => $match->player_1_ID,
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
			for ($round = 1; $round <= $totalRounds; $round++) {
	            $roundTitle = 'Round ' . $round;
	            $currentPlayersCount = $matchesCount;

	            // Determine the number of matches for this round
	            $matchesCount = $currentPlayersCount / 2;
	        
	            // Initialize bracketData array for this round
	            $roundData = array(
	                'round_title' => $roundTitle,
	                'round' 	  => $round,
	                'bracketData' => array()
	            );
	        
	            // Fetch matches for this round
	            $matchesQuery = array(
	                'tournamentID'  => $tournamentID,
	                'round'         => $round,
	                'seed'          => 0
	            );

	            $queryMatches = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND round = '" . $round .  "' AND seed = '0' ORDER BY groupID ASC";
	            $matches = $this->db->query($queryMatches)->result();

	            // $matches = $this->get_data('tournament_matches', $matchesQuery);
	        	$lastGroup = 0;

	            // Populate slots with match data
	            foreach ($matches as $match) {
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

	                $roundData['bracketData'][] = array(
	                	'matchID'	=> $match->id,
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

	                $lastGroup = $match->groupID;
	            }
	        
	            // Add empty slots if needed
	            $emptySlots = $matchesCount - count($matches);

	            if($emptySlots > 0) {
	                for ($i = 0; $i < $emptySlots; $i++) {
	                	$lastGroup++;
	                	$roundData['bracketData'][] = array(
	                		'matchID' => 0,
	                        'groupID' => $lastGroup,
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
	            
	            // $this->multisort($roundData['bracketData'], 'groupID');
	            // Add round data to bracketData
	            $bracket[] = $roundData;
	        }
	       
	        if($tournamentData[0]->type == 4) {
	        	$finalRound = $round;
	        	$additionalMatchData = $this->get_data('tournament_matches', array(
	        		'tournamentID'  => $tournamentID,
	                'round'         => $finalRound,
	                'seed'          => 0
	        	));

	        	$groupID = '';
	        	$player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
	        	$username_player_1 = '';
	        	$player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
	        	$username_player_2 = '';
				$player_1_result = '';
				$player_1_score = '';
				$player_1_ID = '';
				$player_2_result = '';
				$player_2_score = '';
				$player_2_ID = '';

	        	if(count($additionalMatchData) > 0) {
	        		$groupID = $additionalMatchData[0]->groupID;
	        		// Player 1 User Details
	                $player_1_get_image = $this->get_user_meta('user_image', $additionalMatchData[0]->player_1_ID);
	                
	                if($player_1_get_image == null) {
	                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
	                } else {
	                    $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $additionalMatchData[0]->player_1_ID . '/' . $player_1_get_image;
	                }
	                
	                $username_player_1 = $this->get_username($additionalMatchData[0]->player_1_ID);

	                // Player 2 User Details
	                $player_2_get_image = $this->get_user_meta('user_image', $additionalMatchData[0]->player_2_ID);
	                            
	                if($player_2_get_image == null) {
	                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
	                } else {
	                    $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $additionalMatchData[0]->player_2_ID . '/' . $player_2_get_image;
	                }
	                
	                $username_player_2 = $this->get_username($additionalMatchData[0]->player_2_ID);

	                if($additionalMatchData[0]->winnerID > 0) {
	                    $player_1_result = ($additionalMatchData[0]->winnerID == $additionalMatchData[0]->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
	                    $player_2_result = ($additionalMatchData[0]->winnerID == $additionalMatchData[0]->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
	                }

	                $player_1_ID = $additionalMatchData[0]->player_1_ID;
	                $player_2_ID = $additionalMatchData[0]->player_2_ID;
	                $player_1_score = $additionalMatchData[0]->player_1_score;
	                $player_2_score = $additionalMatchData[0]->player_2_score;
 	        	}

	        	$slotKey = count($bracket);
	        	$bracket[$slotKey+1] = array(
                    'round_title' => 'Final Round',
                    'round' 	  => $finalRound,
                );

                $bracket[$slotKey+1]['bracketData'][] = array(
                		'matchID'     => 0,
                		'groupID'	  => $groupID,
                        'player_1_ID' => $player_1_ID ,
                        "name_1"      => $username_player_1,
                        'class_1'     => $player_1_result,
                        'img_src_1'   => $player_1_thumnail_url,
                        'score_1'     => $player_1_score,
                        'player_2_ID' => $player_2_ID,
                        "name_2"      => $username_player_2,
                        'class_2'     => $player_2_result,
                        'img_src_2'   => $player_2_thumnail_url,
                        'score_2'     => $player_2_score
                );  
	        }
	    }
	    
        return $bracket;
 	} 

 	public function get_looser_bracket($tournamentID) {
 		$rounds = $this->get_rounds($tournamentID);

        $tournamentData = $this->get_data('tournament', array('id' => $tournamentID));
        $totalPlayers   = $this->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount   = count($totalPlayers);

        if ($playersCount == 0) {
        	return array();
        }

        $playersCount = intdiv($playersCount, 2);
        $totalRounds  = strlen(decbin($playersCount - 1));
        $bracket      = array();
        $key          = 0;
        $matchesCount = $playersCount;
       

        $nextRoundPlayers = $playersCount;

        for($round = 1; $round <= $totalRounds; $round++) {                
            $query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round . "' AND seed = 1 ORDER BY groupID ASC, id ASC";
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
            $lastGroupID  = 0;
            $key_count_match = 0;
            $matchPlayersReserved = 0;

            if($round == $totalRounds) {
            	$finalRound = true;
            }

            // Fetch matches for this round
            $matchesQuery = array(
                'tournamentID'  => $tournamentID,
                'round'         => $round,
                'seed'          => 1
            );

            $matches = $this->get_data('tournament_matches', $matchesQuery);

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

                $lastGroupID = $match->groupID;
            endforeach; 
			// Add empty slots if needed
            $emptySlots = $matchesCount - count($matches);
        
            if($emptySlots > 0) {
                for ($i = 0; $i < $emptySlots; $i++) {
                	$lastGroupID++;
                    $roundData['bracketData'][] = array(
                        'groupID' => $lastGroupID,
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
            
            // $this->multisort($roundData['bracketData'], 'groupID');
            // Add round data to bracketData
            $bracket[] = $roundData;
            $key++;
        }

        return $bracket;
 	} 

 	public function old_bracket() {
 		/*$dataWinner   = array();
 		$winner 	  = 0;
 		$roundbracket = array();
 		$roundData    = array();
 		$roundDataItems = array();

 		foreach($rounds as $round) {
 			$query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID ."' AND round = '" . $round->round . "' ORDER BY id ASC";
            $matchesData = $this->db->query($query)->result();
            $roundTitle  = 'Round ' . $round->round;
            $roundData[] =  array(
            		array(
            			'round_title' => $roundTitle,
            			'round' => $round->round
            		)
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

                $bracket[] = array(
                        array(
                        	"name" 		=> $username_player_1,
                        	'class'		=> $player_1_result,
                            "id"   		=> $match->player_1_ID,
                            "seed" 		=> $match->player_1_ID,
                            'img_src'   => $player_1_thumnail_url,
                            'score'		=> $player_1_result
                        ) , array(
                            "name" 		=> $username_player_2,
                            'class'		=> $player_2_result,
                            "id"   		=> $match->player_2_ID,
                            "seed" 		=> $match->player_2_ID,
                            'img_src'   => $player_2_thumnail_url,
                            'score'		=> $player_1_result
                        )
                    );

                if($match->status == 0) {
                	$winner_get_image = $this->get_user_meta('user_image', $match->winnerID);
                            
	                if($winner_get_image == null) {
	                    $winner_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
	                } else {
	                    $winner_thumnail_url = base_url() . 'assets/uploads/users/user-' . $match->winnerID . '/' . $winner_get_image;
	                }
	                
	                $username_winner = $this->get_username($match->winnerID);

	               /* $winner_score = '';
	                
	                if($match->winnerID > 0) {
	                    $player_1_result = ($match->winnerID == $matches->player_1_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
	                    $player_2_result = ($matches->winnerID == $matches->player_2_ID) ? 'dso-bracket-winner' : 'dso-bracket-looser';
	                }

	                $player_1_score = $matches->player_1_score;
	                $player_2_score = $matches->player_2_score;

	                $dataWinner[] = array(
	                	array(
	                		"name" 		=> $username_winner,
                            "id"   		=> $match->winnerID,
                            "seed" 		=> $match->winnerID,
                            'img_src'   => $winner_thumnail_url
	                	)
	                );

	                $winner = 1;
                }
                $roundDataItems[$round->round] = $bracket;
            endforeach;

            $roundbracket[] = $bracket;
            if($winner == 1) {
            	$roundbracket[] = $dataWinner;
            }

            $bracket = null;
        }


        $returnData['rounds'] = $roundData;
        $returnData['roundbracket'] = $roundDataItems;

        return $returnData;*/
 	}

 	public function create_match($tournamentID = null) {
 		//Get all players and see if normal criteria meets
 		$getPlayers = $this->db->query("SELECT * FROM tournament_players WHERE tournamentID = '" . $tournamentID . "' AND status = 1 ORDER BY id ASC");

 		//Get min required tournament players to start tournament
 		$getRequiredPlayers = $this->get_data('tournament', array('id' => $tournamentID)); 

 		if($getPlayers->num_rows() > 1) {
	 		if($getPlayers->num_rows() <= $getRequiredPlayers[0]->max_allowed_players) {
	 			$this->create_data('tournament', array('max_allowed_players' => $getPlayers->num_rows()), array('id' => $tournamentID)); 
	 		}

			$this->create_data('tournament', array('status' => 2), array('id' => $tournamentID));
			if($getRequiredPlayers[0]->brackets == 1) {
				$bracketMatchesTypes = array(1, 3, 4);

				if(in_array($getRequiredPlayers[0]->type, $bracketMatchesTypes)) {
			        $totalRounds = $getPlayers->num_rows() / 2;

		            foreach($getPlayers->result() as $players):
		                //Check if player exist
		                $checkPlayer = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));
		                $groupID = 1;

		                if(count($checkPlayer) == 0) {
		                    //Creating match 
		                    $dataInsert = array(
		                        'tournamentID' => $tournamentID,
		                        'groupID'	   => $groupID,
		                        'player_1_ID'  => $players->participantID,
		                        'player_2_ID'  => 0,
		                        'round'        => 1,
		                        'winnerID'     => 0,
		                        'status'       => 1
		                    );

							if($getRequiredPlayers[0]->type == 4) {
								$dataInsert['stage'] = 2;
							}

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
		                    	//Get last group 
		                    	$query = "SELECT * FROM tournament_matches WHERE tournamentID = '".$tournamentID."' ORDER BY id DESC LIMIT 1";
		                    	$dataMatch = $this->db->query($query)->result();
		                    	
		                    	//Check the number of groups created per match
		                    	$checkGroup = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'groupID' => $dataMatch[0]->groupID));

						    	$groupID = $dataMatch[0]->groupID + 1;


		                        $dataInsert = array(
		                            'tournamentID' => $tournamentID,
		                            'groupID'	   => $groupID,
		                            'player_1_ID'  => $players->participantID,
		                            'player_2_ID'  => 0,
		                            'round'        => 1,
		                            'winnerID'     => 0,
		                            'status'       => 1
		                        );

								if($getRequiredPlayers[0]->type == 4) {
									$dataInsert['stage'] = 2;
								}

		                        $this->process_data->create_data('tournament_matches', $dataInsert);
		                    }
		                }
		            endforeach; 
		        }

		        if($getRequiredPlayers[0]->type == 2) {
		        	//Create elmination match system
		        	$groupID = 1;
		        	$countMatch = 1;

		        	foreach($getPlayers->result() as $players):
			        	if($count > 2) {
			        		$groupID += 1;
			        		$count = 1;
			        	}
			        	$dataPlayer = array(
			                'tournamentID' => $tournamentID,
							'groupID'	   => $groupID,
			                'player_1_ID'  => $players->participantID,
			                'player_2_ID'  => 0,
			                'round'        => 1,
			                'points'	   => 0,
			                'winnerID'     => 0,
			                'status'       => 1
			            );

			            $this->process_data->create_data('tournament_matches', $dataPlayer);
			            $count += 1;
			        endforeach;     
		        }
		    } else {
		        if($getRequiredPlayers[0]->type == 2) {
		        	//Create elmination match ssytem
		        	foreach($getPlayers->result() as $players):
			        	$dataPlayer = array(
			                'tournamentID' => $tournamentID,
			                'player_1_ID'  => $players->participantID,
			                'player_2_ID'  => 0,
			                'round'        => 1,
			                'points'	   => 0,
			                'winnerID'     => 0,
			                'status'       => 1
			            );
						print_r($dataPlayer);

			            $this->process_data->create_data('tournament_matches', $dataPlayer);
			        endforeach;     
		        }
		    }

		    return true;
		} else {
			return false;
		}
 	}

 	public function get_offset_limit($table, $id, $offset, $limit) {
 		$query = "SELECT * FROM " . $table . " ORDER BY " . $id . " LIMIT ".$offset . ", " . $limit;
 		$sql = $this->db->query($query)->result();

 		return $sql;
 	}

 	public function get_recently_joined() {
 		$query = "SELECT * FROM users WHERE role = 4 ORDER BY id DESC LIMIT 8";
 		$sql   = $this->db->query($query)->result();

 		return $sql;                                                             
 	}

 	public function notificationContactSupport($data) {
 		$body    = '<!DOCTYPE html>
            <html>
            <head>
              <title>order received</title>
              <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
            <style>
                div, h1, h2, h3, h4 ,h5, span,  p {font-family: "Lato", sans-serif;}
              </style>
            </head>
            <body>
                <div style="max-width: 800px;margin: auto;">
                    <div style="text-align: center;width: 100%;background: #333;padding: 20px;box-sizing: border-box;">
                        <img src="https://dsoesports.org/assets/frontend/images/logo.png" />
                    </div>

                    <div style="text-align: center;">
                        <h2>Support Request Receive</h2>
                        <p>
                            Hi, <br /><br />
                            You have received a query from support page.
                        </p>

                        <div style="margin-top: 20px;margin-bottom:15px;display: block;">
                        	<p>Name : '.$data['first_name']. ' ' . $data['last_name'] .'</p>
                        	<p>Email : '.$data['email'].'</p>
                        	<p>Message : '.$data['question'].'</p>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <p style="text-align: center;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">© DsoEsports. All rights reserved.</p>
                        <p style="text-align: center;font-weight: 600;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">If you have any questions please contact us info@dsoesports.org</p>

                        <ul style="text-align: center;margin: 0; padding: 0;list-style-type: none;">
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/fb-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/linked-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/insta-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/twitter-icon.png" /></li>
                        </ul>
                    </div>
                </div>  
            </body>
            </html>
            ';

            return $body;
 	}

 	public function get_team_data($userID) {
 		$get_team_id = $this->get_data('team_members', array('user_Id' => $userID));

 		if(count($get_team_id) > 0) {
	 		$get_image = $this->get_user_meta('user_image', $get_team_id[0]->teamID);
					                        		
			if($get_image == null) {
				$teamLogo = base_url() . 'assets/frontend/images/team-logo.png';
			} else {
				$teamLogo = base_url() . 'assets/uploads/users/user-' . $get_team_id[0]->id . '/' . $get_image;
			}

	 		$dataTeam['teamLogo']    = $teamLogo;
	 		$dataTeam['team_name']   = $this->get_user_meta('team_name', $get_team_id[0]->teamID); 
	 		$dataTeam['profile_url'] = base_url() . 'team/' . $this->get_user_meta('team_slug', $get_team_id[0]->teamID); 
	 	} else {
	 		$dataTeam = '';
	 	}

 		return $dataTeam;
 	}

 	public function checkTournamentRegistration($tournamentID, $userID) {
 		$check = $this->get_data('tournament_players', array(
 			'tournamentID'  => $tournamentID,
 			'participantID' => $userID
 		));

 		return count($check);
 	}

 	public function get_active_tournaments($gameID = null) {
 		$query = "SELECT * FROM tournament WHERE game_id = '" . $gameID . "' AND status != 3";
 		$get = $this->db->query($query)->result();
 		$totalTournaments = count($get);

 		return $totalTournaments;
 	}

 	public function get_rounds($tournamentID) {
 		$query = "SELECT COUNT(id) AS total_matches,  round FROM tournament_matches WHERE tournamentID = '".$tournamentID."' GROUP BY round ORDER BY round ASC";
 		$data  = $this->db->query($query);
 		$data  = $data->result();

 		return $data;  
 	}

 	public function get_matches_data($tournamentID, $round, $seed = 0) {
 		$matchesData = $this->get_data(
            'tournament_matches', 
            array(
                'tournamentID'  => $tournamentID,
                'round' => $round,
                'seed'  => $seed
            )
        );
 		$tournamentData = $this->get_tournaments(array('tournament.id' => $tournamentID));
        $html 	 = '';
        $winnerID = '';

        foreach($matchesData as $matches):  
            // Player 1 User Details
            $player_1_get_image = $this->get_user_meta('user_image', $matches->player_1_ID);
                        
            if($player_1_get_image == null) {
                $player_1_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
            } else {
                $player_1_thumnail_url = base_url() . 'assets/uploads/users/user-' . $matches->player_1_ID . '/' . $player_1_get_image;
            }
            
            $username_player_1 = $this->get_username($matches->player_1_ID);

            // Player 2 User Details
            $player_2_get_image = $this->get_user_meta('user_image', $matches->player_2_ID);
                        
            if($player_2_get_image == null) {
                $player_2_thumnail_url = base_url() . 'assets/uploads/users/default.jpg';
            } else {
                $player_2_thumnail_url = base_url() . 'assets/uploads/users/user-' . $matches->player_2_ID . '/' . $player_2_get_image;
            }
            
            $username_player_2 = $this->get_username($matches->player_2_ID);

            $player_1_result = '';
            $player_2_result = '';

            if($matches->winnerID > 0) {
                $player_1_result = ($matches->winnerID == $matches->player_1_ID) ? 'dso-winner' : 'dso-looser';
                $player_2_result = ($matches->winnerID == $matches->player_2_ID) ? 'dso-winner' : 'dso-looser';
            }

            $result_class = ($matches->winnerID == 0) ? '-outline' : '';
   			if($matches->status == 0) {
	            $player_result = 'badge-danger';
	            $player_result_message = " Eliminated";
	        }

	        if($matches->status == 1) {
	            $player_result = 'badge-warning';
	            $player_result_message = " Playing";
	        }

	        if($matches->status == 2) {
	            $player_result = 'badge-success';
	            $player_result_message = " Qualified";
	        }

	        $html .= '<div class="matches-table manage-matches">';
        	$html .= '<div class="match-row match-elimination">';
            $html .= '<div class="match-player">';
             	$html .= '<span class="dso-match-icon ion-ios-star'. $result_class . ' ' . $player_1_result .'"></span>';
	            $html .= '<div class="user-thumb">';
	            $html .= '<img src="'. $player_1_thumnail_url .'" />';
	            $html .= '</div>';
	            
	            $matchWinner1 = ($matches->winnerID == $matches->player_1_ID) ? '<label class="badge badge-success">Winner</label>' : '' ;
	            
	            $html .= '<label>'. $username_player_1;
	            if($tournamentData[0]->allowed_participants == 1) {
                $html .= '<a href="'. base_url() .'account/getTeamPlayers" class="btn btn-small view-players" data-id="'. $tournamentData[0]->id.'" data-team="'. $matches->player_1_ID .'">View Players</a>';
                } 
	            $html .= '</label>';
            $html .= '</div>';

            $html .= '<div class="mid-vs">';
	            $html .= '<h2>'.$matches->player_1_score.'</h2>';
	            $html .= '<span>VS</span>';
	            $html .= '<h2>'. $matches->player_2_score.'</h2>';
            $html .= '</div>';

            $matchWinner2 = ($matches->winnerID == $matches->player_2_ID) ? '<label class="badge badge-success">Winner</label>' : '' ;
            
            $html .= '<div class="match-player match-right">';
            $html .= '<label>'. $username_player_2;
            if($tournamentData[0]->allowed_participants == 1) {
            	$html .= '<a href="'. base_url() .'account/getTeamPlayers" class="btn btn-small view-players" data-id="'. $tournamentData[0]->id.'" data-team="'. $matches->player_2_ID .'">View Players</a>';
            } 
            $html .= '</label>';
                
	            $html .= '<div class="user-thumb">';
	            $html .= '<img src="'. $player_2_thumnail_url .'" />';
	            $html .= '</div>';

	           $html .= '<span class="dso-match-icon ion-ios-star'. $result_class . ' ' . $player_2_result .'"></span>';
            $html .= '</div>';
        	$html .= '</div>';
        	$html .= '</div>';
        	if($matches->status == 0) {
        		$winnerID = $matches->winnerID;
        	}
        endforeach;

        if($winnerID != '') {
        	$winner_get_image = $this->get_user_meta('user_image', $winnerID);
                        
            if($winner_get_image == null) {
                $winner_thumnail_url = base_url() . 'assets/frontend/images/default.png';
            } else {
                $winner_thumnail_url = base_url() . 'assets/uploads/users/user-' . $winnerID . '/' . $winner_get_image;
            }
            
            $username_winner = $this->get_username($winnerID);

    		$html .= '<div class="winner-champ bracket-area">';
            $html .= '<div class="discount-animation">';
            $html .= '<img class="element ring-fat" src="' . base_url() .'assets/frontend/images/element-light-ring-fat.svg"> ';
            $html .= '<img class="element ring-fat-2" src="' . base_url() .'assets/frontend/images/element-ring-fat.svg"> ';
            $html .= '<img class="element cross-fat" src="' . base_url() .'assets/frontend/images/element-cross-fat.svg"> ';
            $html .= '<img class="element cross-fat-2" src="' . base_url() .'assets/frontend/images/element-dark-cross-fat.svg">'; 
            $html .= '<img class="element cross-fat-3" src="' . base_url() .'assets/frontend/images/element-light-cross-fat.svg"> ';
            $html .= '<img class="element snake" src="' . base_url() .'assets/frontend/images/element-light-snake.svg">';
            $html .= '<img class="element snake-2" src="' . base_url() .'assets/frontend/images/element-dark-snake.svg">';
            $html .= '<img class="element snake-3" src="' . base_url() .'assets/frontend/images/element-snake.svg">';
            $html .= '<img class="element halfpipe" src="' . base_url() .'assets/frontend/images/element-dark-halfpipe.svg">';
            $html .= '</div>';
            
            $html .= '<div class="icon">';
            $html .= '<img src="' . base_url() .'assets/frontend/images/trophy-icon.png">';
            $html .= '</div>';

            $html .= '<div class="win-con group-bracket">';
            $html .= '<div class="single-bracket">';
            $html .= '<div class="left d-flex align-items-center">';
            $html .= '<div class="player-thumb"><img src="' . $winner_thumnail_url .'" alt="image"></div>';
            $html .= '<p>'.$username_winner.'</p>';
            $html .= '</div>';
            $html .= '<div class="right">';
            $html .= '<span>'.$winnerID.'</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        	$html .= '</div>';
        }

        return $html;
 	} 

 	public function get_spectstor_tournament($userID) {
 		$sql  = "SELECT tournament.* FROM tournaments LEFT JOIN tournament_spectators ON tournament_spectators.tournamentID = tournament.id WHERE tournament_spectators.specID - '" . $userID . "'";
 		$data = $this->db->query($sql);
 		$data = $data->result();

 		return $data;
 	}

 	public function newsletter_tempalate($message) {
 		$body    = '<!DOCTYPE html>
            <html>
            <head>
              <title>order received</title>
              <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
            <style>
                div, h1, h2, h3, h4 ,h5, span,  p {font-family: "Lato", sans-serif;}
              </style>
            </head>
            <body>
                <div style="max-width: 800px;margin: auto;">
                    <div style="text-align: center;width: 100%;background: #333;padding: 20px;box-sizing: border-box;">
                        <img src="https://dsoesports.org/assets/frontend/images/logo.png" />
                    </div>

                    <div>
                        '.$message.'
                    </div>

                    <div style="margin-top: 30px;">
                        <p style="text-align: center;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">© DsoEsports. All rights reserved.</p>
                        <p style="text-align: center;font-weight: 600;font-size: 12px;line-height: 20px;color: #525F7F;margin: 15px 0;">If you have any questions please contact us info@dsoesports.org</p>

                        <ul style="text-align: center;margin: 0; padding: 0;list-style-type: none;">
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/fb-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/linked-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/insta-icon.png" /></li>
                            <li style="display: inline-block;vertical-align: middle;"><img style="width: 25px;" src="https://you-boost.com/wp-content/uploads/2021/08/twitter-icon.png" /></li>
                        </ul>
                    </div>
                </div>  
            </body>
            </html>
            ';

            return $body;
 	}

 	public function game_name($game_slug = null) {
 		$gamedata = $this->get_data('games', array('slug' => $game_slug));

 		return $gamedata;
 	}
 	
 	public function get_tournament_match_meta($matchID = null, $playerID = null, $meta_key = null) {
		if($matchID != '' && $playerID != '') {
			$matchMeta = $this->get_data('tournament_matches_meta', array('matchID' => $matchID, 'playerID' => $playerID, 'meta_key' => $meta_key));

			if(count($matchMeta) == 0) {
				return '';
			} else {
				return $matchMeta[0]->meta_value;
			}
		} else {
 			return false;
		}
	} 

	public function chatNotificationsCount($chatID) {
		$userID = $this->session->userdata('user_id');
		$getDataByChat = $this->get_data('messages', array('chatID' => $chatID, 'receiver_id' => $userID, 'status' => 1));

		return count($getDataByChat);
	}

	public function create_match_chat_group($tournamentID, $matchID, $playerID, $slot = 1) {
		//Create New Round Chat Group
        $dataMemebers[] = $playerID;
        //Get tournament Spectators
        $tournamentSpectators = "SELECT tournament_spectators.*, users.username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '" . $tournamentID . "'";
        $tournamentSpectators = $this->db->query($tournamentSpectators)->result();

        //Check if group chat is already created
        $chatGroupData = $this->process_data->get_data('tournament_chat_group', array(
            'matchID'  => $matchID,
            'slot' 	   => $slot
        ));	

        if(count($chatGroupData) == 0) {
            foreach($tournamentSpectators as $spectator):
                $dataMemebers[] = $spectator->specID;
            endforeach;

            $tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
            array_push($dataMemebers, $tournamentData[0]->created_by);

            $membersID = serialize($dataMemebers);

            $dataChatGroup = array(
                'matchID'  => $matchID,
                'memberID' => $membersID,
                'slot' 	   => $slot
            );

            $this->process_data->create_data('tournament_chat_group', $dataChatGroup);	
        } else {
            $membersID = unserialize($chatGroupData[0]->memberID);
            array_push($membersID, $playerID);
            $membersID = serialize($membersID);

            $this->process_data->create_data('tournament_chat_group', array('memberID' => $membersID), array('ID' => $chatGroupData[0]->ID));
        }
	}

	public function looser_count($playerID, $tournamentID) {
		$losesCountCondition = array(
    		'tournamentID'	=> $tournamentID,
    		'playerID' 	   	=> $playerID,
    		'meta_key'		=> 'loss_count'  
    	);

    	$getLossCountQuery = $this->get_data('tournament_matches_meta', $losesCountCondition);
    	
    	if(count($getLossCountQuery) > 0) {
	    	$getLossCount = $getLossCount[0]->meta_value; 
	    } else {
	    	$getLossCount = 0; 
	    }

    	return $getLossCount;
	}

	public function processMatch($tournamentID, $playerID, $round, $groupID, $position, $seed = 0) {
		//Creating match 
        $dataInsert = array(
            'tournamentID' => $tournamentID,
            'groupID'	   => $groupID,
            $position  	   => $playerID,
            'round'        => $round,
            'status'       => 1
        );

        if($seed == 1) {
            $dataInsert['seed'] = 1;
        }

        $newMatchID = $this->create_data('tournament_matches', $dataInsert);

        $this->create_match_chat_group($tournamentID, $newMatchID, $playerID);
	}

	public function assignToFreeSlot($tournamentID, $playerID, $matchID, $playerSlot = 2) {
		$dataInsert['player_' . $playerSlot . '_ID'] = $playerID;

        $this->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
        $this->create_match_chat_group($tournamentID, $matchID, $playerID, $playerSlot);
	}

	public function createAdditionalFinalRound($tournamentID, $player_1_ID, $player_2_ID, $round, $groupID) {
		//Get no of looses for the player
		$player1LossCount = $this->looser_count($tournamentID, $player_1_ID);
    	$player2LossCount = $this->looser_count($tournamentID, $player_2_ID);
    	$additionalRound  = false;
    	
    	if($player1LossCount == 1 || $player2LossCount == 1) {	
    		//Creating match 
            $dataInsert = array(
                'tournamentID' => $tournamentID,
                'groupID'	   => $groupID,
                'player_1_ID'  => $player_1_ID,
                'player_2_ID'  => $player_2_ID,
                'round'        => $round,
                'winnerID'     => 0,
                'status'       => 1
            );

            $newMatchID = $this->create_data('tournament_matches', $dataInsert);

            $this->create_match_chat_group($tournamentID, $newMatchID, $player_1_ID);
            $this->create_match_chat_group($tournamentID, $newMatchID, $player_2_ID, 2);
    	}
	}

	public function create_round_match($matchID, $tournamentID, $winnerID) {
		$getTournamentQuery = "SELECT tournament.* FROM tournament LEFT JOIN tournament_matches ON tournament_matches.tournamentID = tournament.id WHERE tournament_matches.id = '" . $matchID . "'";
        $tournamentData  = $this->db->query($getTournamentQuery)->result();
		$getMatchDetails = $this->get_data('tournament_matches', array('id' => $matchID));
	
		$totalPlayers = $this->get_data('tournament_players', array('tournamentID' => $tournamentID));
		$playersCount = count($totalPlayers);
		$totalRounds  = strlen(decbin($playersCount - 1));

		if($getMatchDetails[0]->seed == 1) {
			$winnerRound = $totalRounds + 1;
			$totalRounds = $totalRounds - 1; 
		}

		$round 	  = $getMatchDetails[0]->round;
		$newRound = $round + 1;

		// Calculate the next group
	    $nextGroup = ceil($getMatchDetails[0]->groupID / 2);

	    // Determine if the winner is player 1 or player 2 in the next match
	    $position = ($getMatchDetails[0]->groupID % 2 == 1) ? 'player_1_ID' : 'player_2_ID';

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
                    $playerSlot = 1;
                } else {
                    $playerSlot = 2;
                }

                $this->assignToFreeSlot($tournamentID, $winnerID, $getFreeSlotMatch[0]->id, $playerSlot);
            } else {
                if($round < $totalRounds) {
                	$getMatchDataCond = array(
                		'tournamentID' => $tournamentID,
                        'round'   => $newRound
                	);

                	// Check if current match is for winner bracket or looser bracket
                	// Winner Bracket Seed 0
                	// Looser Bracket Seed 1
                	if($getMatchDetails[0]->seed == 1) {
						$getMatchDataCond['seed'] = 1;
					} else {
						$getMatchDataCond['seed'] = 0;
					}

                    if($newRound == $totalRounds) {
                        $getMatchData = $this->process_data->get_data('tournament_matches', $getMatchDataCond);
                    } else {
                    	$freeSlotMatchQuery  = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND round = '" . $newRound . "'";
						$freeSlotMatchQuery .= " AND (player_1_ID = 0 OR player_2_ID = 0)";
						$freeSlotMatchQuery .= " AND groupID = '" . $nextGroup . "'";

						if($tournamentData[0]->type == 4 && $getMatchDetails[0]->seed == 1) {
							$freeSlotMatchQuery .= " AND seed = 1";
						} else {
							$freeSlotMatchQuery .= " AND seed = 0";
						}
						
						$getMatchData = $this->db->query($freeSlotMatchQuery)->result();
                    }

                    if(count($getMatchData) > 0) {
                    	$playerSlot = ($getMatchData[0]->player_1_ID == 0) ? 1 : 2;

                    	$this->assignToFreeSlot($tournamentID, $winnerID, $getMatchData[0]->id, $playerSlot);
                    } else {
                        //Creating match 
                        $seed = 0;

                        if($getMatchDetails[0]->seed == 1) {
                            $seed = 1;
                        }

                        $this->processMatch($tournamentID, $winnerID, $newRound, $nextGroup, $position, $seed);
                    }
                }				
            }
        } else {
        	if($tournamentData[0]->type == 4) {
	        	//If current Round is final round of winner vs looser
	        	if($round == ($totalRounds + 1)) {
	        		$this->createAdditionalFinalRound(
	        			$tournamentID, 
	        			$getMatchDetails[0]->player_1_ID, 
	        			$getMatchDetails[0]->player_2_ID, 
	        			$newRound, 
	        			$getMatchDetails[0]->groupID
	        		);
	        	} else {
	        		if($getMatchDetails[0]->seed == 0) {
	        			//Creating match 
                        $this->processMatch($tournamentID, $winnerID, $newRound, $getMatchDetails[0]->groupID);
	        		}

	        		if($getMatchDetails[0]->seed == 1) {
	        			//Get Final Round match data from upper bracket
		        		$getMatchDataCond = array(
		            		'tournamentID' => $tournamentID,
		                    'round'   	   => $winnerRound,
		                    'seed'   	   => 0,
		            	);

		            	$getMatchDataLog = $this->get_data('tournament_matches', $getMatchDataCond);

		            	if(count($getMatchDataLog) > 0) {
		            		$this->assignToFreeSlot($tournamentID, $winnerID, $getMatchDataLog[0]->id);
			            } else {
			            	//Creating match 
	                        $this->processMatch($tournamentID, $winnerID, $newRound, $getMatchDetails[0]->groupID);
			            }
	        		}
	        	}
	        }
        }

        /*
		 * Create Round For Looser Player If Tournament is for Double Elimination
		 */

        if($tournamentData[0]->type == 4 && $getMatchDetails[0]->seed == 0) {
    		$matchRound = $round; 
            //Get Looser ID
            if($getMatchDetails[0]->winnerID == $getMatchDetails[0]->player_1_ID) {
                $looserID   = $getMatchDetails[0]->player_2_ID;
                $looserSlot = 'player_2_ID';
            } else {
                $looserID 	= $getMatchDetails[0]->player_1_ID;
                $looserSlot = 'player_1_ID';
            }

            //Check if loss count is less then 2 
            $checkLossCount = $this->looser_count($playerID, $tournamentID);

            if($checkLossCount < 2 && $round < $totalRounds) {
	            //Check if looser bracket have any match created
	            $looserMatchData = $this->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'seed' => 1));

	            if(count($looserMatchData) > 0) {
	                $freeSlotMatchQuery  = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "'";
					$freeSlotMatchQuery .= " AND (player_1_ID = 0 OR player_2_ID = 0)";
					$freeSlotMatchQuery .= " AND groupID = '" . $nextGroup . "'";
					$freeSlotMatchQuery .= " AND seed = 1";
					
					$checkMatch = $this->db->query($freeSlotMatchQuery)->result();

	                if(count($checkMatch) > 0) {
	                    $matchID = $checkMatch[0]->id;
	                    $playerSlot = ($checkMatch[0]->player_1_ID == 0) ? 1 : 2;
	                    $this->assignToFreeSlot($tournamentID, $looserID, $matchID, $playerSlot);
	                } else {
	                    //Creating match    
	                    $this->processMatch($tournamentID, $looserID, $matchRound, $nextGroup, $position, 1);
	                }
	            } else {
	                $this->processMatch($tournamentID, $looserID, $matchRound, $nextGroup, $position, 1);
	            }
	        }
        }
	}

	public function create_top_seed_matches($tournamentID) {

	}
}