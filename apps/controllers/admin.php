<?php

class Admin extends Controller {

	function Admin()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */