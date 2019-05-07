<?php
/*
|--------------------------------------------------------------------------
| @Filename: system_settings.php
|--------------------------------------------------------------------------
| @Desc    : system settings controller
| @Date    : 2011-05-11
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class System_settings extends CI_Controller 
{

	function System_settings()
	{
		parent::__construct();	
		
		//loaders here ;-)
		$this->load->database();
		
		//misc
		$this->load->helper('misc');
		
		$this->load->model('System_settings_model','system_settings');
		
	}
	
	
	/**
	| @name
	|      - index
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - default controller
	|
	**/
	function index()
	{
    //perms
		$this->etc->check_permission('SYSTEM_SETTINGS');
		
		//get rec
		$gdata = $this->system_settings->select_sys_settings();

		
		//set data
		$vdata['jData_Total']        = 0;
		$vdata['jData']              = $gdata['data'];
		$vdata['jData_Hidden']       = array();


		//view
		$this->load->view('sys.settings.frm.php',$vdata);
		
	}
	
	
	
	
	/**
	| @name
	|      - proc
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - show the edit form
	|
	**/
	function proc()
	{
		//perms
		$this->etc->check_permission('SYSTEM_SETTINGS');

		//set p-data
		$pdata               = null;
		$pdata['mail']        = trim($this->input->get_post('mail' ));
		$pdata['ym']   = trim($this->input->get_post('ym' ));
		$pdata['twitter']   = trim($this->input->get_post('twitter' ));
		$pdata['fb']      = trim($this->input->get_post('fb' ));

		//set rules
		$this->form_validation->set_rules('mail',  'Mail URL',     'trim|required');
		$this->form_validation->set_rules('ym',  'Yahoo Messenger',     'trim|required');
		$this->form_validation->set_rules('twitter',  'Twitter',     'trim|required');
		$this->form_validation->set_rules('fb',  'Facebook',     'trim|required');
		
		
		//chk rules
		if ($this->form_validation->run() == TRUE)
		{
		
  		//upd8 it;-)
  		$ddata = $this->system_settings->save($pdata);
	
  		if($ddata['status'])
  		{
  			//set status
  			$this->etc->set_success_message($this->config->item('USER_SYS_SETTINGS_OK_MSG'));
  		
  		}
  		else
  		{
  			//set status
  			$this->etc->set_error_message($this->config->item('USER_USYS_SETTINGS_ERR_MSG'));
  		}
  
  		//fwd
  		redirect(site_url('system_settings'));
  		return;
  		
  		
		}
		else
		{
      //view
		  $this->load->view('sys.settings.frm.php',$vdata);
    }
		
		
	}
	

  
  
  

 }
/* End of file system_settings.php */
/* Location: ./system/application/controllers/system_settings.php */