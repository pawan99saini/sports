<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['site_visits']   = $this->db->get_where('site_visits');
		$data['total_players'] = $this->db->get_where('users', array('role' => 4))->num_rows();
		$data['total_teams'] = $this->db->get_where('users', array('role' => 5))->num_rows();	
		$data['active_tournaments'] = $this->db->get_where('tournament', array('status' => 1))->num_rows();
		$data['inactive_tournaments'] = $this->db->get_where('tournament', array('status' => 0))->num_rows();

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/dashboard');
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function login() {
		$data = array(
			'title' => 'Admin - Login' 
		);

		$this->load->view('admin/login');
	}

	public function loginprocess() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$status = $this->verify_user->login_user(array(
			'username' => $username,
			'password' => md5($password) 
		));

		$url = base_url() . 'admin';

		if($status == false) {
			$data_return =array(
					'status'  => 0,
					'message' => '<div class="message"><i class="icon ion-ios-close-circle-outline"></i> Invalid username / password provided</div>', 
				);
		} else {
			$data_return =array(
					'status'  => 1,
					'url' 	  => $url, 
					'message' => '<div class="message"><i class="icon ion-ios-checkmark-circle-outline"></i> Success</div>', 
				);
		}

		echo json_encode($data_return);
	}

	public function logout() {
		$userID = $this->session->userdata('user_id');
		$this->verify_user->processLogout($userID);

		redirect('admin/login');
	}

	public function games($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'categories') {
			$data['title'] = 'Categories';

			$data['categoriesData'] = $this->process_data->get_data('categories');

			$page = 'categories'; 
		} elseif($method == 'delete') {
			$this->db->where('game_id', $id)->delete('games');
			redirect('admin/games');	
		} elseif($method == 'create') {
			$data['title'] = 'Create Game';

			$data['categoriesData'] = $this->process_data->get_data('categories');
			$data['id']				= $id;

			$data['game_title'] = '';
			$data['filename']   = '';
			$data['categoryID']   = '';
			$data['status'] = '';

			if($id != null) {
				$gameData = $this->process_data->get_games($id);

				$data['game_title'] = $gameData[0]->game_name;
				$data['filename']	= $gameData[0]->game_image;
				$data['categoryID']	= $gameData[0]->category_id;
				$data['status']	= $gameData[0]->status;
			}

			$page = 'create-game'; 
		} else {
			$data['title'] = 'Games';

			$data['gamesData'] 	= $this->process_data->get_games();

			$page = 'games'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function create_category() {
		$title 	  	 = $this->input->post('title');
		$status   	 = $this->input->post('status');	
		$description = $this->input->post('description');
		$id 	  	 = $this->input->post('id');
		$filename 	 = $this->input->post('icon_filename');

		$config['upload_path'] = getcwd() . '/assets/frontend/images/games/categories/'; 

		$file     = $_FILES['icon']['name'];
		$filesize = $_FILES['icon']['size'];
		$location = $config['upload_path'].$file;

		$return_arr = array();

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['icon']['tmp_name'],$location)){
			    $dataInsert['filename'] = $file;
			}
		} else {
			$dataInsert['filename'] = $filename;
		}

		if(!empty($id)) {
			$id = array('id' => $id);
		}

		$slug = $this->process_data->slugify($title);
		
		$this->process_data->create_data('categories', 
			array(
				'title' => $title,
				'description' => $description,
				'image' => $dataInsert['filename'], 
				'status' => $status,
				'slug' => $slug
			), $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Record '.$status.' Successfully.</div>');

		redirect('admin/games/categories');
	} 

	public function createGame() {
		$title	  = $this->input->post('game_title');	
		$category = $this->input->post('category');
		$id		  = $this->input->post('id');
		$filename = $this->input->post('filename');
		$status = $this->input->post('status');

		$config['upload_path'] = getcwd() . '/assets/frontend/images/games/'; 

		$file     = $_FILES['game_image']['name'];
		$filesize = $_FILES['game_image']['size'];
		$location = $config['upload_path'].$file;

		$return_arr = array();

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['game_image']['tmp_name'],$location)){
			    $dataInsert['filename'] = $file;
			}
		} else {
			$dataInsert['filename'] = $filename;
		}

		if(!empty($id)) {
			$id = array('game_id' => $id);
		}

		$game_slug = $this->process_data->slugify($title);

		$this->process_data->create_data('games', 
			array(
				'game_name' => $title,
				'category_id' => $category,
				'game_image' => $dataInsert['filename'], 
				'slug' => $game_slug,
				'status' => $status
			), $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Game '.$status.' Successfully.</div>');

		redirect('admin/games');
	}

	public function deleteGameCategory($id) {
		$this->db->where('id', $id)->delete('categories');

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Category Deleted Successfully.</div>');

		redirect('admin/games/categories');
	}

	public function spectator_request($tournamentID = null, $method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'view') {
			$data['title'] = 'Create User';

			$data['id'] = $id;

			$spectatorData = $this->process_data->get_data('application', array('id' => $id));

			$data['spectatorData'] = $spectatorData;
	
			$page = 'view-spectator-application'; 
		} else {
			$data['title'] = 'Spectator Requests';

			$data['tournamentData'] = $this->process_data->get_data('tournament');

			$page = 'spectator-requests'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function getApplications() {
		$tournamentID = $this->input->post('tournamentID');

		$applicationsData = $this->process_data->get_data('application', array('tournamentID' => $tournamentID));

		$data['applicationsData'] = $applicationsData;

		$this->load->view('admin/admin-new/spectator-application', $data);
	}

	public function viewSpectatorApplication($id = null) {
		$data['id'] = $id;

		$spectatorData = $this->process_data->get_data('application', array('id' => $id));

		$data['spectatorData'] = $spectatorData;

		$this->load->view('admin/admin-new/view-spectator-application', $data);
	}

	public function teams($method = null, $id = null, $fieldID = null, $teamID = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['meta'] = $this->process_data;

		if($method == 'recruitment') {
			$data['title'] = 'Recruitment';

			$data['teamsData'] = $this->process_data->get_data('teams');
			$data['teamID']    = 0;

			if($fieldID != null) {
				if($id == 'delete') {
					$applicationData = $this->process_data->get_data('team_application', array('id' => $fieldID));
					$this->db->where(array('id' => $fieldID))->delete('team_application');
					$this->db->where(array('appID' => $fieldID))->delete('team_application_field_values');

					redirect('admin/teams/recruitment?teamID=' . $applicationData[0]->teamID);	
				} else {
					$data['applicationData'] = $this->process_data->get_data('team_application', array('id' => $fieldID));
					$data['fieldsData']   = $this->process_data->get_data('team_application_field_values', array('appID' => $data['applicationData'][0]->id));
					$data['teamID'] = $data['applicationData'][0]->teamID;

					$page = "view-team-application";
				}
			} else {
				if($this->input->get('teamID') == true) {
					$teamID = $this->input->get('teamID');
					$data['teamID']   = $teamID;
					$data['getTeamData'] = $this->process_data->get_data('teams', array('ID' => $teamID));
					$data['teamApplications'] = $this->process_data->get_data('team_application', array('teamID' => $teamID));
					$data['metaFieldsData'] = $this->process_data->get_data('team_application_fields', array('teamID' => $teamID));
				}

				$page = 'team-recruitment-applications';
			} 
		} elseif($method == 'delete') {
			$this->db->where('ID', $id)->delete('teams');
			redirect('admin/teams');	
		} elseif($method == 'fields') {
			$data['title'] = 'Manage Fields';

			if($id == null) {
				$data['teamsData'] = $this->process_data->get_data('teams');
			} else {
				if($id == 'delete') {
					$this->db->where('ID', $fieldID)->delete('team_application_fields');
					redirect('admin/teams/fields/'.$teamID);
				} else {
					$data['teamData'] = $this->process_data->get_data('teams', array('ID' => $id));
					$data['fieldsData'] = $this->process_data->get_data('team_application_fields', array('teamID' => $id));
				}
			}

			$data['id'] = $id;

			$page = 'manage-form-fields'; 
		} else {
			$data['title'] = 'Teams';

			$data['teamsData'] = $this->process_data->get_data('teams');

			$page = 'teams'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function create_team() {
		$title 	  	 = $this->input->post('title');
		$status   	 = $this->input->post('status');	
		$id 	  	 = $this->input->post('id');
		$filename 	 = $this->input->post('icon_filename');

		$config['upload_path'] = getcwd() . '/assets/uploads/teams-recruitment/'; 

		$file     = $_FILES['icon']['name'];
		$filesize = $_FILES['icon']['size'];


		$return_arr = array();

		$updateTeamID = '';

		if(!empty($id)) {
			$updateTeamID = array('ID' => $id);
		}

		$slug = $this->process_data->slugify($title);

		$checkSlug = $this->db->query("SELECT * FROM tournament WHERE slug LIKE '%" .$slug . "%'");
		
		if($checkSlug->num_rows() > 0) {
			$count = $checkSlug->num_rows();
			$slug = $slug . '-' . $count;
		}
		
		$filename = ($file == '') ? $filename : $file;

		$teamID = $this->process_data->create_data('teams', 
			array(
				'title'  => $title, 
				'status' => $status,
				'slug'   => $slug
			), $updateTeamID);

		if(!empty($id)) {
			$teamID = $id;
		}

		$folderPath = $config['upload_path'] . 'team-' . $teamID;

		if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true); 
        } 

		/* Upload file */
		if(!empty($file)) {
			$temp = explode(".", $_FILES["icon"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $folderPath . '/' . $newfilename)){
			    $filename = $newfilename;

			    $this->process_data->create_data('teams', 
				array(
					'thumbnail'  => $filename
				), array(
					'ID' => $teamID
				));
			}
		}		

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Record '.$status.' Successfully.</div>');

		redirect('admin/teams');
	} 

	public function create_field() {
		$field_type   = $this->input->post('field_type');
		$field_label  = $this->input->post('field_name');	
		$placeholder  = $this->input->post('placeholder');
		$is_required  = $this->input->post('is_required');
		$is_required  = ($is_required == '') ? 0 : 1;
		$field_values = $this->input->post('field_values'); 
		$teamID 	  = $this->input->post('teamID'); 
		$id 	 	  = $this->input->post('id'); 

		$arr_values = array('radio', 'select', 'checkbox');
                                        	
    	if(in_array($field_type, $arr_values)) {
    		$field_values = serialize(preg_split('/\n|\r\n/', $field_values));
    	}

		if(!empty($id)) {
			$id = array('ID' => $id);
		}

		$field_name = strtolower(str_replace(' ', '_', $field_label));
		$field_name = preg_replace('/[^A-Za-z0-9\-]/', '', $field_name);

		$this->process_data->create_data('team_application_fields', 
			array(
				'teamID'  			=> $teamID,
				'field_type'  		=> $field_type, 
				'field_label' 		=> $field_label,
				'field_name' 		=> $field_name,
				'placeholder_text' 	=> $placeholder,
				'teamID'  			=> $teamID,
				'field_values'  	=> $field_values, 
				'is_required' 		=> $is_required,
			), $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Record '.$status.' Successfully.</div>');

		redirect('admin/teams/fields/'.$teamID);
	} 

	public function valorant_recruitment($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

        $data = array(
            'title' => 'Valorant Recruitment',
            'class' => 'inner' 
        );

        if($method == null) {
        	$sql = "SELECT * FROM valorant_applciation ORDER BY id DESC";
	        $data['valorantData'] = $this->db->query($sql)->result();
	    }

	    if($method == 'edit') {
	    	$data['id'] = $id;
	        $valorantData = $this->process_data->get_data('valorant_applciation', array('id' =>$id));
	        $data['first_name'] = $valorantData[0]->first_name;
	        $data['last_name'] = $valorantData[0]->last_name;
	        $data['username'] = $valorantData[0]->username;
	        $data['valorant_rank'] = $valorantData[0]->valorant_rank;
	        $data['valorant_name'] = $valorantData[0]->valorant_name;
	        $data['age'] = $valorantData[0]->age;
	        $data['email'] = $valorantData[0]->email;
	        $data['phone'] = $valorantData[0]->phone;
	    }

	    if($method == 'delete') {
	    	$this->db->where('id', $id)->delete('valorant_applciation');
			
			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Application Deleted Successfully.</div>');

			redirect('admin/valorant-recruitment');
	    }

        $this->load->view('admin/admin-new/includes/header', $data);
        $this->load->view('admin/admin-new/valorant-recruitment', $data);
        $this->load->view('admin/admin-new/includes/footer');
    }

    public function updateRCapplicaiton() {
    	$first_name 	  	 = $this->input->post('first_name');
		$last_name   	 = $this->input->post('last_name');	
		$username = $this->input->post('username');
		$valorant_rank 	  	 = $this->input->post('valorant_rank');
		$valorant_name   	 = $this->input->post('valorant_name');	
		$age = $this->input->post('age');
		$email 	  	 = $this->input->post('email');
		$phone   	 = $this->input->post('phone');	
		$id 	  	 = $this->input->post('id');

		$datapost = array(
			'first_name' 	  => $first_name,
			'last_name' 	  => $last_name,
			'username' => $username,
			'valorant_rank' 	  => $valorant_rank,
			'valorant_name' 	  => $valorant_name,
			'age' 	  => $age,
			'email' => $email,
			'phone' 	  => $phone,
		);
	
		$this->process_data->create_data('valorant_applciation', $datapost, $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Valorant Application '.$status.' Successfully.</div>');

		redirect('admin/valorant-recruitment');
    }

    public function getPhoneValorant($methodID = null) {
	    $id = $methodID;

	    if($methodID == null) {
	    	$id = $this->input->post('id');
	    }

	    $valorantData = $this->process_data->get_data('valorant_applciation', array('id' => $id));

	    if($methodID == null) {
	    	echo $valorantData[0]->phone;
	    } else {
		    return $valorantData[0]->phone;
		}
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

		redirect('admin/spectator-requests');
	}

	public function tournaments($method = null, $id = null, $arrg_type = null, $arrg_id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['ci'] 	= $this->process_data;

		if($method == 'categories') {
			$data['title'] = 'Categories';

			$data['categoriesData'] = $this->process_data->get_data('categories');

			$page = 'categories'; 
		} elseif($method == 'create') {
			$data['title'] = 'Create Game';

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
			$data['bracket_system'] = '';
			$data['status'] = '';
			$data['max_players'] = '';
			$data['max_spectators'] = '';
			$data['req_credits'] = '';
			$data['tournament_meta'] = '';
			$data['type'] = '';
			$data['match_type'] = '';
			$data['max_team_players'] = '';

			if($id != null) {
				$tournamentData = $this->process_data->get_tournaments(array('tournament.id' => $id));

				$data['title'] 		 = $tournamentData[0]->title;
				$data['category_id'] = $tournamentData[0]->category_id;
				$data['game_id']     = $tournamentData[0]->game_id;
				$data['description'] = $tournamentData[0]->description;
				$data['region'] 	 = $tournamentData[0]->region;
				$data['date'] 		 = $tournamentData[0]->organized_date;
				$data['time'] 		 = $tournamentData[0]->time;
				$data['format'] 	 = $tournamentData[0]->format;
				$data['game_map'] 	 = $tournamentData[0]->game_map;
				$data['title'] 		 = $tournamentData[0]->title;
				$data['filename'] 	 = $tournamentData[0]->image;
				$data['rules'] 		 = $tournamentData[0]->rules;
				$data['schedule'] 	 = $tournamentData[0]->schedule;
				$data['contact'] 	 = $tournamentData[0]->contact;
				$data['max_players'] 	= $tournamentData[0]->max_allowed_players;
				$data['max_spectators'] = $tournamentData[0]->max_allowed_spectators;
				$data['req_credits']   = $tournamentData[0]->req_credits;
				$data['status'] 	 = $tournamentData[0]->status;
				$data['bracket_system'] = $tournamentData[0]->brackets;
				$data['type'] = $tournamentData[0]->type;
				$data['match_type'] = $tournamentData[0]->allowed_participants;
				$data['max_team_players'] = $tournamentData[0]->max_team_players;

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

			redirect('admin/tournaments');
		} elseif($method == 'notice-board') {
			if($id == null) {
				$data['notice'] = false;

				$data['tournamentsData'] = $this->process_data->get_tournaments();
				$page = 'notice-board';	
			} else {
				$data['notice'] = true;
				$data['tournamentID'] = $id;
				$data['tournamentsData'] = $this->process_data->get_tournaments(array('tournament.id' => $id));
				$data['announcmentsData'] = $this->process_data->get_data('tournament_notice', array('tournamentID' => $id));

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

					redirect('admin/tournament/notice-board/' . $id);
				}
			}
		} elseif($method == 'participants') {
			$data['participents'] = $this->process_data->get_participents($id);

			$page = 'participants'; 
		} else {
			$data['title'] = 'Toournaments';

			$data['tournamentsData'] = $this->process_data->get_tournaments();

			$page = 'tournaments'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function createTournament() {
		$title	     = $this->input->post('title');	
		$category    = $this->input->post('category');
		$description = $this->input->post('description');
		$game_id 	 = $this->input->post('game_id');
		$category_id = $this->input->post('category_id');
		$region	  	 = $this->input->post('region');	
		$date 		 = $this->input->post('date');
		$time		 = $this->input->post('time');
		$format      = $this->input->post('format');
		$game_map	 = $this->input->post('game_map');	
		$rules 		 = $this->input->post('rules');
		$schedule	 = $this->input->post('schedule');
		$contact 	 = $this->input->post('contact');
		$status 	 = $this->input->post('tournament_status');
		$bracket 	 = $this->input->post('bracket_req');
		$match_type  = $this->input->post('match_type');
		$max_players = $this->input->post('max_team_players');
		$type 		 = $this->input->post('type');
		$id		  	 = $this->input->post('id');
		$filename 	 = $this->input->post('filename');
		$meta_title  = $this->input->post('placement');
		$meta_value  = $this->input->post('prize');

		$stat_title  = $this->input->post('stat_title');
		$stat_value  = $this->input->post('stat_value');

		$max_players  	= $this->input->post('max_players');
		$max_spectators = $this->input->post('max_spectators');
		$req_credits = $this->input->post('req_credits');

		$config['upload_path'] = getcwd() . '/assets/frontend/images/tournaments/'; 

		$file     = $_FILES['tournament_image']['name'];
		$filesize = $_FILES['tournament_image']['size'];

		$return_arr = array();

		$temp = explode(".", $_FILES["tournament_image"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$location = $config['upload_path'].$newfilename;

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['tournament_image']['tmp_name'],$location)){
			    $dataInsert['filename'] = $newfilename;
			}
		} else {
			$dataInsert['filename'] = $filename;
		}

		if(!empty($id)) {
			$t_id = array('id' => $id);
		}

		//Create Slug 
		$slug = $this->process_data->slugify($title);

		//If ID exist and not empty updaet tournament data
		if($id == null) {
			$checkSlug = $this->db->query("SELECT * FROM tournament WHERE slug LIKE '%" .$slug . "%'");
		
			if($checkSlug->num_rows() > 0) {
				$count = $checkSlug->num_rows();
				$slug = $slug . '-' . $count;
			}

			$tournamentID = $this->process_data->create_data('tournament', 
				array(
					'game_id' => $game_id,
					'category_id' => $category_id,
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
					'brackets' => $bracket,
					'status' => $status,  
					'max_allowed_players' => $max_players, 
					'max_allowed_spectators' => $max_spectators,
					'allowed_participants' => $match_type,
					'max_team_players' => $max_players,
					'req_credits' => $req_credits,
					'slug' => $slug
				));

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
			$this->process_data->create_data('tournament', 
			array(
				'game_id' => $game_id,
				'category_id' => $category_id,
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
				'status' => $status,  
				'brackets' => $bracket,
				'type' => $type,
				'max_allowed_players' => $max_players, 
				'max_allowed_spectators' => $max_spectators,
				'allowed_participants' => $match_type,
				'max_team_players' => $max_players,
				'slug' => $slug
			), array('id' => $id));

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
				$this->process_data->create_data('tournament_meta', $dataTournament, array(
					'id' => $checkData->row()->id));

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

		redirect('admin/tournaments');
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

		redirect('admin/tournaments/notice-board/' . $tournamentID);
	}

	public function updateTournamentStatus() {
		$user_id = $this->session->userdata('user_id');
		$id 	 = $this->input->post('id');	
		$status  = $this->input->post('status');	

		$dataUpdate = array(
			'mode' => $status,
		);

		$this->process_data->create_data('tournament', $dataUpdate, array('id' => $id));
	}

	public function deleteParticipent($tournamentID, $participantID) {
		$this->db->where('id', $participantID)->delete('tournament_players');

		redirect('admin/tournaments/participants/' . $tournamentID);
	}

	public function matches($method = null, $tournamentID = null, $arrg = null, $round = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$user_id = $this->session->userdata('user_id');

		$data['tournamentData'] = $this->process_data->get_data('tournament');
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

				redirect('admin/matches/manage/'.$tournamentID);
			} else {
				if($arrg != 'round') {
					$round = 1;
				}

				$param = '';

				$data['activeRound'] 	= $round;
				$data['tournamentData'] = $this->process_data->get_data('tournament', array('id' => $tournamentID));
				$data['playersData']    = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
				$data['matchesData'] 	= $this->process_data->get_matches($tournamentID, $round);
				$data['totalRounds']	= $this->process_data->get_rounds($tournamentID); 
				$data['active_url']	    = base_url() . 'admin/matches/manage/' . $tournamentID . $param;
				$data['specApplication'] = $this->process_data->get_data('application', array(
						'tournamentID' => $tournamentID,
						'status' => 2
					));

				//Getting lists for manual tournament
				//Get new lists of players 
				$getPlayers = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));
		        
		        $query = "SELECT * FROM tournament_players";
		        
		        $setDisabled = 0;
		        $playerID 	 = 0;

		        if($data['tournamentData'][0]->type == 1) {
			        $getRound = 0;
			        if(count($getPlayers) > 0) { 
				        $exclude_player = array();
				        //Check if game round 1 has been completed
				        $checkRound = "SELECT round FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND winnerID > 0 GROUP BY round ORDER BY id DESC LIMIT 1";
				        $checkRound = $this->db->query($checkRound)->result();
				       
				        $getRound = count($checkRound) > 0 ? $checkRound[0]->round : 0;
				       
				        foreach($getPlayers as $player):
				        	if($player->winnerID == 0) {
					            $exclude_player[] = $player->player_1_ID;
					            $exclude_player[] = $player->player_2_ID;

					            if($player->player_2_ID == 0) {
					            	$setDisabled = 1;
					            	$playerID 	 = $player->player_1_ID; 
					            }
					        } else {
					        	if($player->winnerID == $player->player_1_ID) {
						        	$looserID[] = $player->player_2_ID;
						        } else {
						        	$looserID[] = $player->player_1_ID;
						        }
					        }
				        endforeach;

				        if(isset($looserID)) {
				        	$exclude_player = array_merge($exclude_player, $looserID);
				        	$exclude_player = implode(',', $exclude_player);
				        	$query2 = $query . " WHERE participantID NOT IN (".$exclude_player.")";
					    	$data['playersList2'] = $this->db->query($query2)->result();
				        } else {
				        	$exclude_player = implode(',', $exclude_player);
				    	}

				    	if($setDisabled == 1) {
				    		$playersTerm = str_replace($playerID . ',', '', $exclude_player);
					    	$query2 = $query . " WHERE participantID NOT IN (".$playersTerm.")";
					    	$data['playersList2'] = $this->db->query($query2)->result();
					    }

					    if($exclude_player != '') {
				        	$query .= " WHERE participantID NOT IN (".$exclude_player.")";
				        }
				    } else {
				    	$exclude_player = '';
				    }

			        $playersList = $this->db->query($query)->result();

			        $data['playersList'] = $playersList;
			        $data['setDisabled'] = $setDisabled;
			        $data['playerID']	 = $playerID;
			        $data['getRound']	 = $getRound + 1;
			    } else {

			    }
			}

			$page = 'matches'; 
		} else {
			$data['title'] = 'Manage Matches';

			$page = 'matches'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function create_manual_match() {
		$tournamentID = $this->input->post('tournamentID');
		$player_1 	  = $this->input->post('player_1');
		$player_2 	  = $this->input->post('player_2');
		$player   	  = $this->input->post('value_player');
		$round 		  = $this->input->post('round');

		if($player == 'player_1') {
			//Creating match 
            $dataInsert = array(
                'tournamentID' => $tournamentID,
                'player_1_ID'  => $player_1,
                'player_2_ID'  => $player_2,
                'round'        => $round,
                'winnerID'     => 0,
                'status'       => 1
            );

            $this->process_data->create_data('tournament_matches', $dataInsert);
            $dataReturn['matchResult'] = 0;
            $getMatchData = array();
		} else {
			$checkMatch = $this->process_data->get_data('tournament_matches', 
				array(
					'tournamentID' => $tournamentID, 
					'player_1_ID' => $player_1
				)
			);

	        $matchID = $checkMatch[0]->id;
            $dataInsert = array(
                'player_2_ID'  => $player_2
            );

            $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
            $dataReturn['matchResult'] = 1;
            $getMatchData = $this->process_data->get_data('tournament_matches',  array('id' => $matchID));
		}

		//Get new lists of players 
		$getPlayers = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID));
        
        $exclude_player = array();
        foreach($getPlayers as $player):
        	if($player->winnerID == 0) {
	            $exclude_player[] = $player->player_1_ID;
	            $exclude_player[] = $player->player_2_ID;
	        }
        endforeach;
  
        $exclude_player = implode(',', $exclude_player);
        
        $query  = "SELECT * FROM tournament_players";

        if($exclude_player != '') {
        	$query .= " WHERE participantID NOT IN (".$exclude_player.")";
        }

        $playersList = $this->db->query($query)->result();

        $dataHTML = '<div class="form-group">
                        <label>Player 2</label>
                        <select class="form-control player-select" name="player_2">
                            <option value="">Select Player</option>';
        foreach($playersList as $player):
        	$player_username = $this->process_data->get_username($player->participantID); 
            $dataHTML .= '<option value="'. $player->participantID .'">';
            $dataHTML .= $player_username; 
            $dataHTML .= '</option>';
        endforeach;

        $dataHTML .= '</select>
         				</div>';
		
		$dataReturn['players'] = $dataHTML;

		if($dataReturn['matchResult'] == 1) {
			$matchData  = '<tr class="row-match-'.$getMatchData[0]->id.'">';
			$matchData .= '<td>'.$getMatchData[0]->id.'</td>';

			$player_1_username = $this->process_data->get_username($getMatchData[0]->player_1_ID);
            $player_2_username = $this->process_data->get_username($getMatchData[0]->player_2_ID);

            $matchData .= '<td>';
            $matchData .= '<span>' . $player_1_username . '</span>';

            if($getMatchData[0]->winnerID > 0) {
                if($getMatchData[0]->winnerID == $getMatchData[0]->player_1_ID) {
                    $matchData .= "<label class='badge badge-success'>Winner</label>";
                } else {
                    $matchData .= "<label class='badge badge-danger'>Loser</label>";
                }
            }
     
            $matchData .= '</td>';
            $matchData .= '<td>';
            
            if($getMatchData[0]->player_2_ID > 0) { 
                $matchData .= '<span>' . $player_2_username . '</span>';
                                                  
                if($getMatchData[0]->winnerID > 0) {
                    if($getMatchData[0]->winnerID == $getMatchData[0]->player_2_ID) {
                        $matchData .= "<label class='badge badge-success'>Winner</label>";
                    } else {
                        $matchData .= "<label class='badge badge-danger'>Loser</label>";
                    }
                }
            } else {
                $matchData .= 'N/A';
            }
                            
            $matchData .= '</td>';
            $matchData .= '<td>' . $getMatchData[0]->round . '</td>';
            $matchData .= '<td>';
            
            if($getMatchData[0]->winnerID == 0) {  
            	$matchData .= '<select class="form-control setWinner">';
                $matchData .= '<option value="0">Select Winner</option>';
                
                if($getMatchData[0]->player_2_ID > 0) {
                    $matchData .= '<option value="' . $getMatchData[0]->player_1_ID . '" data-id="' . $getMatchData[0]->id . '" data-round="' . $getMatchData[0]->round . '">' . $player_1_username . '</option>';
                    $matchData .= '<option value="' . $getMatchData[0]->player_2_ID . '" data-id="' . $getMatchData[0]->id . '" data-round="' . $getMatchData[0]->round . '">' . $player_2_username . '</option>';
                }
				
				$matchData .= '</select>';
            } else { 
                $matchData .= "<label class='badge badge-info'>Match Completed</label>";
            }
            
            $matchData .= '</td>';
			$matchData .= '</tr>';

			$dataReturn['matchID']   = $getMatchData[0]->id;
			$dataReturn['matchData'] = $matchData; 
		}       

		echo json_encode($dataReturn);
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

		//Check if in round 2 any player exist or not
		$getMatchData = $this->process_data->get_data('tournament_matches', array(
			'tournamentID' => $tournamentID,
			'round'		   => $newRound
		));

		if(count($getMatchData) > 0) {
			foreach($getMatchData as $match):
				if($match->player_2_ID == 0) {
					$matchID = $match->id;
                    $dataInsert = array(
                        'player_2_ID'  => $player_id
                    );

                    $this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $matchID));
					break;
				}
			endforeach;
		} else {
			//Creating match 
            $dataInsert = array(
                'tournamentID' => $tournamentID,
                'player_1_ID'  => $player_id,
                'player_2_ID'  => 0,
                'round'        => $newRound,
                'winnerID'     => 0,
                'status'       => 1
            );

            $this->process_data->create_data('tournament_matches', $dataInsert);
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
        echo '<td>' . $newRound . '</td>';
        echo '<td>';
        echo "<label class='badge badge-info'>Match Completed</label>";        
        echo '</td>';
	}

	public function setScore() {
		$batchID = $this->input->post('batchID');
		$score   = $this->input->post('score');

		$this->process_data->create_data('tournament_matches', 
			array("points" => $score), 
			array('id' => $batchID)
		);

		echo $score;
	}

	public function eliminatePlayer() {
		$batchID = $this->input->post('batchID');

		$this->process_data->create_data('tournament_matches', 
			array("status" => 0), 
			array('id' => $batchID)
		);

		$html = '<span class="badge badge-danger">Eliminated</span>';

		echo $html;
	}

	public function newsletter($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'create') {
			$data['title'] = 'Create Article';
			$data['id']	   = $id;

			$data['title']  = '';
			$data['answer'] = '';
			$data['status'] = '';
			$data['category_id'] = '';

			$data['categoriesData'] = $this->process_data->get_data('article_categories');

			if($id != null) {
				$articlesData = $this->process_data->get_data('support_articles', array('id' => $id));

				$data['title']  = $articlesData[0]->title;
				$data['answer']	= $articlesData[0]->answer;
				$data['category_id'] = $articlesData[0]->category_id;
				$data['status'] = $articlesData[0]->status;
			}

			$page = 'create-article';
		} elseif($method == 'delete') {
			$this->db->where('id', $id)->delete('support_articles');
			
			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Article Deleted Successfully.</div>');

			redirect('admin/articles');
		} elseif($method == 'categories') {
			$data['categoriesData'] = $this->process_data->get_data('article_categories');
			$page = 'article-categories'; 

		} elseif($method == 'categories' && $id == 'delete') {	
			$this->db->where('id', $ct_id)->delete('article_categories'); 
		} else {
			$data['title'] = 'Newsletter';

			$data['emailTemplate'] = $this->process_data->get_data('email_notification', array('id' => 5));

			$page = 'newsletter'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function sendNewsletter() {
		$subject = $this->input->post('subject');
		
		$email_content = $this->input->post('email_content');
		
		$email_type = $this->input->post('email_type');
		$email_user = $this->input->post('email_user');

		$email_message = $this->process_data->newsletter_tempalate($email_content);

		$from     = "no-reply@dsoesports.org";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;
		
		if($email_type == 'single') {
			if(mail($this->input->post('email_user_single'),$subject,$email_message,$headers)) {
            	echo "Email Sent";
            } else {
            	echo "Not Found";
            }
		}	

		if($email_type == 'multiple') {
			foreach($email_user as $email):
				mail($email,$subject,$email_message,$headers);   
			endforeach;
		}	

		if($email_type == 'upload') {
			if(!empty($_FILES['email_user_file']['name'])) {
	            $csvFile = fopen($_FILES['email_user_file']['tmp_name'], 'r');
	 
	            fgetcsv($csvFile);
	 
	            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
	                $email = $getData[1];
	                mail($email,$subject,$email_message,$headers);
	            }
	 
	            fclose($csvFile);	    
		    }
		}	

		$message = '<div class="message"><i class="fa fa-check-circle"></i> Email has been sent successfully.</div>';  

		$this->session->set_flashdata('message', $message);
		redirect('admin/newsletter');
	}

	public function jobs($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'create') {
			$data['title'] = 'Create Job Post';
			$data['id']		  = $id;

			$data['job_title']   = '';
			$data['package']     = '';
			$data['job_type']    = '';
			$data['location']    = '';
			$data['company']     = '';
			$data['experience']  = '';
			$data['description'] = '';
			$data['status']      = '';
            $data['metaData']    = array();

			if($id != null) {
				$jobsData = $this->process_data->get_data('jobs', array('id' => $id));
                $metaData = $this->process_data->get_data('job_meta', array('jobID' => $id));

				$data['job_title']   = $jobsData[0]->title;
				$data['package']	 = $jobsData[0]->package;
				$data['job_type']	 = $jobsData[0]->type;
				$data['location'] 	 = $jobsData[0]->location;
				$data['company']	 = $jobsData[0]->company;
				$data['experience']	 = $jobsData[0]->experience;
				$data['description'] = $jobsData[0]->description;
				$data['status']      = $jobsData[0]->status;
                $data['metaData']    = $metaData;
			}

			$page = 'create-job'; 
		} elseif($method == 'delete') {
			$this->db->where('id', $id)->delete('jobs');
			
			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Job Deleted Successfully.</div>');

			redirect('admin/jobs');
	    } elseif($method == 'applications') {
	    	$data['id'] = $id;
	        $data['valorantData'] = $this->process_data->get_data('job_application');

	        $page = 'job-applications';
		} else {
			$data['title'] = 'Jobs';

			$data['jobsData'] 	= $this->process_data->get_data('jobs');

			$page = 'job-listings'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function createJob() {
		$job_title   = $this->input->post('job_title');	
		$package     = $this->input->post('package');
		$job_type 	 = $this->input->post('job_type');
		$location	 = $this->input->post('location');
		$company     = $this->input->post('company');
		$experience	 = $this->input->post('experience');
		$description = $this->input->post('description');
		$status 	 = $this->input->post('status');
		$id		  	 = $this->input->post('id');

		if(!empty($id)) {
			$id = array('id' => $id);
		}

		$slug = $this->process_data->slugify($job_title);

		$datapost = array(
			'title' => $job_title,
			'package' => $package,
			'type' => $job_type,
			'location' => $location,
			'company' => $company,
			'experience' => $experience,
			'description' => $description,
			'status'	=> $status,
			'slug' => $slug
		);
	
		$jobID = $this->process_data->create_data('jobs', $datapost, $id);

        if(!empty($id)) {
            $jobID = $id['id'];
        }

        $this->db->where('jobID', $jobID)->delete('job_meta');
        
        foreach($this->input->post('meta_key') as $key => $meta):
            $dataInsert = array(
                'jobID' => $jobID,
                'meta_key' => $meta,
                'meta_value' => $this->input->post('meta_value')[$key]
            );

            $this->process_data->create_data('job_meta', $dataInsert);
        endforeach;

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Job Post '.$status.' Successfully.</div>');

		redirect('admin/jobs');
	}

	public function articles($method = null, $id = null, $ct_id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'create') {
			$data['title'] = 'Create Article';
			$data['id']	   = $id;

			$data['title']  = '';
			$data['answer'] = '';
			$data['status'] = '';
			$data['category_id'] = '';

			$data['categoriesData'] = $this->process_data->get_data('article_categories');

			if($id != null) {
				$articlesData = $this->process_data->get_data('support_articles', array('id' => $id));

				$data['title']  = $articlesData[0]->title;
				$data['answer']	= $articlesData[0]->answer;
				$data['category_id'] = $articlesData[0]->category_id;
				$data['status'] = $articlesData[0]->status;
			}

			$page = 'create-article';
		} elseif($method == 'delete') {
			$this->db->where('id', $id)->delete('support_articles');
			
			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Article Deleted Successfully.</div>');

			redirect('admin/articles');
		} elseif($method == 'categories') {
			$data['categoriesData'] = $this->process_data->get_data('article_categories');
			$page = 'article-categories'; 

		} elseif($method == 'categories' && $id == 'delete') {	
			$this->db->where('id', $ct_id)->delete('article_categories'); 
		} else {
			$data['title'] = 'Articles';

			$data['articlesData'] = $this->process_data->get_articles();

			$page = 'articles'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function create_article_category() {
		$title 	  	 = $this->input->post('title');
		$status   	 = $this->input->post('status');	
		$description = $this->input->post('description');
		$id 	  	 = $this->input->post('id');
		$filename 	 = $this->input->post('icon_filename');

		$config['upload_path'] = getcwd() . '/assets/frontend/images/categories/'; 

		$file     = $_FILES['icon']['name'];
		$filesize = $_FILES['icon']['size'];
		$location = $config['upload_path'].$file;

		$return_arr = array();

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['icon']['tmp_name'],$location)){
			    $dataInsert['filename'] = $file;
			}
		} else {
			$dataInsert['filename'] = $filename;
		}

		if(!empty($id)) {
			$id = array('id' => $id);
		}

		$this->process_data->create_data('article_categories', 
			array(
				'title' => $title,
				'description' => $description,
				'icon_name' => $dataInsert['filename'], 
				'status' => $status,
				'slug' => $this->process_data->slugify($title)
			), $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Record '.$status.' Successfully.</div>');

		redirect('admin/articles/categories');
	}

	public function createArticle() {
		$title    = $this->input->post('title');	
		$category = $this->input->post('category');
		$answer	  = $this->input->post('answer');
		$status   = $this->input->post('status');
		$id		  = $this->input->post('id');

		if(!empty($id)) {
			$id = array('id' => $id);
		}

		$datapost = array(
			'title' 	  => $title,
			'answer' 	  => $answer,
			'category_id' => $category,
			'status' 	  => $status,
			'slug' 		  => $this->process_data->slugify($title)
		);
	
		$this->process_data->create_data('support_articles', $datapost, $id);

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Article '.$status.' Successfully.</div>');

		redirect('admin/articles');
	}

	public function users($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['ci'] = $this->process_data;

		if($method == 'create') {
			$data['title'] = 'Create User';

			$data['id'] = $id;

			$data['first_name'] = '';
			$data['last_name']  = '';
			$data['username']   = '&nbsp;';
			$data['email']   	= '';
			$data['country']    = '';
			$data['user_type']  = '';
			$data['credits']    = '';
			$data['sm_id']		= '';			
			$data['salary']  = '';
			$data['paid_leaves']  = '';
			$data['shift_hours']  = '';
			$data['allowed_time_in']  = '';
			$data['shift_time_start']  = '';
			$data['shift_time_end']  = '';
			$data['salary_cycle'] = '';
			$data['dso_member'] = 0;

			if($id != null) {
				$userData = $this->process_data->get_data('users', array('id' => $id));

				$data['first_name'] = $userData[0]->first_name;
				$data['last_name']  = $userData[0]->last_name;
				$data['username']   = $userData[0]->username;
				$data['email']   	= $userData[0]->email;
				$data['sm_id']		= $userData[0]->sm_id;
				$data['country']    = $userData[0]->country;
				$data['credits']    = $userData[0]->credit;
				$data['user_type']  = $userData[0]->role;
				$data['salary']  = $this->process_data->get_user_meta('salary', $id);
				$data['salary_cycle'] = $this->process_data->get_user_meta('salary_cycle', $id);
				$data['paid_leaves']  = $this->process_data->get_user_meta('paid_leaves', $id);
				$data['shift_hours']  = $this->process_data->get_user_meta('shift_hours', $id);
				$data['allowed_time_in']  = $this->process_data->get_user_meta('allowed_time_in', $id);
				$data['shift_time_start']  = $this->process_data->get_user_meta('shift_time_start', $id);
				$data['shift_time_end']  = $this->process_data->get_user_meta('shift_time_end', $id);
				$data['dso_member']  = $this->process_data->get_user_meta('dso_member', $id);
			}

			$page = 'create-user'; 
		} elseif($method == 'delete') {
			$this->db->where('id', $id)->delete('users');
			$this->db->where('user_id', $id)->delete('user_meta');
			$this->db->where('userID', $id)->delete('user_log');

			$folderPath = getcwd() . 'assets/uploads/users/user-' . $id;
			$filename   = 'user-' . $id;

			// $this->delete_dir($folderPath, $filename);
			
			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Job Deleted Successfully.</div>');

			redirect('admin/jobs');
		} elseif($method == 'dso') {
			$data['title'] = 'Users';

			$data['userData'] 	= $this->process_data->get_data('users');

			$page = 'dso-members'; 
		} else {
			$data['title'] = 'Users';

			$data['userData'] 	= $this->process_data->get_data('users');

			$page = 'users'; 
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function players($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		if($method == 'create') {
			$data['title'] = 'Create User';

			$data['id'] = $id;

			$data['first_name'] = '';
			$data['last_name']  = '';
			$data['username']   = '&nbsp;';
			$data['email']   	= '';
			$data['country']    = '';
			$data['user_type']  = '';
			$data['sm_id']		= '';

			if($id != null) {
				$userData = $this->process_data->get_data('users', array('id' => $id));

				$data['first_name'] = $userData[0]->first_name;
				$data['last_name']  = $userData[0]->last_name;
				$data['username']   = $userData[0]->username;
				$data['email']   	= $userData[0]->email;
				$data['sm_id']		= $userData[0]->sm_id;
				$data['country']    = $userData[0]->country;
				$data['user_type']  = $userData[0]->role;
			}

			$page = 'create-user'; 
		} else {
			$data['title'] = 'Players';

			$data['userData'] 	= $this->db->get_where('users', array('role' => 4, 'role' => 5))->result();

			$page = 'players'; 
		}

		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('admin/includes/footer');
	}

	public function createUser() {
		$first_name = $this->input->post('first_name');	
		$last_name  = $this->input->post('last_name');
		$username   = str_replace(' ', '', $this->input->post('username'));
		$email 		= $this->input->post('email');
		$country	= $this->input->post('country');
		$user_type  = $this->input->post('user_type');
		$credits    = $this->input->post('credits');
		$dso_member = $this->input->post('dso_member');
		$user_id  	= $this->input->post('id');

		$id = '';

		if(!empty($user_id)) {
			$id = array('id' => $user_id);
		}

		$datauser = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'username' 	 => $username,
			'email' 	 => $email,
			'country' 	 => $country,
			'credit' 	 => $credits
		);

		if($this->input->post('password') != null) {
			$password 	= md5(str_replace(' ', '', $this->input->post('password')));
			$datauser['password'] = $password;
		}

		if($this->input->post('user_type') != null) {
			$datauser['role'] = $user_type;
		}
	
		$userID = $this->process_data->create_data('users', $datauser, $id);

		if($userID == 'n/a') {
			$userID = $user_id;
		}

		$this->process_data->update_user_meta('dso_member', $dso_member, $userID);

		if($user_type == 2 || $user_type == 3 || $user_type == 6 || $user_type == 7 || $user_type == 8 || $user_type == 9 || $user_type == 10) {
			if(!empty($this->input->post('salary_cycle'))) {
				$this->process_data->update_user_meta('salary_cycle', $this->input->post('salary_cycle'), $userID);
			}

			if( $this->input->post('salary_cycle') != 'Project Based') {
				if(!empty($this->input->post('salary'))) {
					$this->process_data->update_user_meta('salary', $this->input->post('salary'), $userID);
				}
				if(!empty($this->input->post('shift_hours'))) {
					$this->process_data->update_user_meta('shift_hours', $this->input->post('shift_hours'), $userID);
				}
				if(!empty($this->input->post('paid_leaves'))) {
					$this->process_data->update_user_meta('paid_leaves', $this->input->post('paid_leaves'), $userID);
				}
			}
		} else {
			$this->db->where(array('meta_title' => 'salary', 'user_id' => $userID))->delete('user_meta');
			$this->db->where(array('meta_title' => 'salary_cycle', 'user_id' => $userID))->delete('user_meta');
			$this->db->where(array('meta_title' => 'paid_leaves', 'user_id' => $userID))->delete('user_meta');
			$this->db->where(array('meta_title' => 'shift_hours', 'user_id' => $userID))->delete('user_meta');	
		}

		if($id == '') {
			$status = 'Created';
		} else {
			$status = 'Updated';
		}

		$userID = $id['id'];
		$folderPath = getcwd() . '/assets/uploads/users/user-' . $userID;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true); 
        } 

		$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Game '.$status.' Successfully.</div>');

		redirect('admin/users');
	}

	public function confirmAdminPassword() {
    	$password = md5($this->input->post('password'));
    	$id = $this->input->post('rowID');
    	$userID = $this->session->userdata('user_id');

    	$checkPassword = $this->process_data->get_data('users', array('password' => $password, 'id' => $userID));

    	if(count($checkPassword) > 0) {
    		$data['status'] = 1;
    		$data['rowID']  = $id;
    		$data['phone']  = $this->getPhoneValorant($id);
    	} else {
    		$data['status']  = 0;
    		$data['message'] = '<div class="message"><i class="fa fa-times-circle"></i> Invalid password provided.</div>';
    	}

    	echo json_encode($data);
    }

	public function attendance($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}
		
		if($this->session->userdata('user_role') != 1) {
			redirect('admin/login');
		}

		if($method == 'time_out') {
			$status = $this->verify_user->process_time_out();

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
			$data['title'] = 'Attendance';
			$empQuery = "SELECT * FROM users WHERE role IN (2, 3, 6, 7, 8, 9, 10)";
			$data['dataEmployees'] = $this->db->query($empQuery)->result();

			date_default_timezone_set("America/Los_Angeles");

			$data['current_date'] = date('d F Y');

			$page = 'attendance';
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function attendance_report() {
		$userID 	= $this->input->post('emp_id'); 
		$start_date = $this->input->post('start_date');
		$end_date   = date('Y-m-d', strtotime($start_date . ' +7 days'));

        $current_class = '';
	
		$html 		  	 = '';        
		$days_worked  	 = 0;
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
		                }

		                $diff[] = strtotime($dataTime->time_out) - strtotime($dataTime->time_in);
		                $html .= '</label>';
		            }
		        endforeach;
		        
	       		$html .= '</div>';
	       		$html .= '<div class="timesheet-edit"></div>';
	       		date_default_timezone_set('UTC');
	       		$total_time = date('H:i:s', array_sum($diff));
	       		$total_week_time[] = array_sum($diff);
	       		$html .= '<div class="time-calc">Time Spent : '.$total_time.'</div>';
		        $html .= '<a href="'.base_url().'admin/editTime" class="sm-btn btn btn-info edit-time" data-id="'.$userID.'" data-date="'.$set_date.'">Edit Time</a>';
		        $html .= '<div class="loader-wrapper">
                                    <div class="loader-sub" id="time-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>';
	       	} else {
	       		$days_abscent += 1; 
	       	}
       		$html .= '</li>';
       	}

		$get_salary = "SELECT * FROM wallet WHERE userID = '".$userID."'";
       	$get_salary = $this->db->query($get_salary)->result();
       	
       	$total_time     = date('H:i:s', array_sum($total_week_time));
       	$total_earnings = (count($get_salary) > 0) ? $get_salary[0]->balance : 0;

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
	                        <div class="title"><i class="ti-alarm-clock"></i> Time Spent This Week:</div>
	                        <div class="text totalTime">
	                             '.$total_time.'
	                        </div>
	                    </li>

	                    <li>
	                        <div class="title">
	                        	<i class="mdi mdi-cash-multiple"></i> 
	                        	Total Earnings:</div>
	                        <div class="text">
	                             <span class="earnings">$'.$total_earnings.'</span>';
	               	if($total_earnings > 0) {
	                	$report .= '<a href="'.base_url().'admin/payNow" class="btn btn-info row-inline waves-effect waves-light m-r-10 btn-curved pay-balance" data-user="'.$userID.'">Pay Now</a>';
	            	}
            $report .= '</div>
	                    </li>
	                </ul> ';

        $dataReturn['calendarData'] = $html;
        $dataReturn['reportData']	= $report;
 
		echo json_encode($dataReturn);
		exit;
	}

	public function getNextWeek() {
		$userID    = $this->input->post('user_id');
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
	       		$html .= '<div class="timesheet-edit"></div>';
	       		date_default_timezone_set('UTC');
	       		$total_time = date('H:i:s', array_sum($diff));
	       		$total_week_time[] = array_sum($diff);
	       		$html .= '<div class="time-calc">Time Spent : '.$total_time.'</div>';
		        $html .= '<a href="'.base_url().'admin/editTime" class="sm-btn btn btn-info edit-time" data-id="'.$userID.'" data-date="'.$set_date.'">Edit Time</a>';
		        $html .= '<div class="loader-wrapper">
                                    <div class="loader-sub" id="time-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>';
	       	} else {
	       		$days_abscent += 1; 
	       	}
       		$html .= '</li>';
       	}

       	$get_salary = "SELECT * FROM wallet WHERE userID = '".$userID."'";
       	$get_salary = $this->db->query($get_salary)->result();
       	
       	$total_time     = date('H:i:s', array_sum($total_week_time));
       	$total_earnings = (count($get_salary) > 0) ? $get_salary[0]->balance : 0;

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
                        <div class="title"><i class="ti-alarm-clock"></i> Time Spent This Week:</div>
                        <div class="text totalTime">
                             '.$total_time.'
                        </div>
                    </li>

                    <li>
                        <div class="title">
                        	<i class="mdi mdi-cash-multiple"></i> 
                        	Total Earnings:</div>
                        <div class="text">
                            <span class="earnings">$'.$total_earnings.'</span>';
                if($total_earnings > 0) {
	                $report .= '<a href="'.base_url().'admin/payNow" class="btn btn-info row-inline waves-effect waves-light m-r-10 btn-curved pay-balance" data-user="'.$userID.'">Pay Now</a>';
	            }
            $report .= '</div>
                    </li>
                </ul> ';

        echo json_encode(array(
        	'week_date' 	  => $week_date, 
        	'week_calendar'   => $week_calendar,
        	'week_attendance' => $html,
        	'week_report'	  => $report,
        	'start_date'	  => $start_date,
        	'end_date' 		  => $end_date
        ));
	}

	public function editTime() {
		$set_date = $this->input->post('userDate');
		$userID   = $this->input->post('userID');

		$timeLog = $this->process_data->get_data('attendance', array('userID' => $userID, 'date' => $set_date));

		$html  = '<div class="time-edit-form">';
		$html .= '<form method="POST" action="'. base_url() .'admin/setTime" onsubmit="return false;" class="setTime">';
		foreach($timeLog as $dataTime):
			$html .= '<div class="form-group"><label>Time In</label>';
			$html .= '<input type="time" class="form-control" name="time_in[]" value="'.$dataTime->time_in.'" />'; 
			$html .= '</div>';
			$html .= '<div class="form-group"><label>Time Out</label>';
			$html .= '<input type="time" class="form-control" name="time_out[]" value="'.$dataTime->time_out.'" />'; 
			$html .= '</div>';
			$html .= '<input type="hidden" name="rowID[]" value="'.$dataTime->id.'" />';
        endforeach;
        $html .= '<input type="hidden" name="weekTime" value="" />';
		$html .= '<button type="submit" class="btn btn-info sm-btn">Update Time</button>';
		$html .= '</form>';
		$html .= '</div>';

		echo $html;
	}

	public function setTime() {
		$rowID    = $this->input->post('rowID');
		$time_in  = $this->input->post('time_in');
		$time_out = $this->input->post('time_out');
		$weekTime = $this->input->post('weekTime');
		$userID   = 0;

		$timeData = '';

		foreach($rowID as $key => $id):
			$getData = $this->process_data->get_data('attendance', array('id' => $id));
			$userID  = $getData[0]->userID;
 			
 			/*
 			 * 1. Get old time to create new timeframe
 			 */
 			$oldTimeIn  = $getData[0]->time_in;
 			$oldTimeOut = $getData[0]->time_out;
 			$totalOldTime[] = strtotime($oldTimeOut) - strtotime($oldTimeIn);

 			$timeIn  = $time_in[$key];
			$timeOut = $time_out[$key];
		
			$dataUpdate = array(
				'time_in'  => $timeIn,
				'time_out' => $timeOut
			);

			$this->process_data->create_data('attendance',  $dataUpdate, array('id' => $id));
			
			$diff[] = strtotime($timeOut) - strtotime($timeIn);

			$time_in_convert = (date('A', strtotime($timeIn)) == 'AM') ? 'PM' : 'AM';
            $time_in_new = date('h:i:s', strtotime($timeIn)) . ' ' . $time_in_convert;

            $timeData .= '<label class="badge badge-success">Time In : ' . $time_in_new . '</label>';
            $timeData .= '<label class="badge badge-warning">Time Out : ';
           
            $time_out_convert = (date('A', strtotime($timeOut)) == 'AM') ? 'PM' : 'AM';
            $timeData .= date('h:i:s', strtotime($timeOut)) . ' ' . $time_out_convert;

            $timeData .= '</label>';

			$dataUpdate = array();
		endforeach;

		date_default_timezone_set('UTC');
   		$total_time = date('H:i:s', array_sum($diff));

   		/*
   		 * Setting Total Week Time
   		 */
   		$weekTime = strtotime($weekTime) - array_sum($totalOldTime);
   		$totalWeekTime = $weekTime + array_sum($diff);
   		$totalWeekTime = date('H:i:s', $totalWeekTime);

   		/*
   		 * Calculate total time and remove amount from balance to adjust the amount
   		 */
   		$totalOldTime = date('H.i', array_sum($totalOldTime));
   		$salary 	= $this->process_data->get_user_meta('salary', $userID);
   		$oldAmount  = $totalOldTime * $salary;

   		$get_salary = "SELECT * FROM wallet WHERE userID = '".$userID."'";
       	$get_salary = $this->db->query($get_salary)->result();

       	$initBalance = $get_salary[0]->balance - $oldAmount;

       	/*
       	 * Calculate amount with new hours spent
       	 */	
       	$totalNewTime = date('H.i', array_sum($diff)); 
       	$newAmount    = $totalNewTime * $salary; 
       	$newBalance   = $initBalance + $newAmount;

       	$this->process_data->create_data('wallet', array(
       		'balance' => $newBalance,
       		'last_updated' => date('Y-m-d H:i:s')
       	), array(
       		'userID' => $userID
       	));

       	echo json_encode(
       		array(
       			'total_time'  => 'Time Spent : ' . $total_time,
       			'timeData'    => $timeData,
       			'totalSalary' => '$' . $newBalance,
       			'totalWeekTime' => $totalWeekTime 
       		)
       	);
	}

	public function payNow() {
		$userID = $this->input->post('userID');

		$getPyamentData = $this->process_data->geT_data('wallet', array('userID' => $userID));
		$getPayment     = $getPyamentData[0]->balance;

		$dataInsert = array(
			'userID' 	   => $userID,
			'balance' 	   => 0,
			'paid' 	 	   => $getPayment,
			'last_updated' => date('Y-m-d H:i:s') 
		);

		$this->process_data->create_data('wallet', $dataInsert, array('userID' => $userID));

		//Creating Transaction
		$description = "Salary Paid User Reff #".$userID;
		$transData = array(
			'user_id' 	   => $userID,
			'description'  => $description,
			'type' 		   => 'salary_payment',
			'txn_id' 	   => 'N/A',
			'trans_status' => 'Cleared',
			'trans_type'   => 'debit',
			'date_trans'   => date('Y-m-d')
		); 	

		$this->process_data->create_data('transaction', $transData);

		$balance = '$0.00';
		echo $balance;
	}

	public function tasks($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['title'] = 'Projects';

		$data['meta'] = $this->process_data;

		if($method == 'create') {
			$query = "SELECT * FROM users WHERE role IN ('8 , 9')";
			$data['usersData'] = $this->db->query($query)->result();

			$data['title'] = 'Create Article';
			$data['id']	   = $id;

			$data['title']  = '';
			$data['filename'] = '';
			$data['userID'] = '';
			$data['description'] = '';
			$data['price'] = '';

			if($id != null) {
				$taskData = $this->process_data->get_data('agent_tasks', array('id' => $id));

				$data['title']  = $taskData[0]->title;
				$data['filename']	= $taskData[0]->attachment;
				$data['userID'] = $taskData[0]->agentID;
				$data['description'] = $taskData[0]->description;
				$data['price'] = $taskData[0]->price;
			}

			$page = 'create-task';
		} elseif($method == 'delete') {
			$this->db->where('id', $id)->delete('agent_tasks');
			redirect('admin/tasks');
		} elseif($method == 'view') {
			$data['title'] = 'View Project';
			$data['projectsData'] = $this->process_data->get_data('agent_tasks', array('id' => $id));
			$data['projectMessages'] = $this->process_data->geT_data('project_comments', array('projectID' => $id));

			$query_activity = "SELECT * FROM activity_log WHERE act_id = '" . $id . "' AND act_type = 'agent-task' ORDER BY id ASC";
			$data['activityLog']  = $this->db->query($query_activity)->result();

			$page = 'view-project';
		} else {
			$data['projectsData'] = $this->process_data->get_data('agent_tasks');

			$page = 'tasks';
		}

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function createTask() {
		$userID		 = $this->input->post('userID');
		$title   	 = $this->input->post('title');
		$description = $this->input->post('description');
		$filename    = $this->input->post('filename');
		$price 		 = $this->input->post('price');
		$taskID		 = $this->input->post('id');

		$type = 0;

		if($userID == 'builder') {
			$type 	= 1;
			$userID = 0;
		}

		if($userID == 'programmer') {
			$type 	= 2;
			$userID = 0;
		}

		$price = ($price == '') ? '0.00' : $price;
		
		$dataInsert = array(
			'title' 	   => $title,
			'date_created' => date('Y-m-d'),
			'description'  => $description,
			'agentID'      => $userID,
			'price'		   => $price,
			'type'		   => $type,
			'status' 	   => 1
		);

		$condition = '';

		if(!empty($taskID)) {
			$condition = array('id' => $taskID);
		}

		$projectID = $this->process_data->create_data('agent_tasks', $dataInsert, $condition);

		$folderPath = getcwd() . '/assets/uploads/projects/project-' . $projectID;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true); 
        } 

		$config['upload_path'] = $folderPath; 

		$file     = $_FILES['attachment']['name'];
		$filesize = $_FILES['attachment']['size'];
		$location = $config['upload_path'].$file;

		$return_arr = array();

		/* Upload file */
		if(!empty($file)) {
			if(move_uploaded_file($_FILES['attachment']['tmp_name'],$location)){
			    $dataFile['attachment'] = $file;
			}
		} else {
			$dataFile['attachment'] = $filename;
		}

		$this->process_data->create_data('agent_tasks', $dataFile, array('id' => $projectID));

		redirect('admin/tasks');
	}

	public function reports() {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}
		
		$data['title'] = 'Daily Report';
		$data['reportData'] = $this->process_data->get_data('daily_report');
		$data['meta']	= $this->process_data;

		$page = 'daily-status-report';

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
	}

	public function getReport() {
		$reportID = $this->input->post('id');

		$report = $this->process_data->get_data('daily_report', array('id' => $reportID));

		$data['title'] = $report[0]->title;
		$data['url'] = base_url() . 'assets/uploads/users/user-' . $report[0]->userID . '/' . $report[0]->filename;
		$data['description'] = $report[0]->description;
		$data['comment'] = $report[0]->comments;
		$data['status'] = $report[0]->status;
		$data['id']	=	$reportID;

		echo json_encode($data); 
	}

	public function updateReport() {
		$reportID = $this->input->post('id');
		$comment = $this->input->post('description');
		$status = $this->input->post('status');

		$dataUpdate = array(
			'comments' => $comment,
			'status' => $status
		);

		$this->process_data->create_data('daily_report', $dataUpdate, array('id' => $reportID));

		redirect('admin/reports');
	}

	public function leaves($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}

		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
		}

		$data['title'] = 'Leave Requests';
		$data['leavesData'] = $this->db->select('emp_leaves.*, users.username');
		$data['leavesData'] = $this->db->join('users', 'users.id = emp_leaves.emp_id');
		$data['leavesData'] = $this->db->get('emp_leaves')->result();

		$page = 'leaves';

		$this->load->view('admin/admin-new/includes/header', $data);
		$this->load->view('admin/admin-new/'.$page, $data);
		$this->load->view('admin/admin-new/includes/footer');
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

		redirect('hrm/leaves');
	}

	public function application_details() {
		$id = $this->input->post('id');

		$application = $this->db->select('emp_leaves.*, users.username');
		$application = $this->db->join('users', 'users.id = emp_leaves.emp_id');
		$application = $this->db->get_where('emp_leaves', array('emp_leaves.id' => $id));

		$html = '<div class="form-group">
                                <label>Date</label>
                                <p>'.$application->row()->date_from.'</p>
                            </div>';

        if($application->row()->date_type != 'N/A') {                   

		$html .= '<div class="leaves_date_req">';


		if($application->row()->date_type == 'multi_dates') { 
        $html .= '<div class="form-group multi_dates date-method">
	                                <label>
	                                	Requested Dates
	                                </label>

	                                <ul>';
	                                $date_to = unserialize($application->row()->date_to);
	                                foreach($date_to as $dates) {
	                                	$html .= '<li>' . $dates. '</li>';
	                                }

	                                $html .= '</ul>
		                        </div>';
		                    } else { 
		 $html .= '<div class="form-group date_range date-method">
	                                <label>Leaves Till Date</label>
	                                <p>'.$application->row()->date_to.'</p>
		                        </div>';
		                    }
          $html .= '</div>';
		                    }

           $html .= '<div class="form-group">
                                <label>Leave Type</label>
                                <p>'.$application->row()->leave_type.'</p>
                            </div>

                            <div class="form-group">
                                <label>Reason</label>
                                <p>'.$application->row()->reason.'</p>
                            </div>';
        $html .= '<form method="POST" action="'.base_url().'admin/processleave">';    
        $reject  = ($application->row()->status == 1) ? 'selected' : '';
        $approve = ($application->row()->status == 2) ? 'selected' : '';
            $html .= '<div class="form-group">
                <label>Action</label>
                <select name="status" class="form-control">
                	<option value="0">Select Action</option>
                	<option value="1" ' . $reject  . '>Reject</option>
                	<option value="2" ' . $approve . '>Approve</option>
                </select>
            </div>

            <input type="hidden" name="id" value="'.$application->row()->id.'" />

            <div class="form-group">
                <button type="submit" class="btn btn-info row-inline waves-effect waves-light m-r-10 cat-submit">Submit</button>
            </div>';
        $html .= '</form>';    

        echo $html;
	}

	public function processleave() {
		$status = $this->input->post('status');
		$id = $this->input->post('id');

		$this->db->where('id', $id)->update('emp_leaves', array(
			'status' => $status
		));

		redirect('admin/leaves');
	}

	public function salary($method = null) {
		if($this->session->userdata('is_logged_in') != true) {
			redirect('admin/login');
		}
		
		if($this->session->userdata('user_role') > 1) {
			redirect('admin/login');
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

		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('admin/includes/footer');
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

					if(!empty($projectFiles)) {
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

	public function requestRevision() {
		$projectID 	= $this->input->post('projectID');
		$status 	= $this->input->post('status');

		$getProjectData = $this->process_data->get_data('agent_tasks', array('id' => $projectID));
		$curStage 	    = $getProjectData[0]->status;

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
		$descriptionUser = 'Project Reff #DSO-' . $projectID . ' Status Changed from ' . $stageStatus[$curStage] . ' to ' .  $stageStatus[$status] . ' By Admin (' . $username . ')';

		$dataActivity = array(
			'act_id' 		=> $projectID,
			'description' 	=> $descriptionUser,
			'date_activity' => date('Y-m-d H:i:s'),
			'act_type'		=> 'agent-task',
			'user_id'		=> $userID
		);

		$this->process_data->create_activity($dataActivity);

		$this->process_data->create_data('agent_tasks', 
			array('status' => $status), 
			array('id' => $projectID)
		);

		redirect('admin/tasks/view/'.$projectID);
	}

	

    public function delete_dir($dirPath, $dirname) {
		if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	    	$filename = array_filter(explode('/', $file));
	    	$filename = end($filename);
	        if (is_dir($file)) {
	            self::delete_dir($file, $filename);
	        } else {
	        	$getFileID = $this->process_data->get_data('files', array('filename' => $filename));
			    $this->db->where('id', $getFileID[0]->id)->delete('files');
	            unlink($file);
	        }
	    }

	    $getFolderID = $this->process_data->get_data('folders', array('directory_name' => $dirname));
	    $this->db->where('id', $getFolderID[0]->id)->delete('folders');
	    rmdir($dirPath);
	}

	public function test() {
        $players = 74;
        $player_count = 0;
        $leftPlayers = $players;
        for($i = 1; $i <= log($players / 2, 2); $i ++) {
        	$leftPlayers =  $leftPlayers / 2;
        	if(is_float($leftPlayers)) {
        		break;
        	}
        	echo $i . ')' . $leftPlayers . '<br />';
        }       
    }

    public function update_salary() {
    	$usersData = $this->process_data->get_data('users');

    	foreach($usersData as $user):
    		$total_hours 	= 0;
    		$total_earnings = 0;

    		$userID 		= $user->id;
	    	$get_time_query = "SELECT * FROM attendance WHERE userID = '".$user->id."'";
	       	$get_time_total = $this->db->query($get_time_query)->result();
	       	$billing_time 	= array();

	       	if(count($get_time_total) > 0) {
	       		foreach($get_time_total as $time_calc_total):
		            if($time_calc_total->time_out != '00:00:00') {
		            	date_default_timezone_set('UTC');
	                    $billing_time[] = strtotime($time_calc_total->time_out) - strtotime($time_calc_total->time_in);
		            }
		        endforeach;
	       	}

	       	$total_hours    = date('H.i', array_sum($billing_time));
	       	$billing_cycle  = $this->process_data->get_user_meta('salary_cycle', $userID);
	       	$salary 	    = $this->process_data->get_user_meta('salary', $userID);

	       	if($total_hours > 0) {
		       	$total_earnings = $salary * $total_hours;
		       	$walletData 	= $this->db->get_where('wallet', array('userID' => $userID))->result();
		    	$balance	    = (count($walletData) > 0) ? $walletData[0]->balance : 0;
		    	$newBalance		= $balance + $total_earnings;
		    	$addWalletData  = array('balance' => $newBalance, 'last_updated' => date('Y-m-d H:i:s'));

				if(count($walletData) > 0) {
					$this->db->where('userID', $userID)->update('wallet', $addWalletData);
				} else {
					$addWalletData['userID'] = $userID;
					$addWalletData['clearance'] = 0;
					$addWalletData['paid'] = 0;
					$this->db->insert('wallet', $addWalletData);
				}  

				echo 'User ID : ' . $userID . ' | Total Hours : ' . $total_hours . ' | Total Earnings : ' .   	 	$total_earnings . '<br />'; 
			}
       	endforeach;
    }
}