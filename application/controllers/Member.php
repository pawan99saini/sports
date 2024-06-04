<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('verify_user');
		$this->load->model('process_data');
	}

	public function index() {
		$data = array(
			'title' => 'Dashboard' 
		);

		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}

		if($this->session->userdata('user_role') == 1) {
			redirect('member/login');
		}

		$userID = $this->session->userdata('user_id');
		$user_log_id = $this->session->userdata('user_log_id');
		$dataPrev = $this->db->query("SELECT * FROM user_log WHERE userID = '" . $userID . "' ORDER BY id DESC LIMIT 1, 1")->result(); 

		$data['userLog'] = $dataPrev;	
		$data['meta'] = $this->process_data;
		
		$data['active_tournaments'] = $this->db->get_where('tournament', array('created_by' => $userID,'status' => 1))->num_rows();
		$data['inactive_tournaments'] = $this->db->get_where('tournament', array('created_by' => $userID,'status' => 0))->num_rows();

		$data['profileData'] = $this->process_data->get_data('users', array('id' => $userID));

		$query = "SELECT * FROM attendance WHERE userID = '" . $userID . "' ORDER BY id DESC LIMIT 0,1";
		$attendance = $this->db->query($query)->result();

		$data['attendance']  = $attendance;

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/dashboard', $data);
		$this->load->view('app/includes/footer');
	}

	public function login() {
		$data = array(
			'title' => 'Admin - Login' 
		);

		$this->load->view('app/login');
	}

	public function loginprocess() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$status = $this->verify_user->login_user(array(
			'username' => $username,
			'password' => md5($password) 
		));

		$url = base_url() . 'member';

		if($status == false) {
			$data_return = array(
				'status'  => 0,
				'message' => '<div class="message"><i class="fa fa-times-circle"></i> Invalid username / password provided</div>', 
			);
		} else {
			if($status > 1) {
				$data_return = array(
					'status'  => 1,
					'url' 	  => $url, 
					'message' => '<div class="message"><i class="fa fa-check-circle"></i> Success</div>', 
				);
			} else {
				$userID = $this->session->userdata('user_id');
				$this->verify_user->processLogout($userID);
				$data_return = array(
					'status'  => 0,
					'message' => '<div class="message"><i class="fa fa-times-circle"></i> Access Denied</div>', 
				);
			}
		}

		echo json_encode($data_return);
	}

	public function logout() {
		$userID = $this->session->userdata('user_id');
		$this->verify_user->processLogout($userID);

		redirect('member/login');
	}

	public function tournaments($method = null, $id = null, $arrg_type = null, $arrg_id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}

		if($method == 'categories') {
			$data['title'] = 'Categories';

			$data['categoriesData'] = $this->process_data->get_data('categories');

			$page = 'categories'; 
		} elseif($method == 'create') {
			$data['title'] = 'Create Tournament';

			$data['categoriesData'] = $this->process_data->get_data('categories');
			$data['id']				= $id;

			$data['gamesData'] 	= $this->process_data->get_games();

			$data['category_id'] = '';
			$data['game_id']   = '';
			$data['description'] = '';
			$data['region'] = '';
			$data['date'] = '';
			$data['time'] = '';
			$data['format'] = '';
			$data['game_map'] = '';
			$data['title'] = '';
			$data['filename'] = '';
			$data['rules'] = '';
			$data['schedule'] = '';
			$data['contact'] = '';
			$data['status'] = '';
			$data['tournament_meta'] = '';
			$data['max_players'] = '';
			$data['max_spectators'] = '';
			$data['req_credits'] = '';

			if($id != null) {
				$tournamentData = $this->process_data->get_tournaments($id);

				$data['title'] 		 	= $tournamentData[0]->title;
				$data['category_id'] 	= $tournamentData[0]->category_id;
				$data['game_id']     	= $tournamentData[0]->game_id;
				$data['description'] 	= $tournamentData[0]->description;
				$data['region'] 	 	= $tournamentData[0]->region;
				$data['date'] 		 	= $tournamentData[0]->organized_date;
				$data['time'] 		 	= $tournamentData[0]->time;
				$data['format'] 	 	= $tournamentData[0]->format;
				$data['game_map'] 	 	= $tournamentData[0]->game_map;
				$data['title'] 		 	= $tournamentData[0]->title;
				$data['filename'] 	 	= $tournamentData[0]->image;
				$data['rules'] 		 	= $tournamentData[0]->rules;
				$data['schedule'] 	 	= $tournamentData[0]->schedule;
				$data['contact'] 	 	= $tournamentData[0]->contact;
				$data['status'] 	 	= $tournamentData[0]->status;
				$data['max_players'] 	= $tournamentData[0]->max_allowed_players;
				$data['max_spectators'] = $tournamentData[0]->max_allowed_spectators;
				$data['req_credits'] =$tournamentData[0]->req_credits;

				$data['tournament_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $id, 'meta_type' => 'prize_data'))->result();
				$data['stats_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $id, 'meta_type' => 'stats_data'))->result();
			}

			$page = 'create-tournament'; 
		} elseif($method == 'delete') {
			$folder_path = getcwd() . '/assets/frontend/images/tournaments/'; 
			$get_image = $this->process_data->get_data('tournament', array('id' => $id));

			$image_name = $get_image[0]->image;
			unlink($folder_path . '/' . $image_name);

			$this->db->where('id', $id)->delete('tournament');
			$this->db->where('post_id', $id)->delete('tournament_meta');

			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament Deleted Successfully.</div>');

			redirect('member/tournaments');	
		} elseif($method == 'notice-board') {
			if($id == null) {
				$data['notice'] = false;

				$data['tournamentsData'] = $this->process_data->get_tournaments();
				$page = 'notice-board';	
			} else {
				$data['notice'] = true;
				$data['tournamentID'] = $id;
				$data['tournamentsData'] = $this->process_data->get_tournaments($id);
				$data['announcmentsData'] = $this->process_data->get_data('tournament_notice', array('tournamentID' => $id, 'created_by' => $this->session->userdata('user_id')));

				if($arrg_type == 'create') {
					$page = 'create-announcment';
				} else {
					$page = 'notice-board';
				}

				if($arrg_type == 'create' && $arrg_id == null) {
					$data['message'] = null;
					$data['id']      = null;
				} elseif($arrg_type == 'create' && $arrg_id != null) {
					$announcmentData = $this->process_data->get_data('tournament_notice', array('id' => $arrg_id));

					$data['message'] = $announcmentData[0]->message;
					$data['id']      = $arrg_id;
				} elseif($arrg_type == 'delete') {
					$this->db->where('id', $arrg_id)->delete('tournament_notice');

					$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament notice deleted successfully.</div>');

					redirect('member/tournament/notice-board/' . $id);
				}
			}	
		} else {
			$data['title'] = 'Toournaments';

			$data['tournamentsData'] = $this->process_data->get_tournaments_by_user();

			$page = 'tournaments'; 
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function createTournament() {
		$title	     = $this->input->post('title');	
		$category    = $this->input->post('category_id');
		$description = $this->input->post('description');
		$game_id 	 = $this->input->post('game_id');
		$region	  	 = $this->input->post('region');	
		$date 		 = $this->input->post('date');
		$time		 = $this->input->post('time');
		$format      = $this->input->post('format');
		$game_map	 = $this->input->post('game_map');	
		$rules 		 = $this->input->post('rules');
		$schedule	 = $this->input->post('schedule');
		$contact 	 = $this->input->post('contact');
		$id		  	 = $this->input->post('id');
		$filename 	 = $this->input->post('filename');
		$meta_title  = $this->input->post('placement');
		$meta_value  = $this->input->post('prize');
		$stat_title  = $this->input->post('stat_title');
		$stat_value  = $this->input->post('stat_value');
		
		$max_players  	= $this->input->post('max_players');
		$max_spectators = $this->input->post('max_spectators');
		$req_credits = $this->input->post('req_credits');
		$created_by  	= $this->session->userdata('user_id');

		$config['upload_path'] = getcwd() . '/assets/frontend/images/tournaments/'; 

		$file     = $_FILES['tournament_image']['name'];
		$filesize = $_FILES['tournament_image']['size'];
		$location = $config['upload_path'].$file;

		$return_arr = array();

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['tournament_image']['tmp_name'],$location)){
			    $dataInsert['filename'] = $file;
			}
		} else {
			$dataInsert['filename'] = $filename;
		}

		//Create Slug 
		$slug = $this->process_data->slugify($title);

		//If ID exist and not empty updaet tournament data
		if(!empty($id)) {
			$condition = array('id' => $id);

			$tournamentID = $this->process_data->create_data('tournament', 
				array(
					'game_id' => $game_id,
					'category_id' => $category,
					'region' => $region,
					'organized_date' => $date, 
					'description' => $description, 
					'format' => $format, 
					'game_map' => $game_map, 
					'time' => $time, 
					'title' => $title, 
					'rules' => $rules, 
					'image' => $dataInsert['filename'], 
					'schedule' => $schedule, 
					'contact' => $contact, 
					'max_allowed_players' => $max_players, 
					'max_allowed_spectators' => $max_spectators,
					'req_credits' => $req_credits,
					'status' => 1, 
					'created_by' => $created_by, 
					'slug' => $slug
				), $condition);

			$tournamentID = $id;
		} else {
			$checkSlug = $this->db->query("SELECT * FROM tournament WHERE slug LIKE '%" .$slug . "%'");
		
			if($checkSlug->num_rows() > 0) {
				$count = $checkSlug->num_rows();
				$slug = $slug . '-' . $count;
			}

			$tournamentID = $this->process_data->create_data('tournament', 
			array(
				'game_id' => $game_id,
				'category_id' => $category,
				'region' => $region,
				'organized_date' => $date, 
				'description' => $description, 
				'format' => $format, 
				'game_map' => $game_map, 
				'time' => $time, 
				'title' => $title, 
				'rules' => $rules, 
				'image' => $dataInsert['filename'], 
				'schedule' => $schedule, 
				'contact' => $contact, 
				'max_allowed_players' => $max_players, 
				'max_allowed_spectators' => $max_spectators,
				'status' => 1, 
				'created_by' => $created_by, 
				'slug' => $slug
			));
		}		

		if(empty($id)) {
			$dataTournament = array(
				'meta_title' => serialize($meta_title),
				'meta_description' => serialize($meta_value),
				'meta_type' => 'prize_data',
				'post_id' => $tournamentID
			);
			$this->process_data->create_data('tournament_meta', $dataTournament);

			$dataStats = array(
				'meta_title' => serialize($stat_title),
				'meta_description' => serialize($stat_value),
				'meta_type' => 'stats_data',
				'post_id' => $tournamentID
			);
			$this->process_data->create_data('tournament_meta', $dataStats);
		} else {
			$tournament_id = array('post_id' => $id);

			$checkData  = $this->db->get_where('tournament_meta', array('post_id' => $id, 'meta_type' => 'prize_data'));
			$checkStats = $this->db->get_where('tournament_meta', array('post_id' => $id, 'meta_type' => 'stats_data'));

			$dataTournament = array(
				'meta_title' => serialize($meta_title),
				'meta_description' => serialize($meta_value),
				'meta_type' => 'prize_data',
			);

			$dataStats = array(
				'meta_title' => serialize($stat_title),
				'meta_description' => serialize($stat_value),
				'meta_type' => 'stats_data',
			);

			if($checkData->num_rows() > 0) { 
				$this->process_data->create_data('tournament_meta', $dataTournament, array('id' => $checkData->row()->id));
			} else {
				$dataTournament['post_id'] = $id;
				$this->process_data->create_data('tournament_meta', $dataTournament);
			}

			if($checkStats->num_rows() > 0) { 
				$this->process_data->create_data('tournament_meta', $dataStats, array('id' => $checkStats->row()->id));
			} else {
				$dataStats['post_id'] = $id;
				$this->process_data->create_data('tournament_meta', $dataStats);
			}
		}		

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament '.$status.' Successfully.</div>');

		redirect('member/tournaments');
	}

	public function createTournamentNotice() {
		$message      = $this->input->post('message');	
		$tournamentID = $this->input->post('tournamentID');
		$date_posted  = date('Y-m-d H:i:s');
		$id 		  = $this->input->post('id');
		$created_by   = $this->session->userdata('user_id');

		if(!empty($id)) {
			$updateID = array('id' => $id);
		}

		if($id == null) {
			$this->process_data->create_data('tournament_notice', 
				array(
					'message' 		=> $message,
					'tournamentID' 	=> $tournamentID,
					'date_posted'	=> $date_posted,
					'created_by' 	=> $created_by
				));
		} else {
			$this->process_data->create_data('tournament_notice', 
			array(
				'message' => $message,
				
			), $updateID);
		}		

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament Notice '.$status.' Successfully.</div>');

		redirect('member/tournaments/notice-board/' . $tournamentID);
	}

	public function spectator_request($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}

		if($method == 'view') {
			$data['title'] = 'Create User';

			$data['id'] = $id;

			$spectatorData = $this->process_data->get_data('application', array('id' => $id));

			$data['spectatorData'] = $spectatorData;
	
			$page = 'view-spectator-application'; 
		} else {
			$data['title'] = 'Spectator Requests';

			$user_id = $this->session->userdata('user_id');

			$data['tournamentData'] = $this->process_data->get_data('tournament', array('created_by' => $user_id));

			$page = 'spectator-requests'; 
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function getApplications() {
		$tournamentID = $this->input->post('tournamentID');

		$applicationsData = $this->process_data->get_data('application', array('tournamentID' => $tournamentID));

		$data['applicationsData'] = $applicationsData;

		$this->load->view('app/spectator-application', $data);
	}

	public function viewSpectatorApplication($id = null) {
		$data['id'] = $id;

		$spectatorData = $this->process_data->get_data('application', array('id' => $id));

		$data['spectatorData'] = $spectatorData;

		$this->load->view('app/view-spectator-application', $data);
	}

	public function updateSpectator() {
		$status  = $this->input->post('status');	
		$comment = $this->input->post('comment');
		$id 	 = $this->input->post('id');

		$data_update = array(
			'status'   => $status,
			'comments' => $comment
		);

		$this->process_data->create_data('application', $data_update, array('id' => $id));

		$applicationsData = $this->process_data->get_data('application', array('id' => $id));

		$data['applicationsData'] = $applicationsData;

		$this->load->view('app/spectator-application', $data);
	}

	public function matches($method = null, $tournamentID = null, $arrg = null, $round = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}

		$user_id = $this->session->userdata('user_id');

		$data['tournamentData'] = $this->process_data->get_data('tournament', array('created_by' => $user_id));
		$data['meta'] = $this->process_data;

		if($method == 'manage') {
			$data['title'] = 'View Match';

			$data['tournamentID'] = $tournamentID;

			if($arrg == 'create') { 
				$check = $this->process_data->create_match($tournamentID);
				
				if($check == true) {
					$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Match created successfully.</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-times-circle"></i> Match cannot be created at this moment the minimum required players to start the match did not meet.</div>');
				}

				redirect('member/matches/manage/'.$tournamentID);
			} else {
				if($arrg != 'round') {
					$round = 1;
				}

				$param = '';

				// if($arrg != null) {
				// 	$param .= '/' . $arrg;
				// } else {
				// 	$param .= '/round';
				// }

				$data['activeRound'] 	= $round;
				$data['tournamentData'] = $this->process_data->get_data('tournament', array('id' => $tournamentID));
				$data['playersData']    = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
				$data['matchesData'] 	= $this->process_data->get_matches($tournamentID, $round);
				$data['totalRounds']	= $this->process_data->get_rounds($tournamentID); 
				$data['active_url']	    = base_url() . 'member/matches/manage/' . $tournamentID . $param;
			}

			$page = 'matches'; 
		} else {
			$data['title'] = 'Manage Matches';

			$page = 'matches'; 
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function setWinner() {
		$player_id = $this->input->post('playerID');
		$rowID = $this->input->post('rowID');
		$round = $this->input->post('round');

		$newRound = $round + 1;

		//Set Winner 
		$setWinner = array(
			'winnerID' => $player_id
		);

		$this->process_data->create_data('tournament_matches', $setWinner, array('id' => $rowID));

		//Get tournament ID
		$getTournamentData = $this->process_data->get_data('tournament_matches', array('id' => $rowID));
		$tournamentID      = $getTournamentData[0]->tournamentID;

		//Get Group ID
		$getCurrrentMatchesData = $this->process_data->get_data('tournament_matches', array('id' => $rowID));
		$groupID      			= $getCurrrentMatchesData[0]->groupID;

		//Check if in round 2 any player exist or not
		$getMatchData = $this->process_data->get_data('tournament_matches', array(
			'tournamentID' => $tournamentID,
			'round'		   => $newRound,
			'groupID'      => $groupID
		));

		$previousRound = ($round == 1) ? 1 : ($round - 1);

		//Check if this is final round then do not create additional match
		$checkFinalRound = $this->process_data->get_data('tournament_matches', array(
			'tournamentID' => $tournamentID,
			'round'		   => $previousRound
		));

		if(count($checkFinalRound) > 2) {
			if(count($getMatchData) > 0) {
				foreach($getMatchData as $match):
					if($match->player_2_ID == 0) {
						$matchID = $match->id;
	                    $dataInsert = array(
	                        'player_2_ID'  => $player_id
	                    );

	                    $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
						break;
					} else {
						//Creating match 
			            $dataInsert = array(
			            	'groupID'      => $groupID,
			                'tournamentID' => $tournamentID,
			                'player_1_ID'  => $player_id,
			                'player_2_ID'  => 0,
			                'round'        => $newRound,
			                'winnerID'     => 0,
			                'status'       => 1
			            );

			            $this->process_data->create_data('tournament_matches', $dataInsert);

			            break;
					}
				endforeach;
			} else {
				//Creating match 
	            $dataInsert = array(
	            	'groupID'      => $groupID,
	                'tournamentID' => $tournamentID,
	                'player_1_ID'  => $player_id,
	                'player_2_ID'  => 0,
	                'round'        => $newRound,
	                'winnerID'     => 0,
	                'status'       => 1
	            );

	            $this->process_data->create_data('tournament_matches', $dataInsert);
			}
		} else {
			$this->process_data->create_data('tournament_matches', array('status' => 0), array('id' => $rowID));
		}

		echo '<td>' . $getTournamentData[0]->id . '</td>';
            
        $player_1_username = $this->process_data->get_username($getTournamentData[0]->player_1_ID);
        $player_2_username = $this->process_data->get_username($getTournamentData[0]->player_2_ID);
 
        echo '<td>';
        echo '<span>' . $player_1_username . '</span>';
    
        if($getTournamentData[0]->winnerID == $getTournamentData[0]->player_1_ID) {
            echo "<label class='badge badge-success'>Winner</label>";
        } else {
            echo "<label class='badge badge-danger'>Loser</label>";
        }
             
        echo '</td>';
        echo '<td>';
        echo '<span>' . $player_2_username . '</span>';
             
        if($getTournamentData[0]->winnerID == $getTournamentData[0]->player_2_ID) {
            echo "<label class='badge badge-success'>Winner</label>";
        } else {
            echo "<label class='badge badge-danger'>Loser</label>";
        }
        
        echo '</td>';
        echo '<td>' . $round . '</td>';
        echo '<td>';
        echo "<label class='badge badge-info'>Match Completed</label>";        
        echo '</td>';
	}

	public function attendance($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}
		
		if($method == 'time_in') {
			$status = $this->verify_user->process_time_in();

			if($status == 1) {
				$data['status']   = 1;
				$data['dataHtml'] = '<i class="mdi mdi-clock"></i> <span>Timed In At : '.date('H:i:s A').'</span>';
			} else {
				$data['status'] 	 = 0;
				$data['dataMessage'] = '<div class="message"><i class="fa fa-times-circle"></i> Your shift time is not over you cannot <strong>Clock Out</strong> Please contact your reporting authority to clock out early.</div>';
			}

			echo json_encode($data);
			exit;
		} elseif($method == 'time_out') {
			$status = $this->verify_user->process_time_out();

			if($status == 1) {
				$data['status']   = 1;
				$data['dataHtml'] = '<i class="mdi mdi-clock"></i> <span> Timed Out At : '.date('H:i:s A').'</span>';
			} else {
				$data['status'] 	 = 0;
				$data['dataMessage'] = '<div class="message"><i class="fa fa-times-circle"></i> You cannot <strong>Clock Out</strong> until you submit your daily report please <a href="'.base_url().'member/submit-work">submit report</a> and then clock out.</div>';
			}

			echo json_encode($data);
			exit;
		} else {
			$data['title'] = 'Attendance';

			$userID = $this->session->userdata('user_id');

			$day     = date('D'); 

			$data['day'] 	 = $day;
			$data['dateGet'] = date('d');
			$data['month']   = date('M');

            //check the current day
            if($day != 'Mon') {    
                $start_date = date('Y-m-d', strtotime('last Monday'));    
            } else {
                $start_date = date('Y-m-d');   
            }

            //always next saturday
            if($day != 'Sun') {
                $end_date = date('Y-m-d', strtotime('next Sunday'));
            } else {
                $end_date = date('Y-m-d');
            }

            $dayFrom = date('D, M d, Y', strtotime($start_date));
			$dayTo   = date('D, M d, Y', strtotime($end_date));

            $data['start_date'] = $start_date;
            $data['end_date']	= $end_date;
            $data['dayFrom'] 	= $dayFrom;
            $data['dayTo']		= $dayTo;
			
			$current_class = '';
            $data_header   = '';                                
            
            for($i = 0; $i <= 6; $i++) {
                $daySet = date('D', strtotime($start_date . ' +'.$i.' days')); 
                $date   = date('d', strtotime($start_date . ' +'.$i.' days'));
                $month  = date('M', strtotime($start_date . ' +'.$i.' days')); 
                
                if($date == date('d')) {
                    $current_class = ' class="active-date"';
                }

                $data_header .= '<li '.$current_class.'>';
                $data_header .= '<span>' . $date . '</span>';
                $data_header .= '<div class="daySet"><span>' . $daySet . '</span>';
                $data_header .= '<span>' . $month . '</span></div>';
                $data_header .= '</li>';
            }

            $data['data_header'] = $data_header;
            $data['date']	= $date;

			$html = '';
			$days_worked = 0;
			$days_abscent = 0;
			$total_week_time = array();
	        for($i = 0; $i <= 6; $i++) {

	        	$set_date = date('Y-m-d', strtotime($start_date . ' +'.$i.' days'));
	        	$get_attendance  = "SELECT * FROM attendance WHERE date = '".$set_date."' AND userID = '".$userID."'";
				$data['timeLog'] = $this->db->query($get_attendance)->result();
	            $html .= '<li>';
	            if(count($data['timeLog']) > 0) {
	            	$days_worked += 1; 
					$html .= '<div class="time-box-set">';
					$diff = array();
					foreach($data['timeLog'] as $dataTime):
			            if($dataTime->time_in == '00:00:00') {
			                 $html .= '<label class="badge badge-danger">Abscent</label>';
			            } else {
			                $time_in_convert = (date('A', strtotime($dataTime->time_in)) == 'AM') ? 'PM' : 'AM';

			                $time_in = date('h:i:s', strtotime($dataTime->time_in)) . ' ' . $time_in_convert;

			                $html .= '<label class="badge badge-success">Time In : ' . $time_in . '</label>';
			                $html .= '<label class="badge badge-warning">Time Out : ';
			                
			                if($dataTime->time_out == '00:00:00') {
			                    $html .= 'N/A';
			                } else { 
			                    $time_out_convert = (date('A', strtotime($dataTime->time_out)) == 'AM') ? 'PM' : 'AM';
			                    $html .= date('h:i:s', strtotime($dataTime->time_out)) . ' ' . $time_out_convert;
			                	$diff[] = strtotime($dataTime->time_out) - strtotime($dataTime->time_in);
			                }

			                $html .= '</label>';
			            }
			        endforeach;
			        
		       		$html .= '</div>';
		       		date_default_timezone_set('UTC');
		       		$total_time = date('H:i:s', array_sum($diff));
		       		$total_week_time[] = array_sum($diff);
		       		$html .= '<div class="time-calc">Time Spent : '.$total_time.'</div>';
		       	} else {
		       		$days_abscent += 1; 
		       	}
	       		$html .= '</li>';
	       	}

	       	$total_time = date('H:i:s', array_sum($total_week_time));

	       	$report = '<ul class="personal-info user-report">
	                    <li>
	                        <div class="title"><i class="ti-calendar"></i> Total Working Days:</div>
	                        <div class="text clock_in">
	                             07
	                        </div>
	                    </li>

	                    <li>
	                        <div class="title"><i class="icon-calender"></i> Days Worked:</div>
	                        <div class="text">
	                             '.$days_worked.'
	                        </div>
	                    </li>

	                    <li>
	                        <div class="title"><i class="icon-calender"></i> Abscent Days:</div>
	                        <div class="text">
	                             '.$days_abscent.'
	                        </div>
	                    </li>

	                    <li>
	                        <div class="title"><i class="ti-alarm-clock"></i> Total Time Spent:</div>
	                        <div class="text">
	                             '.$total_time.'
	                        </div>
	                    </li>
	                </ul> ';


        	$data['calendarData'] = $html;
    		$data['reportData']	= $report;

			$page = 'attendance';
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function getNextWeek() {
		$userID    = $this->session->userdata('user_id');
		$date_get  = $this->input->post('dataStep');
		$daysAhead = ($date_get == '+') ? '+1' : '-7';
		$week_init_date  = ($date_get == '+') ? $this->input->post('end_date') : $this->input->post('start_date');  
		$week_start_date = date('Y-m-d', strtotime($week_init_date . ' '.$daysAhead.' days'));
		$day     = date('D', strtotime($week_start_date)); 

        //check the current day
        if($day != 'Mon') {    
            $start_date = date($week_start_date, strtotime('last Monday'));    
        } else {
            $start_date = date($week_start_date);   
        }
  
        $week_end_date = date('Y-m-d', strtotime($week_start_date . ' +6 days'));

        //always next sunday
        if($day != 'Sun') {
            $end_date = date($week_end_date, strtotime('next Sunday'));
        } else {
            $end_date = date($week_end_date);
        }

        $week_date = '<span>';

        $dayFrom = date('D, M d, Y', strtotime($start_date));
        $dayTo   = date('D, M d, Y', strtotime($end_date));  
        
        $week_date .= $dayFrom . ' - ' . $dayTo;

        $week_date .= '</span>
        <i class="ti-calendar"></i>';

        $current_class 	 = '';
		$header_calendar = ''; 
		$week_calendar   = '';

        for($i = 0; $i <= 6; $i++) {
            $daySet = date('D', strtotime($week_start_date . ' +'.$i.' days')); 
            $date   = date('d', strtotime($week_start_date . ' +'.$i.' days'));
            $month  = date('M', strtotime($week_start_date . ' +'.$i.' days')); 
            
            if($date == date('d')) {
                $current_class = ' class="active-date"';
            }

            $week_calendar .= '<li '.$current_class.'>';
            $week_calendar .= '<span>' . $date . '</span>';
            $week_calendar .= '<div class="daySet"><span>' . $daySet . '</span>';
            $week_calendar .= '<span>' . $month . '</span></div>';
            $week_calendar .= '</li>';
        }

        $start_date = $week_start_date;
        $end_date   = $week_end_date;

        $html = '';
		$days_worked 	 = 0;
		$days_abscent 	 = 0;
		$total_week_time = array();

        for($i = 0; $i <= 6; $i++) {

        	$set_date = date('Y-m-d', strtotime($start_date . ' +'.$i.' days'));
        	$get_attendance  = "SELECT * FROM attendance WHERE date = '".$set_date."' AND userID = '".$userID."'";
			$data['timeLog'] = $this->db->query($get_attendance)->result();
            $html .= '<li>';
            if(count($data['timeLog']) > 0) {
            	$days_worked += 1; 
				$html .= '<div class="time-box-set">';
				$diff = array();
				foreach($data['timeLog'] as $dataTime):
		            if($dataTime->time_in == '00:00:00') {
		                 $html .= '<label class="badge badge-danger">Abscent</label>';
		            } else {
		                $time_in_convert = (date('A', strtotime($dataTime->time_in)) == 'AM') ? 'PM' : 'AM';

		                $time_in = date('h:i:s', strtotime($dataTime->time_in)) . ' ' . $time_in_convert;

		                $html .= '<label class="badge badge-success">Time In : ' . $time_in . '</label>';
		                $html .= '<label class="badge badge-warning">Time Out : ';
		                
		                if($dataTime->time_out == '00:00:00') {
		                    $html .= 'N/A';
		                } else { 
		                    $time_out_convert = (date('A', strtotime($dataTime->time_out)) == 'AM') ? 'PM' : 'AM';
		                    $html .= date('h:i:s', strtotime($dataTime->time_out)) . ' ' . $time_out_convert;
		                	$diff[] = strtotime($dataTime->time_out) - strtotime($dataTime->time_in);
		                }

		                $html .= '</label>';
		            }
		        endforeach;
		        
	       		$html .= '</div>';
	       		date_default_timezone_set('UTC');
	       		$total_time = date('H:i:s', array_sum($diff));
	       		$total_week_time[] = array_sum($diff);
	       		$html .= '<div class="time-calc">Time Spent : '.$total_time.'</div>';
	       	} else {
	       		$days_abscent += 1; 
	       	}
       		$html .= '</li>';
       	}

       	$total_time = date('H:i:s', array_sum($total_week_time));

       	$report = '<ul class="personal-info user-report">
                    <li>
                        <div class="title"><i class="ti-calendar"></i> Total Working Days:</div>
                        <div class="text clock_in">
                             07
                        </div>
                    </li>

                    <li>
                        <div class="title"><i class="icon-calender"></i> Days Worked:</div>
                        <div class="text">
                             '.$days_worked.'
                        </div>
                    </li>

                    <li>
                        <div class="title"><i class="icon-calender"></i> Abscent Days:</div>
                        <div class="text">
                             '.$days_abscent.'
                        </div>
                    </li>

                    <li>
                        <div class="title"><i class="ti-alarm-clock"></i> Total Time Spent:</div>
                        <div class="text">
                             '.$total_time.'
                        </div>
                    </li>
                </ul> ';

        echo json_encode(array(
        	'week_date' => $week_date, 
        	'week_calendar' => $week_calendar,
        	'week_attendance' => $html,
        	'week_report'	=> $report,
        	'start_date' => $start_date,
        	'end_date' => $end_date
        ));
	}

	public function getReport() {
		$userID = $this->input->post('user_id');
		$date 	= $this->input->post('current_date'); 

		$dataLog = $this->db->get_where('attendance', array('userID' => $userID, 'date' => $date));
		

		if($dataLog->num_rows() > 0) {
			$time_in_convert  = (date('A', strtotime($dataLog->row()->time_in)) == 'AM') ? 'PM' : 'AM';
			$time_out_convert = (date('A', strtotime($dataLog->row()->time_out)) == 'AM') ? 'PM' : 'AM';
			$time_in  = $dst->format('h:i:s A');
			$time_out = ($dataLog->row()->time_out == '00:00:00') ? 'N/A' : date('h:i:s', strtotime($dataLog->row()->time_out)) . ' ' . $time_out_convert;
		} else {
			$time_in  = 'N/A';
			$time_out = 'N/A';
		}

		$data['clock_in'] 	  = $time_in;
		$data['clock_out'] 	  = $time_out;
		$data['current_date'] = date('d F Y', strtotime($date));

		echo json_encode($data);
	}

	public function leaves($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}
		
		$data['title'] = 'My Leaves';
		$data['leavesData'] = $this->db->get_where('emp_leaves', array('emp_id' => $this->session->userdata('user_id')))->result();

		$page = 'leaves';

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function create_leave() {
		$userID       = $this->session->userdata('user_id');
		$leave_date   = $this->input->post('leave_date');
		$date_type    = $this->input->post('date_type');
		$leaves_date  = $this->input->post('leaves_date');
		$date_count   = $this->input->post('date_count');
		$end_date 	  = $this->input->post('end_date');
		$leave_type   = $this->input->post('leave_type');
		$reason 	  = $this->input->post('reason');
		$leave_method = $this->input->post('leave_method');

		if($leave_method == 'yes') {
			if($date_type == 'multi_dates') {
				$date_to = serialize($leaves_date);
			} else {
				$date_to 	= $end_date;
				$diff_date  = strtotime($leave_date) - strtotime($end_date);
				$date_count = abs(round($diff_date / 86400));
			}
		} else {
			$date_type = 'N/A';
			$date_to   = 'N/A';
		}

		$dataInsert = array(
			'emp_id' 	   => $userID,
			'date_request' => date('Y-m-d'),
			'date_from'    => $leave_date,
			'date_type'    => $date_type,
			'date_to' 	   => $date_to,
			'total_leaves' => $date_count,
			'reason' 	   => $reason,
			'leave_type'   => $leave_type,
			'status' 	   => 0
		);

		$this->db->insert('emp_leaves', $dataInsert);

		redirect('member/leaves');
	}

	public function payroll($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}
		
		if($method == 'time_out') {
			$status = $this->verify_user->process_time_out();

			date_default_timezone_set("Asia/Karachi");
			if($status == 1) {
				$data['status']   = 1;
				$data['dataHtml'] = '<h4><i class="mdi mdi-clock"></i> Timed Out At : '.date('H:i:s A').'</h4>';
			} else {
				$data['status'] 	 = 0;
				$data['dataMessage'] = '<div class="message"><i class="fa fa-times-circle"></i> Your shift time is not over you cannot <strong>Clock Out</strong> Please contact your reporting authority to clock out early.</div>';
			}

			echo json_encode($data);
			exit;
		} else {
			$data['title'] = 'My Salary Statement';
			$data['salaryData'] = $this->db->get_where('salary_statement', array('emp_id' => $this->session->userdata('user_id')))->result();

			$page = 'salary';
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function submit_work($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}
		
		$data['title'] = 'Submit Daily Report';
		$data['reportData'] = $this->db->get_where('daily_report', array('userID' => $this->session->userdata('user_id')))->result();

		$page = 'submit-work';

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function submitDailyReport() {
		$title	     = $this->input->post('title');	
		$description = $this->input->post('description');
		$userID  	 = $this->session->userdata('user_id');

		$config['upload_path'] = getcwd() . '/assets/uploads/users/user-' . $userID; 

		$file     = $_FILES['attachment']['name'];
		$filesize = $_FILES['attachment']['size'];
		$location = $config['upload_path'].'/'.$file;

		$return_arr = array();
		$dataInsert = array(
			'title' => $title,
			'description' => $description,
			'userID' => $userID,
			'date_posted' => date('Y-m-d')
		);
		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['attachment']['tmp_name'],$location)){
			    $dataInsert['filename'] = $file;
			}
		} else {
			$dataInsert['filename'] = '';
		}

		$condition = '';

		//If ID exist and not empty updaet tournament data
		if(!empty($id)) {
			$condition = array('id' => $id);
		} 
			
		$this->process_data->create_data('daily_report', $dataInsert, $condition);
		
		redirect('member/submit-work');	
	}

	public function projects($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('member/login');
		}

		$user_role = $this->session->userdata('user_role');

		if($user_role < 8) {
			redirect('member/login');
		}
		
		$data['meta'] = $this->process_data;
		
		if($method == 'view') {
			$data['title'] = 'View Project';
			$data['projectsData'] = $this->process_data->get_data('agent_tasks', array('id' => $id));
			$data['projectMessages'] = $this->process_data->geT_data('project_comments', array('projectID' => $id));

			$query_activity = "SELECT * FROM activity_log WHERE act_id = '" . $id . "' AND act_type = 'agent-task'";
			$data['activityLog']  = $this->db->query($query_activity)->result();

			$page = 'view-project';
		} else {
	 		$data['title'] = 'Manage Projects';
			$data['agentTask'] = $this->process_data->get_data('agent_tasks');

			$page = 'manage-projects';
		}

		$this->load->view('app/includes/header', $data);
		$this->load->view('app/'.$page, $data);
		$this->load->view('app/includes/footer');
	}

	public function updateProjectStage() {
		$stage 	    = $this->input->post('newStage');
		$curStage   = $this->input->post('currentStage');
		$projectID  = $this->input->post('projectID');

		$this->process_data->create_data('agent_tasks', array('status' => $stage), array('id' => $projectID));

		if($stage == 1) {
			$percentage = 0;
		} else {
			$percentage = number_format((100 / 5) * $stage);
		}

		$stageStatus = array(
			'1' => 'New Project', 
			'2' => 'In Progress', 
			'3' => 'Available To Review',
			'4' => 'Revisions Requested',
			'5' => 'Completed'
		);

		//Get username
		$userID   = $this->session->userdata('user_id');
		$username = $this->process_data->get_username($userID);

		//Creating Activity
		$descriptionUser = 'Project Reff #DSO-' . $projectID . ' Status Changed from ' . $stageStatus[$curStage] . ' to ' .  $stageStatus[$stage] . ' By ' . $username;

		$dataActivity = array(
			'act_id' 		=> $projectID,
			'description' 	=> $descriptionUser,
			'date_activity' => date('Y-m-d H:i:s'),
			'act_type'		=> 'agent-task',
			'user_id'		=> $userID
		);

		$this->process_data->create_activity($dataActivity);

		echo json_encode(array('percentage' => $percentage));
	}

	public function processProjectFile() {
		$projectID  = $this->input->post('projectID');
		$folder  = getcwd() . '/assets/uploads/projects/project-' . $projectID;
		
		$filename 	 = $_FILES["file"]["name"];
		$source 	 = $_FILES["file"]["tmp_name"];
		$target_file = $folder . '/' . $filename;

		$temp = explode(".", $_FILES["file"]["name"]);
		$newfilename = strtolower(round(microtime(true)) . '.' . end($temp));
		$fileUpload = $folder . '/' . $newfilename;

		echo '<input type="hidden" name="fileName[]" class="filename" value="' . $newfilename . '" />';
	}

	public function postProjectComment() {
		$projectID 	  = $this->input->post('projectID');
		$comment   	  = $this->input->post('comment');
		$projectFiles = $this->input->post('fileName');
		$filesUpload  = serialize($projectFiles);

		$dataInsert = array(
			'projectID'   => $projectID,
			'senderID'	  => $this->session->userdata('user_id'),
			'receiverID'  => 0,
			'comment'	  => $comment,
			'files_data'  => $filesUpload,
			'date_posted' => date('Y-m-d H:i:s')
		); 

		$this->process_data->create_data('project_comments', $dataInsert);

		//Get User Data
		$userID   = $this->session->userdata('user_id');
    	$userData = $this->process_data->get_data('users', array('id' => $userID));

    	echo '<div class="comment">
				<div class="thumb"><i class="fa fa-user"></i></div>
				<div class="comment-content">
					<h4>
						<a href="'.base_url().'profile/'.$userData[0]->username.'">'.$userData[0]->first_name . ' ' . $userData[0]->last_name . '</a>
						<span><i class="fa fa-calendar-alt"></i> '.date('F d') .','.date('Y') . ' at '. date('h:i:s A').'</span>
					</h4>

					<p>'.$comment.'</p>
					';

					if(!empty($projectFiles) > 0) {
					echo '<div class="project-files">
                        <ul>';
                        $folder = base_url() . 'assets/uploads/projects/project-' . $projectID;
                        foreach($projectFiles as $file):
                            echo '<li>
                                <div class="files-box">
                                    <i class="icon-paper-clip"></i>
                                    <span><a href="'.$folder.'/'.$file.'" download="">'.$file.'</a></span>
                                </div>
                            </li>';
                        endforeach;
                        echo '</ul>
                    </div>';
                }
				echo '</div>
			</div>';
	}

	public function test() {
		// $data_capture = $this->process_data->get_employee();

		// echo '<pre>';
		// print_r($data_capture);
		// echo '</pre>';

		$date_1 = strtotime('18:42:57');
		$date_2 = strtotime('18:44:55');

		$hours = abs($date_2 - $date_1) / 3600;
		echo $hours;
	}
}