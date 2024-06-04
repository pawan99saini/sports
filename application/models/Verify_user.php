<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_user extends CI_Model {
	public function login_user($data = array(), $role = 1) {
		//Getting User details
		$checkUser = $this->db->get_where('users', $data);

		if($checkUser->num_rows() > 0) {
			$userID = $checkUser->row()->id;
			$data_login  = array(
				'userID' => $checkUser->row()->id,
				'login_time' => date('Y-m-d H:i:s')
			);

			$this->db->insert('user_log', $data_login);
			$user_log_id = $this->db->insert_id();

			$dataSession = array(
				'is_logged_in' => true,
				'user_id'	   => $checkUser->row()->id,
				'name'		   => $checkUser->row()->first_name . ' ' . $checkUser->row()->last_name,
				'username' 	   => $checkUser->row()->username,
				'user_role'	   => $checkUser->row()->role,
				'user_log_id'  => $user_log_id
			);

			//Update user status
			$this->db->where('id', $checkUser->row()->id)->update('users', array('log_status' => 'Online'));

			$this->session->set_userdata($dataSession);
			return $checkUser->row()->role;
		} else {
			return false;
		}
	}

	public function process_time_in() {
		/* Creating Attendance Log
		 *
		 * Getting employee information*/

		$userID  = $this->session->userdata('user_id');
		
		//Creating Time Log
		$time_in 		   = date('H:i:s');
		$current_time 	   = date('Y-m-d H:i:s A');
		
		$dataTimeIn = array(
			'date' 	 	 => date('Y-m-d'),
			'time_in' 	 => $time_in,
			'userID' 	 => $userID,
			'late_count' => 0,
			'month'		 => date('m'),
			'year'		 => date('Y')
		);

		$this->db->insert('attendance', $dataTimeIn);

		return true;
	}

	public function process_time_out() {
		/* Creating Attendance Log
		 *
		 * Getting employee information*/
		$userID   = $this->session->userdata('user_id');
		$userRole = $this->session->userdata('user_role'); 

		$checkTimein = $this->db->get_where('attendance', array('userID' => $userID, 'time_out' => '00:00:00'));

		$time_in 		   = strtotime($checkTimein->row()->time_in);
		$current_time_out  = strtotime(date('H:i:s'));
		$time_out 		   = date('H:i:s');

		//Caculate shift hours
		$shift_hours = $current_time_out - $time_in;
		$shift_hours = date('H.i', $shift_hours);

		$dataTimeOut = array(
			'time_out' => $time_out,
			'total_log_time' => $shift_hours
		);

		/*
		 * Report Check for particular user to check if user have submitted report if not cannot time out
		 */
		$validate = true;

		if($userRole == 9) {
			$dateToday   = date('Y-m-d');
			$checkReport = $this->db->get_where("daily_report", array('userID' => $userID, 'date_posted' => $dateToday))->result();

			if(count($checkReport) > 0) {
				$validate = true;
			} else {
				$validate = false;
			}
		}

		if($validate == true) {
			/*
			 * Log time salary calculation
			 */

			$walletData = $this->db->get_where('wallet', array('userID' => $userID))->result();

			$billing_cycle  = $this->process_data->get_user_meta('salary_cycle', $userID);
	       	$salary 	    = $this->process_data->get_user_meta('salary', $userID);
	       	$balance	    = (count($walletData) > 0) ? $walletData[0]->balance : 0;
			
			$total_earnings = 0;
			if($salary != '') {
	       		$total_earnings = $salary * $shift_hours;
			}

	       	$newBalance		= $balance + $total_earnings;

	       	$addWalletData = array('balance' => $newBalance, 'last_updated' => date('Y-m-d H:i:s'));

			if(count($walletData) > 0) {
				$this->db->where('userID', $userID)->update('wallet', $addWalletData);
			} else {
				$addWalletData['userID'] = $userID;
				$addWalletData['clearance'] = 0;
				$addWalletData['paid'] = 0;
				$this->db->insert('wallet', $addWalletData);
			}

			$this->db->where(array('userID' => $userID, 'time_out' => '00:00:00'))->update('attendance', $dataTimeOut);
			return true;	
		} else {
			return false;
		}
	}

	public function processLogout($userID) {
		//Track Session Logout Time
		$user_log_id = $this->session->userdata('user_log_id');

		$data_logout  = array(
			'logout_time' => date('Y-m-d H:i:s')
		);

		$this->db->where('id', $user_log_id)->update('user_log', $data_logout);

		$this->db->where('id', $user_log_id)->update('users', array(
			'log_status' => 'Offline'
		));

		$this->session->sess_destroy();
	}
}