<?php
    class Notfound404 extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->helper('url');
        }

        public function index() {
            $this->output->set_status_header('404'); 
   
            $data['title'] = 'DsoEsports -  404 Not Found';
            $data['class'] = 'inner';
            $data['page_active'] = '';

            $this->load->view('includes/header-new.php', $data);
            $this->load->view('404-not-found', $data);
            $this->load->view('includes/footer-new.php');
        }
   }
