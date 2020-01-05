<?php
class Amoregetbeachy extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}
    public function index()
    {
        redirect('https://guestli.st/639219');
    }
}
