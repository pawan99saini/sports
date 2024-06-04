<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('verify_user');
		$this->load->model('process_data');
		$this->load->model('loademojione');
		$this->load->model('TournamentModel');
	}

	public function videos($method = null, $id = null) {
		if($this->session->userdata('is_logged_in') == true) {
			$data = array(
				'title' => 'Manage Videos',
				'class' => 'inner',
				'page_active' => 'videos'
			);

			$data_cond = array(
                'user_id' => $this->session->userdata('user_id')
            );

            if($id != null) {
                $data_cond['id'] = $id;
            }
            
            $dataVideo = $this->db->get_where('videos', $data_cond);
            
            $data['meta'] = $this->process_data; 

            if($method == 'create') {
                $data['id']         = '';
                $data['title']      = '';
                $data['video_url']  = '';
                $data['video_type'] = '';
                $data['thumbnail_file'] = '';
                $data['user_id']    = '';
                
                if($id != null) {
                    $data['id']         = $id;
                    $data['title']      = $dataVideo->row()->title;
                    $data['video_url']  = $dataVideo->row()->video_url;
                    $data['video_type'] = $dataVideo->row()->video_type;
                    $data['thumbnail_file'] = $dataVideo->row()->thumbnail;
                    $data['user_id']    = $this->session->userdata('user_id');
                }
                
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

            $this->load->view('includes/header-new', $data);
            $this->load->view($page, $data);
            $this->load->view('includes/footer-new');
		} else {
			redirect('login');
		}
	}

	public function processVideo() {
		$id  = $this->input->post('id');
		$title  	= $this->input->post('title');
		$video_type = $this->input->post('video_type');
		$video_url  = $this->input->post('video_url');
		$userID     = $this->session->userdata('user_id');

        $folderPath = getcwd() . '/assets/frontend/videos/users/user-' . $userID;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true); 
        }

        $data = array(
			'title' 	 => $title,
			'video_type' => $video_type,
			'user_id' 	 => $userID
		);
        
        if(!empty($_FILES['video_file']['name'])) {
            $thumbnail = $_FILES['video_file']['name'];
			$thumbnail_tmp = $_FILES['video_file']['tmp_name'];

            $temp = explode(".", $thumbnail);
            $thumbnail_filename = round(microtime(true)) . '.' . end($temp);

			move_uploaded_file($thumbnail_tmp, $folderPath . "/".$thumbnail_filename);
            $data['thumbnail'] = $thumbnail_filename;
        } else {
            $data['thumbnail'] = $this->input->post('thumbnail_file');
        }

		if($video_type == 'custom') {
			$filename = $_FILES['video_file']['name'];
			$file_tmp = $_FILES['video_file']['tmp_name'];

			if($filename != null) {
				move_uploaded_file($file_tmp, $folderPath . "/".$filename);

				$video_url = $filename;
			}
		}

        $data['video_url'] = $video_url;

		if($id == '') {
			$this->db->insert('videos', $data);
		} else {
			$this->db->where('id', $id)->update('videos', $data);	
		}

		redirect('videos');
	}

	public function getVideo() {
		$videoID = $this->input->post('videoID');
		$userID  = $this->session->userdata('user_id');

		$videoData = $this->process_data->get_data('videos', array('id' => $videoID));

		$htmlData = '';

		$videoTitle = $videoData[0]->title;
		
		if($videoData[0]->video_type == 'custom') {
			$htmlData = '<video width="520" height="380" controls>
			<source src="'.base_url() . 'assets/frontend/videos/users/user-'.$userID.'/'.$videoData[0]->video_url.'" type="video/mp4">
		  Your browser does not support the video tag.
		  </video>';
		}

		if($videoData[0]->video_type == 'youtube') {
			$htmlData = '<iframe width="520" height="380"
			src="https://www.youtube.com/embed/'.$videoData[0]->video_url.'">
			</iframe>';
		}

		echo json_encode(array(
			'video_url' => $htmlData,
			'title' => $videoTitle
		));
	}

	public function update_tagline() {
		$tagline = $this->input->post('tagline');
		$user_id = $this->session->userdata('user_id');

		$this->process_data->update_user_meta('user_tagline', $tagline, $user_id);
	}

	public function update_description() {
		$description = $this->input->post('p_desc');
		$user_id = $this->session->userdata('user_id');
		echo $description;
		$this->process_data->update_user_meta('user_description', $description, $user_id);
	}

	public function update_user_picture() {
		$userID 	  = $this->session->userdata('user_id');
		$update_value = $this->input->post('update_value'); 
		$target_loc   = $this->input->post('target_loc'); 

		if($update_value == 'Cover Photo') {
			$meta_title = 'user_cover_picture';
		} else {
			$meta_title = 'user_image';
		}

		if($target_loc == 'team') {
			$folderPath = getcwd() . '/assets/uploads/teams'; 
		} else {
			$folderPath = getcwd() . '/assets/uploads/users/user-' . $userID;

			if (!file_exists($folderPath)) {
				mkdir($folderPath, 0777, true); 
			}	
		}

		$file     = $_FILES['update_image']['name'];
		$file_tmp = $_FILES['update_image']['tmp_name'];

		$return_arr = array();

		$temp = explode(".", $_FILES["update_image"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$location = $folderPath . '/' . $newfilename;

		/* Upload file */
		if(move_uploaded_file($file_tmp,$location)){
			$filename = $newfilename;
		}
		
		if($target_loc == 'team') {
			$metaData['teamID'] 	= $this->input->post('teamID');
			$metaData['meta_key'] 	= ($update_value == 'Cover Photo') ? 'team_cover_picture' : 'team_logo';
			$metaData['meta_value'] = $filename;

			$this->process_data->create_data('team_meta', $metaData);

			redirect('team/profile/edit');
		} else {
			$this->process_data->update_user_meta($meta_title, $filename, $userID);
			redirect('profile/edit');
		}
	}

	public function followPlayer($userStatus = 0) {
		$userID   = $this->session->userdata('user_id');
		$playerID = $this->input->post('playerID');

		$getFollowersData = $this->process_data->get_data('user_meta', array(
			'user_id' 	 => $playerID, 
			'meta_title' => 'user_followers'
		));

		if($userStatus == 1) {
			if(count($getFollowersData) > 0) {
				$followersData = unserialize($getFollowersData[0]->meta_value);
				array_push($followersData, $userID);

				$dataReturn['followersCount'] = count($followersData);

				$updateFollowers = serialize($followersData);

				$this->process_data->create_data('user_meta', array(
					'meta_value' => $updateFollowers
				), array(
					'user_id'    => $playerID,
					'meta_title' => 'user_followers',
				));	
			} else {
				$followersData = array($userID);

				$dataReturn['followersCount'] = count($followersData);
				
				$updateFollowers = serialize($followersData);

				$this->process_data->create_data('user_meta', array(
					'user_id'    => $playerID,
					'meta_title' => 'user_followers',
					'meta_value' => $updateFollowers
				));	
			}	

			//Create Following List
			$getFollowingData = $this->process_data->get_data('user_meta', array(
				'user_id' 	 => $userID, 
				'meta_title' => 'user_following'
			));

			if(count($getFollowingData) > 0) {
				$followingData = unserialize($getFollowingData[0]->meta_value);
				array_push($followingData, $playerID);

				$updateFollowing = serialize($followingData);

				$this->process_data->create_data('user_meta', array(
					'meta_value' => $updateFollowing
				), array(
					'user_id'    => $userID,
					'meta_title' => 'user_following',
				));	
			} else {
				$followingData = array($playerID);

				$updateFollowing = serialize($followingData);

				$this->process_data->create_data('user_meta', array(
					'user_id'    => $userID,
					'meta_title' => 'user_following',
					'meta_value' => $updateFollowing
				));	
			}	

			$dataReturn['followerText'] = 'Follwing';
			$dataReturn['updateUrl']    = base_url() . 'account/followPlayer';		
		} else {
			if(count($getFollowersData) > 0) {
				$followersData = unserialize($getFollowersData[0]->meta_value);

				foreach (array_keys($followersData, $userID) as $key) {
				    unset($followersData[$key]);
				}

				$dataReturn['followersCount'] = count($followersData);

				$updateFollowers = serialize($followersData);

				$this->process_data->create_data('user_meta', array(
					'meta_value' => $updateFollowers
				), array(
					'user_id'    => $playerID,
					'meta_title' => 'user_followers',
				));	
			}

			//Create Following List
			$getFollowingData = $this->process_data->get_data('user_meta', array(
				'user_id' 	 => $userID, 
				'meta_title' => 'user_following'
			));

			if(count($getFollowingData) > 0) {
				$followingData = unserialize($getFollowingData[0]->meta_value);

				foreach (array_keys($followingData, $playerID) as $key) {
				    unset($followingData[$key]);
				}

				$updateFollowing = serialize($followingData);

				$this->process_data->create_data('user_meta', array(
					'meta_value' => $updateFollowing
				), array(
					'user_id'    => $userID,
					'meta_title' => 'user_following',
				));	
			}

			$dataReturn['followerText'] = 'Follow';
			$dataReturn['updateUrl']    = base_url() . 'account/followPlayer/1';
		} 

		echo json_encode($dataReturn);
	}

	public function logout() {
		$userID = $this->session->userdata('user_id');
		$this->verify_user->processLogout($userID);

		redirect('/');
	}

	public function settings() {
		if($this->session->userdata('is_logged_in') != true) {
            redirect('login');
        }

		$data = array(
			'title' => 'Settings',
			'class' => 'inner',
			'page_active' => 'settings' 
		);

		$user_id = $this->session->userdata('user_id');

		$data['profileData']   = $this->process_data->get_data('users', array('id' => $user_id));	
		$data['activeMembers'] = $this->process_data->get_data('users', array('role' => 4, 'log_status' => 'Online'));	
		$data['recentJoined']  = $this->process_data->get_recently_joined();
		$data['meta']   	   = $this->process_data;
		$data['gamesData'] = $this->process_data->get_games();

		$this->load->view('includes/header-new', $data);
		$this->load->view('settings', $data);
		$this->load->view('includes/footer-new');
	}

	public function general_info() {
		$fname 	  		  = $this->input->post('fname');
		$lname   		  = $this->input->post('lname');
		$email 	  		  = $this->input->post('email');
		$platform 		  = $this->input->post('platform');
		$discord_username = $this->input->post('discord_username');
		$console_username = $this->input->post('console_username');
		$type 	  		  = $this->input->post('type');
		$game_platform 	  = $this->input->post('game_platform');
		$country 	  	  = $this->input->post('country');
		$interested_game  = serialize($this->input->post('interested_game'));
		
		$dataCreate = array(
			'first_name' 	   => $fname,
			'last_name' 	   => $lname,
			'platform' 		   => $platform,
			'discord_username' => $discord_username,
			'console_username' => $console_username,
			'type' 			   => $type,
			'game_platform'    => $game_platform,
			'country' 		   => $country,
			'interested_game'  => $interested_game
		);

		$this->process_data->create_data('users', $dataCreate, array('id' => $this->session->userdata('user_id')));

		redirect('account/settings');
	}

	public function update_contact() {
		$userID 		 = $this->session->userdata('user_id');
		$contact_method  = $this->input->post('contact_method');
		$social_platform = $this->input->post('social_platform');
		$social_url 	 = $this->input->post('social_url');

		//Updating contact method
		if($contact_method != null) {
			$this->process_data->update_user_meta('contact_method', $contact_method, $userID);
		}

		//Updating Social Media
		$count1   = count($social_platform);
        $count2   = count($social_url);

        if($count1 > $count2) {
            $social_platform = array_slice($social_platform, 0, $count2);
        }

		$data_social = array_combine($social_platform, $social_url);
		$data_social = serialize($data_social);

		if($count1 > 0) {
			$this->process_data->update_user_meta('user_social_contact', $data_social, $userID);	
		}	

		redirect('account/settings');
	}

	public function messages($username = null) {
		if($this->session->userdata('is_logged_in') != true) {
            redirect('login');
        }
        
		$data = array(
			'title' => 'Messaging',
			'class' => 'inner',
			'page_active' => 'messages'  
		);

		$user_id = $this->session->userdata('user_id');
		
		$data['user_id'] = $user_id;

		// $contactListQuery = "SELECT * FROM contacts WHERE (userID = '".$user_id."' OR friendID = '".$user_id."') ORDER BY id DESC"; 
		// $getContactList   = $this->db->query($contactListQuery)->result();

		$data['emojione'] 	 = $this->loademojione; 	

		if($username != null) {
			//Check if contact exist or not 
			$getContactID = $this->process_data->get_data('users', array('username' => $username));
			$contactID    = $getContactID[0]->id;
			$contactQuery = "SELECT * FROM contacts WHERE (userID = '".$user_id."' OR friendID = '".$user_id."') AND (userID = '".$getContactID[0]->id."' OR friendID = '".$getContactID[0]->id."')"; 
			$checkUser    = $this->db->query($contactQuery)->result();

			if(count($checkUser) == 0) {
				$dataContact = array(
					'userID'   => $user_id,
					'friendID' => $contactID
				);

				$chatID = $this->process_data->create_data('contacts', $dataContact);

				$data['threadID']	 = $chatID;
			} else {
				$chatID = $checkUser[0]->id;
			}

			$data['contactData'] = $checkUser;
			$data['threadID']    = $chatID;
			$data['contact_id_current'] = $contactID;
			$data['chat_status'] = true;

			$updateSeen = array(
				'status' => 0
			);

			$this->process_data->create_data('messages', $updateSeen, array('chatID' => $chatID, 'receiver_id' => $user_id));
			
			//Getting messages of current query
			$query = "SELECT * FROM messages WHERE (sender_id = '".$contactID."' OR receiver_id = '".$contactID."') AND (messages.sender_id = '".$user_id."' OR messages.receiver_id = '".$user_id."')";
			$data['messageData'] = $this->db->query($query)->result();
		} else { 
			$data['chat_status'] = false;
			$data['checkUser']   = '';
			$data['messageData'] = '';
			$data['contact_id_current'] = 0;
		}

		$contactListQuery = "SELECT messages.*, contacts.userID, contacts.friendID FROM messages LEFT JOIN contacts ON contacts.id = messages.chatID, (SELECT MAX(messages.id) as lastid
		FROM messages
		WHERE (messages.receiver_id = '".$user_id."' OR messages.sender_id = '".$user_id."')

		GROUP BY CONCAT(LEAST(messages.receiver_id,messages.sender_id),'.',
		GREATEST(messages.receiver_id, messages.sender_id))) as conversations
		WHERE messages.id = conversations.lastid AND (contacts.userID = '".$user_id."' OR contacts.friendID = '".$user_id."')
		ORDER BY messages.date_time DESC";
		$getContactList   = $this->db->query($contactListQuery)->result();

		$data['contactList'] = $getContactList;	
		$data['meta']        = $this->process_data;

		$this->load->view('includes/header-new', $data);
		$this->load->view('messages', $data);
		$this->load->view('includes/footer-new' );
	}

    public function searchContact() {
        $search = $this->input->post('search');
        $userID = $this->session->userdata('user_id');

        if($search != '') {
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
                            $search_results .= '<a href="' . base_url() . 'account/messages/' . $user->username . '">';
                                $search_results .= '<span>@' . $user->username . '</span>';
                            $search_results .= '</a>';
                            $search_results .= '</div>';
                        $search_results .= '</div>';
                    }
                endforeach;
            } else {    
                $search_results .= '<div class="user-data">';
                $search_results .= '<span>No Results Found</span>';
                $search_results .= '</div>';
            }
        } else {
            echo '';
        }

        
        echo $search_results;
    }

	public function processFile() {
		$chatID  = $this->input->post('chatID');
		$folder  = getcwd() . '/assets/frontend/uploads/messages/chat-' . $chatID;
		$dirname = $this->input->post('directory');
		
		if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        } 

		$filename 	 = $_FILES["file"]["name"];
		$source 	 = $_FILES["file"]["tmp_name"];
		$target_file = $folder . '/' . $filename;

		$temp = explode(".", $_FILES["file"]["name"]);
		$newfilename = rand(0000,9999).strtolower(round(microtime(true)) . '.' . end($temp));
		$fileUpload = $folder . '/' . $newfilename;

		if (move_uploaded_file($source, $fileUpload)) {
			echo '<input type="hidden" name="fileID[]" value="' . $newfilename . '" />';
		}
	}

	public function getStrickers() {
		$dataReturn['stickers'] = array();

		$stickerCategories = $this->process_data->get_data('chat_sticker_categories');

		foreach($stickerCategories as $category):
			$dataReturn['stickers'][$category->title] = array();

			$stickers = $this->process_data->get_data('chat_stickers', array('categoryID' => $category->ID)); 
			foreach($stickers as $sticker):
				$dataReturn['stickers'][$category->title][] = base_url() . 'assets/uploads/stickers/' . $sticker->filename;
			endforeach;	
		endforeach;	


		echo json_encode($dataReturn);
	}

	public function sendMessage() {
		$message     = $this->input->post('message_data');
		$receiver_id = $this->input->post('friendID');
		$threadID  	 = $this->input->post('chatID');
		$sender_id 	 = $this->session->userdata('user_id');
		$chatFiles 	 = $this->input->post('chatFiles');
		$type        = $this->input->post('type');
		$chatFile    = '';
		
		if(!empty($chatFiles)) {
			$chatFile = serialize($chatFiles);
		}

		$dataCreate = array(
			'chatID'	  => $threadID,
			'sender_id'   => $sender_id,
			'receiver_id' => $receiver_id,
			'message'     => $message,
			'file_data'   => $chatFile,
			'date_time'   => date('Y-m-d H:i:s'),
			'type'        => $type,
			'status'      => 1
		);

		$return   = $this->process_data->create_data('messages', $dataCreate);
		$userData = $this->process_data->get_data('users', array('id' => $sender_id));	

		if($type == 3) {
			$gifUrl   = $message; 
			$messageContent  = '<div class="message"><div class="msg-gif">';
			$messageContent .= '<img src="'.$gifUrl.'" />';
			$messageContent .= '</div></div>';
		} elseif($type == 4) {							
			$gifUrl   = $message;
			$messageContent  = '<div class="msg-sticker">';
			$messageContent .= '<img src="'.$gifUrl.'" />';
			$messageContent .= '</div>';
		} else {
			$convertedMessage = urldecode($message);
			$convertedMessage = $this->loademojione->getEmojisFromString($convertedMessage);

			$messageContent  = '<div class="message">';
			$messageContent .= $convertedMessage;
			$messageContent .= '</div>';
			
		}

		$data['message']  = '<li class="me">';
		$data['message'] .= '<div class="entete">';
		$data['message'] .= '<h3>' . date('H:i A') .'</h3>';
		$data['message'] .= '<h2>' . $userData[0]->username . '</h2>';
		$data['message'] .= '<span class="status blue"></span>';	
		$data['message'] .= '</div>';

		$data['message'] .= $messageContent;

		$folderPath = base_url() . 'assets/frontend/uploads/messages/chat-' . $threadID . '/';
		
		if(!empty($chatFiles)) {
			$data['message'] .= '<div class="fileData zoom-gallery">';
			foreach($chatFiles as $fileData):
				$data['message'] .= '<div class="chat-image">';
				$data['message'] .= '<a href="'.$folderPath.$file.'" data-effect="mfp-move-horizontal">';
				$data['message'] .= '<img src="'.$folderPath.$fileData.'" />';
				$data['message'] .= '</a></div>';
			endforeach;
			$data['message'] .= '</div>';
		}

		$data['message'] .= '</li>';

		$data['chatCount'] = count($this->process_data->get_data('messages', array('chatID' => $threadID)));

		$data['contactId'] = $receiver_id;

		$contactClass = 'class="user-contact chat-active"';

		$contactsData    = '<li ' . $contactClass . '  data-contact-id="'.$receiver_id.'" data-chat-count="0">';
		
		$chat_user_image = $this->process_data->get_user_meta('user_image', $receiver_id);
		$get_userdata    = $this->process_data->get_userdata($receiver_id);
		$username 		 = $get_userdata->username;
		
		if($chat_user_image == null) {
			$image_url = base_url() . 'assets/uploads/users/default.jpg';
		} else {
			$image_url = base_url() . 'assets/uploads/users/user-' . $receiver_id . '/' . $chat_user_image;
		}
		
		$contactsData .= '<a href="' .  base_url() . 'account/messages/' . $username . '">';
		$contactsData .= '<div class="sidebar-thumb">';
		$contactsData .= '<img src="' .  $image_url . '" alt="">';
		$contactsData .= '</div>';
		$contactsData .= '<div>';
		$contactsData .= '<h2>' . $username . '</h2>';

		$userStatus 	 = $get_userdata->log_status;
		$userStatusClass = strtolower($userStatus);

		$contactsData .= '<h3>';
		$contactsData .= '<span class="status ' . $userStatusClass . '"></span>';
		$contactsData .= $userStatus;
		$contactsData .= '</h3>';
		$contactsData .= '</div>';
		$contactsData .= '</a>';
		$contactsData .= '</li>';

		$data['chatContact'] = $contactsData;

		echo json_encode($data);
	}

	public function updateMessages($chatID, $chatCount) {
        $userID = $this->session->userdata('user_id');

        $getChatData = $this->process_data->get_data('messages', array('chatID' => $chatID));
		$newCount    = count($getChatData);
        
        if(count($getChatData) > $chatCount) {
            $limitOffset = count($getChatData) - $chatCount;

            //Getting messages of current query
            $query = "SELECT * FROM messages WHERE chatID = '".$chatID."' ORDER BY id LIMIT " . $chatCount . ', ' . $limitOffset;
            $messagesData = $this->db->query($query)->result();

            $htmlData = '';
			
            foreach($messagesData as $messageData):
                $senderID     = $messageData->sender_id;
                $message      = $messageData->message;
                $messageFiles = $messageData->file_data;
				$type         = $messageData->type;
				$userData 	  = $this->process_data->get_data('users', array('id' => $senderID));	

                if($senderID != $userID) {
	                $messageClass = ($senderID != $userID) ? 'me' : 'you';
	                if($type == 3) {
						$gifUrl   = $message; 
						$messageContent  = '<div class="message"><div class="msg-gif">';
						$messageContent .= '<img src="'.$gifUrl.'" />';
						$messageContent .= '</div></div>';
					} elseif($type == 4) {							
						$gifUrl   = $message;
						$messageContent  = '<div class="msg-sticker">';
						$messageContent .= '<img src="'.$gifUrl.'" />';
						$messageContent .= '</div>';
					} else {
						$convertedMessage = urldecode($message);
						$convertedMessage = $this->loademojione->getEmojisFromString($convertedMessage);
			
						$messageContent  = '<div class="message">';
						$messageContent .= $convertedMessage;
						$messageContent .= '</div>';
						
					}
			
					$htmlData .= '<li class="me">';
					$htmlData .= '<div class="entete">';
					$htmlData .= '<h3>' . date('H:i A') .'</h3>';
					$htmlData .= '<h2>' . $userData[0]->username . '</h2>';
					$htmlData .= '<span class="status blue"></span>';	
					$htmlData .= '</div>';
			
					$htmlData .= $messageContent;
			
					$folderPath = base_url() . 'assets/frontend/uploads/messages/chat-' . $chatID . '/';
					
					if(!empty($chatFiles)) {
						$htmlData .= '<div class="fileData zoom-gallery">';

						foreach($chatFiles as $fileData):
							$htmlData .= '<div class="chat-image">';
							$htmlData .= '<a href="'.$folderPath.$file.'" data-effect="mfp-move-horizontal">';
							$htmlData .= '<img src="'.$folderPath.$fileData.'" />';
							$htmlData .= '</a></div>';
						endforeach;
						
						$htmlData .= '</div>';
					}
			
					$htmlData .= '</li>';
	            }
            endforeach;

            echo json_encode(
                array(
                    'message'         => $htmlData,
                    'status'          => 1,
                    'chatCount'       => $newCount,
                    'updateChatCount' => $newCount . ' Messages'
                )
            );
        } else {
            echo json_encode(
                array(
                    'status'  => 0
                )
            );
        }
    }

    public function updateContacts($chatID = 0) {
        $userID = $this->session->userdata('user_id');


		$contactsData = "";

		$contactListQuery = "SELECT messages.*, contacts.userID, contacts.friendID FROM messages LEFT JOIN contacts ON contacts.id = messages.chatID, (SELECT MAX(messages.id) as lastid
		FROM messages
		WHERE (messages.receiver_id = '".$userID."' OR messages.sender_id = '".$userID."')

		GROUP BY CONCAT(LEAST(messages.receiver_id,messages.sender_id),'.',
		GREATEST(messages.receiver_id, messages.sender_id))) as conversations
		WHERE messages.id = conversations.lastid AND (contacts.userID = '".$userID."' OR contacts.friendID = '".$userID."')
		ORDER BY messages.date_time DESC";
		
		$contactList 	= $this->db->query($contactListQuery)->result();
		$contactIDs  	= array();
		$contactDataSet = array();
		$newChatCount   = array();

		foreach($contactList as $contact): 
			if($contact->status == 1) {
				if($contact->userID == $userID) {
					$contactID = $contact->friendID;
				} else {
					$contactID = $contact->userID;
				} 

				$contactIDs[] = $contactID;
				$contactClass = ($contact->chatID == $chatID) ? 'chat-active' : '' ;

				$notificationCount = $this->process_data->chatNotificationsCount($contact->chatID);

				$contactsData    = '<li class="user-contact ' . $contactClass . '"  data-contact-id="'.$contactID.'" data-chat-count="'.$notificationCount.'">';
				
				$chat_user_image = $this->process_data->get_user_meta('user_image', $contactID);
				$get_userdata    = $this->process_data->get_userdata($contactID);
				$username 		 = $get_userdata->username;
				
				if($chat_user_image == null) {
					$image_url = base_url() . 'assets/uploads/users/default.jpg';
				} else {
					$image_url = base_url() . 'assets/uploads/users/user-' . $contactID . '/' . $chat_user_image;
				}
	            
	            $contactsData .= '<a href="' .  base_url() . 'account/messages/' . $username . '">';
		        $contactsData .= '<div class="sidebar-thumb">';
				$contactsData .= '<img src="' .  $image_url . '" alt="">';
				$contactsData .= '</div>';
				$contactsData .= '<div>';
				$contactsData .= '<h2>' . $username . '</h2>';

				$userStatus 	 = $get_userdata->log_status;
				$userStatusClass = strtolower($userStatus);

				$contactsData .= '<h3>';
				$contactsData .= '<span class="status ' . $userStatusClass . '"></span>';
				$contactsData .= $userStatus;
				$contactsData .= '</h3>';

				if($chatID == $contact->chatID) {
					$updateSeen = array(
						'status' => 0
					);

					$this->process_data->create_data('messages', $updateSeen, array('chatID' => $chatID, 'receiver_id' => $userID));
				}

				$notificationCount = $this->process_data->chatNotificationsCount($contact->chatID);
				
				if($notificationCount > 0) {
					$contactsData .= '<div class="notify-contact-bubble">';
					$contactsData .= '<span class="bubbleCount">' . $notificationCount . '</span>';
					$contactsData .= '</div>';
				}				

				$contactsData .= '</div>';
				$contactsData .= '</a>';
				$contactsData .= '</li>';

				$contactDataSet[$contactID] = $contactsData;
				$newChatCount[$contactID]   = $notificationCount;
			}
		endforeach; 

        echo json_encode(
            array(
				'chatContacts' => $contactDataSet,
				'chatCount'    => $newChatCount,
				'contactIds'   => $contactIDs
            )
        );
    }

	public function update_header() {
		$teamName = $this->input->post('teamName');
		$team_name_show = $this->input->post('team_name_show');
		$team_logo_show = $this->input->post('team_logo_show');
		$user_id = $this->session->userdata('user_id');

		$this->process_data->update_user_meta('team_name', $teamName, $user_id);
		$this->process_data->update_user_meta('team_name_show', $team_name_show, $user_id);
		$this->process_data->update_user_meta('team_logo_show', $team_logo_show, $user_id);

		$data['team_name']  = $teamName;
		$data['team_title'] = $team_name_show;
		$data['team_logo']  = $team_logo_show;

		echo json_encode($data); 
	}

	public function search_member() {
		$search_keyword = $this->input->post('email');
		$user_type 		= $this->input->post('user_type');
		$search_query 	= "SELECT * FROM users WHERE username LIKE '%" . $search_keyword . "%' OR email LIKE '%" . $search_keyword . "%'";
		$searchData 	= $this->db->query($search_query)->result();

		$users_html = '';	
		$image_url  = base_url() . 'assets/uploads/users/default.jpg';

		if($user_type == 'add_member') {
			$url = 'add_member/member/';
			$url_email = 'add_member/email/';
			$user_class = 'invite-player-btn';
		} else {
			$url = 'add_spectator/';
			$url_email = 'add_spectator/email/';
			$user_class = 'invite-spectator-btn';
		}

		$playersData = array();

		if(count($searchData) > 0) {
			foreach($searchData as $user):
				if($user->id != $this->session->userdata('user_id')) {
					if($user_type == 'add_member') {
						$playersData = $this->process_data->get_data('team_members', array('user_id' => $user->id, 'status' => 1));
					}

					if(count($playersData) == 0) {
						$users_html .= '<div class="user-data">';
						$users_html .= '<div class="user-thumb">';
						$users_html .= '<img src="' . $image_url . '" />';
						$users_html .= '</div>';

						$users_html .= '<div class="inner-player-data">';
						$users_html .= '<h2>' . $user->email . '</h2>';
						$users_html .= '<span>@' . $user->username . '</span>';
						$users_html .= '</div>';

						$users_html .= '<div class="add-player-btn-row">';
						$users_html .= '<a href="' . base_url() . 'account/' . $url . $user->id . '" class="btn btn-curved btn-small ' . $user_class . '">Invite</a>';
						$users_html .= '</div>';
						$users_html .= '</div>';
					}
				}
			endforeach;
		} else {
			// Remove all illegal characters from email
			$email = filter_var($search_keyword, FILTER_SANITIZE_EMAIL);


			// Validate e-mail
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$users_html .= '<div class="user-data">';
				$users_html .= '<div class="user-thumb">';
				$users_html .= '<img src="' . $image_url . '" />';
				$users_html .= '</div>';

				$users_html .= '<div class="inner-player-data">';
				$users_html .= '<h2>'.$email.'</h2>';
				$users_html .= '</div>';

				$users_html .= '<div class="add-player-btn-row">';
				$users_html .= '<a href="'.base_url().'account/'.$url_email.$email.'" class="btn btn-curved btn-small '.$user_class.'">Invite</a>';
				$users_html .= '</div>';
				$users_html .= '</div>';
			} else {
				$users_html .= '<div class="user-data">';
				$users_html .= '<span>No Players Found</span>';
				$users_html .= '</div>';
			}
		}

		echo $users_html;
	}

	public function add_member($requestMethod = null, $playerID = null, $teamID = null) {
		if($requestMethod == 'member') {
			//Create join request
			$dataUser = array(
				'teamID'   => $teamID,
				'email'    => 'N/A',
				'reff_url' => 'N/A',
				'user_id'  => $playerID,
				'request'  => 1
			);

			
			$rowID = $this->process_data->create_data('team_members', $dataUser);
			
			$teamData = $this->process_data->get_data('team_profile', array('ID' => $teamID));;
			$url = base_url() . 'team/' . $teamData[0]->slug . '/join/' . $playerID;

			$dataUpdate = array('reff_url' => $url);
			$this->process_data->create_data('team_members', $dataUpdate, array('id' => $rowID));

			$team_name = $teamData[0]->team_name;

			//Creating Notification
			$description  = $team_name . " Request you to join their team.";

			$date_time = date('Y-m-d H:i:s');

			$data_notify = array(
				'userID' 	  => $playerID,
				'submitBy'    => $teamID,
				'description' => $description,
				'time_posted' => $date_time,
				'url'	      => $url,
				'type'		  => 'team_join_request',
				'status'	  => 0
			);

			$this->process_data->create_data('notification', $data_notify);
		} else {
			$user_email = $playerID;

			//Send invitaion to join team
			$dataUser = array(
				'teamID'   => $teamID,
				'email'    => $user_email,
				'reff_url' => 'N/A',
				'user_id'  => 0,
				'request'  => 3
			);

			$teamData = $this->process_data->get_data('users', array('id' => $teamID));

			$username   = $teamData[0]->first_name . ' ' . $teamData[0]->last_name;
			$registerID = $this->process_data->create_data('team_members', $dataUser);

			$email 	 = $this->db->get_where('email_notification', array('id' => 4));
            $subject = $email->row()->subject;

            $invitation_link = 'KSRCVR' . $registerID; 
            $invitation_link = 'https://dsoesports.org/register/affiliate/'.$invitation_link;

            $subject = str_replace('{username}', $username, $subject);

            $shortcodes    = array('{username}', '{invitation_link}');
            $dataChange    = array($username, $invitation_link);
            $email_message = str_replace($shortcodes, $dataChange, $email->row()->message);  
            $from          = "no-reply@dsoesports.org";
            $headers       = 'MIME-Version: 1.0' . "\r\n";
            $headers      .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers      .= "From:" . $from;

            mail($user_email,$subject,$email_message,$headers);   
		}

		$teamMembers = $this->process_data->get_data('team_members', array('teamID' => $teamID));

		echo count($teamMembers);
	}

	public function add_spectator($playerID = null) {
		$tournamentID = $this->input->post('tournamentID');
		$user_email   = $this->input->post('email');

		if($playerID != null) {
			//Create join request
			$dataUser = array(
				'tournamentID' => $tournamentID,
				'specID'       => $playerID,
				'status' 	   => 1
			);

			$rowID = $this->process_data->create_data('tournament_spectators', $dataUser);
		} else {
			return false;  
		}

		//Get user Details
		$userData = $this->process_data->get_data('users', array('id' => $playerID));

		$htmlReturn = '';

		$htmlReturn .= '<div class="select-player-box dso-spec-application">';
           $htmlReturn .= ' <div class="select-player-content">';
               $htmlReturn .= '<div class="select-player-data">';
               		$htmlReturn .= '<div class="dso-btn-abs">';
                        $htmlReturn .= '<div class="d-flex align-items-center gap-1">';
							$htmlReturn .= '<label>Normal Spectator</label>';
							$htmlReturn .= '<div class="toggle-btn">';
                                $htmlReturn .= '<input type="checkbox" id="switch' . $playerID . '" name="spectatorRole" value="' . $playerID . '" data-url="' .  base_url() . 'account/update_spectator_role/' . $tournamentID . '" />';
                                $htmlReturn .= '<label for="switch' . $playerID . '">Toggle</label>';
                            $htmlReturn .= '</div>';
							$htmlReturn .= '<label>Super Admin</label>';
						$htmlReturn .= '</div>';
					$htmlReturn .= '</div>';

                    $htmlReturn .= '<h5>@'.  $userData[0]->username . '</h5>';
                    $htmlReturn .= '<p>';
                        $htmlReturn .= '<strong>Email : </strong>';
                        $htmlReturn .= '<span>'. $userData[0]->email . '</span>';
                    $htmlReturn .= '</p>';

					$user_social = $this->process_data->get_user_meta('user_social_contact', $userData[0]->id);

                    $htmlReturn .= '<div class="player-social">';
                    	$htmlReturn .= "<p>";
                        $htmlReturn .= '<strong>Social : </strong>';

                        if($user_social) {
						$htmlReturn .= '</p>';
							$social_data = unserialize($user_social);
						
							$htmlReturn .= '<ul class="ft-social">';
							foreach($social_data as $platform => $url):
								if($url != null) {
						
									$htmlReturn .= '<li>';
										$htmlReturn .= '<a href="' . $url . '" target="_blank">';
											$htmlReturn .= '<i class="fab fa-'. $platform . '"></i>';
										$htmlReturn .= '</a>';
									$htmlReturn .= '</li>';
								 } 
							endforeach;
							$htmlReturn .= '</ul>';
						} else {
                        	$htmlReturn .= '<span>';
							$htmlReturn .= 'Socialy Inactive';
                        	$htmlReturn .= '</span>';
							$htmlReturn .= '</p>';
						}
                    $htmlReturn .= '</div>';

                    $htmlReturn .= '<p>';
                        $htmlReturn .= '<strong>Discord : </strong>';
                        $htmlReturn .= '<span>';
                            $htmlReturn .= $userData[0]->discord_username; 
                        $htmlReturn .= '</span>';
                    $htmlReturn .= '</p>';
                $htmlReturn .= '</div>';

                $htmlReturn .= ' <div class="player-btn-row">';
                    $htmlReturn .= '<a href="'. base_url() .'account/processSpectator" class="btn dso-ebtn-sm spectator-request" data-id="'. $userData[0]->id .'" data-status="3">';
                        $htmlReturn .= '<span class="dso-btn-text">Remove</span>';
                        $htmlReturn .= '<div class="btn-loader">';
                        $htmlReturn .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
                        $htmlReturn .= '</div>';
                   $htmlReturn .= ' </a>';
	        	$htmlReturn .= '</div>';
	        $htmlReturn .= '</div>';
        $htmlReturn .= '</div>';

        //Getting current players count
		$currentSpectators = $this->process_data->get_data('tournament_spectators', array('tournamentID' => $tournamentID, 'status' => 1));

		//Get Tournament Data
		$tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));

		$allowed_spectators = $tournamentData[0]->max_allowed_spectators;
        $active_spectators  = count($currentSpectators);
        $get_spectators_per = (100 / $allowed_spectators) * $active_spectators;

        $prgress_bar_class = 'bg-danger';

        if($get_spectators_per > 60) {
            $prgress_bar_class = 'bg-warning';
        }

        if($get_spectators_per == 100) {
            $prgress_bar_class = 'bg-success';
        }
		
        //Get Old Class
        $active_spec_old  = count($currentSpectators) - 1;
        $get_spectators_per_old = (100 / $allowed_spectators) * $active_spec_old;

        $prgress_bar_class_before = 'bg-danger';
        if($get_spectators_per_old > 60) {
            $prgress_bar_class_before = 'bg-warning';
        }

        if($get_spectators_per_old == 100) {
            $prgress_bar_class_before = 'bg-success';
        }

		$dataReturn['spectatorsCounter']  = $active_spectators . '/' . $allowed_spectators;
		$dataReturn['spectator_per'] 	  = $get_spectators_per . '%';
		$dataReturn['spectator_addClass'] = $prgress_bar_class;
		$dataReturn['spectator_oldClass'] = $prgress_bar_class_before;
		$dataReturn['spectator_html']	  = $htmlReturn;

		echo json_encode($dataReturn);
	}

	public function update_spectator_role($tournamentID = null) {
		$spectatorID = $this->input->post('id');
		$role 		 = $this->input->post('roleSet');

		if($tournamentID != null) {
			$currentSpectators = $this->process_data->get_data('tournament_spectators', array('tournamentID' => $tournamentID));

			foreach($currentSpectators as $spectator):
				$dataUpdate = array('role' => 0);

				$this->process_data->create_data('tournament_spectators', $dataUpdate, array('specID' => $spectator->specID));
			endforeach;

			$this->process_data->create_data('tournament_spectators', 
				array('role' => $role), array('id' => $spectatorID));
		} else {
			exit;
		}
	}

	public function processJoin() {
        $userID 	  = $this->session->userdata('user_id');
        $tournamentID = $this->input->post('tournament_id');
        $userType 	  = $this->session->userdata('user_role');

        $dataCreate = array(
        	'tournamentID' 	=> $tournamentID,
        	'participantID' => $userID,
        	'type' 			=> $userType,
        	'status' 		=> 1
        );

        //Check min required players
        $getTournament = $this->process_data->get_tournaments(array('tournament.id' => $tournamentID)); 

        if($getTournament[0]->allowed_participants == 1) {
        	$dataCreate['team_members'] = serialize($this->input->post('tournamentMembers'));
        }

        $maxPlayers = $getTournament[0]->max_allowed_players;
        $getPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));

        if(count($getPlayers) <= $maxPlayers) {
        	$this->process_data->create_data('tournament_players', $dataCreate);

		    $dataCredits = $this->process_data->get_data('users', array('id' => $userID));
        	
        	if($getTournament[0]->req_credits > 0) {
		        $newCredits  = ($dataCredits[0]->credit == 0) ? 0 : ($dataCredits[0]->credit - $getTournament[0]->req_credits);

		        $this->process_data->create_data('users', array('credit' => $newCredits) , array('id' => $userID));
	        	$data['remain_credits'] = $dataCredits[0]->credit - $getTournament[0]->req_credits;
		    } else {
		    	$data['remain_credits'] = $dataCredits[0]->credit;
		    }

	        $data['url'] 	 = base_url() . 'tournaments/' . $getTournament[0]->category_slug . '/' . $getTournament[0]->game_slug . '/' . $getTournament[0]->slug;
	        $data['message'] = '<div class="message"><i class="fa fa-check-circle"></i> Thank you for taking interest and joining the tournament.</div>';
	    } else {
	    	$data['url'] 	 = base_url() . 'tournaments/' . $getTournament[0]->category_slug . '/' . $getTournament[0]->game_slug . '/' . $getTournament[0]->slug;
	    	$data['message'] = '<div class="message"><i class="fa fa-times-circle"></i> Sorry you are late the registration is closed.</div>';
	    }

        echo json_encode($data);
    }

    public function test_data() {
    	$membersData = $this->input->post('tournamentMembers');

    	print_r($membersData);
    }

    public function create_topic() {
    	$userID 	   	   = $this->session->userdata('user_id');
    	$post_title 	   = $this->input->post('post_title');
    	$topic_description = $this->input->post('topic_description');

    	$dataCreate = array(
    		'title' 	  => $post_title, 
    		'description' => $topic_description,
    		'teamID' 	  => $userID,
    		'views'  	  => 0
    	);

    	$postID = $this->process_data->create_data('discussion', $dataCreate);

    	$htmlData = '<div class="post-dsc">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-8 col-forum-info">
                                <div class="topic-title">                                               
                                    <h2 class="entry-title h4 mt-2 pb-2 pr-5">
                                        <a class="bbp-topic-permalink p-permalink" href="'.base_url(). 'account/get_topic' . '" data-post="'.$postID.'">'.$post_title.'</a>
                                    </h2>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 col-forum-meta mt-4 mt-md-0">
                                <div class="row">
                                    <div class="col topic-voice-count">
                                        <div class="small text-uppercase font-weight-bold">
                                            Views                   </div>
                                        <div class="h3">
                                            0                   </div>
                                    </div>
                                    <div class="col topic-reply-count">
                                        <div class="small text-uppercase font-weight-bold">
                                            Replies                 </div>
                                        <div class="h3">
                                            0                  </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

        echo $htmlData;            
    }

    public function get_topic() {
    	$postID   = $this->input->post('postID');
    	$postData = $this->process_data->get_data('discussion', array('id' => $postID));
    	$postComments = $this->process_data->get_topic_comments($postID);

    	$data['post_title']   = $postData[0]->title;
    	$data['post_content'] = $postData[0]->description;
    	$data['date_created'] = $postData[0]->date_created;
    	$data['views'] 		  = $postData[0]->views;
    	$data['postID'] 	  = $postID;
    	$data['postComments'] = $postComments;
    	$data['ci'] = $this->process_data;

    	$this->load->view('topic-details', $data);
    }

    public function post_comment() {
    	$postID  = $this->input->post('postID');
    	$userID  = $this->session->userdata('user_id');
    	$comment = $this->input->post('comment');

    	$this->process_data->create_data('comments', array(
    		'userID' => $userID,
    		'postID' => $postID,
    		'post_type' => 'team_topic',
    		'comment' => $comment,
    		'date_posted' => date('H:i:s Y-m-d')
    	));

    	//Get User Data
    	$userData = $this->process_data->get_data('users', array('id' => $userID));

    	echo '<div class="comment">
				<div class="thumb"><i class="fa fa-user"></i></div>
				<div class="comment-content">
					<h4>
						<a href="'.base_url().'profile/'.$userData[0]->username.'">'.$userData[0]->first_name . ' ' . $userData[0]->last_name . '</a>
						<span><i class="fa fa-calendar-alt"></i> '.date('F d') .','.date('Y') . ' at '. date('h:i:s A').'</span>
					</h4>

					<p>'.$comment.'</p>
				</div>
			</div>';
    }

    public function buy_credits() {
    	if($this->session->userdata('is_logged_in') != true) {
            redirect('login');
        }

        $userID = $this->session->userdata('user_id');

        //Check if package has been purchased 
        $userData = $this->process_data->get_data('users', array('id' => $userID));

        if($userData[0]->membership > 0) {

        } else {
        	redirect('my-account');
        }
    }

    public function getTeamPlayers($tournamentID = null) {
    	if($tournamentID != null) {
	    	$teamID = $this->session->userdata('user_id');

	    	$html = '<div class="dso-lg-content m-b-20">
	                    <h3>Select Players To Join</h3>
	                </div>';
	        $get_participents = false;
	        $getPlayersData = $this->process_data->get_data('team_members', array('teamID' => $teamID, 'status' => 1));
        } else {
        	$html = '';
        	$teamID = $this->input->post('teamID');
        	$tournamentID = $this->input->post('tournamentID');
        	$get_participents = true;
        	$teamPlayers = $this->process_data->get_data('tournament_players', array('participantID' => $teamID, 'tournamentID' => $tournamentID));
        	$teamMembersID = implode(',', unserialize($teamPlayers[0]->team_members));

        	$getPlayersData = $this->db->query("SELECT * FROM `team_members` WHERE teamID = '".$teamID."' AND user_id IN (".$teamMembersID.")")->result();
        }
       
	    $tournamentData = $this->process_data->get_tournaments(array('tournament.id' => $tournamentID));

    	$html .= '<div class="team-row">';

    	foreach($getPlayersData as $player):
    		$playerData = $this->process_data->get_data('users', array('id' => $player->user_id));
    		$html .= '<div class="select-player-box">';
    		if($get_participents == false) {
	    		$html .= '<div class="player-btn-row">';
	            
	            if($tournamentData[0]->req_credits == 0) {
	    			$html .= '<a href="javascript:void(0);"" class="btn dso-ebtn-sm btn-select" data-id="'.$playerData[0]->id.'">';
	            	$html .= '<span class="dso-btn-text">Select</span>';
	            	$html .= '<div class="btn-loader">';
	            	$html .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
	            	$html .= '</div>';
	            	$html .= '</a>';
	    		} else {
	    			if($playerData[0]->credit > $tournamentData[0]->req_credits) {
	    				$html .= '<a href="javascript:void(0);"" class="btn dso-ebtn-sm btn-select" data-id="'.$playerData[0]->id.'">';
		            	$html .= '<span class="dso-btn-text">Select</span>';
		            	$html .= '<div class="btn-loader">';
		            	$html .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
		            	$html .= '</div>';
		            	$html .= '</a>';
	    			} else {
	    				$html .= '<a href="'.base_url().'account/addCreditsPlayer/'.$tournamentID.'" class="btn dso-ebtn-sm add-credits-player-btn" data-id="'.$playerData[0]->id.'">';
		            	$html .= '<span class="dso-btn-text">Add Credits</span>';
		            	$html .= '<div class="btn-loader">';
		            	$html .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
		            	$html .= '</div>';
		            	$html .= '</a>';
	    			}
	    		}
			    
			    $html .= '</div>';//End Button Row
			}
    		
    		$html .= '<div class="thumbnail-circle '.strtolower($playerData[0]->log_status).'">';
            
    		$get_image = $this->process_data->get_user_meta('user_image', $playerData[0]->id);
    		
    		if($get_image == null) {
    			$image_url = base_url() . 'assets/uploads/users/default.jpg';
    		} else {
    			$image_url = base_url() . 'assets/uploads/users/user-' . $playerData[0]->id . '/' . $get_image;
    		}

            $html .= '<img loading="lazy" src="'. $image_url .'" class="avatar user-25-avatar avatar-450 photo" />';
            $html .= '</div>';//Avatar End
    		
            $html .= '<div class="select-player-content">';
            
            $html .= '<div class="select-player-data">';
            $html .= '<h5 class="text-truncate">@'.$playerData[0]->username.'</h5>';
            if($get_participents == false) {
	            $html .= '<p><strong>Available Credits :</strong> <span class="player-credits">'.$playerData[0]->credit.'</span></p>';
	        }
            $html .= '</div>';//End Player Data

            $html .= '</div>';//Player Content

    		$html .= '</div>';//End Player Box
    	endforeach;

    	$html .= '</div>';
    	
    	if($get_participents == false) {
	    	$html .= '<div class="message" style="display: none;"></div>';
	    	$html .= '<div class="players-required">';
	    	$html .= '<p>Required Players To Join <span class="req-players-join">' . $tournamentData[0]->max_team_players . '</span> - <span class="selected-players-count">0</span>';
	    	$html .= '</div>';
	    	$html .= '<input type="hidden" name="tournament_id" value="' . $tournamentData[0]->id . '" />';
	    	$html .= '<div class="dso-btn-row">';
	    	$html .= '<a href="'.base_url().'account/processJoin" class="btn dso-ebtn dso-ebtn-solid confirm-selection" style="display: none;">';
	    	$html .= '<span class="dso-btn-text">Confirm</span>';
	        $html .= '<div class="dso-btn-bg-holder"></div>';
	        $html .= '</a>';
	    	$html .= '<a href="javascript:void(0);" class="btn dso-ebtn dso-ebtn-outline cancel-selection">';
	    	$html .= '<span class="dso-btn-text">Cancel</span>';
	        $html .= '<div class="dso-btn-bg-holder"></div>';
	        $html .= '</a>';
	    	$html .= '</div>';
	    }


    	echo $html;
    }

    public function addCreditsPlayer($tournamentID = null) {
    	$teamID     = $this->session->userdata('user_id');
    	$playerID   = $this->input->post('playerID');
    	$teamData   = $this->process_data->get_data('users', array('id' => $teamID));
    	$playerData = $this->process_data->get_data('users', array('id' => $playerID)); 

    	$tournamentData = $this->process_data->get_tournaments(array('tournament.id' => $tournamentID));

    	$teamAccountCredits = $teamData[0]->credit - $tournamentData[0]->req_credits;
    	$userAccountCredits = $playerData[0]->credit + $tournamentData[0]->req_credits;

    	if($teamAccountCredits > $tournamentData[0]->req_credits) {
	    	$this->process_data->create_data('users', array('credit' => $userAccountCredits), array('id' => $playerID));
	    	$this->process_data->create_data('users', array('credit' => $teamAccountCredits), array('id' => $teamID));
	    	$data['status'] = 1;
	    	$data['playerCredits'] = $userAccountCredits;
	    	$data['message'] = 'Topup successfull';
	    } else {
	    	$data['status']  = 0;
	    	$data['message'] = 'Your account does not have enough credits to support the player please topup your account';
	    }

	    echo json_encode($data);
    }

    public function tournaments($method = null, $id = null, $arrg = null, $round = null, $round_num = null) {
		if($this->session->userdata('is_logged_in') == true) {
			$data = array(
				'title' => 'Login',
				'class' => 'inner',
			);

			$data_cond = array(
                'user_id' => $this->session->userdata('user_id')
            );

            if($id != null) {
                $data_cond['id'] = $id;
            }
            
            $dataVideo = $this->db->get_where('videos', $data_cond);
            $data['meta'] = $this->process_data;
            $data['categoriesData'] = $this->process_data->get_data('categories');
            $data['gamesData'] 	= $this->process_data->get_games();

            if($method == 'create') {
            	$data['title'] = 'Create Tournament';

            	if($id != null) {
	            	$data_tournament = array(
		                'tournament.id' => $id
		            );

		            $data['tournamentData'] = $this->process_data->get_tournaments_by_cond($data_tournament); 
		        } else {
		        	$data['tournamentData'] = array();
		        }

                $data['page_active'] = 'create-tournaments';
                $data['tournamentID'] = $id;
                $page = 'create-tournament';
            } elseif($method == 'matches' && $id != null) {
            	$data['title'] = 'Manage Tournament Matches';

            	$data['page_active'] = 'manage-tournaments';

            	$data['tournamentData'] = $this->process_data->get_data('tournament', array('slug' => $id));
            	$tournamentID 		    = $data['tournamentData'][0]->id;
            	$data['tournamentID']   = $tournamentID; 

				if($arrg == 'create') { 
					$check = $this->process_data->create_match($tournamentID);
		
					if($check == true) {
						$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Match created successfully.</div>');
					} else {
						$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-times-circle"></i> Match cannot be created at this moment the minimum required players to start the match did not meet.</div>');
					}

					redirect('account/tournaments/matches/'.$id);
				} else {	
					$data['arrg'] = $arrg;
					if($arrg != 'round') {
						$round = 1;
						if($arrg == 'reset-match' && $round == null) {
							$round = 1;
						} else {
							if($arrg == 'reset-match' && $round_num != null) {
								$round = $round_num;
							}
						}
					}

					$faceoff = 0;

					if($arrg == 'faceoff-matches') {
						$faceoff = 1;
						$round   = 1;
						if($round_num != null) {
							$round = $round_num;
						}
					}

					$param = '';

					$data['activeRound'] = $round;
					$data['playersData'] = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));
					$data['matchesData'] = $this->process_data->get_matches($tournamentID, $round, $faceoff);
					$data['totalRounds'] = $this->process_data->get_rounds($tournamentID); 
					
					$data['trounamentSpectators'] = $this->db->query("SELECT tournament_spectators.*, users.username, users.email, users.discord_username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '".$tournamentID."'")->result();
					$data['spectatorsCount'] = $this->db->query("SELECT tournament_spectators.*, users.username, users.email, users.discord_username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '".$tournamentID."' AND tournament_spectators.status = 1")->result();
					
					if($arrg == 'reset-match') {
						$param = "/reset-match";
						$data['active_url'] = base_url() . 'account/tournaments/matches/' . $id . $param;
					} else {
						$data['active_url'] = base_url() . 'account/tournaments/matches/' . $id . $param;
					}

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
				    } 
				}

				if($arrg == 'reset-match') {
					$page = 'tournament/reset-match';
				} elseif($arrg == 'update-match') {
					$tournamentData    = $this->process_data->get_data('tournament', array('slug' => $id));
					$tournamentMatches = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentData[0]->id));

					foreach($tournamentMatches as $match):
						if($match->player_1_ID == 0 && $match->player_2_ID == 0) {
							$this->db->where(array('id' => $match->id))->delete('tournament_matches');
						}
					endforeach;

					redirect('account/tournaments/matches/'.$id);

				} else {
                	$page = 'tournament/manage-matches';
				}
            } elseif($method == 'notice-board') {
            	$data['title'] = 'Tournament Notice Board';

            	$data['page_active'] = 'manage-tournaments';
            	$data['notice'] = true;
				$data['slug'] = $id;
				$data['tournamentData']   = $this->process_data->get_data('tournament', array('slug' => $id));
				$data['announcmentsData'] = $this->process_data->get_data('tournament_notice', array('tournamentID' => $data['tournamentData'][0]->id));

				if($arrg == 'create' && $round == null) {
					$data['notice']  = false;
					$data['message'] = null;
					$data['id']      = null;
				} elseif($arrg == 'create' && $round != null) {
					$data['notice']  = false;
					$announcmentData = $this->process_data->get_data('tournament_notice', array('id' => $round));

					$data['message'] = $announcmentData[0]->message;
					$data['id']      = $round;
				} elseif($arrg == 'delete') {
					$this->db->where('id', $arrg_id)->delete('tournament_notice');

					$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament notice deleted successfully.</div>');

					redirect('account/tournament/notice-board/' . $id);
				}

				$page = 'notice-board';
            } elseif($method == 'attending') {
                $data['page_active'] = 'attending-tournaments';
                $data['title'] = 'Tournament Attending';
                
                $userID = $this->session->userdata('user_id');

                if($id == null) {
                    $tournamentMatches = $this->db->query("SELECT * FROM `tournament_matches` WHERE (player_1_ID = '" . $userID . "' OR player_2_ID = '" . $userID . "')")->result();
       				
       				$tournamentIDSets = array();

                    foreach($tournamentMatches as $match):
                        $tournamentIDSets[] = $match->tournamentID;
                    endforeach;

                    if(empty($tournamentIDSets)) {
                    	$data['tournamentsData'] = array();
                    } else {

	                    $tournamentIDSets = implode(',', $tournamentIDSets);

	                    $data['tournamentsData'] = $this->db->query("SELECT * FROM tournament WHERE id IN (".$tournamentIDSets.") ORDER BY id DESC")->result();
					}

                    $page = 'tournament/tournaments-attending';
                } else {
                    $data['title'] .= ' Match';

                    $data['tournamentData'] = $this->process_data->get_data('tournament', array('slug' => $id));
                    $tournamentID = $data['tournamentData'][0]->id;
                    $currentMatch = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND (player_1_ID = '" . $userID . "' OR player_2_ID = '" . $userID . "') AND match_status < 5";
                    $data['currentMatch'] = $this->db->query($currentMatch)->result();

					if(count($data['currentMatch']) == 0) {
						$currentMatch = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND (player_1_ID = '" . $userID . "' OR player_2_ID = '" . $userID . "') AND match_status = 5";
                    	$data['currentMatch'] = $this->db->query($currentMatch)->result();
					}
					
					if($data['currentMatch'][0]->player_1_ID == $userID) {
						$slot = 1;
					} else {
						$slot = 2;
					}

					$matcheChat   = $this->process_data->get_data('tournament_chat_group', array('matchID' => $data['currentMatch'][0]->id, 'slot' => $slot));

					if(count($matcheChat) == 0) {
						//Create New Round Chat Group
						$dataMemebers[] = $userID;
						//Get tournament Spectators
						$tournamentSpectators = "SELECT tournament_spectators.*, users.username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '" . $tournamentID . "'";
						$tournamentSpectators = $this->db->query($tournamentSpectators)->result();

						foreach($tournamentSpectators as $spectator):
							$dataMemebers[] = $spectator->specID;
						endforeach;

						$tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
						array_push($dataMemebers, $tournamentData[0]->created_by);

						$membersID = serialize($dataMemebers);

						$dataChatGroup = array(
							'matchID'  => $data['currentMatch'][0]->id,
							'memberID' => $membersID,
							'slot'     => $slot
						);

						$this->process_data->create_data('tournament_chat_group', $dataChatGroup);	

						$matcheChat = $this->process_data->get_data('tournament_chat_group', array('matchID' => $data['currentMatch'][0]->id, 'slot' => $slot));
					}

					$messagesData = $this->process_data->get_data('tournament_chat_messages', array('chatID' => $matcheChat[0]->ID));

					$data['messagesData'] = $messagesData;
					$data['chatID']      = $matcheChat[0]->ID;
					$tournamentSpectators = "SELECT tournament_spectators.*, users.username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '" . $tournamentID . "'";
                    
					$data['tournamentSpectators'] = $this->db->query($tournamentSpectators)->result();
                    $data['userID'] = $userID;

                    $page = 'tournament/tournament-attending-match';
                }
            } elseif($method == 'delete') {
                $folder_path = getcwd() . '/assets/frontend/images/tournaments/'; 
				$get_image = $this->process_data->get_data('tournament', array('id' => $id));

				$image_name = $get_image[0]->image;
				unlink($folder_path . '/' . $image_name);

				$this->db->where('id', $id)->delete('tournament');
				$this->db->where('post_id', $id)->delete('tournament_meta');
				$this->db->where('tournamentID', $id)->delete('tournament_spectators');
				$this->db->where('tournamentID', $id)->delete('tournament_players');

				$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Tournament Deleted Successfully.</div>');

				redirect('account/tournaments');
            } else {
            	$data['title'] = 'Manage Tournament';
            	
            	$data['page_active'] = 'manage-tournaments';
                $data['tournamentsData'] = $this->process_data->get_tournaments(array('created_by' => $data_cond['user_id'], 'order_by_id' => 'DESC'));

		        if(count($data['tournamentsData']) > 0) {
		            $data['participents'] = $this->process_data->get_participents($data['tournamentsData'][0]->id);
		        }

                $page = 'manage-tournaments';
            }

            $this->load->view('includes/header-new', $data);
            $this->load->view($page, $data);
            $this->load->view('includes/footer-new');
		} else {
			redirect('login');
		}
	}

	public function processTournament() {
		$step = $this->input->post('target');
		$tournamentID = $this->input->post('tournamentID');
		
		$data = array();

		if($tournamentID != null) {
        	$data_tournament = array(
                'tournament.id' => $tournamentID
            );

            $data['tournamentData'] = $this->process_data->get_tournaments_by_cond($data_tournament); 
            $data['tournament_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $tournamentID, 'meta_type' => 'prize_data'))->result();
            $data['stats_meta'] = $this->db->get_where('tournament_meta', array('post_id' => $tournamentID, 'meta_type' => 'stats_data'))->result();
        } else {
        	$data['tournamentData'] = array();
        	$data['tournament_meta'] = '';
        	$data['stats_meta'] = '';
        }

		$btnHtml = '';

		$dataReturn['final'] = 0;

		if($step == '2') {
			$btnHtml = '<button type="button" class="btn dso-ebtn dso-ebtn-outline btn-prev" data-target="1">
                <span class="dso-btn-text">Previous</span>
                <div class="dso-btn-bg-holder"></div>
            </button>';
		}

        if($step == '2') {
            $dataReturn['dataForm'] = $this->load->view('tournament/basic-details', $data, true);
        }

        if($step == '3') {
            $dataReturn['dataForm'] = $this->load->view('tournament/prize-pool', $data, true);
        }

        if($step == '4') {
        	$data['username'] = $this->process_data->get_username($this->session->userdata('user_id'));
            $dataReturn['dataForm'] = $this->load->view('tournament/statistics', $data, true);
        }

        if($step == '5') {
            $dataReturn['dataForm'] = $this->load->view('tournament/tournament-settings', $data, true);
        }

        if($step == '6') {
        	$dataReturn['final']    = 1;
        	$dataReturn['url']      = base_url() . 'account/createTournament';
            $dataReturn['dataForm'] = $this->load->view('tournament/review', $data, true);
        }

        $dataReturn['prevStep']   = $step - 1;
        $dataReturn['btnData']    = $btnHtml;
        $dataReturn['targetStep'] = $step;
        $dataReturn['nextStep']   = $step + 1;


        echo json_encode($dataReturn);
	}

	public function createTournament() {
		$userID      = $this->session->userdata('user_id');
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
		$bracket 	 = $this->input->post('bracket_req');
		$type 		 = $this->input->post('type');
		$playoff	 = $this->input->post('advancedStageNeeded');
		$match_type  = $this->input->post('match_type');
		$meta_title  = $this->input->post('placement');
		$meta_value  = $this->input->post('prize');
		$stat_title  = $this->input->post('stat_title');
		$stat_value  = $this->input->post('stat_value');
		$id 		 = $this->input->post('tournamentID');

		$max_players  	= $this->input->post('max_players');
		$max_spectators = $this->input->post('max_spectators');

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
			$currentFile = $this->input->post('current_file'); 
			$dataInsert['filename'] = $currentFile;
		}

		//Create Slug 
		$slug = $this->process_data->slugify($title);

		$checkSlug = $this->db->query("SELECT * FROM tournament WHERE slug LIKE '%" .$slug . "%'");
		
		if($checkSlug->num_rows() > 0) {
			$count = $checkSlug->num_rows();
			$slug = $slug . '-' . $count;
		}

		if(!empty($id)) {
			$t_id = array('id' => $id);


		}

		if($id == null) {
			$tournamentID = $this->process_data->create_data('tournament', 
				array(
					'created_by' => $userID,
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
					'max_allowed_players' => $max_players, 
					'max_allowed_spectators' => $max_spectators,
					'req_credits' => 0,
					'allowed_participants' => $match_type,
					'mode' => 1,
					'category_type' => 'community',
					'type' => $type,
					'advancedStageNeeded' => $playoff,
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
			$tournamentID = $id;
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
				'brackets' => $bracket,
				'type' => $type,
				'max_allowed_players' => $max_players, 
				'max_allowed_spectators' => $max_spectators,
				'allowed_participants' => $match_type,
				'max_team_players' => $max_players
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

        $gamesData 	= $this->process_data->get_games($game_id);
		$categoriesData = $this->process_data->get_data('categories', array('id' => $category_id));

		$data['tournament_url'] = base_url() . 'tournaments/' . $categoriesData[0]->slug . '/' . $gamesData[0]->slug . '/' . $slug; 
		$data['tournamentID']   = $tournamentID;
		
		echo $this->load->view('tournament/confirmation', $data, true);
 	}

 	public function updateTournamentStatus() {
		$id 	 = $this->input->post('id');	
		$status  = $this->input->post('status');	

		$dataUpdate = array(
			'mode' => $status,
		);

		$this->process_data->create_data('tournament', $dataUpdate, array('id' => $id));
	}

	public function kick_player($tournamentID) {
		$playerID = $this->input->post('playerID');

		$tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));

		//Check if previously player got kicked get toal number of kicks he faced
		$tournamentPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'participantID' => $playerID));

		if($tournamentPlayers[0]->kick_count < 3) {
			$kick_count = $tournamentPlayers[0]->kick_count + 1;
			$data_update = array(
				'kick_count' 		=> $kick_count,
				'ban_start_period' 	=> date('Y-m-d H:i:s'),
				'ban_end_period' 	=> date('Y-m-d H:i:s', strtotime('+5 hours')),
				'rejoin' 			=> 0,
				'status'			=> 0
			);

			$this->process_data->create_data('tournament_players', $data_update, array('tournamentID' => $tournamentID, 'participantID' => $playerID));

			//Create Notification
			$teamID 	= $this->session->userdata('user_id');
			$getMeta   	= $this->process_data->get_data('users', array('id' => $teamID));
			$username 	= $getMeta[0]->username;

			$description  = "You got kicked by." . $username . " From the Tournament";

			$date_time = date('Y-m-d H:i:s');

			$data_notify = array(
				'userID' 	  => $playerID,
				'submitBy'    => $teamID,
				'description' => $description,
				'time_posted' => $date_time,
				'url'	      => '#',
				'type'		  => 'team_join_request',
				'status'	  => 0
			);

			$this->process_data->create_data('notification', $data_notify);
		} else {

		}

		//Getting current players count
		$currentPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));

		$allowed_players = $tournamentData[0]->max_allowed_players;
        $active_players  = count($currentPlayers);
        $get_players_per = (100 / $allowed_players) * $active_players;

        //Get Old Class
        $active_players_old  = count($currentPlayers) + 1;
        $get_players_per_old = (100 / $allowed_players) * $active_players_old;

        $prgress_bar_class_before = 'bg-danger';
        if($get_players_per_old > 60) {
            $prgress_bar_class_before = 'bg-warning';
        }

        if($get_players_per_old == 100) {
            $prgress_bar_class_before = 'bg-success';
        }

        $prgress_bar_class = 'bg-danger';

        if($get_players_per > 60) {
            $prgress_bar_class = 'bg-warning';
        }

        if($get_players_per == 100) {
            $prgress_bar_class = 'bg-success';
        }

		$dataReturn['players_count']    = $active_players . '/' . $allowed_players;
		$dataReturn['players_progress'] = $get_players_per . '%';
		$dataReturn['current_class']    = $prgress_bar_class;
		$dataReturn['previous_class']   = $prgress_bar_class_before;

		echo json_encode($dataReturn);
	}

	private function create_looser_log($tournamentID, $playerID, $lossCount = 1) {
		// Prepare data for loss count
	    $looserCountData = array(
	        'tournamentID' => $tournamentID,
	        'playerID'     => $playerID,
	        'meta_key'     => 'loss_count',
	    );

	    // Check for existing loss count
	    $existingLooserCount = $this->process_data->get_data('tournament_matches_meta', array(
	        'tournamentID' => $tournamentID,
	        'playerID'     => $playerID,
	        'meta_key'     => 'loss_count',
	    ));

	    if (empty($existingLooserCount)) {
	        // No existing record, create a new one
	        $looserCountData['meta_value'] = $lossCount;
	        $this->process_data->create_data('tournament_matches_meta', $looserCountData);
	    } else {
	        // Existing record found, update it
	        $currentLossCount = (int)$existingLooserCount[0]->meta_value;
	        $looserCountData['meta_value'] = $currentLossCount + $lossCount;
	        $this->process_data->update_data('tournament_matches_meta', $looserCountData, array('ID' => $existingLooserCount[0]->ID));
	    }
	}

	public function matches($method = null, $matchID = null, $playerID = null, $userType = null) {
		$userID = $this->session->userdata('user_id');
        
        $getTournamentQuery = "SELECT tournament.* FROM tournament LEFT JOIN tournament_matches ON tournament_matches.tournamentID = tournament.id WHERE tournament_matches.id = '" . $matchID . "'";
        $tournamentData     = $this->db->query($getTournamentQuery)->result();

		if($method == 'setReady') {
			$checkPlayersStatus = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
			$matchStatus = 0;

			if($playerID == 1) {
				if($checkPlayersStatus[0]->player_2_status == 1) {
					$dataUpdate['match_status'] = 2;
					$matchStatus = 2;
				} 
			} else {
				if($checkPlayersStatus[0]->player_1_status == 1) {
					$dataUpdate['match_status'] = 2;
					$matchStatus = 2;
				}
			}

			$dataUpdate['player_'.$playerID.'_status'] = 1;

			$this->process_data->create_data('tournament_matches', $dataUpdate, array('id' => $matchID));

			$htmlMatchContent  = '<div class="btn-row match-result-btn"></div>';
			$htmlMatchContent .= '<span class="start-match">You Are Ready To Play</span>';

			$dataReturn['startMatch'] = $htmlMatchContent;

			$dataReturn['matchStatus'] = $matchStatus;

			// $dataReturn['matchResultMessage'] = 'Both Opponenets Ready. Waiting For Spectator To Start Match';
			// $dataReturn['matchStatusBadge']   = 'badge badge-info';
			$dataReturn['matchResultMessage'] = 'Match Started';
			$dataReturn['matchStatusBadge']   = 'badge badge-success';
			$dataReturn['matchID']			  = $matchID;

			$dataReturn['setScoreForm']  = '<div class="setScore-form">';
			$dataReturn['setScoreForm'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $userID . '" class="setScore" onsubmit="return false;">';
			$dataReturn['setScoreForm'] .= '<div class="inline-field">';
			$dataReturn['setScoreForm'] .= '<input type="text" name="player_score" value="0" class="form-control" />';
			$dataReturn['setScoreForm'] .= '<input type="hidden" name="userType" value="0" />';
			$dataReturn['setScoreForm'] .= '<input type="hidden" name="player" value="'.$playerID.'" />';
			$dataReturn['setScoreForm'] .= '<div class="inline-sm-btns">';
			$dataReturn['setScoreForm'] .= '<button type="submit" class="btn-small-circle btn-dark">';
			$dataReturn['setScoreForm'] .= '<i class="fa fa-check"></i>';
			$dataReturn['setScoreForm'] .= '</button>';
			$dataReturn['setScoreForm'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
			$dataReturn['setScoreForm'] .= '<i class="fa fa-times"></i>';
			$dataReturn['setScoreForm'] .= '</button>';
			$dataReturn['setScoreForm'] .= '</div>';
			$dataReturn['setScoreForm'] .= '</div>';
			$dataReturn['setScoreForm'] .= '</form>';
			$dataReturn['setScoreForm'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
			$dataReturn['setScoreForm'] .= '</div>';

			$dataReturn['slot'] = $playerID;

			echo json_encode($dataReturn);
		}

		if($method == 'startPlayerMatch') {
			$dataUpdate['match_status'] = 2;

			$this->process_data->create_data('tournament_matches', $dataUpdate, array('id' => $matchID));

			$matchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));

			$dataReturn['player1Html'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $matchData[0]->player_1_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
			';

			$dataReturn['player2Html'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $matchData[0]->player_2_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
			';

			$dataReturn['setScoreSlot1']  = '<div class="setScore-form">';
			$dataReturn['setScoreSlot1'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $matchData[0]->player_1_ID . '" class="setScore" onsubmit="return false;">';
			$dataReturn['setScoreSlot1'] .= '<div class="inline-field">';
			$dataReturn['setScoreSlot1'] .= '<input type="text" name="player_score" value="' . $matchData[0]->player_1_score . '" class="form-control" />';
			$dataReturn['setScoreSlot1'] .= '<input type="hidden" name="player" value="1" />';
			$dataReturn['setScoreSlot1'] .= '<div class="inline-sm-btns">';
			$dataReturn['setScoreSlot1'] .= '<button type="submit" class="btn-small-circle btn-dark">';
			$dataReturn['setScoreSlot1'] .= '<i class="fa fa-check"></i>';
			$dataReturn['setScoreSlot1'] .= '</button>';
			$dataReturn['setScoreSlot1'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
			$dataReturn['setScoreSlot1'] .= '<i class="fa fa-times"></i>';
			$dataReturn['setScoreSlot1'] .= '</button>';
			$dataReturn['setScoreSlot1'] .= '</div>';
			$dataReturn['setScoreSlot1'] .= '</div>';
			$dataReturn['setScoreSlot1'] .= '</form>';
			$dataReturn['setScoreSlot1'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
			$dataReturn['setScoreSlot1'] .= '</div>';

			$dataReturn['setScoreSlot2']  = '<div class="setScore-form">';
			$dataReturn['setScoreSlot2'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $matchData[0]->player_2_ID . '" class="setScore" onsubmit="return false;">';
			$dataReturn['setScoreSlot2'] .= '<div class="inline-field">';
			$dataReturn['setScoreSlot2'] .= '<input type="text" name="player_score" value="' . $matchData[0]->player_2_score . '" class="form-control" />';
			$dataReturn['setScoreSlot2'] .= '<input type="hidden" name="player" value="2" />';
			$dataReturn['setScoreSlot2'] .= '<div class="inline-sm-btns">';
			$dataReturn['setScoreSlot2'] .= '<button type="submit" class="btn-small-circle btn-dark">';
			$dataReturn['setScoreSlot2'] .= '<i class="fa fa-check"></i>';
			$dataReturn['setScoreSlot2'] .= '</button>';
			$dataReturn['setScoreSlot2'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
			$dataReturn['setScoreSlot2'] .= '<i class="fa fa-times"></i>';
			$dataReturn['setScoreSlot2'] .= '</button>';
			$dataReturn['setScoreSlot2'] .= '</div>';
			$dataReturn['setScoreSlot2'] .= '</div>';
			$dataReturn['setScoreSlot2'] .= '</form>';
			$dataReturn['setScoreSlot2'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
			$dataReturn['setScoreSlot2'] .= '</div>';

			$dataReturn['matchID'] = $matchID;
			$dataReturn['matchResultMessage'] = 'Match Started';
			$dataReturn['matchStatusBadge']   = 'badge badge-success';

			echo json_encode($dataReturn);
		}

		if($method == 'setScore') {
			$player = $this->input->post('player');
			$score  = $this->input->post('player_score');

			//Check for the match type
			$getMatchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));

			$setScore = array();

			if($getMatchData[0]->groupID > 0) {
				if($player == '1') {
					$setScore['player_1_score'] = $score;
				} else {
					$setScore['player_2_score'] = $score;	
				}
			} else {
				$setScore['player_1_score'] = $score;
			}

			$managerID_Data = empty($getMatchData[0]->managerID) ? array() : unserialize($getMatchData[0]->managerID);
			array_push($managerID_Data, $userID);
			$managerID = serialize($managerID_Data);
			$setScore['managerID'] = $managerID;

			$this->process_data->create_data('tournament_matches', 
				$setScore, 
				array('id' => $matchID)
			);

			$dataReturn['playerScore'] = $score;
			$dataReturn['scoreUpdate'] = 0;

			$updateScore = false;

			if($player == '1') {
				if($getMatchData[0]->player_2_score > 0) {
					$updateScore = true;
				}
			} else {
				if($getMatchData[0]->player_1_score > 0) {
					$updateScore = true;	
				}
			}

			if($updateScore > 0) {
				$dataReturn['scoreUpdate'] 		= 1;
				$dataReturn['decisionBtnData']  = '<a href="'. base_url() . 'account/matches/setWinner/'. $matchID . '/' . $userID . '/0" class="btn dso-ebtn dso-ebtn-solid btn-match-complete">';
				$dataReturn['decisionBtnData'] .= '<span class="dso-btn-text">Submit Results</span>';
				$dataReturn['decisionBtnData'] .= '<div class="dso-btn-bg-holder"></div>';
				$dataReturn['decisionBtnData'] .= '</a>';
			}

			echo json_encode($dataReturn);
		}

		if($method == 'setWinner') {
			$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
			$round           = $getMatchDetails[0]->round;
			$player_1_score  = $getMatchDetails[0]->player_1_score;
			$player_2_score  = $getMatchDetails[0]->player_2_score;

			if($player_1_score == $player_2_score) {
				$dataReturn['errorMessage'] = '<div class="message">Error: Both players have the same score. Please ensure the scores are corrent and accurate. Please adjust the score and try again.</div>';
			} else {
				$newRound  = $round + 1;
				$managerID_Data = empty($getMatchDetails[0]->managerID) ? array() : unserialize($getMatchDetails[0]->managerID);
				
				if(!in_array($userID, $managerID_Data)) {
					array_push($managerID_Data, $userID);
				}

				$managerID = serialize($managerID_Data);
				
				$winnerID = $playerID;

				$player_1_decision = 0;
				$player_2_decision = 0;

				if($userType == 0) {
					

					if($player_1_score > $player_2_score) {
						$winnerID = $getMatchDetails[0]->player_1_ID;
					} else {
						$winnerID = $getMatchDetails[0]->player_2_ID;
					}


					if($getMatchDetails[0]->player_1_ID == $playerID && $userType == 0) {
						$player_1_decision = 1;
					}

					if($getMatchDetails[0]->player_2_ID == $playerID && $userType == 0) {
						$player_2_decision = 1;
					}
				}

				//Set Winner 
				$setWinner = array(
					'winnerID'     => $winnerID,
					'managerID'    => $managerID,
					'match_status' => 3 
				);

				//Get tournament ID
				$tournamentID = $getMatchDetails[0]->tournamentID;

	            //Check if in round 2 any player exist or not
	            //First check if this is final round
	            $totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
	            $playersCount = count($totalPlayers);

	            $totalRounds =  strlen(decbin($playersCount - 1));

	            if($round < $totalRounds) {
	                $setWinner['status'] = 0;
	            }

	            $this->process_data->create_data('tournament_matches', $setWinner, array('id' => $matchID));
	            
				$getUpdatedMatchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
				$dataReturn['player_1'] = $getUpdatedMatchData[0]->player_1_ID;
				$dataReturn['player_2'] = $getUpdatedMatchData[0]->player_2_ID;

				/*
				 * Setting Match Meta Data
				 */
				//Player 1 Decision
				$this->process_data->create_data('tournament_matches_meta', array(
					'matchID' 	 => $matchID,
					'playerID' 	 => $dataReturn['player_1'],
					'meta_key'   => 'player_1_decision',
					'meta_value' => $player_1_decision
				));

				//Player 2 Decision
				$this->process_data->create_data('tournament_matches_meta', array(
					'matchID' 	 => $matchID,
					'playerID' 	 => $dataReturn['player_2'],
					'meta_key'   => 'player_2_decision',
					'meta_value' => $player_2_decision 
				));

				//Result Time
				$timeStart = date('M d, Y H:i:s');
				$timeEnd   = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +5 Minutes'));
				
				$this->process_data->create_data('tournament_matches_meta', array(
					'matchID' 	 => $matchID,
					'playerID' 	 => 0,
					'meta_key'   => 'match_result_time',
					'meta_value' => $timeEnd
				));

		        if($getUpdatedMatchData[0]->winnerID == $getUpdatedMatchData[0]->player_1_ID) {
		            $dataReturn['player_1_result'] = "<label class='badge badge-success'>Winner</label>";
		            $dataReturn['player_2_result'] = "<label class='badge badge-danger'>Loser</label>";
		        } else {
		        	$dataReturn['player_1_result'] = "<label class='badge badge-danger'>Loser</label>";
		            $dataReturn['player_2_result'] = "<label class='badge badge-success'>Winner</label>";
		        }

		        if($userType == 0) {
					$dataReturn['player_1_decision']  = '<span class="start-match">';
		        	if($playerID == $getUpdatedMatchData[0]->player_1_ID) {
						$dataReturn['player_1_decision'] .= "Player Accepeted Results";
					} else {
						$dataReturn['player_1_decision'] .= "Waiting For Player's Decision";
					}
					$dataReturn['player_1_decision'] .= '</span>';

					$dataReturn['player_2_decision']  = '<span class="start-match">';

					if($playerID == $getUpdatedMatchData[0]->player_2_ID) {
						$dataReturn['player_2_decision'] .= "Player Accepeted Results";
					} else {
						$dataReturn['player_2_decision'] .= "Waiting For Player's Decision";
					}
					
					$dataReturn['player_2_decision'] .= '</span>';
				} else {
					$dataReturn['player_1_decision']  = '<span class="start-match">';
					$dataReturn['player_1_decision'] .= "Waiting For Player's Decision";
					$dataReturn['player_1_decision'] .= '</span>';

					$dataReturn['player_2_decision']  = '<span class="start-match">';
					$dataReturn['player_2_decision'] .= "Waiting For Player's Decision";
					$dataReturn['player_2_decision'] .= '</span>';
				}

				$dataReturn['matchResultMessage'] = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
				$dataReturn['matchStatusBadge']   = 'badge badge-info';
				$dataReturn['matchID']			  = $matchID;
				$dataReturn['matchStatus']		  = 3;
				$dataReturn['timeStart'] 		  = $timeStart;
				$dataReturn['matchTimeEnd']       = date('M d, Y, H:i:s', strtotime($timeEnd));
			}
	        echo json_encode($dataReturn);
		}

		if($method == 'assignResult') {
			$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
			$round           = $getMatchDetails[0]->round;
			
			//Getting Winner ID
			$winnerID = $getMatchDetails[0]->winnerID;
			
			//Get tournament ID
			$tournamentID = $getMatchDetails[0]->tournamentID;

			$timeStart = strtotime(date('Y-m-d H:i:s'));
			$timeEnd   = $this->process_data->get_data('tournament_matches_meta', array(
				'matchID' 	 => $matchID,
				'playerID' 	 => 0,
				'meta_key'   => 'match_result_time'
			));

			$timeEnd = strtotime($timeEnd[0]->meta_value);

			if($timeStart >= $timeEnd) {
				$this->process_data->create_round_match($matchID, $tournamentID, $winnerID);

				if($winnerID == $getMatchDetails[0]->player_1_ID) {
		            $dataReturn['player_1_result'] = "<label class='badge badge-success'>Winner</label>";
		            $dataReturn['player_2_result'] = "<label class='badge badge-danger'>Loser</label>";
		        } else {
		        	$dataReturn['player_1_result'] = "<label class='badge badge-danger'>Loser</label>";
		            $dataReturn['player_2_result'] = "<label class='badge badge-success'>Winner</label>";
		        }

	            $winnerUsername = $this->process_data->get_username($winnerID);

				$dataReturn['matchResultMessage'] = 'Match Completed. ' . $winnerUsername . ' Won The Match';
				$dataReturn['matchStatusBadge']   = 'badge-success';
				$dataReturn['status']			  = 1;
			} else {
				$dataReturn['matchStatus'] = 3;
				$dataReturn['status']      = 0;
			}

			$dataReturn['matchID']	   = $matchID;
			$dataReturn['matchStatus'] = 5;		
			
			echo json_encode($dataReturn);
		}

		if($method == 'acceptMatch') {
			$slot = $this->input->post('slot');

			$dataUpdateMeta['meta_value'] = 1;

			if($slot == 1) {
				$condition['meta_key'] = 'player_1_decision';
			} else {
				$condition['meta_key'] = 'player_2_decision';
			}

			$condition['matchID']  = $matchID;
			$condition['playerID'] = $playerID;

			$this->process_data->create_data('tournament_matches_meta', $dataUpdateMeta, $condition);

			//Get Tournament ID
			$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
			$round           = $getMatchDetails[0]->round;
			$tournamentID 	 = $getMatchDetails[0]->tournamentID;

			//Check if both players decision is true
			$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
				'matchID'  => $matchID,
				'playerID' => $getMatchDetails[0]->player_1_ID,
				'meta_key' => 'player_1_decision',
			));

			$player_1_decision = $player_1_decision[0]->meta_value;

			$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
				'matchID'  => $matchID,
				'playerID' => $getMatchDetails[0]->player_2_ID,
				'meta_key' => 'player_2_decision',
			));

			$player_2_decision = $player_2_decision[0]->meta_value;

			if($player_1_decision == 1 && $player_2_decision == 1) {			
				//Getting Winner ID
				$winnerID = $getMatchDetails[0]->winnerID;
				$newRound = $round + 1;

				//Check if in round 2 any player exist or not
				//First check if this is final round
				$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
				$playersCount = count($totalPlayers);

				$totalRounds =  strlen(decbin($playersCount - 1));

				$setWinner['match_status'] = 5;

				if($round < $totalRounds) {
					$setWinner['status'] = 0;
				}

				// Code that runs when match results are announced
				if ($winnerID == $getMatchDetails[0]->player_1_ID) {
				    $looserID = $getMatchDetails[0]->player_2_ID;
				} else {
				    $looserID = $getMatchDetails[0]->player_1_ID;
				}

				// Update the looser's loss count
				$this->create_looser_log($tournamentID, $looserID);

				// Ensure the winner's loss count is not incremented (if necessary)
				$this->create_looser_log($tournamentID, $winnerID, 0);

				$this->process_data->create_data('tournament_matches', $setWinner, array('id' => $matchID));
				
				//Check if the matches are over
				if($this->TournamentModel->isFinalRound($tournamentID, $matchID) == true) {
					if($tournamentData[0]->type == 4 && $tournamentData[0]->advancedStageNeeded > 0) {
						$this->TournamentModel->createAdvancedStageMatches($tournamentID);
					}
				}
				
				if($getMatchDetails[0]->matchType == 1) {
					$this->process_data->create_round_match($matchID, $tournamentID, $winnerID);
				} else {
					$this->TournamentModel->markWinner($matchID, $winnerID);
				}

				if($winnerID == $getMatchDetails[0]->player_1_ID) {
					$dataReturn['player_1_result'] = "<label class='badge badge-success'>Winner</label>";
					$dataReturn['player_2_result'] = "<label class='badge badge-danger'>Loser</label>";
				} else {
					$dataReturn['player_1_result'] = "<label class='badge badge-danger'>Loser</label>";
					$dataReturn['player_2_result'] = "<label class='badge badge-success'>Winner</label>";
				}

				$winnerUsername = $this->process_data->get_username($winnerID);

				$dataReturn['matchResultMessage'] = 'Match Completed. ' . $winnerUsername . ' Won The Match';
				$dataReturn['matchStatusBadge']   = 'badge-success';
				$dataReturn['matchID']			  = $matchID;
				$dataReturn['message']			  = '<div class="message">Match Successfully completed on mutual aggreement. Please Wait While you be redirected to your next round</div>';
				$dataReturn['matchStatus']		  = 5;
				$dataReturn['checkStatus']		  = 1;
			} else {
				$dataReturn['matchStatus'] 	 = 3;
				$dataReturn['checkStatus'] 	 = 0;
				$dataReturn['message']       = '<div class="message">Success waiting for your opponent to accept results.</div>';
				$dataReturn['playerMessage'] = '<span class="start-match">You Accepeted The Results</span>';
			}

			echo json_encode($dataReturn);
		}

		if($method == 'disputeMatch') {
			$slot = $this->input->post('slot');

			$this->process_data->create_data('tournament_matches', array('match_status'=> 4), array(
				'id' => $matchID
			));

			$upload_path = getcwd() . '/assets/uploads/disputes/'; 

			$file     = $_FILES['fileimage']['name'];
			$filesize = $_FILES['fileimage']['size'];

			$return_arr = array();

			$temp = explode(".", $_FILES["fileimage"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$location = $upload_path.$newfilename;

			/* Upload file */
			if(move_uploaded_file($_FILES['fileimage']['tmp_name'],$location)){
				$uploaded_file = $newfilename;
			} else {
				$uploaded_file = 'N/A';
			}

			$description = $this->input->post('description');

			$player_decision_meta['matchID']  = $matchID;
			$player_decision_meta['playerID'] = $playerID;
			$player_decision_meta['meta_key'] = 'player_'.$slot.'_decision';

			$this->process_data->create_data('tournament_matches_meta', array('meta_value'=> 2), $player_decision_meta);

			$this->process_data->create_data('tournament_matches_meta', array(
				'meta_key' 	 => 'uploaded_file', 
				'meta_value' => $uploaded_file,
				'matchID'  	 => $matchID,
				'playerID' 	 => $playerID				
			));

			$this->process_data->create_data('tournament_matches_meta', array(
				'meta_key' 	 => 'description', 
				'meta_value' => $description,
				'matchID'  	 => $matchID,
				'playerID' 	 => $playerID				
			));

			$dataReturn['matchResultMessage'] = 'Match In Dispute';
			$dataReturn['matchStatusBadge']   = 'badge-danger';
			$dataReturn['matchID']			  = $matchID;
			$dataReturn['message']			  = '<div class="message">Disputed Successfully created. Your spectator will look into this matter if you want a quick support you clan click on chat to discuss further</div>';
			$dataReturn['matchStatus']		  = 4;
			$dataReturn['playerMessage']	  = '<span class="start-match">You Filed Dispute.</span>';
			$dataReturn['playerSlot']		  = $slot; 
			$dataReturn['playerID']			  = $playerID;

			echo json_encode($dataReturn);
		}

		if($method == 'viewDispute') {
			$slot = $this->input->post('slot');
			
			$description = $this->process_data->get_data('tournament_matches_meta', array('matchID' => $matchID, 'playerID' => $playerID, 'meta_key' => 'description'))[0]->meta_value;	
			$imageUrl 	 = $this->process_data->get_data('tournament_matches_meta', array('matchID' => $matchID, 'playerID' => $playerID, 'meta_key' => 'uploaded_file'))[0]->meta_value;	
			$imageUrl    = base_url() . 'assets/uploads/disputes/' . $imageUrl;

			$dataReturn['description'] = $description;
			$dataReturn['imageUrl']    = $imageUrl;
			$dataReturn['playerID']	   = $playerID;
			$dataReturn['matchID']	   = $matchID;

			$matchData   = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
			$player_1_ID = $matchData[0]->player_1_ID;
			$player_2_ID = $matchData[0]->player_2_ID;

			//New Assigned Player Details
			$player_1_image = $this->process_data->get_user_meta('user_image', $player_1_ID);
			$player_2_image = $this->process_data->get_user_meta('user_image', $player_2_ID);
			$player_1_score = $matchData[0]->player_1_score;
			$player_2_score = $matchData[0]->player_2_score;
																	
			if($player_1_image == null) {
				$player_1_thumnail = base_url() . 'assets/uploads/users/default.jpg';
			} else {
				$player_1_thumnail = base_url() . 'assets/uploads/users/user-' . $player_1_ID . '/' . $player_1_image;
			}

			$player_1_username = $this->process_data->get_username($player_1_ID);

			if($player_2_image == null) {
				$player_2_thumnail = base_url() . 'assets/uploads/users/default.jpg';
			} else {
				$player_2_thumnail = base_url() . 'assets/uploads/users/user-' . $player_2_ID . '/' . $player_2_image;
			}

			$player_2_username = $this->process_data->get_username($player_2_ID);			

			$html = '<div class="match-row">
				<div class="match-player">
					<div class="user-thumb">
						<img src="' . $player_1_thumnail . '" />
					</div>

					<label>
						' . $player_1_username . '
					</label>
				</div>

				<div class="match-status-form text-white">
					<label>Score</label>
					<input type="text" class="form-control" name="player_1_score" value="'.$player_1_score.'">
				</div>
			</div>';

			$html .= '<div class="match-row">
				<div class="match-player">
					<div class="user-thumb">
						<img src="' . $player_2_thumnail . '" />
					</div>

					<label>
						' . $player_2_username . '
					</label>
				</div>

				<div class="match-status-form text-white">
					<label>Score</label>
					<input type="text" class="form-control" name="player_2_score" value="'.$player_2_score.'">
				</div>
			</div>';

			$dataReturn['playerResults'] = $html;

			echo json_encode($dataReturn);
		}

		if($method == 'eliminate') {
			$getMatchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));

			$managerID_Data = empty($getMatchData[0]->managerID) ? array() : unserialize($getMatchData[0]->managerID);
			array_push($managerID_Data, $userID);
			$managerID = serialize($managerID_Data);
			$setScore['managerID'] = $managerID;

			$this->process_data->create_data('tournament_matches', 
				array("status" => 0, 'managerID' => $managerID), 
				array('id' => $matchID)
			);

			$html = '<span class="badge badge-danger">Eliminated</span>';

			echo $html;
		}

		if($method == 'nextRound') {
			$tournamentID = $matchID;
			$round 		  = $playerID;

			$getMatchData = $this->process_data->get_data('tournament_matches', array(
				'tournamentID' => $tournamentID,
				'round'		   => $round
			));

			$getTournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));

			$valid = false;
			foreach($getMatchData as $checkMatch):
				if($checkMatch->status == 0) {
					$valid = true;
					break;
				}
			endforeach;

			if($valid == true) {
				$newRound = $round + 1;
				foreach($getMatchData as $match):
					if($match->status == 1) {
						//Creating match 
						// Get player's previous round score
						$oldScore = $match->player_1_score;
			            $dataInsert = array(
			                'tournamentID' 	 => $tournamentID,
			                'groupID'	   	 => 0,
			                'player_1_ID'  	 => $match->player_1_ID,
			                'player_2_ID'  	 => 0,
			                'player_1_score' => $oldScore,
			                'round'        	 => $newRound,
			                'winnerID'     	 => 0,
			                'status'       	 => 1
			            );

			            $this->process_data->create_data('tournament_matches', $dataInsert);

			            $dataUpdate = array(
			            	'status' => 2
			            );

			            $this->process_data->create_data('tournament_matches', $dataUpdate, array('id' => $match->id));
					}
				endforeach;

				$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> New Round Started.</div>');
			} else {
				$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-times-circle"></i> Next Round cannot be created there is no one eliminated from this round.</div>');
			}

			redirect('account/tournaments/matches/' . $getTournamentData[0]->slug . '/round/' . $newRound);
		}

		if($method == 'completeMatch') {
			$tournamentID = $matchID;
			$round 		  = $playerID;

			$getMatchData = $this->process_data->get_data('tournament_matches', array(
				'tournamentID' => $tournamentID,
				'round'		   => $round
			));

			$getTournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));

			foreach($getMatchData as $match):
				if($match->status == 1) {
		            $dataUpdate = array(
		            	'status' => 2
		            );

		            $this->process_data->create_data('tournament_matches', $dataUpdate, array('id' => $match->id));
				}
			endforeach;

			$this->process_data->create_data('tournament', array('status' => 3), array('id' => $tournamentID));

			$this->session->set_flashdata('message', '<div class="message"><i class="fa fa-check-circle"></i> Match Completed.</div>');

			redirect('account/tournaments/matches/' . $getTournamentData[0]->slug);
		}
	}

	public function startPlayerMatch($matchID, $playerID) {
		$dataUpdate['match_status'] = 2;

		$this->process_data->create_data('tournament_matches', $dataUpdate, array('id' => $matchID));

		$matchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$dataReturn['slot']  = 1;

		if($matchData[0]->player_2_ID == $playerID) {
			$dataReturn['slot']  = 2;
		}

		$dataReturn['player1Html'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $matchData[0]->player_1_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
		';

		$dataReturn['player2Html'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $matchData[0]->player_2_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>
		';

		$dataReturn['setScoreSlot1']  = '<div class="setScore-form">';
		$dataReturn['setScoreSlot1'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $matchData[0]->player_1_ID . '" class="setScore" onsubmit="return false;">';
		$dataReturn['setScoreSlot1'] .= '<div class="inline-field">';
		$dataReturn['setScoreSlot1'] .= '<input type="text" name="player_score" value="' . $matchData[0]->player_1_score . '" class="form-control" />';
		$dataReturn['setScoreSlot1'] .= '<input type="hidden" name="player" value="1" />';
		$dataReturn['setScoreSlot1'] .= '<div class="inline-sm-btns">';
		$dataReturn['setScoreSlot1'] .= '<button type="submit" class="btn-small-circle btn-dark">';
		$dataReturn['setScoreSlot1'] .= '<i class="fa fa-check"></i>';
		$dataReturn['setScoreSlot1'] .= '</button>';
		$dataReturn['setScoreSlot1'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
		$dataReturn['setScoreSlot1'] .= '<i class="fa fa-times"></i>';
		$dataReturn['setScoreSlot1'] .= '</button>';
		$dataReturn['setScoreSlot1'] .= '</div>';
		$dataReturn['setScoreSlot1'] .= '</div>';
		$dataReturn['setScoreSlot1'] .= '</form>';
		$dataReturn['setScoreSlot1'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
		$dataReturn['setScoreSlot1'] .= '</div>';

		$dataReturn['setScoreSlot2']  = '<div class="setScore-form">';
		$dataReturn['setScoreSlot2'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $matchData[0]->player_2_ID . '" class="setScore" onsubmit="return false;">';
		$dataReturn['setScoreSlot2'] .= '<div class="inline-field">';
		$dataReturn['setScoreSlot2'] .= '<input type="text" name="player_score" value="' . $matchData[0]->player_2_score . '" class="form-control" />';
		$dataReturn['setScoreSlot2'] .= '<input type="hidden" name="player" value="2" />';
		$dataReturn['setScoreSlot2'] .= '<div class="inline-sm-btns">';
		$dataReturn['setScoreSlot2'] .= '<button type="submit" class="btn-small-circle btn-dark">';
		$dataReturn['setScoreSlot2'] .= '<i class="fa fa-check"></i>';
		$dataReturn['setScoreSlot2'] .= '</button>';
		$dataReturn['setScoreSlot2'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
		$dataReturn['setScoreSlot2'] .= '<i class="fa fa-times"></i>';
		$dataReturn['setScoreSlot2'] .= '</button>';
		$dataReturn['setScoreSlot2'] .= '</div>';
		$dataReturn['setScoreSlot2'] .= '</div>';
		$dataReturn['setScoreSlot2'] .= '</form>';
		$dataReturn['setScoreSlot2'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
		$dataReturn['setScoreSlot2'] .= '</div>';

		$dataReturn['matchID'] = $matchID;
		$dataReturn['matchResultMessage'] = 'Match Started';
		$dataReturn['matchStatusBadge']   = 'badge badge-success';

		echo json_encode($dataReturn);
	}

	private function get_tournament_match_meta($matchID = null, $playerID = null, $meta_key = null) {
		if($matchID != null && $playerID != null) {
			$matchMeta = $this->process_data->get_data('tournament_matches_meta', array('matchID' => $matchID, 'playerID' => $playerID, 'meta_key' => $meta_key));

			if(count($matchMeta) == 0) {
				return '';
			} else {
				return $matchMeta[0]->meta_value;
			}
		} else {
			return false;
		}
	} 

	public function checkMatchWinnerStatus() {
		$tournamentData = $this->process_data->get_data('tournament', array('status' => 2));

		foreach($tournamentData as $tournament):
			$tournamentID = $tournament->id;

			$checkRound ="SELECT round FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND winnerID > 0 GROUP BY round ORDER BY id DESC LIMIT 1";
			$getActiveRound = $this->db->query($checkRound)->result();
			$round 	   = $getActiveRound[0]->round;

			$getCurrentMatch = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'round' => $round, 'status' => 3));
			
			foreach($getCurrentMatch as $currentMatch):
				$matchID  = $currentMatch->id;
				$newRound = $currentMatch->round + 1;

				$currentTime = strtotime(date('Y-m-d H:i:s'));
				$resultTime  = $this->get_tournament_match_meta($matchID, 0, 'match_result_time');
				$proceed   	 = false;
				
				$player_1_decision = $this->get_tournament_match_meta($matchID, $currentMatch->player_1_ID, 'player_1_decision');
				$player_2_decision = $this->get_tournament_match_meta($matchID, $currentMatch->player_2_ID, 'player_2_decision');

				if($currentTime > strtotime($resultTime)) {
					$proceed = true;
				} else {
					if($player_1_decision == 1 && $player_2_decision == 1) {
						$proceed = true;
					}
				}

				if($proceed == true) {
					$player_1_score = $currentMatch->player_1_score;
					$player_2_score = $currentMatch->player_2_score;

					if($player_1_score > $player_2_score) {
						$playerID = $currentMatch->player_1_ID;
					} else {
						$playerID = $currentMatch->player_2_ID;
					}

					$this->process_data->create_data('tournament_matches', array('status' => 0), array('id' => $matchID));

					//Check if any free slot is available in same round if it is then match current player with free slot player
					$freeSlotMatchQuery  = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND round = '" . $round . "'";
					$freeSlotMatchQuery .= " AND (player_1_ID = 0 OR player_2_ID = 0)";
					$getFreeSlotMatch = $this->db->query($freeSlotMatchQuery)->result();

					if($player_1_status > 0 && $player_2_status > 0) {
						if(count($getFreeSlotMatch) > 0) {
							//Check if both players in the match have agreed with the results
							$player_1_status = $getFreeSlotMatch[0]->player_1_status;
							$player_2_status = $getFreeSlotMatch[0]->player_2_status;

							if($getFreeSlotMatch[0]->player_1_ID == 0) {
								$assignPlayer['player_1_ID'] = $playerID;
								$playerSlot = 1;
							} else {
								$assignPlayer['player_2_ID'] = $playerID;
								$playerSlot = 2;
							}

							$this->process_data->create_data('tournament_matches', $assignPlayer, array('id' => $getFreeSlotMatch[0]->id));
						} else {
							//First check if this is final round
							$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
							$playersCount = count($totalPlayers);
				
							$totalRounds =  strlen(decbin($playersCount - 1));
				
							if($round < $totalRounds) {
								$setWinner['status'] = 0;
							}
				
							$this->process_data->create_data('tournament_matches', $setWinner, array('id' => $matchID));
							
							if($round < $totalRounds) {
								if($newRound == $totalRounds) {
									$getMatchData = $this->process_data->get_data('tournament_matches', array(
										'tournamentID' => $tournamentID,
										'round'   => $newRound
									));
								} else {
									$getMatchData = $this->process_data->get_data('tournament_matches', array(
										'tournamentID' => $tournamentID,
										'round'   	   => $newRound,
										'groupID' 	   => $currentMatch->groupID
									));
								}

								if(count($getMatchData) > 0) {
									foreach($getMatchData as $match):
										if($match->player_2_ID == 0) {
											$dataInsert = array(
												'player_2_ID'  => $playerID
											);

											$this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $match->id));
											break;
										}
									endforeach;
								} else {
									//Creating match 
									$dataInsert = array(
										'tournamentID' => $tournamentID,
										'groupID'	   => $currentMatch->groupID,
										'player_1_ID'  => $playerID,
										'player_2_ID'  => 0,
										'round'        => $newRound,
										'winnerID'     => 0,
										'status'       => 1
									);

									$this->process_data->create_data('tournament_matches', $dataInsert);
								}
							}

							
						}
					}
				}
			endforeach;
		endforeach;
	}

	public function processDisputeResponse() {
		$matchID 		= $this->input->post('matchID');
		$playerID 		= $this->input->post('playerID');
		$player_1_score = $this->input->post('player_1_score');
		$player_2_score = $this->input->post('player_2_score');
		$comments       = $this->input->post('comments');
		$setAction 		= $this->input->post('setaction');

		//Add Match Meta Data For Player
		$commentsMeta = array(
			'matchID' 	 => $matchID,
			'playerID' 	 => $playerID,
			'meta_key' 	 => 'dispute_comment',
			'meta_value' => $comments,
		);

		$this->process_data->create_data('tournament_matches_meta', $commentsMeta);

		$disputeStatusMeta = array(
			'matchID' 	 => $matchID,
			'playerID' 	 => $playerID,
			'meta_key' 	 => 'dispute_status',
			'meta_value' => $setAction,
		);

		$this->process_data->create_data('tournament_matches_meta', $disputeStatusMeta);

		$matchData   = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$player_1_ID = $matchData[0]->player_1_ID;
		$player_2_ID = $matchData[0]->player_2_ID;
		
		if($player_1_score > $player_2_score) {
			$winnerID = $player_1_ID;
		} else {
			$winnerID = $player_2_ID;
		}

		//Setting New Winner
		$dataMatch['player_1_score'] = $player_1_score;
		$dataMatch['player_2_score'] = $player_2_score;
		$dataMatch['winnerID']	  	 = $winnerID;
		$dataMatch['match_status']	 = 5;
		
		$this->process_data->create_data('tournament_matches', $dataMatch, array('id' => $matchID));

		$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));

		$round		  = $getMatchDetails[0]->round;
		$tournamentID = $getMatchDetails[0]->tournamentID;
		$newRound 	  = $round + 1;

		//Check if in round 2 any player exist or not
		//First check if this is final round
		$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
		$playersCount = count($totalPlayers);
		$totalRounds  = strlen(decbin($playersCount - 1));


		if($round < $totalRounds) {
			if($newRound == $totalRounds) {
				$getMatchData = $this->process_data->get_data('tournament_matches', array(
					'tournamentID' => $tournamentID,
					'round'   	   => $newRound
				));
			} else {
				$getMatchData = $this->process_data->get_data('tournament_matches', array(
					'tournamentID' => $tournamentID,
					'round'   	   => $newRound,
					'groupID' 	   => $getMatchDetails[0]->groupID
				));
			}

			if(count($getMatchData) > 0) {
				foreach($getMatchData as $match):
					if($match->player_2_ID == 0) {
						$dataInsert = array(
							'player_2_ID'  => $winnerID
						);

						$this->process_data->create_data('tournament_matches', $dataInsert, array('id' => $match->id));
						break;
					}
				endforeach;
			} else {
				//Creating match 
				$dataInsert = array(
					'tournamentID' => $tournamentID,
					'groupID'	   => $getMatchDetails[0]->groupID,
					'player_1_ID'  => $winnerID,
					'player_2_ID'  => 0,
					'round'        => $newRound,
					'winnerID'     => 0,
					'status'       => 1
				);

				$this->process_data->create_data('tournament_matches', $dataInsert);
			}
		}	

		if($winnerID == $player_1_ID) {
			$dataReturn['player_1_result'] = "<label class='badge badge-success'>Winner</label>";
			$dataReturn['player_2_result'] = "<label class='badge badge-danger'>Loser</label>";
		} else {
			$dataReturn['player_1_result'] = "<label class='badge badge-danger'>Loser</label>";
			$dataReturn['player_2_result'] = "<label class='badge badge-success'>Winner</label>";
		}


		$dataReturn['matchID'] 		  = $matchID;
		$dataReturn['player_1_score'] = $player_1_score;
		$dataReturn['player_2_score'] = $player_2_score;
		$dataReturn['player_1_ID'] 	  = $player_1_ID;
		$dataReturn['player_2_ID'] 	  = $player_2_ID;

		$winnerUsername = $this->process_data->get_username($winnerID);

		$dataReturn['matchResultMessage'] = 'Match Completed. ' . $winnerUsername . ' Won The Match';
		$dataReturn['matchStatusBadge']   = 'badge-success';
		$dataReturn['message']			  = '<div class="message">Match Successfully completed on mutual aggreement.</div>';

		echo json_encode($dataReturn);
	}

	public function getMatchResults() {
		$dataReturn['setSlot'] = 1;

		//New Assigned Player Details
		$player_image = $this->process_data->get_user_meta('user_image', $playerID);
																
		if($player_image == null) {
			$player_thumnail = base_url() . 'assets/uploads/users/default.jpg';
		} else {
			$player_thumnail = base_url() . 'assets/uploads/users/user-' . $playerID . '/' . $player_image;
		}

		$player_username = $this->process_data->get_username($playerID);

		if($playerSlot == 1) {
			$dataReturn['playerData']  = '<div class="user-thumb">';
			$dataReturn['playerData'] .= '<img src="' . $player_thumnail . '" />';
			$dataReturn['playerData'] .= '</div>';
			$dataReturn['playerData'] .= '<label class="player-' . $playerID . '">';
			$dataReturn['playerData'] .= $player_username;
			$dataReturn['playerData'] .= '<a href="' . base_url() . 'account/matches/setWinner/' . $getFreeSlotMatch[0]->id . '/' . $playerID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>';                                                                  
			$dataReturn['playerData'] .= '</label>';
		} else {
			$dataReturn['playerData']  = '<label class="player-' . $playerID . '">';
			$dataReturn['playerData'] .= $player_username;
			$dataReturn['playerData'] .= '<a href="' . base_url() . 'account/matches/setWinner/' . $getFreeSlotMatch[0]->id . '/' . $playerID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>';                                                                  
			$dataReturn['playerData'] .= '</label>';
			$dataReturn['playerData'] .= '<div class="user-thumb">';
			$dataReturn['playerData'] .= '<img src="' . $player_thumnail . '" />';
			$dataReturn['playerData'] .= '</div>';
		}

		$dataReturn['playerID']     = $playerID;
		$dataReturn['playerSlot']   = $playerSlot; 
		$dataReturn['slotScore']    = '0';
		$dataReturn['matchID']      = $getFreeSlotMatch[0]->id;
		$dataReturn['slotScoreUrl'] = base_url() . 'account/matches/setScore/' . $getFreeSlotMatch[0]->id . '/' . $playerID; 
	}

	public function createTournamentNotice() {
		$message      = $this->input->post('message');	
		$tournamentID = $this->input->post('tournamentID');
		$date_posted  = date('Y-m-d H:i:s');
		$id 		  = $this->input->post('id');
		$created_by   = $this->session->userdata('user_id');
		$tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
		$slug = $tournamentData[0]->slug;

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

		redirect('account/tournaments/notice-board/' . $slug);
	}

	public function processSpectator() {
		$appID  = $this->input->post('appID');	
		$status = $this->input->post('status');

		$applicationData = $this->db->query('SELECT * FROM tournament_spectators WHERE id = ' . $appID)->result();
		$previousApplication = $this->db->query('SELECT * FROM tournament_spectators WHERE tournamentID = ' . $applicationData[0]->tournamentID . ' AND (status = 1 OR status = 2)')->result();
		$tournamentID = $applicationData[0]->tournamentID;

		if($status == 1) {
			$this->process_data->create_data('tournament_spectators', 
			array(
				'status' => 1,
				
			), array('id' => $appID));

			$htmlData = '<a href="'.base_url().'account/processSpectator" class="btn dso-ebtn-sm spectator-request" data-id="'.$appID.'" data-staus="3"><span class="dso-btn-text">Remove</span>
                                                <div class="btn-loader">
                                                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                </div></a>';
            $dataReturn['htmlData'] = $htmlData;
            $dataReturn['status']   = 1;                                 
		}

		if($status == 2) {
			$this->process_data->create_data('application', 
			array(
				'status' => 0,
				
			), array('id' => $appID));

			$dataReturn['status']   = 0;
		}

		if($status == 3) {
			$checkSpectator = $this->process_data->get_data('tournament_spectators', array('id' => $appID));
			
			if(count($checkSpectator) == 0) {
				$this->process_data->create_data('application', 
				array(
					'status' => 3,
					
				), array('id' => $appID));
			} else {
				//Check if this is approved spectator
				$this->db->where('id', $appID)->delete('tournament_spectators');
			}

			$dataReturn['status'] = 0;
		}

		//Getting current Spectators count
		$tournamentsData = $this->process_data->get_tournaments(array('tournament.id' => $tournamentID));
		$specApplication = $this->db->query('SELECT * FROM tournament_spectators WHERE tournamentID = ' . $tournamentID . ' AND status = 1')->result();


		$allowed_spectators = $tournamentsData[0]->max_allowed_spectators;
        $active_applciations  = count($specApplication);
        $get_applications_per = (100 / $allowed_spectators) * $active_applciations;

        $prgress_bar_class = 'bg-danger';

        if($get_applications_per > 60) {
            $prgress_bar_class = 'bg-warning';
        }

        if($get_applications_per == 100) {
            $prgress_bar_class = 'bg-success';
        }
		
        //Get Old Class
        $active_spec_old  = $active_applciations - 1;
        $get_players_per_old = (100 / $allowed_spectators) * $active_spec_old;

        $prgress_bar_class_before = 'bg-danger';
        if($get_players_per_old > 60) {
            $prgress_bar_class_before = 'bg-warning';
        }

        if($get_players_per_old == 100) {
            $prgress_bar_class_before = 'bg-success';
        }

		$dataReturn['counter']  = $active_applciations . '/' . $allowed_spectators;
		$dataReturn['per'] 		= $get_applications_per . '%';
		$dataReturn['addClass'] = $prgress_bar_class;
		$dataReturn['oldClass'] = $prgress_bar_class_before;

		echo json_encode($dataReturn);
	}

    public function processTeamProfile() {
        $teamData = $this->input->post('teamData');
        $teamMeta = $this->input->post('teamMeta');

		//Create Slug 
		$slug = $this->process_data->slugify($teamData['team_name']);

		$checkSlug = $this->db->query("SELECT * FROM team_profile WHERE slug LIKE '%" .$slug . "%'");
		
		if($checkSlug->num_rows() > 0) {
			$count = $checkSlug->num_rows();
			$slug = $slug . '-' . $count;
		}

		$teamData['slug'] = $slug;

		$config['upload_path'] = getcwd() . '/assets/uploads/teams/'; 

		$file     = $_FILES['team_logo']['name'];
		$filesize = $_FILES['team_logo']['size'];

		$return_arr = array();

		$temp = explode(".", $_FILES["team_logo"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$location = $config['upload_path'].$newfilename;

		/* Upload file */
		if(move_uploaded_file($_FILES['team_logo']['tmp_name'],$location)){
			$teamMeta['team_logo'] = $newfilename;
		}

		//Uploading Header Background
		$header_bg = $_FILES['header_background']['name'];
	
		$header_bg_temp = explode(".", $_FILES["header_background"]["name"]);
		$header_bg_file = round(microtime(true)) . '.' . end($header_bg_temp);
		$location = $config['upload_path'].$header_bg_file;

		/* Upload file */
		if(move_uploaded_file($_FILES['header_background']['tmp_name'],$location)){
			$teamMeta['team_cover_picture'] = $header_bg_file;
		}

		$teamData['userID'] = $this->session->userdata('user_id');

		$teamID = $this->process_data->create_data('team_profile', $teamData);

		foreach($teamMeta AS $key => $meta):
			$metaData['teamID'] 	= $teamID;
			$metaData['meta_key'] 	= $key;
			$metaData['meta_value'] = $meta;

			$this->process_data->create_data('team_meta', $metaData);
		endforeach;

		$this->process_data->create_data('users', array('active_team' => 1), array('id' => $this->session->userdata('user_id')));

        $this->load->view('includes/add-team-members-form', array('teamID' => $teamID));
    }

    public function spectate_tournament($slug = null, $round = null) {
    	if($this->session->userdata('is_logged_in') == true) {
			$data = array(
				'title' => 'Spectator Panel',
				'class' => 'inner',
				'page_active' => 'spectate-tournament'
			);

			$userID 	  = $this->session->userdata('user_id');
			$data['meta'] = $this->process_data;

			if($slug == null) {
				//Get the spectators data bsed on the user ID
				$spectatorsData = $this->process_data->get_data('tournament_spectators', array('specID' => $userID));

				$data['spectatorsData'] = $spectatorsData;
				
				$page = 'manage-spectate-matches';
			} else {
				$data['title'] = 'Manage Tournament Matches';

				$spectatorsData 		= $this->process_data->get_data('tournament_spectators', array('specID' => $userID));
            	$data['tournamentData'] = $this->process_data->get_data('tournament', array('slug' => $slug));
            	$tournamentID 		    = $data['tournamentData'][0]->id;
            	$data['tournamentID']   = $tournamentID; 

				if($round == null) {
					$round = 1;
				}

				$param = '';

				$data['activeRound'] 	= $round;
				$data['playersData']    = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));
				$data['matchesData'] 	= $this->process_data->get_matches($tournamentID, $round);
				$data['totalRounds']	= $this->process_data->get_rounds($tournamentID); 
				$data['active_url']	    = base_url() . 'account/spectate-tournament/' . $slug . $param;
				$data['trounamentSpectators'] = $this->db->query("SELECT tournament_spectators.*, users.username, users.email, users.discord_username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '".$tournamentID."'")->result();
				$data['spectatorsCount'] = $this->db->query("SELECT tournament_spectators.*, users.username, users.email, users.discord_username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '".$tournamentID."' AND tournament_spectators.status = 1")->result();


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
				} 
				
				$data['allowed_access'] = (count($spectatorsData) > 0) ? true : false;
				$data['role']			= (count($spectatorsData) > 0) ? $spectatorsData[0]->role : '';
				$page = 'tournament/manage-spectate-matches';
			}

			$this->load->view('includes/header-new', $data);
            $this->load->view($page, $data);
            $this->load->view('includes/footer-new');
		}
    }

	public function resetMatch($method = null, $matchID = null) {
		$currentPlayerID = $this->input->post('currentPlayer');
		$playerPlaceID   = $this->input->post('player');
		$tournamentID    = $this->input->post('tournamentID');
		$activeRound     = $this->input->post('round');

		if($method == 'assign') {
			$replacePlayerID = $this->input->post('player_ID');

			$updateMatchData['player_'.$playerPlaceID.'_ID'] 	= $replacePlayerID;
			$updateMatchData['player_'.$playerPlaceID.'_score'] = 0;
			
			//Get new player's old location and replace it with current player
			$query = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "' AND round = '" . $activeRound . "' AND (player_1_ID =  '" . $replacePlayerID . "' OR player_2_ID = '" . $replacePlayerID . "')";
			$replaceMatchData = $this->db->query($query)->result();
			
			if($replacePlayerID == $replaceMatchData[0]->player_1_ID) {
				$updateReplaceMatchData['player_1_ID'] = $currentPlayerID;
				$updateReplaceMatchData['player_1_score'] = 0;
				$currentPlayerPlaceID = 1;
			}
			
			if($replacePlayerID == $replaceMatchData[0]->player_2_ID) {
				$updateReplaceMatchData['player_2_ID'] = $currentPlayerID;
				$updateReplaceMatchData['player_2_score'] = 0;
				$currentPlayerPlaceID = 2;
			}
			
			$this->process_data->create_data('tournament_matches', $updateReplaceMatchData, array('id' => $replaceMatchData[0]->id));
			
			$this->process_data->create_data('tournament_matches', $updateMatchData, array('id' => $matchID));

			$playersData = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));
			
			$returnData['currentPlayerMatchId']  = $matchID;
			$returnData['replacedPlayerMatchId'] = $replaceMatchData[0]->id;

			//New Assigned Player Details
			$replaced_player_image = $this->process_data->get_user_meta('user_image', $replacePlayerID);
                                                                    
			if($replaced_player_image == null) {
				$replaced_player_thumnail = base_url() . 'assets/uploads/users/default.jpg';
			} else {
				$replaced_player_thumnail = base_url() . 'assets/uploads/users/user-' . $replacePlayerID . '/' . $replaced_player_image;
			}

			$replaced_player_username = $this->process_data->get_username($replacePlayerID);

			if($playerPlaceID == 1) {
				$returnData['replacedPlayerData']  = '<div class="user-thumb">';
				$returnData['replacedPlayerData'] .= '<img src="' . $replaced_player_thumnail . '" />';
				$returnData['replacedPlayerData'] .= '</div>';
				$returnData['replacedPlayerData'] .= '<label class="player-' . $replacePlayerID . '">';
				$returnData['replacedPlayerData'] .= $replaced_player_username;
				$returnData['replacedPlayerData'] .= '<a href="' . base_url() . 'account/resetMatch/remove/' . $matchID . '/' .  $replacePlayerID . '" class="btn dso-ebtn-sm btn-dark">Remove</a>';
				$returnData['replacedPlayerData'] .= '</label>';
			} else {
				$returnData['replacedPlayerData']  = '<label class="player-' . $replacePlayerID . '">';
				$returnData['replacedPlayerData'] .= $replaced_player_username;
				$returnData['replacedPlayerData'] .= '<a href="' . base_url() . 'account/resetMatch/remove/' . $matchID . '/' .  $replacePlayerID . '" class="btn dso-ebtn-sm btn-dark">Remove</a>';
				$returnData['replacedPlayerData'] .= '</label>';
				$returnData['replacedPlayerData'] .= '<div class="user-thumb">';
				$returnData['replacedPlayerData'] .= '<img src="' . $replaced_player_thumnail . '" />';
				$returnData['replacedPlayerData'] .= '</div>';
			}

			$returnData['replacedPlayerDropdown'] = '';
			
			foreach($playersData as $reassignPlayer):
				if($reassignPlayer->participantID != $replacePlayerID) {
					$playerUserData = $this->process_data->get_user_data($reassignPlayer->participantID); 
					$playerUsername = $playerUserData->username;
				
					$returnData['replacedPlayerDropdown'] .= '<option value="' . $reassignPlayer->participantID . '">' . $playerUsername . '</option>';
				}
			endforeach; 
			
			$returnData['replacePlayerID'] = $replacePlayerID;


			//Current Player Data
			$player_current_image = $this->process_data->get_user_meta('user_image', $currentPlayerID);
                                                                    
			if($player_current_image == null) {
				$player_current_thumnail = base_url() . 'assets/uploads/users/default.jpg';
			} else {
				$player_current_thumnail = base_url() . 'assets/uploads/users/user-' . $currentPlayerID . '/' . $player_current_image;
			}

			$username_player_current = $this->process_data->get_username($currentPlayerID);

			if($currentPlayerPlaceID == 1) {
				$returnData['currentPlayerData']  = '<div class="user-thumb">';
				$returnData['currentPlayerData'] .= '<img src="' . $player_current_thumnail . '" />';
				$returnData['currentPlayerData'] .= '</div>';
				$returnData['currentPlayerData'] .= '<label class="player-' . $currentPlayerID . '">';
				$returnData['currentPlayerData'] .= ($currentPlayerID > 0) ? $username_player_current : 'Free Slot';
				if($currentPlayerID > 0) {
					$returnData['currentPlayerData'] .= '<a href="' . base_url() . 'account/resetMatch/remove/' . $matchID . '" player="'. $currentPlayerID . '" placement="' . $currentPlayerPlaceID . '" id="' . $tournamentID . '" class="btn dso-ebtn-sm btn-dark remove-player">Remove</a>';
				}
				$returnData['currentPlayerData'] .= '</label>';
			} else {
				$returnData['currentPlayerData']  = '<label class="player-' . $currentPlayerID . '">';
				$returnData['currentPlayerData'] .= ($currentPlayerID > 0) ? $username_player_current : 'Free Slot';
				if($currentPlayerID > 0) {
					$returnData['currentPlayerData'] .= '<a href="' . base_url() . 'account/resetMatch/remove/' . $matchID . '" player="'. $currentPlayerID . '" placement="' . $currentPlayerPlaceID . '" id="' . $tournamentID . '" class="btn dso-ebtn-sm btn-dark remove-player">Remove</a>';
				}
				$returnData['currentPlayerData'] .= '</label>';
				$returnData['currentPlayerData'] .= '<div class="user-thumb">';
				$returnData['currentPlayerData'] .= '<img src="' . $player_current_thumnail . '" />';
				$returnData['currentPlayerData'] .= '</div>';
			}

			$returnData['currentPlayerDropdown'] = '';

			foreach($playersData as $reassignPlayer):
				if($reassignPlayer->participantID != $currentPlayerID) {
					$playerUserData = $this->process_data->get_user_data($reassignPlayer->participantID); 
					$playerUsername = $playerUserData->username;
				
					$returnData['currentPlayerDropdown'] .= '<option value="' . $reassignPlayer->participantID . '">' . $playerUsername . '</option>';
				}
			endforeach; 

			$returnData['currentPlayerID'] = $currentPlayerID;
		}

		if($method == 'remove') {
			//New Assigned Player Details
			$player_thumnail = base_url() . 'assets/uploads/users/default.jpg';
			$player_username = 'Free Slot';

			$updateMatchData['player_'.$playerPlaceID.'_ID'] 	= 0;
			$updateMatchData['player_'.$playerPlaceID.'_score'] = 0;

			$this->process_data->create_data('tournament_matches', $updateMatchData, array('id' => $matchID));
			$this->process_data->create_data('tournament_players', array('status' => 0), array('tournamentID' => $tournamentID, 'participantID' => $currentPlayerID));

			if($playerPlaceID == 1) {
				$returnData['replacedPlayerData']  = '<div class="user-thumb">';
				$returnData['replacedPlayerData'] .= '<img src="' . $player_thumnail . '" />';
				$returnData['replacedPlayerData'] .= '</div>';
				$returnData['replacedPlayerData'] .= '<label class="player-0">';
				$returnData['replacedPlayerData'] .= $player_username;
				$returnData['replacedPlayerData'] .= '</label>';
			} else {
				$returnData['replacedPlayerData']  = '<label class="player-0">';
				$returnData['replacedPlayerData'] .= $player_username;
				$returnData['replacedPlayerData'] .= '</label>';
				$returnData['replacedPlayerData'] .= '<div class="user-thumb">';
				$returnData['replacedPlayerData'] .= '<img src="' . $player_thumnail . '" />';
				$returnData['replacedPlayerData'] .= '</div>';
			}

			$playersData = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));
			$returnData['replacedPlayerDropdown'] = '';
			foreach($playersData as $reassignPlayer):
				$playerUserData = $this->process_data->get_user_data($reassignPlayer->participantID); 
				$playerUsername = $playerUserData->username;
			
				$returnData['replacedPlayerDropdown'] .= '<option value="' . $reassignPlayer->participantID . '">' . $playerUsername . '</option>';
			endforeach; 

			$returnData['currentPlayerMatchId']   = $matchID;
			$returnData['currentPlayerID'] 		  = $currentPlayerID;
			$returnData['replacePlayerID'] 		  = 0;
		}

		echo json_encode($returnData);
	}

	public function getMatchUpdate() {
		$userID  		 = $this->session->userdata('user_id');
		$matchID 		 = $this->input->post('matchID');
		$matchStatus 	 = $this->input->post('matchStatus');
		$player_1_score  = $this->input->post('player_1_score');
		$player_2_score  = $this->input->post('player_2_score');
		$player_1_dec 	 = $this->input->post('player_1_dec');
		$player_2_dec 	 = $this->input->post('player_2_dec');
		$player_1_status = $this->input->post('player_1_status');
		$player_2_status = $this->input->post('player_2_status');

		$player_1_cur_status = $player_1_status;
		$player_2_cur_status = $player_2_status;

		$getMatchData = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$tournamentData = $this->process_data->get_data('tournament', array('id' => $getMatchData[0]->tournamentID));
		$player_1_ID 		= $getMatchData[0]->player_1_ID;
		$player_2_ID 		= $getMatchData[0]->player_2_ID;
		$player_1_new_score = $getMatchData[0]->player_1_score;
		$player_2_new_score = $getMatchData[0]->player_2_score;
		$match_new_status   = $getMatchData[0]->match_status;
		$player_1_status  	= $getMatchData[0]->player_1_status;
		$player_2_status  	= $getMatchData[0]->player_2_status;
		$winnerID 			= $getMatchData[0]->winnerID;
		$username_player_1  = $this->process_data->get_username($getMatchData[0]->player_1_ID);
		$username_player_2  = $this->process_data->get_username($getMatchData[0]->player_2_ID);

		$dataReturn['player_1_status'] = $player_1_status;
		$dataReturn['player_2_status'] = $player_2_status;
		$dataReturn['matchStatus'] 	   = $match_new_status;

		$currentSlot = 1;

		if($player_2_ID == $userID) {
			$currentSlot = 2;			
		}

		$score_update = false;

		//Create Status Update For Score
		if($player_1_new_score != $player_1_score) {
			$dataReturn['slot_1_score'] = $player_1_new_score;
			$score_update = true;
		}

		if($player_2_new_score != $player_2_score) {
			$dataReturn['slot_2_score'] = $player_2_new_score;
			$score_update = true;
		}	
		

		$dataReturn['player_1_desc'] = '';
		$dataReturn['player_2_desc'] = '';

		//Check Match Status And Update If New
		if($matchStatus != $match_new_status) {
			$acceptMatch = array(1, 4);
			if(in_array($tournamentData[0]->type, $acceptMatch)) {
				if($match_new_status == 0) {
					$matchStatus = 'Awaiting For Both Opponents To Be Ready To Get Started';
					$matchStatusClass = 'warning';

					if($player_2_ID != $userID) {
						$dataReturn['player_2_decision'] = '<span class="start-match">';
						if($player_2_status > 0) {
							if($getMatchData[0]->match_status == 2) { 
								$dataReturn['player_2_decision'] .= 'Match Inprogress';
							} else {
								$dataReturn['player_2_decision'] .= 'Your Opponent Is Ready';
							}
						} else { 
							$dataReturn['player_2_decision'] .= 'Your Opponent Is Not Ready';
						} 
						
						$dataReturn['player_2_decision'] .= '</span>';
					} else {
						if($player_2_status > 0) { 
							$dataReturn['player_2_decision'] = '<span class="start-match">';
								if($getMatchData[0]->match_status == 2) { 
									$dataReturn['player_2_decision'] .= 'Match Inprogress';
								} else { 
									$dataReturn['player_2_decision'] .= 'You Are Ready To Play';
								} 
							$dataReturn['player_2_decision'] .= '</span>';
						} else {
							if($getMatchData[0]->player_1_ID > 0) { 
								$dataReturn['player_2_decision'] = '<a href="' . base_url() . 'account/matches/setReady/' . $getMatchData[0]->id . '/2" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
							}
						} 
					}

					if($player_1_ID != $userID) {
						if($player_1_ID == 0) { 
							$dataReturn['player_1_decision']  = '<span class="start-match">';
							$dataReturn['player_1_decision'] .= 'No opponent assigned';
							$dataReturn['player_1_decision'] .= '</span>';
						} else { 
							$dataReturn['player_1_decision'] = '<span class="start-match">';
								if($player_1_status > 0) { 
									if($getMatchData[0]->match_status == 2) { 
										$dataReturn['player_1_decision'] .= 'Match Inprogress';
									} else { 
										$dataReturn['player_1_decision'] .= 'Your Opponent Is Ready';
									} 
								} else { 
									$dataReturn['player_1_decision'] .= 'Your Opponent Is Not Ready';
								}
							$dataReturn['player_1_decision'] .= '</span>';
						}
					} else {
						if($player_1_status > 0) { 
							$dataReturn['player_1_decision']  = '<span class="start-match">';
								if($getMatchData[0]->match_status == 2) { 
									$dataReturn['player_1_decision'] .= 'Match Inprogress';
								} else { 
									$dataReturn['player_1_decision'] .= 'You Are Ready To Play';
								}
							$dataReturn['player_1_decision'] .= '</span>';
						} else {
							if($player_2_ID > 0) {
								$dataReturn['player_1_decision'] = '<a href="<?= base_url(); ?>account/matches/setReady/<?= $id; ?>/1" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
							}
						}
					}
				}

				if($match_new_status == 1) {
					$matchStatus = 'Both Opponents Ready. Waiting For Spectator To Start Match';
					$matchStatusClass = 'info';

					if($player_2_ID != $userID) {
						$dataReturn['player_2_decision'] = '<span class="start-match">';
						if($player_2_status > 0) {
							if($getMatchData[0]->match_status == 2) { 
								$dataReturn['player_2_decision'] .= 'Match Inprogress';
							} else {
								$dataReturn['player_2_decision'] .= 'Your Opponent Is Ready';
							}
						} else { 
							$dataReturn['player_2_decision'] .= 'Your Opponent Is Not Ready';
						} 
						
						$dataReturn['player_2_decision'] .= '</span>';
					} else {
						if($player_2_status > 0) { 
							$dataReturn['player_2_decision'] = '<span class="start-match">';
								if($getMatchData[0]->match_status == 2) { 
									$dataReturn['player_2_decision'] .= 'Match Inprogress';
								} else { 
									$dataReturn['player_2_decision'] .= 'You Are Ready To Play';
								} 
							$dataReturn['player_2_decision'] .= '</span>';
						} else {
							if($getMatchData[0]->player_1_ID > 0) { 
								$dataReturn['player_2_decision'] = '<a href="' . base_url() . 'account/matches/setReady/' . $getMatchData[0]->id . '/2" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
							}
						} 
					}

					if($player_1_ID != $userID) {
						if($player_1_ID == 0) { 
							$dataReturn['player_1_decision']  = '<span class="start-match">';
							$dataReturn['player_1_decision'] .= 'No opponent assigned';
							$dataReturn['player_1_decision'] .= '</span>';
						} else { 
							$dataReturn['player_1_decision'] = '<span class="start-match">';
								if($player_1_status > 0) { 
									if($getMatchData[0]->match_status == 2) { 
										$dataReturn['player_1_decision'] .= 'Match Inprogress';
									} else { 
										$dataReturn['player_1_decision'] .= 'Your Opponent Is Ready';
									} 
								} else { 
									$dataReturn['player_1_decision'] .= 'Your Opponent Is Not Ready';
								}
							$dataReturn['player_1_decision'] .= '</span>';
						}
					} else {
						if($player_1_status > 0) { 
							$dataReturn['player_1_decision']  = '<span class="start-match">';
								if($getMatchData[0]->match_status == 2) { 
									$dataReturn['player_1_decision'] .= 'Match Inprogress';
								} else { 
									$dataReturn['player_1_decision'] .= 'You Are Ready To Play';
								}
							$dataReturn['player_1_decision'] .= '</span>';
						} else {
							if($player_2_ID > 0) {
								$dataReturn['player_1_decision'] = '<a href="<?= base_url(); ?>account/matches/setReady/<?= $id; ?>/1" class="btn dso-ebtn-sm btn-dark btn-set-ready">I\'m Ready</a>';
							}
						}
					}

					$dataReturn['matchStartRequest'] .= '<div class="match-start-wrapper">';
					$dataReturn['matchStartRequest'] .= '<p>You Both Are Ready To Play</p>';
					$dataReturn['matchStartRequest'] .= '<a href="' . base_url() . 'account/startPlayerMatch/' . $matchID . '/'. $userID . '" class="btn dso-ebtn-sm btn-dark btn-start-player-match">Start Match</a>';
					$dataReturn['matchStartRequest'] .= '</div>';
				}

				if($match_new_status == 2) {
					$matchStatus = 'Match Started';
					$matchStatusClass = 'success';

					$dataReturn['player_1_decision']  = '<span class="start-match">';
					$dataReturn['player_1_decision'] .= 'Match Inprogress';
					$dataReturn['player_1_decision'] .= '</span>';

					$dataReturn['player_2_decision']  = '<span class="start-match">';
					$dataReturn['player_2_decision'] .= 'Match Inprogress';
					$dataReturn['player_2_decision'] .= '</span>';

					$dataReturn['setScoreForm']  = '<div class="setScore-form">';
					$dataReturn['setScoreForm'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $userID . '" class="setScore" onsubmit="return false;">';
					$dataReturn['setScoreForm'] .= '<div class="inline-field">';
					$dataReturn['setScoreForm'] .= '<input type="text" name="player_score" value="0" class="form-control" />';
					$dataReturn['setScoreForm'] .= '<input type="hidden" name="userType" value="0" />';
					$dataReturn['setScoreForm'] .= '<input type="hidden" name="player" value="'.$currentSlot.'" />';
					$dataReturn['setScoreForm'] .= '<div class="inline-sm-btns">';
					$dataReturn['setScoreForm'] .= '<button type="submit" class="btn-small-circle btn-dark">';
					$dataReturn['setScoreForm'] .= '<i class="fa fa-check"></i>';
					$dataReturn['setScoreForm'] .= '</button>';
					$dataReturn['setScoreForm'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
					$dataReturn['setScoreForm'] .= '<i class="fa fa-times"></i>';
					$dataReturn['setScoreForm'] .= '</button>';
					$dataReturn['setScoreForm'] .= '</div>';
					$dataReturn['setScoreForm'] .= '</div>';
					$dataReturn['setScoreForm'] .= '</form>';
					$dataReturn['setScoreForm'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
					$dataReturn['setScoreForm'] .= '</div>';

					$dataReturn['slot'] = $currentSlot;
				}

				if($match_new_status == 3) {
					$matchStatus = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
					$matchStatusClass = 'info';

					//Check if both players decision is true
					$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_1_ID,
						'meta_key' => 'player_1_decision',
					));
					$player_1_decision = $player_1_decision[0]->meta_value;

					$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_2_ID,
						'meta_key' => 'player_2_decision',
					));

					$player_2_decision = $player_2_decision[0]->meta_value;

					$dataReturn['player_1_desc'] = $player_1_decision;
					$dataReturn['player_2_desc'] = $player_2_decision;

					if($player_1_decision != $player_1_dec) {
						if($player_1_ID != $userID) {    
							if($player_1_decision != '') {
								$dataReturn['player_1_decision'] = '<span class="start-match">';
								
								if($player_1_decision == 0) {
									$dataReturn['player_1_decision'] .= 'Waiting For Your Opponent Decision';
								}

								if($player_1_decision == 1) {
									$dataReturn['player_1_decision'] .= 'Player Accepted Results';
								}

								$dataReturn['player_1_decision'] .= '</span>';
							}
						}

						if($player_1_ID == $userID) {
							if($player_1_decision != ''  && $player_1_decision == 0) {
								$dataReturn['player_1_decision']  = '<div class="btn-row">';
								$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/acceptMatch/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>';
								$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/disputeMatch/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>';
								$dataReturn['player_1_decision'] .= '</div>';
							} else {
								$dataReturn['player_1_decision']  = '<span class="start-match">';
								$dataReturn['player_1_decision'] .= 'You Accepted Results';
								$dataReturn['player_1_decision'] .= '</span>';
							}
						}
					}

					if($player_2_decision != $player_2_dec) {
						if($player_2_ID != $userID) {    
							if($player_2_decision != '') {
								$dataReturn['player_2_decision'] = '<span class="start-match">';
								
								if($player_2_decision == 0) {
									$dataReturn['player_2_decision'] .= 'Waiting For Your Opponent Decision';
								}


								if($player_2_decision == 1) {
									$dataReturn['player_2_decision'] .= 'Player Accepted Results';
								}

								$dataReturn['player_2_decision'] .= '</span>';
							}
						}

						if($player_2_ID == $userID) {
							if($player_2_decision != ''  && $player_2_decision == 0) {
								$dataReturn['player_2_decision']  = '<div class="btn-row">';
								$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/acceptMatch/' . $matchID . '/' . $player_2_ID . '" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>';
								$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/disputeMatch/' . $matchID . '/' . $player_2_ID . '" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>';
								$dataReturn['player_2_decision'] .= '</div>';
							} else {
								$dataReturn['player_2_decision']  = '<span class="start-match">';
								$dataReturn['player_2_decision'] .= 'You Accepted Results';
								$dataReturn['player_2_decision'] .= '</span>';
							}
						}
					}

					$matchTime = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => 0,
						'meta_key' => 'match_result_time',
					));

					$dataReturn['timeStart']	= date('M d, Y H:i:s');
					$dataReturn['matchTimeEnd'] = date('M d, Y H:i:s', strtotime($matchTime[0]->meta_value));

					$dataReturn['slot1Data'] = '';
					$dataReturn['slot2Data']  = '';

					if($winnerID > 0 && $winnerID == $player_1_ID) {                 
						$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
					} 

					if($winnerID > 0 && $winnerID == $player_2_ID) {                 
						$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
					} 
				}

				if($match_new_status == 4) {
					$matchStatus = 'Match In Dispute';
					$matchStatusClass = 'danger';

					//Check if both players decision is true
					$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_1_ID,
						'meta_key' => 'player_1_decision',
					));
					$player_1_decision = $player_1_decision[0]->meta_value;

					$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_2_ID,
						'meta_key' => 'player_2_decision',
					));

					$player_2_decision = $player_2_decision[0]->meta_value;

					$dataReturn['player_1_desc'] = $player_1_decision;
					$dataReturn['player_2_desc'] = $player_2_decision;

					if($player_1_decision != $player_1_dec) {
						if($player_1_ID != $userID) {    
							if($player_1_decision != '') {
								$dataReturn['player_1_decision'] = '<span class="start-match">';

								if($player_1_decision == 2) {
									$dataReturn['player_1_decision'] .= 'Your Oppenent Filed Dispute';
								}

								$dataReturn['player_1_decision'] .= '</span>';
							}
						}
					}

					if($player_2_decision != $player_2_dec) {
						if($player_2_ID != $userID) {    
							if($player_2_decision != '') {
								$dataReturn['player_2_decision'] = '<span class="start-match">';
								
								if($player_2_decision == 2) {
									$dataReturn['player_2_decision'] .= 'Your Oppenent Filed Dispute';
								}

								$dataReturn['player_2_decision'] .= '</span>';
							}
						} 
					}
				}

				if($match_new_status == 5) {
					$winnerUsername = $this->process_data->get_username($winnerID);

					$matchStatus = 'Match Completed. ' . $winnerUsername . ' Won The Match';
					$matchStatusClass = 'success';

					//Check if both players decision is true
					$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_1_ID,
						'meta_key' => 'player_1_decision',
					));
					$player_1_decision = $player_1_decision[0]->meta_value;

					$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_2_ID,
						'meta_key' => 'player_2_decision',
					));

					$player_2_decision = $player_2_decision[0]->meta_value;

					$dataReturn['player_1_desc'] = $player_1_decision;
					$dataReturn['player_2_desc'] = $player_2_decision;
					
					if($player_1_decision != $player_1_dec) {
						if($player_1_ID != $userID) {    
							if($player_1_decision != '') {
								$dataReturn['player_1_decision'] = '<span class="start-match">';

								if($player_1_decision == 1) {
									$dataReturn['player_1_decision'] .= 'Your Oppenent Accepeted The Results';
								}

								$dataReturn['player_1_decision'] .= '</span>';
							}
						} 
					}

					if($player_2_decision != $player_2_dec) {
						if($player_2_ID != $userID) {    
							if($player_2_decision != '') {
								$dataReturn['player_2_decision'] = '<span class="start-match">';
								
								if($player_2_decision == 1) {
									$dataReturn['player_2_decision'] .= 'Your Oppenent Accepeted The Results';
								}

								$dataReturn['player_2_decision'] .= '</span>';
							}
						} 
					}

					$dataReturn['slot1Data'] = '';
					$dataReturn['slot2Data']  = '';

					
					if($winnerID > 0 && $winnerID == $player_1_ID) {                 
						$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
					} 

					if($winnerID > 0 && $winnerID == $player_2_ID) {                 
						$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
					} 
				}

				$statusPrefix = 'badge badge-';

				$dataReturn['updateResult']		  = 1;
				$dataReturn['matchResultMessage'] = $matchStatus;
				$dataReturn['matchStatusBadge']   = $statusPrefix.$matchStatusClass;
				$dataReturn['matchID']			  = $matchID;
				$dataReturn['matchStatus']		  = $match_new_status;
				$dataReturn['playerMessage'] 	  = '<span class="start-match">You Accepeted The Results</span>';
				$dataReturn['matchType'] 		  = 1;
			}

			if($tournamentData[0]->type == 2) {
				$dataReturn['updateResult'] = 1;
				
				if($match_new_status == 1) {
					$dataReturn['matchResultMessage'] = 'Match Inprogress';
					$dataReturn['matchStatusBadge']   = 'badge badge-info';
				}

				if($match_new_status == 2) {
					$dataReturn['matchResultMessage'] = 'Qualified';
					$dataReturn['matchStatusBadge']   = 'badge badge-success';
				}

				if($match_new_status == 0) {
					$dataReturn['matchResultMessage'] = 'Eliminated';
					$dataReturn['matchStatusBadge']   = 'badge badge-danger';
				}
			}
		} else {
			$dataReturn['updateResult'] = 0;

			$acceptMatch = array(1, 4);
			if(in_array($tournamentData[0]->type, $acceptMatch)) {
				if($match_new_status == 0) {
					if($player_1_cur_status != $player_1_status) { 
						$dataReturn['player_1_decision']  = '<span class="start-match">';
						$dataReturn['player_1_decision'] .= 'Player Is Ready';
						$dataReturn['player_1_decision'] .= '</span>';
						$dataReturn['updateResult'] = 1;
					}
					
					if($player_2_cur_status != $player_2_status) { 
						$dataReturn['player_2_decision']  = '<span class="start-match">';
						$dataReturn['player_2_decision'] .= 'Player Is Ready';
						$dataReturn['player_2_decision'] .= '</span>';
						$dataReturn['updateResult'] = 1;
					}
				}

				if($match_new_status == 3) {
					$matchStatus = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
					$matchStatusClass = 'info';

					//Check if both players decision is true
					$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_1_ID,
						'meta_key' => 'player_1_decision',
					));

					$player_1_decision = $player_1_decision[0]->meta_value;

					$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_2_ID,
						'meta_key' => 'player_2_decision',
					));

					$player_2_decision = $player_2_decision[0]->meta_value;

					$dataReturn['player_1_desc'] = $player_1_decision;
					$dataReturn['player_2_desc'] = $player_2_decision;

					if($player_1_decision != $player_1_dec) {
						if($player_1_ID != $userID) {    
							if($player_1_decision != '') {
								$dataReturn['player_1_decision'] = '<span class="start-match">';
								
								if($player_1_decision == 0) {
									$dataReturn['player_1_decision'] .= 'Waiting For Your Opponent Decision';
								}

								$dataReturn['player_1_decision'] .= '</span>';
							}
						}

						if($player_1_ID == $userID) {
							if($player_1_decision != ''  && $player_1_decision == 0) {
								$dataReturn['player_1_decision']  = '<div class="btn-row">';
								$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/acceptMatch/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>';
								$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/disputeMatch/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>';
								$dataReturn['player_1_decision'] .= '</div>';
							} 
						}
					}

					if($player_2_decision != $player_2_dec) {
						if($player_2_ID != $userID) {    
							if($player_2_decision != '') {
								$dataReturn['player_2_decision'] = '<span class="start-match">';
								
								if($player_2_decision == 0) {
									$dataReturn['player_2_decision'] .= 'Waiting For Your Opponent Decision';
								}

								$dataReturn['player_2_decision'] .= '</span>';
							}
						}

						if($player_2_ID == $userID) {
							if($player_2_decision != ''  && $player_2_decision == 0) {
								$dataReturn['player_2_decision']  = '<div class="btn-row">';
								$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/acceptMatch/' . $matchID . '/' . $player_2_ID . '" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decission">Accept</a>';
								$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/disputeMatch/' . $matchID . '/' . $player_2_ID . '" data-slot="2" class="btn dso-ebtn-sm btn-dark btn-set-decline">Decline</a>';
								$dataReturn['player_2_decision'] .= '</div>';
							} 
						}
					}

					$matchTime = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => 0,
						'meta_key' => 'match_result_time',
					));

					$dataReturn['timeStart']	= date('M d, Y H:i:s');
					$dataReturn['matchTimeEnd'] = date('M d, Y H:i:s', strtotime($matchTime[0]->meta_value));

					$dataReturn['slot1Data'] = '';
					$dataReturn['slot2Data']  = '';

					if($winnerID > 0 && $winnerID == $player_1_ID) {                 
						$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
					} 

					if($winnerID > 0 && $winnerID == $player_2_ID) {                 
						$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
					} 
				} 

				if($match_new_status == 5) {
					$winnerUsername = $this->process_data->get_username($winnerID);

					$matchStatus = 'Match Completed. ' . $winnerUsername . ' Won The Match';
					$matchStatusClass = 'success';

					//Check if both players decision is true
					$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_1_ID,
						'meta_key' => 'player_1_decision',
					));
					$player_1_decision = $player_1_decision[0]->meta_value;

					$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
						'matchID'  => $matchID,
						'playerID' => $player_2_ID,
						'meta_key' => 'player_2_decision',
					));

					$player_2_decision = $player_2_decision[0]->meta_value;

					$dataReturn['player_1_desc'] = $player_1_decision;
					$dataReturn['player_2_desc'] = $player_2_decision;
					
					if($player_1_decision != $player_1_dec) {
						if($player_1_ID != $userID) {    
							if($player_1_decision != '') {
								$dataReturn['player_1_decision'] = '<span class="start-match">';

								if($player_1_decision == 1) {
									$dataReturn['player_1_decision'] .= 'Your Oppenent Accepeted The Results';
								}

								$dataReturn['player_1_decision'] .= '</span>';
							}
						} 
					}

					if($player_2_decision != $player_2_dec) {
						if($player_2_ID != $userID) {    
							if($player_2_decision != '') {
								$dataReturn['player_2_decision'] = '<span class="start-match">';
								
								if($player_2_decision == 1) {
									$dataReturn['player_2_decision'] .= 'Your Oppenent Accepeted The Results';
								}

								$dataReturn['player_2_decision'] .= '</span>';
							}
						} 
					}

					$dataReturn['slot1Data'] = '';
					$dataReturn['slot2Data']  = '';

					
					if($winnerID > 0 && $winnerID == $player_1_ID) {                 
						$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
					} 

					if($winnerID > 0 && $winnerID == $player_2_ID) {                 
						$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
						$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
					} 
				}

				$dataReturn['matchType']   = 1;
				$dataReturn['matchID']     = $matchID;
			}
		}

		$dataReturn['scoreUpdate'] = 0;

		//Check if score updates
		if($score_update == true) {
			$dataReturn['scoreUpdate'] = 1;
		}

		if($player_1_new_score > 0 && $player_2_new_score > 0) {
			$dataReturn['matchSubmit'] = 1;

			$dataReturn['decisionBtnData']  = '<a href="'. base_url() . 'account/matches/setWinner/'. $matchID . '/' . $userID . '/0" class="btn dso-ebtn dso-ebtn-solid btn-match-complete">';
			$dataReturn['decisionBtnData'] .= '<span class="dso-btn-text">Submit Results</span>';
			$dataReturn['decisionBtnData'] .= '<div class="dso-btn-bg-holder"></div>';
			$dataReturn['decisionBtnData'] .= '</a>';
		}

		$dataReturn['player_1_ID'] = $player_1_ID;
		$dataReturn['player_2_ID'] = $player_2_ID;

		echo json_encode($dataReturn);
	}

	public function getManagerMatchUpdate() {
		$matchID 		 = $this->input->post('matchID');
		$matchStatus 	 = $this->input->post('matchStatus');
		$player_1_score  = $this->input->post('player_1_score');
		$player_2_score  = $this->input->post('player_2_score');
		$player_1_cur_status = $this->input->post('player_1_status');
		$player_2_cur_status = $this->input->post('player_2_status');
		$player_1_dec 	 = $this->input->post('player_1_dec');
		$player_2_dec 	 = $this->input->post('player_2_dec');

		$getMatchData 		= $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$player_1_ID 		= $getMatchData[0]->player_1_ID;
		$player_2_ID 		= $getMatchData[0]->player_2_ID;
		$player_1_new_score = $getMatchData[0]->player_1_score;
		$player_2_new_score = $getMatchData[0]->player_2_score;
		$match_new_status   = $getMatchData[0]->match_status;
		$player_1_status  	= $getMatchData[0]->player_1_status;
		$player_2_status  	= $getMatchData[0]->player_2_status;
		$winnerID 			= $getMatchData[0]->winnerID;

		$dataReturn['player_1_status'] 	= $player_1_status;
		$dataReturn['player_2_status'] 	= $player_2_status;
		$dataReturn['matchStatus'] 	   	= $match_new_status;
		$dataReturn['matchID']   	   	= $matchID;
		$dataReturn['player_1_ID']		= $player_1_ID;
		$dataReturn['player_2_ID']		= $player_2_ID;

		$score_update = false;

		//Create Status Update For Score
		if($player_1_new_score != $player_1_score) {
			$dataReturn['slot_1_score'] = $player_1_new_score;
			$score_update = true;
		}

		if($player_2_new_score != $player_2_score) {
			$dataReturn['slot_2_score'] = $player_2_new_score;
			$score_update = true;
		}

		$dataReturn['player_1_desc'] 	 = '';
		$dataReturn['player_2_desc'] 	 = '';
		$dataReturn['player_1_decision'] = '';
		$dataReturn['player_2_decision'] = '';
		$dataReturn['matchStartRequest'] = '';
		$dataReturn['matchStatusBadge']  = '';
		$dataReturn['timeStart'] 		 = '';
		$dataReturn['setScoreSlot1']	 = '';
		$dataReturn['setScoreSlot2']	 = '';

 		//Check Match Status And Update If New
		if($matchStatus != $match_new_status) {
			if($match_new_status == 0) {
				$matchStatus = 'Awaiting For Both Opponents To Be Ready To Get Started';
				$matchStatusClass = 'warning';

				if($player_1_cur_status != $player_1_status) { 
					$dataReturn['player_1_decision']  = '<span class="start-match">';
					$dataReturn['player_1_decision'] .= 'Player Is Ready';
					$dataReturn['player_1_decision'] .= '</span>';
				}
				
				if($player_2_cur_status != $player_2_status) { 
					$dataReturn['player_2_decision']  = '<span class="start-match">';
					$dataReturn['player_2_decision'] .= 'Player Is Ready';
					$dataReturn['player_2_decision'] .= '</span>';
				}
			}

			if($match_new_status == 1) {
				$matchStatus = 'Both Opponents Ready. Waiting For Spectator To Start Match';
				$matchStatusClass = 'info';

				if($player_1_cur_status != $player_1_status) { 
					$dataReturn['player_1_decision']  = '<span class="start-match">';
					$dataReturn['player_1_decision'] .= 'Player Is Ready';
					$dataReturn['player_1_decision'] .= '</span>';
				}
				
				if($player_2_cur_status != $player_2_status) { 
					$dataReturn['player_2_decision']  = '<span class="start-match">';
					$dataReturn['player_2_decision'] .= 'Player Is Ready';
					$dataReturn['player_2_decision'] .= '</span>';
				}

				$dataReturn['matchStartRequest'] .= '<div class="match-start-wrapper">';
				$dataReturn['matchStartRequest'] .= '<p>Players Are Ready To Play The Match</p>';
				$dataReturn['matchStartRequest'] .= '<a href="' . base_url() . 'account/matches/startPlayerMatch/' . $matchID . '" class="btn dso-ebtn-sm btn-dark btn-start-match">Start Match</a>';
				$dataReturn['matchStartRequest'] .= '</div>';
			}

			if($match_new_status == 2) {
				$matchStatus = 'Match Started';
				$matchStatusClass = 'success';

				$dataReturn['player_1_decision'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $player_1_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>';
				$dataReturn['player_2_decision'] = '<a href="' . base_url() . 'account/matches/setWinner/' . $matchID . '/' . $player_2_ID . '" class="btn dso-ebtn-sm btn-dark btn-set-winner">Set Winner</a>';

				$dataReturn['setScoreSlot1'] .= '<div class="setScore-form">';
				$dataReturn['setScoreSlot1'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $getMatchData[0]->player_1_ID . '" class="setScore" onsubmit="return false;">';
				$dataReturn['setScoreSlot1'] .= '<div class="inline-field">';
				$dataReturn['setScoreSlot1'] .= '<input type="text" name="player_score" value="' . $getMatchData[0]->player_1_score . '" class="form-control" />';
				$dataReturn['setScoreSlot1'] .= '<input type="hidden" name="player" value="1" />';
				$dataReturn['setScoreSlot1'] .= '<div class="inline-sm-btns">';
				$dataReturn['setScoreSlot1'] .= '<button type="submit" class="btn-small-circle btn-dark">';
				$dataReturn['setScoreSlot1'] .= '<i class="fa fa-check"></i>';
				$dataReturn['setScoreSlot1'] .= '</button>';
				$dataReturn['setScoreSlot1'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
				$dataReturn['setScoreSlot1'] .= '<i class="fa fa-times"></i>';
				$dataReturn['setScoreSlot1'] .= '</button>';
				$dataReturn['setScoreSlot1'] .= '</div>';
				$dataReturn['setScoreSlot1'] .= '</div>';
				$dataReturn['setScoreSlot1'] .= '</form>';
				$dataReturn['setScoreSlot1'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
				$dataReturn['setScoreSlot1'] .= '</div>';

				$dataReturn['setScoreSlot2'] .= '<div class="setScore-form">';
				$dataReturn['setScoreSlot2'] .= '<form method="POST" action="' . base_url() . 'account/matches/setScore/' . $matchID . '/' . $getMatchData[0]->player_2_ID . '" class="setScore" onsubmit="return false;">';
				$dataReturn['setScoreSlot2'] .= '<div class="inline-field">';
				$dataReturn['setScoreSlot2'] .= '<input type="text" name="player_score" value="' . $getMatchData[0]->player_2_score . '" class="form-control" />';
				$dataReturn['setScoreSlot2'] .= '<input type="hidden" name="player" value="2" />';
				$dataReturn['setScoreSlot2'] .= '<div class="inline-sm-btns">';
				$dataReturn['setScoreSlot2'] .= '<button type="submit" class="btn-small-circle btn-dark">';
				$dataReturn['setScoreSlot2'] .= '<i class="fa fa-check"></i>';
				$dataReturn['setScoreSlot2'] .= '</button>';
				$dataReturn['setScoreSlot2'] .= '<button type="button" class="btn-small-circle btn-cancel-score-set btn-dark">';
				$dataReturn['setScoreSlot2'] .= '<i class="fa fa-times"></i>';
				$dataReturn['setScoreSlot2'] .= '</button>';
				$dataReturn['setScoreSlot2'] .= '</div>';
				$dataReturn['setScoreSlot2'] .= '</div>';
				$dataReturn['setScoreSlot2'] .= '</form>';
				$dataReturn['setScoreSlot2'] .= '<a href="javascript:void(0);" class="add-score">Set Score</a>';
				$dataReturn['setScoreSlot2'] .= '</div>';
			}

			if($match_new_status == 3) {
				$matchStatus = 'Results Announced. Waiting For Both Players To Accept / Decline The Results';
				$matchStatusClass = 'info';

				//Check if both players decision is true
				$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_1_ID,
					'meta_key' => 'player_1_decision',
				));
				
				$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_2_ID,
					'meta_key' => 'player_2_decision',
				));
				
				$player_1_decision = $player_1_decision[0]->meta_value;
				$player_2_decision = $player_2_decision[0]->meta_value;

				$dataReturn['player_1_desc'] = $player_1_decision;
				$dataReturn['player_2_desc'] = $player_2_decision;


				if($player_1_decision != $player_1_dec) {
					if($player_1_decision != '') {
						$dataReturn['player_1_decision'] = '<span class="start-match">';
						
						if($player_1_decision == 0) {
							$dataReturn['player_1_decision'] .= 'Waiting For Player\'s Decision';
						}

						if($player_1_decision == 1) {
							$dataReturn['player_1_decision'] .= 'Player Accepted The Results';
						}

						if($player_1_decision == 2) {
							$dataReturn['player_1_decision'] .= 'Player Filed Dispute';
						}

						$dataReturn['player_1_decision'] .= '</span>';

						if($player_1_decision == 2) {
							$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
						}
					}
				}

				if($player_2_decision != $player_2_dec) {
					if($player_2_decision != '') {
						$dataReturn['player_2_decision'] = '<span class="start-match">';
						
						if($player_2_decision == 0) {
							$dataReturn['player_2_decision'] .= 'Waiting For Player\'s Decision';
						}

						if($player_2_decision == 1) {
							$dataReturn['player_2_decision'] .= 'Player Accepted The Results';
						}

						if($player_2_decision == 2) {
							$dataReturn['player_2_decision'] .= 'Player Filed Dispute';
						}

						$dataReturn['player_2_decision'] .= '</span>';

						if($player_2_decision == 2) {
							$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_2_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
						}
					}
				}

				$matchTime = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => 0,
					'meta_key' => 'match_result_time',
				));

				$dataReturn['timeStart']	= date('M d, Y H:i:s');
				$dataReturn['matchTimeEnd'] = $matchTime[0]->meta_value;

				$dataReturn['slot1Data'] = '';
				$dataReturn['slot2Data']  = '';

				
				if($winnerID > 0 && $winnerID == $player_1_ID) {                 
					$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
				} 

				if($winnerID > 0 && $winnerID == $player_2_ID) {                 
					$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
				}
			}

			if($match_new_status == 4) {
				$matchStatus = 'Match In Dispute';
				$matchStatusClass = 'danger';

				//Check if both players decision is true
				$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_1_ID,
					'meta_key' => 'player_1_decision',
				));
				
				$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_2_ID,
					'meta_key' => 'player_2_decision',
				));
				
				$player_1_decision = $player_1_decision[0]->meta_value;
				$player_2_decision = $player_2_decision[0]->meta_value;

				$dataReturn['player_1_desc'] = $player_1_decision;
				$dataReturn['player_2_desc'] = $player_2_decision;

				if($player_1_decision != $player_1_dec) {
					if($player_1_decision != '') {
						if($player_1_decision == 2) {
							$dataReturn['player_1_decision'] = '<span class="start-match">';
							$dataReturn['player_1_decision'] .= 'Player Filed Dispute';
							$dataReturn['player_1_decision'] .= '</span>';
							$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
						}
					}
				}

				if($player_2_decision != $player_2_dec) {
					if($player_2_decision != '') {
						if($player_2_decision == 2) {
							$dataReturn['player_2_decision'] = '<span class="start-match">';
							$dataReturn['player_2_decision'] .= 'Player Filed Dispute';
							$dataReturn['player_2_decision'] .= '</span>';
							$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_2_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
						}
					}
				}
			}

			if($match_new_status == 5) {
				$winnerUsername = $this->process_data->get_username($winnerID);

				$matchStatus = 'Match Completed. ' . $winnerUsername . ' Won The Match';
				$matchStatusClass = 'success';

				//Check if both players decision is true
				$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_1_ID,
					'meta_key' => 'player_1_decision',
				));
				
				$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_2_ID,
					'meta_key' => 'player_2_decision',
				));
				
				$player_1_decision = $player_1_decision[0]->meta_value;
				$player_2_decision = $player_2_decision[0]->meta_value;

				$dataReturn['player_1_desc'] = $player_1_decision;
				$dataReturn['player_2_desc'] = $player_2_decision;

				if($player_1_decision != $player_1_dec) {
					$dataReturn['player_1_decision'] = '<span class="start-match">';

					if($player_1_decision == 1) {
						$dataReturn['player_1_decision'] .= 'Result Accepted';
					}

					$dataReturn['player_1_decision'] .= '</span>';
				}

				if($player_2_decision != $player_2_dec) {
					$dataReturn['player_2_decision'] = '<span class="start-match">';
					
					if($player_2_decision == 1) {
						$dataReturn['player_2_decision'] .= 'Result Accepted';
					}

					$dataReturn['player_2_decision'] .= '</span>';
				}

				$dataReturn['slot1Data'] = '';
				$dataReturn['slot2Data']  = '';

				
				if($winnerID > 0 && $winnerID == $player_1_ID) {                 
					$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
				} 

				if($winnerID > 0 && $winnerID == $player_2_ID) {                 
					$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
				}
			}

			$statusPrefix = 'badge badge-';

			$dataReturn['player_1_ID'] 		  = $player_1_ID;
			$dataReturn['player_2_ID'] 		  = $player_2_ID;
			$dataReturn['updateResult']		  = 1;
			$dataReturn['matchResultMessage'] = $matchStatus;
			$dataReturn['matchStatusBadge']   = $statusPrefix.$matchStatusClass;
			$dataReturn['matchID']			  = $matchID;
			$dataReturn['matchStatus']		  = $match_new_status;
		} else {
			$dataReturn['updateResult'] = 0;

			if($match_new_status == 0) {
				if($player_1_cur_status != $player_1_status) { 
					$dataReturn['player_1_decision']  = '<span class="start-match">';
					$dataReturn['player_1_decision'] .= 'Player Is Ready';
					$dataReturn['player_1_decision'] .= '</span>';
					$dataReturn['updateResult'] = 1;
				}
				
				if($player_2_cur_status != $player_2_status) { 
					$dataReturn['player_2_decision']  = '<span class="start-match">';
					$dataReturn['player_2_decision'] .= 'Player Is Ready';
					$dataReturn['player_2_decision'] .= '</span>';
					$dataReturn['updateResult'] = 1;
				}
			}

			if($match_new_status == 3) {
				//Check if both players decision is true
				$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_1_ID,
					'meta_key' => 'player_1_decision',
				));
				
				$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_2_ID,
					'meta_key' => 'player_2_decision',
				));
				
				if(count($player_1_decision) > 0) {
					$player_1_decision = $player_1_decision[0]->meta_value;
					$dataReturn['player_1_desc'] = $player_1_decision;
					
					if($player_1_decision != $player_1_dec) {
						if($player_1_decision != '') {
							$dataReturn['player_1_decision'] = '<span class="start-match">';
							
							if($player_1_decision == 0) {
								$dataReturn['player_1_decision'] .= "Waiting For Player's Decision";
							}

							if($player_1_decision == 1) {
								$dataReturn['player_1_decision'] .= 'Result Accepted';
							}

							if($player_1_decision == 2) {
								$dataReturn['player_1_decision'] .= 'Player Filed Dispute';
							}

							$dataReturn['player_1_decision'] .= '</span>';

							if($player_1_decision == 2) {
								$dataReturn['player_1_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_1_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
							}
						}

						$dataReturn['updateResult'] = 1;
					}
				}

				if(count($player_2_decision) > 0) {
					$player_2_decision = $player_2_decision[0]->meta_value;
				
					$dataReturn['player_2_desc'] = $player_2_decision;

					if($player_2_decision != $player_2_dec) {
						if($player_2_decision != '') {
							$dataReturn['player_2_decision'] = '<span class="start-match">';

							if($player_2_decision == 0) {
								$dataReturn['player_2_decision'] .= "Waiting For Player's Decision";
							}

							if($player_2_decision == 1) {
								$dataReturn['player_2_decision'] .= 'Result Accepted';
							}

							if($player_2_decision == 2) {
								$dataReturn['player_2_decision'] .= 'Player Filed Dispute';
							}

							$dataReturn['player_2_decision'] .= '</span>';

							if($player_2_decision == 2) {
								$dataReturn['player_2_decision'] .= '<a href="' . base_url() . 'account/matches/viewDispute/' . $matchID . '/' . $player_2_ID . '" data-slot="1" class="btn dso-ebtn-sm btn-dark btn-view-dispute">View Dispute</a>';
							}
						}

						$dataReturn['updateResult'] = 1;
					}
				}

				$dataReturn['slot1Data'] = '';
				$dataReturn['slot2Data']  = '';

				
				if($winnerID > 0 && $winnerID == $player_1_ID) {                 
					$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
				} 

				if($winnerID > 0 && $winnerID == $player_2_ID) {                 
					$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
				}
			} 

			if($match_new_status == 5) {
				//Check if both players decision is true
				$player_1_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_1_ID,
					'meta_key' => 'player_1_decision',
				));
				
				$player_2_decision = $this->process_data->get_data('tournament_matches_meta', array(
					'matchID'  => $matchID,
					'playerID' => $player_2_ID,
					'meta_key' => 'player_2_decision',
				));				
				
				if(count($player_1_decision) > 0) {
					$player_1_decision = $player_1_decision[0]->meta_value;
					$dataReturn['player_1_desc'] = $player_1_decision;
					if($player_1_decision != $player_1_dec) {
						if($player_1_decision == 1) {
							$dataReturn['player_1_decision']  = '<span class="start-match">';
							$dataReturn['player_1_decision'] .= 'Result Accepted';
							$dataReturn['player_1_decision'] .= '</span>';
							$dataReturn['updateResult'] = 1;
						}	
					}
				}
				
				if(count($player_2_decision) > 0) {
					$player_2_decision = $player_2_decision[0]->meta_value;
					$dataReturn['player_2_desc'] = $player_2_decision;
					if($player_2_decision != $player_2_dec) {
						if($player_2_decision == 1) {
							$dataReturn['player_2_decision']  = '<span class="start-match">';
							$dataReturn['player_2_decision'] .= 'Result Accepted';
							$dataReturn['player_2_decision'] .= '</span>';
							$dataReturn['updateResult'] = 1;
						}
					}
				}

				$dataReturn['slot1Data'] = '';
				$dataReturn['slot2Data']  = '';

				
				if($winnerID > 0 && $winnerID == $player_1_ID) {                 
					$dataReturn['slot1Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot2Data'] = '<label class="badge badge-danger">Looser</label>';
				} 

				if($winnerID > 0 && $winnerID == $player_2_ID) {                 
					$dataReturn['slot2Data'] = '<label class="badge badge-success">Winner</label>';
					$dataReturn['slot1Data'] = '<label class="badge badge-danger">Looser</label>';
				}
			}
		}

		$dataReturn['scoreUpdate'] = 0;

		//Check if score updates
		if($score_update = true) {
			$dataReturn['scoreUpdate'] = 1;
		}

		echo json_encode($dataReturn);
	}

	public function processChatFile() {
		$chatID = $this->input->post('chatID');
		
		if(!empty($_FILES['file']['name'])) {        
            if (!file_exists(getcwd() . '/assets/uploads/messages/tournament-match-chat-'.$chatID)) {
                mkdir(getcwd() . '/assets/uploads/messages/tournament-match-chat-'.$chatID, 0777, true);
            }

			$temp = explode(".", $_FILES["file"]["name"]);
			$newfilename = rand(1,100) . round(microtime(true)) . '.' . end($temp);
			$upload_path = getcwd() . '/assets/uploads/messages/tournament-match-chat-'.$chatID;
			$location = $upload_path.'/'.$newfilename;

			/* Upload file */
			if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				echo '<input type="hidden" name="messageFiles[]" value="' . $newfilename . '" />';
			}
		}
	}

	public function sendMatchMessage() {
		$userID       = $this->session->userdata('user_id');
        $chatID       = $this->input->post('thread');
        $messageFiles = ($this->input->post('messageFiles') !== null) ? serialize($this->input->post('messageFiles')) : '';
        $message      = $this->input->post('message');

        $dataChatLog = array(
            'chatID'    => $chatID,
            'senderID'  => $userID,
            'message'   => $message,
            'fileData'  => $messageFiles,
            'timeStamp' => date('Y-m-d H:i:s')
        );

        $this->process_data->create_data('tournament_chat_messages', $dataChatLog);

        $getChatData = $this->process_data->get_data('tournament_chat_messages', array('chatID' => $chatID));

        $messageClass = 'me';
        $htmlData  = '<li class="' . $messageClass . '">';
        $htmlData .= '<div class="entete">';

        $username   = $this->process_data->get_username($userID);

		$htmlData .= '<h3>' . date('H:i A') . '</h3>';
		$htmlData .= '<h2>@' . $username . '</h2>';
		$htmlData .= '<span class="status blue"></span>';							

        
        $htmlData .= '</div>';

        if($message != null) {
            $htmlData .= '<div class="message">' . $message . '</div>';
        }
        
        if($messageFiles != null) {
            $htmlData .= '<div class="fileData zoom-gallery">';

            $fileData 	= unserialize($messageFiles);
            $folderPath = base_url() . 'assets/uploads/messages/tournament-match-chat-' . $chatID . '/';
            $htmlfiles  = '';
            foreach($fileData as $file):
                $htmlfiles .= '<div class="chat-image">';
                $htmlfiles .= '<a href="'.$folderPath.'/'.$file.'" data-effect="mfp-move-horizontal">';
                $htmlfiles .= '<img src="'.$folderPath.'/'.$file.'" />';
                $htmlfiles .=  '</a>';
                $htmlfiles .= '</div>';
            endforeach;

            $htmlData .= $htmlfiles;
            $htmlData .= '</div>';
        }

        $htmlData .= '</li>';

        echo json_encode(
            array(
                'message'         => $htmlData,
                'chatCount'       => count($getChatData),
                'updateChatCount' => count($getChatData) . ' Messages',
            )
        );
	}

	public function updateMatchChat($chatID, $chatCount) {
        $userID = $this->session->userdata('user_id');

        $getChatData = $this->process_data->get_data('tournament_chat_messages', array('chatID' => $chatID));
        
        if(count($getChatData) > $chatCount) {
            $limitOffset = count($getChatData) - $chatCount;

            //Getting messages of current query
            $query = "SELECT * FROM tournament_chat_messages WHERE chatID = '".$chatID."' ORDER BY ID LIMIT " . $chatCount . ', ' . $limitOffset;
            $messagesData = $this->db->query($query)->result();

            $htmlData = '';
            foreach($messagesData as $messageData):
                $senderID     = $messageData->senderID;
                $message      = $messageData->message;
                $messageFiles = $messageData->fileData;

                if($senderID != $userID) {
	                $messageClass = ($senderID == $userID) ? 'me' : 'you';
	                $htmlData  = '<li class="' . $messageClass . '">';
	                $htmlData .= '<div class="entete">';

	                $username = $this->process_data->get_username($senderID);

	                if($senderID == $userID) {
	                    $htmlData .= '<h3>' . date('H:i A') . '</h3>';
	                    $htmlData .= '<h2>@' . $username . '</h2>';
	                    $htmlData .= '<span class="status blue"></span>';							
	                } else {
	                    $htmlData .= '<span class="status green"></span>';
	                    $htmlData .= '<h2>@' . $username . '</h2>';
	                    $htmlData .= '<h3>' . date('H:i A') . '</h3>';
	                }
	                
	                $htmlData .= '</div>';

	                if($message != null) {
	                    $htmlData .= '<div class="message">' . $message . '</div>';
	                }
	                
	                if($messageFiles != null) {
	                    $htmlData .= '<div class="fileData zoom-gallery">';

	                    $fileData 	= unserialize($messageFiles);
	                    $folderPath = base_url() . 'assets/uploads/messages/tournament-match-chat-' . $chatID . '/';
	                    $htmlfiles  = '';
	                    foreach($fileData as $file):
	                        $htmlfiles .= '<div class="chat-image">';
	                        $htmlfiles .= '<a href="'.$folderPath.'/'.$file.'" data-effect="mfp-move-horizontal">';
	                        $htmlfiles .= '<img src="'.$folderPath.'/'.$file.'" />';
	                        $htmlfiles .=  '</a>';
	                        $htmlfiles .= '</div>';
	                    endforeach;

	                    $htmlData .= $htmlfiles;
	                    $htmlData .= '</div>';
	                }

	                $htmlData .= '</li>';
	            }
            endforeach;

            echo json_encode(
                array(
                    'message'         => $htmlData,
                    'status'          => 1,
                    'chatCount'       => count($getChatData),
                    'updateChatCount' => count($getChatData) . ' Messages',
                )
            );
        } else {
            echo json_encode(
                array(
                    'status'  => 0
                )
            );
        }
    }

	public function getPlayerMatchChat() {
		$userID     = $this->session->userdata('user_id');
		$playerSlot = $this->input->post('playerSlot');
		$matchID    = $this->input->post('matchID');
		$matcheChat = $this->process_data->get_data('tournament_chat_group', array('matchID' => $matchID, 'slot' => $playerSlot));

		
		$messageHtml  = '';
		$messageCount = 0;
		$chatID       = 0;
		
		if(count($matcheChat) > 0) { 
			$chatID       = $matcheChat[0]->ID;
			$messagesData = $this->process_data->get_data('tournament_chat_messages', array('chatID' => $matcheChat[0]->ID));
			
			if(count($messagesData) > 0) { 
				$messageCount = count($messagesData);
				foreach($messagesData as $message):
					$messageClass = ($message->senderID != $userID) ? 'you' : 'me';
					$messageHtml .= '<li class="' . $messageClass . '">';
					$messageHtml .= '<div class="entete">';
					
					$username = $this->process_data->get_username($message->senderID);
					
					if($message->senderID == $userID) {
						$messageHtml .= "<h3>" . date('l h:i A', strtotime($message->timeStamp)) . "</h3>";
						$messageHtml .= "<h2>" . $username . "</h2>";
						$messageHtml .= '<span class="status blue"></span>';							
					} else {
						$messageHtml .= '<span class="status green"></span>';
						$messageHtml .= "<h2>" . $username . "</h2>";
						$messageHtml .= "<h3>" . date('l h:i A', strtotime($message->timeStamp)) . "</h3>";
					}
				
					$messageHtml .= '</div>';
					
					if($message->message != null) { 
						$messageHtml .= '<div class="message">';
						$messageHtml .= $message->message;
						$messageHtml .= '</div>';
					} 

					if($message->fileData != null) {
						$messageHtml .= '<div class="fileData zoom-gallery">';

						$fileData 	 = unserialize($message->fileData);
						$folderPath  = base_url() . 'assets/uploads/messages/tournament-match-chat-' . $message->chatID . '/';
						
						foreach($fileData as $file):
							$messageHtml .= '<div class="chat-image">';
							$messageHtml .= '<a href="'.$folderPath.'/'.$file.'" data-effect="mfp-move-horizontal">';
							$messageHtml .= '<img src="'.$folderPath.'/'.$file.'" />';
							$messageHtml .= '</a>';
							$messageHtml .= '</div>';
						endforeach;

						$messageHtml .= '</div>';
					}
	
					$messageHtml .= '</li>';
					
				endforeach;
			}
		}

		echo json_encode(array(
			'message'   => $messageHtml,
			'chatCount' => $messageCount,
			'chatID'    => $chatID
		));
	}

    public function playersCountUpdate() {
        $tournamentID = $this->input->post('tournamentID');
        $playersCount = $this->input->post('playersCount');

        //Getting current players count
        $tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
		$currentPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID, 'status' => 1));

		$allowed_players = $tournamentData[0]->max_allowed_players;
        $active_players  = count($currentPlayers);

        if($active_players > $playersCount) {
            $get_players_per = (100 / $allowed_players) * $active_players;

            //Get Old Class
            $get_players_per_old = (100 / $allowed_players) * $playersCount;

            $prgress_bar_class_before = 'bg-danger';
            if($get_players_per_old > 60) {
                $prgress_bar_class_before = 'bg-warning';
            }

            if($get_players_per_old == 100) {
                $prgress_bar_class_before = 'bg-success';
            }

            $prgress_bar_class = 'bg-danger';

            if($get_players_per > 60) {
                $prgress_bar_class = 'bg-warning';
            }

            if($get_players_per == 100) {
                $prgress_bar_class = 'bg-success';
            }


            /*
             * Newly Added Players Data
             */
            $offSet        = $active_players - ($active_players -  $playersCount);
            $limit         = ($active_players -  $playersCount);
            $playerQuery   = "SELECT * FROM (SELECT * FROM tournament_players WHERE tournamentID = '".$tournamentID."' ORDER BY id DESC) AS subquery WHERE tournamentID = '".$tournamentID."' ORDER BY id ASC LIMIT " . $offSet . ", " . $limit;
            $playersData   = $this->db->query($playerQuery)->result();
            $playerTeamBox = '';

            foreach($playersData as $player):
                $playerTeamBox .= '<div class="select-player-box">';
                $playerTeamBox .= '<div class="player-btn-row">';
                $playerTeamBox .= '<a href="' . base_url() . 'account/kick_player/'.$tournamentID.'" class="btn dso-ebtn-sm kick-player" data-id="'.$player->participantID.'">';
                $playerTeamBox .= '<span class="dso-btn-text">Kick</span>';
                $playerTeamBox .= '<div class="btn-loader">';
                $playerTeamBox .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
                $playerTeamBox .= '</div>';
                $playerTeamBox .= '</a>';
                $playerTeamBox .= '</div>';

                $player_username = $this->process_data->get_username($player->participantID);
                $player_data     = $this->process_data->get_user_data($player->participantID);
                $get_image       = $this->process_data->get_user_meta('user_image', $player->participantID);
                    
                if($get_image == null) {
                    $image_url = base_url() . 'assets/uploads/users/default.jpg';
                } else {
                    $image_url = base_url() . 'assets/uploads/users/user-' . $player->participantID . '/' . $get_image;
                }

                $playerTeamBox .= '<div class="thumbnail-circle ' .  strtolower($player_data->log_status) . '">';
                $playerTeamBox .= '<img loading="lazy" src="' . $image_url . '">';
                $playerTeamBox .= '</div>';

                $playerTeamBox .= '<div class="select-player-content">';
                $playerTeamBox .= '<h5 class="text-truncate">';
                $playerTeamBox .= '<a href="'.  base_url() . 'profile/' . $player_data->username . '" target="_blank">';
                $playerTeamBox .= '@'. $player_data->username;
                $playerTeamBox .= '</a>';
                $playerTeamBox .= '</h5>';
                $playerTeamBox .= '<div class="player-statistics">';
                
                $userData = $this->process_data->get_data('users', array('id' => $player->participantID));

                $playerTeamBox .= '<div class="player-data">';
                $playerTeamBox .= '<p>';
                $playerTeamBox .= '<i class="dso-tournament-meta-icon fab fa-discord" style="font-size: 12px;"></i>';
                $playerTeamBox .= '<span>Discord</span>';
                $playerTeamBox .= '</p>';

                $playerTeamBox .= '<h6>'. $userData[0]->discord_username . '</h6>';
                $playerTeamBox .= '</div>';
                $playerTeamBox .= '<div class="player-data">';
                $playerTeamBox .= '<p>';
                $playerTeamBox .= '<i class="dso-tournament-meta-icon ion-ios-game-controller-b"></i>';
                $playerTeamBox .= '<span>Tournaments Played</span>';
                $playerTeamBox .= '</p>';

                $playerTeamBox .= '<h6>0</h6>';
                $playerTeamBox .= '</div>';

                $playerTeamBox .= '<div class="player-data">';
                $playerTeamBox .= '<p>';
                $playerTeamBox .= '<i class="dso-tournament-meta-icon ion-trophy"></i>';
                $playerTeamBox .= '<span>Win Rate</span>';
                $playerTeamBox .= '</p>';

                $playerTeamBox .= '<h6>0.00%</h6>';
                $playerTeamBox .= '</div>';
                $playerTeamBox .= '</div>';
                $playerTeamBox .= '</div>';
                $playerTeamBox .= '</div>';
            endforeach;

            $dataReturn['status']           = 1;
            $dataReturn['playersCountData'] = $active_players . '/' . $allowed_players;
            $dataReturn['playersCount']     = $active_players;
            $dataReturn['playerPercentage'] = $get_players_per . '%';
            $dataReturn['playerClassNew']   = $prgress_bar_class;
            $dataReturn['playerClassOld']   = $prgress_bar_class_before;
            $dataReturn['playerTeamBox']    = $playerTeamBox;
        } else {
            $dataReturn['status'] = $tournamentID;
        }

		echo json_encode($dataReturn);
    }

    public function loadMessageNotifications($currentCount = 0) {
        $userID = $this->session->userdata('user_id');

		$chatNotificationQuery = "SELECT * FROM messages WHERE receiver_id = '" . $userID . "' AND status = 1 GROUP BY sender_id ORDER BY id";
        $chatNotificationData = $this->db->query($chatNotificationQuery)->result();
        $notificationCount    = count($chatNotificationData);
        $notificationBubble   = '';
        $dataReturn['status'] = 0;

        if(count($chatNotificationData) > 0) {
            $notificationBubble .= '<div class="notify-contact-bubble">';
            $notificationBubble .= '<span class="bubbleCount">' . $notificationCount . '</span>';
            $notificationBubble .= '</div>';
        }

        if($notificationCount > $currentCount) {
        	$dataReturn['status'] 			= 1;
        	$dataReturn['notification'] 	= $notificationCount;
        	$dataReturn['dataNotification'] = $notificationBubble;
        }        

        echo json_encode($dataReturn);
    }

	public function test() {
		$tournamentID = 76;
		$winnerID = 112;
		$matchID  = 534;
		/*$query = "SELECT * FROM tournament_matches WHERE tournamentID = '".$tournamentID."'  GROUP BY groupID ORDER BY id DESC LIMIT 1";
    	$dataMatch = $this->db->query($query)->result();

    	//Check the number of groups created per match
    	$checkGroup = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'groupID' => $dataMatch[0]->groupID));

    	$groupID = (count($checkGroup) == 2) ? $dataMatch[0]->groupID + 1 : $dataMatch[0]->groupID;
    	echo $groupID;
    	print_r($checkGroup);*/
		// $playersID = array(102, 103);

		// $dataMemebers[] = $winnerID;
		// //Get tournament Spectators
		// $tournamentSpectators = "SELECT tournament_spectators.*, users.username FROM tournament_spectators LEFT JOIN users ON users.id = tournament_spectators.specID WHERE tournament_spectators.tournamentID = '" . $tournamentID . "'";
		// $tournamentSpectators = $this->db->query($tournamentSpectators)->result();

		// //Check if group chat is already created
		// $chatGroupData = $this->process_data->get_data('tournament_chat_group', array(
		// 	'matchID'  => $getFreeSlotMatch[0]->id,
		// 	'slot'     => $playerSlot
		// ));	

		// if(count($chatGroupData) == 0) {
		// 	foreach($tournamentSpectators as $spectator):
		// 		$dataMemebers[] = $spectator->specID;
		// 	endforeach;

		// 	$membersID = serialize($dataMemebers);

		// 	$dataChatGroup = array(
		// 		'matchID'  => $newMatchID,
		// 		'memberID' => $membersID,
		// 		'slot'     => $playerSlot
		// 	);

		// 	$this->process_data->create_data('tournament_chat_group', $dataChatGroup);	
		// } else {
		// 	$membersID = unserialize($chatGroupData[0]->memberID);
		// 	array_push($membersID, $winnerID);
		// 	$membersID = serialize($membersID);

		// 	$this->process_data->create_data('tournament_chat_group', array('memberID' => $membersID), array('ID' => $chatGroupData[0]->ID));
		// }

		$tournamentData = $this->process_data->get_data('tournament', array('id' => $tournamentID));
		// $bracket = $this->process_data->get_looser_bracket($tournamentID);
		$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$round           = $getMatchDetails[0]->round;

		$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
        $playersCount = count($totalPlayers);
        $totalRounds =  strlen(decbin($playersCount - 1));
        $matchesCount = $playersCount;

		$method = 'acceptMatch';

			
		if($method == 'acceptMatch') {
			$getTournamentQuery = "SELECT tournament.* FROM tournament LEFT JOIN tournament_matches ON tournament_matches.tournamentID = tournament.id WHERE tournament_matches.id = '" . $matchID . "'";
	        $tournamentData  = $this->db->query($getTournamentQuery)->result();
			$getMatchDetails = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
	
			$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
			$playersCount = count($totalPlayers);
			$totalRounds  = strlen(decbin($playersCount - 1));

			if($getMatchDetails[0]->seed == 1) {
				$winnerRound = $totalRounds + 1;
				$totalRounds = $totalRounds - 1; 
			}

			$round 	   = $getMatchDetails[0]->round;
			$newRound  = $round + 1;
			
			// Calculate the next group
		    $nextGroup = ceil($getMatchDetails[0]->groupID / 2);

		    // Determine if the winner is player 1 or player 2 in the next match
		    $position = ($getMatchDetails[0]->groupID % 2 == 1) ? 'player_1_ID' : 'player_2_ID'; 

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

	                echo "Free slot match created Slot" . $playerSlot . '<hr />';
	                echo "Group ID : " . $nextGroup . '<hr />';  
	                // $this->process_data->assignToFreeSlot($tournamentID, $winnerID, $getFreeSlotMatch[0]->id, $playerSlot);
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
	                    	$this->process_data->assignToFreeSlot($tournamentID, $winnerID, $getMatchData[0]->id);
	                    	echo 'Seed' . $getMatchDetails[0]->seed . '<hr />';
	                        echo "New Round for winner : " . $winnerID . ' - Round ' . $newRound . '<hr />'; 
	                        echo "Free slot match created Slot " . $position . '<hr />';
	                		echo "Group ID : " . $nextGroup . '<hr />';
	                    } else {
	                        //Creating match 
	                        $seed = 0;

	                        if($getMatchDetails[0]->seed == 1) {
	                            $seed = 1;
	                        }
	                        
	                        echo 'Seed' . $getMatchDetails[0]->seed . '<hr />';
	                        echo "New Round for winner : " . $winnerID . ' - Round ' . $newRound . '<hr />'; 
	                        echo "New match created Slot " . $position . '<hr />';
	                		echo "Group ID : " . $nextGroup . '<hr />';
	                        // $this->process_data->processMatch($tournamentID, $winnerID, $newRound, $getMatchDetails[0]->groupID, $seed);
	                    }
	                }				
	            }
	        } else {
	        	/*if($tournamentData[0]->type == 4) {
		        	//If current Round is final round of winner vs looser
		        	if($round == ($totalRounds + 1)) {
		        		$this->process_data->createAdditionalFinalRound(
		        			$tournamentID, 
		        			$getMatchDetails[0]->player_1_ID, 
		        			$getMatchDetails[0]->player_2_ID, 
		        			$newRound, 
		        			$getMatchDetails[0]->groupID
		        		);
		        	} else {
		        		if($getMatchDetails[0]->seed == 0) {
		        			//Creating match 
	                        $this->process_data->processMatch($tournamentID, $winnerID, $newRound, $getMatchDetails[0]->groupID);
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
			            		// $this->process_data->assignToFreeSlot($tournamentID, $winnerID, $getMatchDataLog[0]->id);
				            } else {
				            	//Creating match 
		                        // $this->process_data->processMatch($tournamentID, $winnerID, $newRound, $getMatchDetails[0]->groupID);
				            }
		        		}
		        	}
		        }*/
	        }

	        if($tournamentData[0]->type == 4 && $getMatchDetails[0]->seed == 0) {
	        	if($round == 1) {
		        	$matchRound = $round; 
		            //Get Looser ID
		            if($getMatchDetails[0]->winnerID == $getMatchDetails[0]->player_1_ID) {
		                $looserID   = $getMatchDetails[0]->player_2_ID;
		                $looserSlot = 'player_2_ID';
		            } else {
		                $looserID 	= $getMatchDetails[0]->player_1_ID;
		                $looserSlot = 'player_1_ID';
		            }

		            //Check if looser bracket have any match created
		            $looserMatchData = $this->process_data->get_data('tournament_matches', array('tournamentID' => $tournamentID, 'seed' => 1));

		            if(count($looserMatchData) > 0) {
	            		$freeSlotMatchQuery  = "SELECT * FROM tournament_matches WHERE tournamentID = '" . $tournamentID . "'";
						$freeSlotMatchQuery .= " AND (player_1_ID = 0 OR player_2_ID = 0)";
						$freeSlotMatchQuery .= " AND groupID = '" . $nextGroup . "'";
						$freeSlotMatchQuery .= " AND seed = 1";
						
						$checkMatch = $this->db->query($freeSlotMatchQuery)->result();

		                if(count($checkMatch) > 0) {
		                    $matchID = $checkMatch[0]->id;
		                    echo "New Round for looser : " . $looserID . ' - Round ' . $matchRound . '<hr />'; 
			            	echo 'Seed ' . 1 . '<hr />';
	                        echo "New match created Slot " . $position . '<hr />';
	                		echo "Group ID : " . $nextGroup . '<hr />';
		                    // $this->process_data->assignToFreeSlot($tournamentID, $looserID, $matchID);
		                } else {
		                    //Get last group 
		                    $query      = "SELECT * FROM tournament_matches WHERE tournamentID = '".$tournamentID."' AND seed = '1' ORDER BY id DESC LIMIT 1";
		                    $dataMatch  = $this->db->query($query)->result();
		                    
		                    //Check the number of groups created per match
		                    $groupID = $dataMatch[0]->groupID + 1;

		                    echo "New Round for looser : " . $position . ' - Round ' . $matchRound . '<hr />'; 
			            	echo 'Seed ' . 1 . '<hr />';
	                        echo "New match created Slot " . $looserSlot . '<hr />';
	                		echo "Group ID : " . $groupID . '<hr />';

		                    //Creating match    
	                        // $this->process_data->processMatch($tournamentID, $looserID, $matchRound, $groupID, 1);
		                }
		            } else {
		            	echo "New Round for looser : " . $position . ' - Round ' . $matchRound . '<hr />'; 
		            	echo 'Seed ' . 1 . '<hr />';
                        echo "New match created Slot " . $looserSlot . '<hr />';
                		echo "Group ID : " . $nextGroup . '<hr />';
		                // $this->process_data->processMatch($tournamentID, $looserID, $matchRound, 1, 1);
		            }
		        }
	        }
	    }


	}
}