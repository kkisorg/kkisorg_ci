<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| User centralizd functions
|--------------------------------------------------------------------------
| @Desc    : 
| @Date    : 2011-05-24 
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|
|
| @Modified By  :  
| @Modified Date: 
*/
class Etc
{
	var $CI;

	/**
	| @name
	|      - __construct
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - default
	|
	**/
	function __construct()
	{
	
		//init all
		$this->CI = &get_instance();
		//$this->CI->load->library('Acl');
		$this->set_language();
		//load
		$this->CI->load->helper('misc');

		
		//try to load ;-)
		$this->CI->load->model('User_model',           'user_model');
		$this->CI->load->model('User_resource_model',  'user_resource_model');

	}


	 
	/**
	| @name
	|      - is_allowed
	|
	| @params
	|      - resource
	|
	| @return
	|      - true/false
	|
	| @description
	|      - permission chking
	|
	**/
	function is_allowed($resource_name)
	{
		log_message('DEBUG',"is_allowed() : etc-info [ $resource_name ]");
		//fmt
		$resource_name = trim($resource_name);
		
		//bypass all su-root
		if ( $this->is_admin() ) return TRUE;

		
		//Get resource based on its name
		$rdata = $this->CI->user_resource_model->select_by_name(array('name'=>$resource_name));

		//Resource is not exists
		if(! $rdata['status'] )
		{
			if (! $rdata['total'])
			{
				//set p-data
				$pdata               = null;
				$pdata['name']       = $resource_name;
				$pdata['desc']       = "Auto-Add-$resource_name";
				$pdata['created_by'] = $this->get_id();
				//exec
				$pret                = $this->CI->user_resource_model->add($pdata);

			}
			return FALSE;
		}
		
		//Resource exists so get the resource id
		$resource    = $rdata['data'];
		$resource_id = $resource->id;
		$mdata       = $this->CI->user_model->select_by_id(array('id' => $this->get_id()));
		$role_id     = $mdata['data']->role;
		if(! $mdata['status'] or $role_id <= 0)
		{  
			return FALSE;
		}
		//return $this->CI->acl->is_allowed($role_id, $resource_id);
		return true;
	}

	
	/**
	| @name
	|      - is_logged_in
	|
	| @params
	|      - 
	|
	| @return
	|      - true/false
	|
	| @description
	|      - TRUE if the current user is logged in, FALSE otherwise
	|
	**/
	function is_logged_in()
	{
		//give it back ;-)
		return $this->CI->session->userdata('sess_user_logged') == 1;
	}

	

	/**
	| @name
	|      - login
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - log user to the system. If username and password are corect then
	|        the user data will be set in the session.
	|
	**/
	function login($usr='', $pass='', $me=0)
	{
		//get info
		$udata = $this->CI->user_model->select_by_mail( array( 'mail' => $usr ) );
		
		$dmp   = @var_export($udata, true);
		$pass2 = md5($pass);
		log_message('DEBUG',"login() : info [ $usr : $pass2 : $dmp ]");
		
		//validate details ;-)
		if ($udata['status'] > 0 and $udata['data']->pass === $pass2 and strlen($pass) )
		{
			//chk remember me
			if($me > 0)
				u_remember_me_set(u_remember_me_encrypt($udata['data']->id));
			else
				$this->dont_remember_me();
			
			//set data
			$user_sess_data = array('sess_user_email'	=> $udata['data']->email,
						'sess_user_id'		=> $udata['data']->id,
						'sess_user_name'	=> $udata['data']->name,
						'sess_role_id'	        => $udata['data']->role,
						'sess_parent_id'	=> $udata['data']->parent,
						'sess_district_id'	        => $udata['data']->district_id,
						'sess_user_logged'	=> 1,
						'sess_user_mhash'	=> u_encrypt_hash($udata['data']->id),
						);
			$this->CI->session->set_userdata($user_sess_data);

			//update ts
			$this->CI->user_model->set_login_ts( array( 'id' => $udata['data']->id ) );
			
			//give it back ;-)
			return array('status'=>TRUE,'pdata' => $udata );
		}
		//wrong-pass
		if ($udata['status'] > 0 )
			$this->CI->user_model->set_wrong_pass( 
					array(	'id'         => $udata['data']->id,
						'updated_by' => $usr) );

                return array('status'=>false,'pdata' => $udata);  
	}

	/**
	| @name
	|      - logout
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - system logout
	|
	**/
	function logout()
	{

		//dmp
		$dmp = @var_export($this->CI->session->userdata(), true);
		log_message('DEBUG', "logout() : info [ $dmp ]");

		//try to set login-ts
		$this->CI->user_model->reset_login_ts( array( 'id' => $this->get_id() ) );
		//fmt
		$user_sess_data = array(
			'sess_user_email'	    => null,
			'sess_user_id'		    => null,
			'sess_user_name'	    => null,
			'sess_role_id '	            => null,
			'sess_parent_id'	    => null,
			'sess_user_mhash'	    => null,
			'sess_user_logged'	    => 0,
			);
		//reset
		$this->CI->session->unset_userdata($user_sess_data);
		$this->CI->session->unset_userdata('sess_url_denied');
		$this->CI->session->sess_destroy();
		//cookie ;0
		$this->dont_remember_me();
	}

	/**
	| @name
	|      - set_error_message
	|
	| @params
	|      - msg
	|
	| @return
	|      - 
	|
	| @description
	|      - status msg setter
	|
	**/
	function set_error_message($msg)
	{
		//fmt
		$msg = trim($msg);
		
		//log-event ;-)
		$this->CI->event_log->dump($msg);


		//$msg = $this->CI->session->flashdata('error_msg').$msg;
		$this->CI->session->set_flashdata('error_msg', $msg);
	}
    

	/**
	| @name
	|      - set_success_message
	|
	| @params
	|      - msg
	|
	| @return
	|      - 
	|
	| @description
	|      - status msg setter
	|
	**/
	function set_success_message($msg)
	{
		//fmt
		$msg = trim($msg);
		
		//log-event ;-)
		$this->CI->event_log->dump($msg);

		//$msg = $this->CI->session->flashdata('success_msg') . $msg;
		$this->CI->session->set_flashdata('success_msg', $msg);
	}

	/**
	| @name
	|      - set_language
	|
	| @params
	|      - lang
	|
	| @return
	|      - 
	|
	| @description
	|      - set lang
	|
	**/
	function set_language($language='')
	{
		//fmt
		$lang = trim($language);
		if($lang == "") $lang = DEFAULT_LANGUAGE;
		
		//set it
		$this->CI->session->set_userdata('sess_language', $lang);
	}

	/**
	| @name
	|      - get_language
	|
	| @params
	|      - lang
	|
	| @return
	|      - STRING based on the language key and user's language
	|
	| @description
	|      - display text based on user's language
	|
	**/
	function get_language()
	{
		$lang = $this->CI->session->userdata('sess_language');
		if(strlen(trim($lang)) > 0)
		{
			return $lang;
		}
		return DEFAULT_LANGUAGE;
	}
	/**
	| @name
	|      - text
	|
	| @params
	|      - lang
	|
	| @return
	|      - STRING based on the language key and user's language
	|
	| @description
	|      - display text based on user's language
	|
	**/
	function text($language_key)
	{
		//give it back
		return $this->CI->lang->line($language_key);
	}

	/**
	| @name
	|      - get_email
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - get current email
	|
	**/
	function get_email()
	{
		//give it back
		return $this->CI->session->userdata('sess_user_email');
	}


	/**
	| @name
	|      - get_created_by
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - get id in string
	|
	**/
	function get_created_by()
	{
		//give it back
		return $this->get_id();
	}
	
	/**
	| @name
	|      - get_mhash
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - get id in string
	|
	**/
	function get_mhash()
	{
		//give it back
		return $this->CI->session->userdata('sess_user_mhash');
	}

	/**
	| @name
	|      - get_updated_by
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - get id in string
	|
	**/
	function get_updated_by()
	{
		//give it back
		return $this->get_id();
	}

	/**
	| @name
	|      - get_id
	|
	| @params
	|      - 
	|
	| @return
	|      - id
	|
	| @description
	|      - get current user's id
	|
	**/
	function get_id()
	{
		//give it back
		return  @intval($this->CI->session->userdata('sess_user_id'));
	}
	


	/**
	| @name
	|      - get_role_id
	|
	| @params
	|      - 
	|
	| @return
	|      - role-id
	|
	| @description
	|      - get current user's role id
	|
	**/
	function get_role_id()
	{
		//give it back
		return $this->CI->session->userdata('sess_role_id');
	}


	/**
	| @name
	|      - check_permission
	|
	| @params
	|      - 
	|
	| @return
	|      - true/false
	|
	| @description
	|      - check the permisssion for a resource against the current user.
	|        The user will be redirected to access denied page if he/she
	|        doesn't have permission.
	|
	**/
	function check_permission($resource_name)
	{
		if ($this->is_allowed($resource_name))
		{
		  
			return TRUE;
		}
		
		//access-denied
		$this->CI->session->set_userdata('sess_url_denied', uri_string());
		redirect(DEFAULT_DENIED_PAGE);
		return FALSE;
	}

	/**
	| @name
	|      - load_lang
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - lang file loader
	|
	**/
	function load_lang($lang_file='')
	{
		$this->CI->lang->load($lang_file, $this->get_language());
	}

	/**
	| @name
	|      - is_admin
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - chk if admin user
	|
	**/
	function is_admin()
	{
		//give it back
		return ($this->get_role_id() == DEFAULT_ROLE_ROOT_ID || $this->get_id() == DEFAULT_ADMIN_ID);
	}
	

	/**
	| @name
	|      - get_name
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - 
	|
	**/
	function get_name()
	{
		//give it back ;-)
		return $this->CI->session->userdata('sess_user_name');
	}
	
	
	/**
	| @name
	|      - dont_remember_me
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - 
	|
	**/
	function dont_remember_me()
	{
		u_remember_me_unset();//delete cookie ;=)
	}
	
	/**
	| @name
	|      - pls_remember_me
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @description
	|      - 
	|
	**/
	function pls_remember_me()
	{
		//get the value ;-)
		$cook = u_remember_me_get();

		if(strlen($cook))
		{
		        //decrypt it ;-)
		        $email = u_remember_me_decrypt($cook);
		       
		        //get info
			$udata = $this->CI->user_model->select_by_mail( array( 'mail' => $email ) );

			$dmp   = @var_export($udata, true);

			log_message('DEBUG',"pls_remember_me() : info [ $dmp ]");

			//validate details ;-)
			if ( $udata['status'] > 0 )
			{
				//set data
				$user_sess_data = array('sess_user_email'	=> $udata['data']->email,
							'sess_user_id'		=> $udata['data']->id,
							'sess_user_name'	=> $udata['data']->name,
							'sess_role_id'	        => $udata['data']->role,
							'sess_parent_id'	=> $udata['data']->parent,
							'sess_user_logged'	=> 1,
							'sess_user_mhash'	=> u_encrypt_hash($udata['data']->id),
							);
				$this->CI->session->set_userdata($user_sess_data);
			}

		}
	}

	/**
	| @name
	|      - get_menu
	|
	| @params
	|      - 
	|
	| @return
	|      - id
	|
	| @description
	|      - get menu id based on the role
	|
	**/
	function get_menu()
	{
		//give it back
		$this->CI->load->model('Menu_model', 'menu_model');
		$this->CI->load->model('Sub_menu_model', 'sub_menu_model');
	
	  $menu_list = $this->CI->menu_model->get_menu();
	  
		//print_r($menu_list['data']);
	}
	
	
	
	function get_sys_settings()
	{
    $this->CI->load->model('System_settings_model', 'system_settings_model');
  
    //get info
		$vdata = $this->CI->system_settings_model->select_sys_settings();
		
		return $vdata;
		
  }


	
}
?>