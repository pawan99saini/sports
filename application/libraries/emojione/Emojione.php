<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // include the 3rd party class
    require_once APPPATH . "/third_party/emojione/LoadEmojione.php";

    // Extend the class so you inherit all functions, etc.
    class Emojione extends LoadEmojione {
        public function __construct() {
            parent::__construct();
        }
        // library functions
        public function shortnameToImage($shortname) {
			$image = $this->LoadImageEmoji($shortname);

			return $image;
       	}
	}