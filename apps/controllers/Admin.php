<?php

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */
