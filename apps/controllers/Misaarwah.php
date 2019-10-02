<?php

class Misaarwah extends CI_Controller
{
    function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->helper('url');

	}

    public function index()
    {
        redirect('https://docs.google.com/forms/d/e/1FAIpQLSd23_ti7lXZVKJ3--1Sk45P7YHKi7kvTVXpaXlMYDevvncxLw/viewform');
    }
}
