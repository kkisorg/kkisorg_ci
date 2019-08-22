<?php
/*
|--------------------------------------------------------------------------
| @Filename: user.php
|--------------------------------------------------------------------------
| @Desc    : user controller
| @Date    : 2011-05-02
| @Version : 1.0
| @By      : gabriela.kartika@gmail.com
|
|
|
| @Modified By  :
| @Modified Date:
*/

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();

		//misc
		$this->load->helper('misc');
		$this->load->library('etc');

		//more
		$this->load->model('User_model',     'user_model');
		$this->load->model('User_role_model','user_role_model');
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
		//view
		$this->view();
	}

	/**
	| @name
	|      - view
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller ( view list )
	|
	**/
	function view()
	{
		//perms
		$this->etc->check_permission('USER.LIST');

		$this->ajx_view(false);
	}

	/**
	| @name
	|      - afrm
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the add form for new
	|
	**/
	function afrm()
	{
		//perms
		$this->etc->check_permission('USER.ADD');


		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];

		//set data
		$vdata['jData_pexpiry_list'] = $this->config->item('COMBO_LIST_PASSWORD_EXPIRY');
		$vdata['jData_active_list']  = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
		$vdata['jData_role_list']    = $rlist;

		//view
		$this->load->view('user.add.frm.php',$vdata);

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
	|      - show the add form for new
	|
	**/
	function login()
	{
		$vdata = null;
		//remember me ;-)
		if(!$this->etc->is_logged_in())
		{
		    $this->etc->pls_remember_me();
		    if($this->etc->is_logged_in())
		    {
		    	redirect(site_url('admin'));
		    	return;
		    }
		}
		//view
		$this->load->view('login.frm.php');

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
	|      - show the add form for new
	|
	**/
	function logout()
	{
		//re-set
		$this->etc->logout();

		//view
		$this->load->view('welcome_message.php');

	}




	/**
	| @name
	|      - denied
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the access-denied
	|
	**/
	function denied()
	{
		//re-set
		//view
		$this->load->view('access.denied.php');

	}

	/**
	| @name
	|      - afrm_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - process new user profile
	|
	**/
	function afrm_proc()
	{

		//perms
		$this->etc->check_permission('USER.ADD');

		//get chk post
		$id   = trim($this->input->get_post('id'   ));
		$hash = trim($this->input->get_post('hash' ));

		//params
		log_message("DEBUG","afrm_proc() : info-params [ $hash : $id ]");


		//cancel?
		if(!$this->input->get_post('Save'))
		{
			//set status
			log_message("DEBUG","afrm_proc() : info [ NOT CLICKED ]");

			//fwd
			redirect(site_url(DEFAULT_USER_ADD));
			return;

		}

		//set rules
		$this->set_rules_for_add();

		//chk rules
		if ($this->form_validation->run() == FALSE)
		{

		  //role-list
  		$rdata = $this->user_role_model->get();
  		$rlist = $rdata['data'];

  		//set data
  		$vdata['jData_pexpiry_list'] = $this->config->item('COMBO_LIST_PASSWORD_EXPIRY');
  		$vdata['jData_active_list']  = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
  		$vdata['jData_role_list']    = $rlist;
			log_message("DEBUG","afrm_proc() : info [ VALIDATION FAILED ]");

			//fwd
			//redirect(site_url(DEFAULT_USER_ADD));

			//return;

      //view
		  $this->load->view('user.add.frm.php',$vdata);
		}
		else
		{

		//set p-data
		$pdata               = null;
		$pdata['email']      = trim($this->input->get_post('email' ));;
		$pdata['country']    = trim($this->input->get_post('country' ));;
		$pdata['mobile']     = trim($this->input->get_post('mobile' ));;
		$pdata['pass']       = md5(trim($this->input->get_post('pass1' )));
		$pdata['name']       = trim($this->input->get_post('name' ));;
		$pdata['created_by'] = $this->etc->get_created_by();
		$pdata['role']       = trim($this->input->get_post('role' ));;
		$pdata['district']       = trim($this->input->get_post('district' ));
		$pdata['status']     = trim($this->input->get_post('status' ));;
		//expiry
		$xpire                      = @intval(trim($this->input->get_post('pass_expiry_days' )));
		$pdata['pass_expiry_days']  = ($xpire <= 0)  ? ($this->config->item('DEFAULT_PASSWORD_EXPIRY_DATE')) : ($xpire);


		//exec
		$pret                = $this->user_model->add($pdata);
		if(!$pret['status'])
		{

			//set status
			$this->etc->set_error_message($this->config->item('USER_ADD_UNKNOWN_ERR_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_ADD));
			return;
		}

		//okay
		$this->etc->set_success_message($this->config->item('USER_ADD_OK_MSG'));


		//fwd
		redirect(site_url(DEFAULT_USER_VIEW));
		return;
		}

	}

	/**
	| @name
	|      - efrm
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the edit form confirmation msg
	|
	**/
	function efrm($hash=null,$id=0)
	{

		//perms
		$this->etc->check_permission('USER.EDIT');

		//params
		log_message("DEBUG","efrm() : info-params [ $hash : $id ]");

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];

		//set data
		$vdata['jData_pexpiry_list'] = $this->config->item('COMBO_LIST_PASSWORD_EXPIRY');
		$vdata['jData_active_list']  = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
		$vdata['jData_role_list']    = $rlist;
		$vdata['jData_Total']        = 0;
		$vdata['jData']              = $gdata['data'];
		$vdata['jData_Hidden']       = array('id'=> $id, 'hash' => $hash, 'email' => $gdata['data']->email);

		//view
		$this->load->view('user.edit.frm.php',$vdata);

	}


	/**
	| @name
	|      - efrm_proc
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
	function efrm_proc()
	{
		//perms
		$this->etc->check_permission('USER.EDIT');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));

		//params
		log_message("DEBUG","efrm_proc() : info-params [ $hash : $id ]");



		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);


		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];

		//set data
		$vdata['jData_active_list'] = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
		$vdata['jData_role_list']   = $rlist;
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'email' => $gdata['data']->email);


		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","efrm_proc() : info [ DECRYPT FAILED ]");

			//view
			$this->load->view('user.edit.frm.php',$vdata);
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");

			//view
			$this->load->view('user.edit.frm.php',$vdata);
			return;
		}


		//set p-data
		$pdata               = null;
		$pdata['email']      = $gdata['data']->email;
		$pdata['mobile']     = trim($this->input->get_post('mobile' ));
		$pdata['name']       = trim($this->input->get_post('name' ));
		$pdata['role']       = trim($this->input->get_post('role' ));
		$pdata['status']     = trim($this->input->get_post('status' ));
		$pdata['district']       = trim($this->input->get_post('district' ));
		$pdata['updated_by'] = $this->etc->get_created_by();
		$pdata['id']         = $id;

		//expiry
		$xpire                      = @intval(trim($this->input->get_post('pass_expiry_days' )));
		$pdata['pass_expiry_days']  = ($xpire <= 0)  ? ($this->config->item('DEFAULT_PASSWORD_EXPIRY_DATE')) : ($xpire);

		//upd8 it;-)
		$ddata = $this->user_model->update($pdata);

		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message($this->config->item('USER_UPD_OK_MSG'));

		}
		else
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_ERR_MSG'));
		}

		//fwd
		redirect(site_url(DEFAULT_USER_VIEW));
		return;


	}
	/**
	| @name
	|      - dfrm
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the delete form confirmation msg
	|
	**/
	function dfrm($hash=null,$id=0)
	{
		//perms
		$this->etc->check_permission('USER.DELETE');

		//params
		log_message("DEBUG","dfrm() : info-params [ $hash : $id ]");

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}




		//fmt view data
		$vdata['jData_Total']    = 0;
		$vdata['jData']          = $gdata['data'];
		$vdata['jData_Hidden']   = array('id'=> $id, 'hash' => $hash);


		//view
		$this->load->view('user.delete.frm.php',$vdata);

	}


	/**
	| @name
	|      - dfrm_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the delete form confirmation msg
	|
	**/
	function dfrm_proc()
	{

		//perms
		$this->etc->check_permission('USER.DELETE');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));

		//params
		log_message("DEBUG","dfrm_proc() : info-params [ $hash : $id ]");


		//cancel?
		if($this->input->get_post('submitCancel'))
		{
			//set status
			log_message("DEBUG","dfrm_proc() : info [ CANCELLED ]");

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;

		}

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ DECRYPT FAILED ]");

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//admin cant be deleted
		if($this->config->item('DEFAULT_ADMIN_ID') == $id )
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ SUPER-ROOT DELETE not ALLOWED ]");

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}


		//delete it;-)
		$ddata = $this->user_model->set_status(array(
								'id'         => $id,
								'status'     => $this->config->item('DEFAULT_INACTIVE_USER_STATUS'),
								'updated_by' => $this->etc->get_created_by(),
							    )
						       );
		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message($this->config->item('USER_DEL_OK_MSG'));

		}
		else
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_DEL_UNKNOWN_REC_MSG'));
		}

		//fwd
		redirect(site_url(DEFAULT_USER_VIEW));
		return;


	}
	/**
	| @name
	|      - view
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller ( view list )
	|
	**/
	function ajx_view($v=true)
	{
		//perms
		$this->etc->check_permission('USER.LIST');

		//sorting
		$sortdata   = array(
				"name"   ,
				"email"  ,
				"role"   ,
				"status" ,
				"created",
				"pass_expiry");

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");

		//get list
		$gdata = $this->user_model->get(array(
						'order' => $fdata['order'],
						'limit' => $fdata['limit'],
		                             ));
		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];
		$rdata['total'] = $rdata['total']==''?0:$rdata['total'];

		$json_str = $this->fmt_jason_data(
						$gdata['data'],
						$fdata['page'],
						$gdata['total'],
						$rlist,
						$fdata['draw']
						);

		//fmt view data
		$vdata['jData_Total']    = @intval($gdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Ajax']     = true;

		//view
		if(!$v)
		   $this->load->view('user.view.php',$vdata);
		else
		   echo $json_str;

	}

	/**
	| @name
	|      - fmt_jason_data
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - jason-data formatter
	|
	**/
	function fmt_jason_data($jdata=null, $page=1, $total=0,$role_list=null, $draw=1)
	{

		//alist
		$alist = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
		//init jason-data
		$jres = "{\"draw\": $draw,
			    \"recordsTotal\" : $total,
          \"recordsFiltered\": $total,
			    \"data\": [
			   ";
		//more
		foreach($jdata as $kk => $vv)
		{
			//role-list
			$role_bfr = $role_list[$vv->role] ? $role_list[$vv->role]->name : $role_list[$this->config->item('DEFAULT_ROLE_ID')]->name;
			$mhash    = u_encrypt_hash($vv->id);
			//edit
			$seq      = array('user',
					  'efrm',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$ehref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Edit</a>';
			$seq      = array('user',
					  'dfrm',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$dhref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Delete</a>';

			$seq      = array('user',
					  'rsetpass',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$rhref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Reset</a>';

			$seq      = array('user',
					  'ulockwpass',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );

			$uhref    = '<a class="btn btn-primary btn-xs" href="'. (($vv->wrong>0) ? site_url($seq) : '#').'">Unlock</a>';

			$hrefs    = $ehref."&nbsp;&nbsp;".$dhref."&nbsp;&nbsp;".$rhref."&nbsp;&nbsp;".$uhref;


			//delete
			$jres .= '     [ ' .
					'"'. addslashes( $vv->name  )  .'",'.
					'"'. addslashes( $vv->email )  .'",'.
					'"'. addslashes( $role_bfr  ) .'",'.
					'"'. addslashes( $vv->status <= 0 ? ($alist['0']) : ($alist['1']) ) .'",'.
					'"'. addslashes( $vv->created ) .'",'.
					'"'. addslashes( $vv->pass_expiry ) .'",'.
					'"'. addslashes( $hrefs           )   .'" '.
					"],\n";
		}//e-loop

		//trim
		$jres  = substr($jres, 0, strlen($jres)-2);
		$jres .= "\n]}\n";


		//tracing ;-)
		log_message("DEBUG","fmt_jason_data() : info [ $jres ] ");

		//give it back
		return $jres;
	}




	/**
	| @name
	|      - set_rules_for_modify
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set rules for modify  user
	|
	**/
	function set_rules_for_modify()
	{
		//passwd min+max
		$pass_min = MIN_PASSWD_LEN;
		$pass_max = MAX_PASSWD_LEN;
		$pass_len = "min_length[$pass_min]|max_length[$pass_max]";

		//set local rules for add
		$this->form_validation->set_rules('name',  'Name',     'trim|required');
		$this->form_validation->set_rules('email', 'Email',    'trim|valid_email|callback_check_uniq_mail');
	}


	/**
	| @name
	|      - check_match_pass
	|
	| @params
	|      -
	|
	| @return
	|      - 1 / 0
	|
	| @description
	|      - extra rules for checking pass + pass2
	|
	**/
	function check_match_pass()
	{
		if($this->input->get_post('pass1', TRUE) != $this->input->get_post('pass2', TRUE))
		{
			$this->form_validation->set_message(
					'check_match_pass',
					$this->config->item('USER_ADD_ERR_MSG_PASS_CONF_DONT_MATCH')
					);
			return false;
		}

		return true;

	}


	/**
	| @name
	|      - set_rules_for_add
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set rules for add user
	|
	**/
	function set_rules_for_add()
	{
		//passwd min+max
		$pass_min = MIN_PASSWD_LEN;
		$pass_max = MAX_PASSWD_LEN;
		$pass_len = "min_length[$pass_min]|max_length[$pass_max]";

		//set local rules for add
		$this->form_validation->set_rules('name',   'Name',     'trim|required');
		$this->form_validation->set_rules('email',  'Email',    'trim|valid_email|callback_check_uniq_mail');
		$this->form_validation->set_rules('pass1',  'Password', "trim|required|$pass_len");
		$this->form_validation->set_rules('pass2',  'Password Confirmation', 'trim|required|callback_check_match_pass');
	}





	/**
	| @name
	|      - check_uniq_mail
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      -  extra rules for checking mail
	|
	**/
	function check_uniq_mail()
	{
		//init params
		$pid     = intval($this->input->get_post('id', TRUE));
		$pdata   = array('mail' => $this->input->get_post('email', TRUE), 'id' => $pid );

		//chck from db
		$rdata   = $this->user_model->select_by_mail($pdata);

		//len
		$is_len  = strlen($this->input->get_post('email', TRUE))<=0 ? (false) : (true);

		//start chking
		if( !$is_len )
		{
			$this->form_validation->set_message(
					'check_uniq_mail',
					$this->config->item('USER_ADD_ERR_MSG_MAIL_REQUIRED')
					);
			return false;
		}
		else if($rdata['status'])
		{
			$this->form_validation->set_message(
						'check_uniq_mail',
						$this->config->item('USER_ADD_ERR_MSG_MAIL_ALREADY_USED')
						);
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	| @name
	|      - logfrm_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - process new user profile
	|
	**/
	function logfrm_proc()
	{

		//get chk post
		$email   = trim($this->input->post('email'   ));
		$pass    = trim($this->input->post('pass'    ));
		$me      = @intval(trim($this->input->post('me')));

		//params
		log_message("DEBUG","logfrm_proc() : info-params [ $email : $pass : $me ]");

		//cancel?
		if(!$this->input->get_post('Login'))
		{
			//set status
			log_message("DEBUG","afrm_proc() : info [ NOT CLICKED ]");

			//fwd
			redirect(site_url(DEFAULT_LOGGED_IN_PAGE));
			return;

		}

		//exec
		$pdata = $this->etc->login($email, $pass, $me);
		if(!$pdata['status'])
		{


			//set status
			$smsg = ($pdata['pdata']['data']->wrong >= MAX_WRONG_ATTEMPT) ? ($this->config->item('USER_LOGIN_ERROR_MAX')) : ($this->config->item('USER_LOGIN_ERROR'));
			$this->etc->set_error_message($smsg);

			log_message("DEBUG","afrm_proc() : INFO-LOGIN-ERR [ $smsg ]");

			//fwd
			redirect(site_url(DEFAULT_LOGGED_IN_PAGE));
			return;
		}

		//chk if its locked ???
		if($pdata['pdata']['data']->wrong >= MAX_WRONG_ATTEMPT)
		{
			//max reached
			$this->etc->set_error_message( $this->config->item('USER_LOGIN_ERROR_MAX') );

			log_message("DEBUG","afrm_proc() : INFO-LOGIN-ERR [ LOCKED ]");

			//fwd
			redirect(site_url(DEFAULT_LOGGED_IN_PAGE));
			return;
		}
		//pass expired
		if($pdata['pdata']['data']->expired > 0)
		{
			//max reached
			$this->etc->set_error_message( $this->config->item('USER_LOGIN_PASS_EXPIRED') );

			log_message("DEBUG","afrm_proc() : INFO-LOGIN-ERR [ PWD-EXPIRED ]");

			//fwd
			redirect(site_url(DEFAULT_LOGGED_IN_PAGE));
			return;
		}

		//in-active
		if($pdata['pdata']['data']->status <= 0)
		{
			//max reached
			$this->etc->set_error_message( $this->config->item('USER_LOGIN_IN_ACTIVE') );

			log_message("DEBUG","afrm_proc() : INFO-LOGIN-ERR [ IN-ACTIVE ]");

			//fwd
			redirect(site_url(DEFAULT_LOGGED_IN_PAGE));
			return;
		}


		//fwd
		//redirect(site_url('admin'));
		$this->load->view('welcome_message');
		return;
	}



	/**
	| @name
	|      - chpass
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the change pwd form
	|
	**/
	function chpass()
	{

		//perms
		$this->etc->check_permission('USER.CHANGE.PASS');

		//get uid
		$uid  = $this->etc->get_id();
		$email= $this->etc->get_email();
		$hash = u_encrypt_hash($uid);

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $uid) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('CHANGE_PWD_ERR_NO_DATA'));

			//fwd
			redirect(site_url('admin'));
			return;
		}

		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array(    'id'    => $uid,
							'hash'  => $hash,
							'email' => $email);


		//view
		$this->load->view('user.chpass.frm.php',$vdata);

	}

	/**
	| @name
	|      - chpass_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - process new user profile
	|
	**/
	function chpass_proc()
	{

		//perms
		$this->etc->check_permission('USER.CHANGE.PASS');

		//get chk post
		$id       = trim($this->input->get_post('id'       ));
		$hash     = trim($this->input->get_post('hash'     ));
		$oldpass  = trim($this->input->get_post('oldpass'  ));
		$newpass1 = trim($this->input->get_post('pass1'    ));
		$newpass2 = trim($this->input->get_post('pass2'    ));

		//params
		log_message("DEBUG","chpass_proc() : info-params [ $hash : $id : $oldpass : $newpass1 : $newpass2 ]");

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array(    'id'    => $uid,
							'hash'  => $hash,
							'email' => $email);


		//cancel?
		if(!$this->input->get_post('Update'))
		{
			//set status
			log_message("DEBUG","chpass_proc() : info [ NOT CLICKED ]");

			//view
			$this->load->view('user.chpass.frm.php',$vdata);
			return;

		}

		//set rules
		$this->set_rules_for_chpass();

		//chk rules
		if ($this->form_validation->run() == FALSE)
		{

			log_message("DEBUG","afrm_proc() : info [ VALIDATION FAILED ]");

			//view
			$this->load->view('user.chpass.frm.php',$vdata);
			return;
		}

		//invalid id
		if($gdata['status']!=1)
		{
			//set status
			$this->etc->set_error_message($this->config->item('CHANGE_PWD_ERR_NO_DATA'));

			//fwd
			redirect(site_url('admin'));
			return;
		}

		//chk old ;-)
		if( strcmp(md5($oldpass), $gdata['data']->pass ) )
		{

			//set status
			$this->etc->set_error_message($this->config->item('CHANGE_PWD_OLD_NOT_MATCH'));

			//view
			$this->load->view('user.chpass.frm.php',$vdata);
			return;
		}


		//fmt-params
		$pdata               = null;
		$pdata['id']         = $id;
		$pdata['pass']       = md5($newpass1);
		$pdata['updated_by'] = $this->etc->get_updated_by();


		//exec
		$pret                = $this->user_model->set_password($pdata);
		if(!$pret['status'])
		{

			//set status
			$this->etc->set_error_message($this->config->item('CHANGE_PWD_UNKNOWN_ERR_MSG'));

			//view
			redirect('/user/chpass');
			return;
		}

		//okay
		$this->etc->set_success_message($this->config->item('CHANGE_PWD_OK_MSG'));


		//fwd
		redirect(site_url('admin'));
		return;
	}


	/**
	| @name
	|      - set_rules_for_modify
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set rules for modify  user
	|
	**/
	function set_rules_for_chpass()
	{
		//passwd min+max
		$pass_min = MIN_PASSWD_LEN;
		$pass_max = MAX_PASSWD_LEN;
		$pass_len = "min_length[$pass_min]|max_length[$pass_max]";

		//set local rules for add
		$this->form_validation->set_rules('oldpass','Old Password',          'trim|required');
		$this->form_validation->set_rules('pass1',  'New Password',          "trim|required|$pass_len");
		$this->form_validation->set_rules('pass2',  'Password Confirmation', 'trim|required|callback_check_match_pass');
	}



	/**
	| @name
	|      - fgotpass
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the change pwd form
	|
	**/
	function fgotpass()
	{
		//view
		$this->load->view('user.fgotpass.frm.php');
	}



	/**
	| @name
	|      - fgotpass_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - process forgot pass
	|
	**/
	function fgotpass_proc()
	{

		//get chk post
		$email       = trim($this->input->get_post('email'));

		//params
		log_message("DEBUG","fgotpass_proc() : info-params [ $email ]");

		//cancel?
		if(!$this->input->get_post('Submit'))
		{
			//set status
			log_message("DEBUG","fgotpass_proc() : info [ NOT CLICKED ]");

			//view
			redirect('/user/fgotpass');
			return;

		}

		//get rec
		$gdata = $this->user_model->select_by_mail( array( 'mail' => $email) );

		//invalid id
		if(!$gdata['status'])
		{
			log_message("DEBUG","fgotpass_proc() : info [ NOT IN DB ]");

			//set status
			$this->etc->set_error_message( $this->config->item('FORGOT_PWD_ERR_NO_DATA') );

			//fwd
			redirect('/user/fgotpass');
			return;
		}

		//fmt
		$npass         = random_string('alnum', 10);
		$msg           = trim($this->config->item('FORGOT_PWD_CONF_EMAIL'));
		$msg           = @str_replace('<_NAME_>',$gdata['data']->name, $msg);

		//calc
		$hash          = u_generate_uuid('FP-');
		$kk            = 'FORGOT-PASS';
		$ref_id        = $this->user_model->bfr_usr($email, $hash, $kk, $npass);
		if(!$ref_id)
		{
			//set status
			$this->etc->set_error_message( $this->config->item('FORGOT_PWD_ERR_NO_DATA') );

			log_message("DEBUG","fgotpass_proc() : info [ FAILED Insert to USER_BUFFER ]");

			//fwd
			redirect('/user/fgotpass');
			return;
		}


		//url
		$raw_url       = $this->config->item('base_url').
				 $this->config->item('FORGOT_PWD_CONF_URL').
							'/'.
				 @rawurlencode($ref_id) .
							'/'.
				 base64url_encode($hash) ;

		$msg           = @str_replace('<_URL_>',$raw_url, $msg);


		//snd mail
		$pdata         = null;
		$pdata['to']   = $email;
		$pdata['from'] = $this->config->item('FORGOT_PWD_FROM_EMAIL');
		$pdata['sub']  = $this->config->item('FORGOT_PWD_SUBJ_EMAIL');
		$pdata['msg']  = $msg;

		//snd
		$ret           = u_send_mail($pdata);

		log_message("DEBUG","fgotpass_proc() : info#$ret [ $msg ]");


		//okay
		$this->etc->set_success_message( $this->config->item('FORGOT_PWD_CONF_EMAIL_SENT') );
		//fwd
		redirect('/user/fgotpass');
		return;
	}
	/**
	| @name
	|      - fgotpass_conf
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - confirm forgot pass
	|
	**/
 	function fgotpass_conf($id='',$hash='')
 	{

 		//chk id + hash
 		$dhash                = base64url_decode($hash);
 		$hdata                = $this->user_model->get_bfr_usr($id,$dhash);

 		//invalid id
		if(!$hdata['status'])
		{
			log_message("DEBUG","fgotpass_conf() : info [ NOT IN DB ]");

			//set status
			$this->etc->set_error_message( $this->config->item('FORGOT_PWD_ERR_NO_DATA') );

			//view
			redirect('/user/fgotpass');
			return;
		}

		//invalid id
		if($hdata['data']->status > 0)
		{
			log_message("DEBUG","fgotpass_conf() : info [ already confirmed ]");

			//set status
			$this->etc->set_error_message( $this->config->item('FORGOT_PWD_CONF_ALREADY') );

			//view
			redirect('/user/fgotpass');
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_mail( array( 'mail' => $hdata['data']->email) );

		//fmt-params
		$pdata               = null;
		$pdata['id']         = $gdata['data']->id;
		$pdata['pass']       = md5($hdata['data']->bfr);
		$pdata['updated_by'] = $this->etc->get_updated_by();

		log_message("DEBUG","fgotpass_conf() : info [ newpass='$npass' ]");

		//exec
		$pret                 = $this->user_model->set_password($pdata);
		if(!$pret['status'])
		{
			//set status
			$this->etc->set_success_message( $this->config->item('FORGOT_PWD_UNKNOWN_ERR_MSG'));

			log_message("DEBUG","fgotpass_proc() : info [ DB-UPD8 FAILED ]");

			//view
			redirect('/user/fgotpass');
			return;

		}

		//set status
		$this->user_model->set_bfr_usr($id);
		//status
		$smsg = str_replace('<_PASS_>', $hdata['data']->bfr,  $this->config->item('FORGOT_PWD_OK_MSG'));

		//okay
		$this->etc->set_success_message( $smsg );

		//fwd
		redirect('/user/fgotpass');
		return;

 	}
	/**
	| @name
	|      - rsetpass
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the edit form confirmation msg
	|
	**/
	function rsetpass($hash=null,$id=0)
	{

		//perms
		$this->etc->check_permission('USER.RESET.PASS');

		//params
		log_message("DEBUG","rsetpass() : info-params [ $hash : $id ]");

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//fmt-params
		$npass                = random_string('alnum', 10);
		$pdata2               = null;
		$pdata2['id']         = $gdata['data']->id;
		$pdata2['pass']       = md5($npass);
		$pdata2['updated_by'] = $this->etc->get_updated_by();

		log_message("DEBUG","rsetpass() : info [ newpass='$npass' ]");

		//exec
		$pret                 = $this->user_model->set_password($pdata2);
		if(!$pret['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;

		}


		//status
		$smsg = $this->config->item('RESET_PWD_OK_MSG');
		$smsg = str_replace('<_MAIL_>', $gdata['data']->email,  $smsg);
		$smsg = str_replace('<_PASS_>', $npass               ,  $smsg);
		$this->etc->set_success_message( $smsg );


		//fwd
		redirect(site_url(DEFAULT_USER_VIEW));
	}

	function tst()
	{
		log_message("DEBUG","tst() redir page base.");
		redirect($this->config->item('sbase_url'));

	}


	/**
	| @name
	|      - ulockwpass
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the edit form confirmation msg
	|
	**/
	function ulockwpass($hash=null,$id=0)
	{

		//perms
		$this->etc->check_permission('USER.UNLOCK.WPASS');

		//params
		log_message("DEBUG","ulockwpass() : info-params [ $hash : $id ]");

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_ULOCK_WPASS_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_ULOCK_WPASS_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url(DEFAULT_USER_VIEW));
			return;
		}

		//fmt-params
		$pdata               = null;
		$pdata['id']         = $gdata['data']->id;
		$pdata['updated_by'] = $this->etc->get_updated_by();


		//exec
		$pret                 = $this->user_model->rset_wrong_pass($pdata);

		log_message("DEBUG","ulockwpass() : info#$pret [ $hash : $id ]");


		$this->etc->set_error_message($this->config->item('USER_ULOCK_WPASS_OK_MSG'));
		//fwd
		redirect(site_url(DEFAULT_USER_VIEW));
	}



	/**
	| @name
	|      - eprof
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - show the edit form confirmation msg
	|
	**/
	function eprof()
	{

		//perms
		$this->etc->check_permission('USER.PROFILE.EDIT');

		//get from sess
		$hash   = $this->etc->get_mhash();
		$id     = $this->etc->get_id();

		//params
		log_message("DEBUG","eprof() : info-params [ $hash : $id ]");

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_PROFILE_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url('admin'));
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_PROFILE_UNKNOWN_REC_MSG'));

			//fwd
			redirect(site_url('admin'));
			return;
		}


		//set data
		$vdata['jData_Total']        = 0;
		$vdata['jData']              = $gdata['data'];
		$vdata['jData_Hidden']       = array('id'=> $id, 'hash' => $hash, 'email' => $gdata['data']->email);


		//view
		$this->load->view('user.eprof.frm.php',$vdata);

	}


	/**
	| @name
	|      - eprof_proc
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
	function eprof_proc()
	{
		//perms
		$this->etc->check_permission('USER.PROFILE.EDIT');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));

		//params
		log_message("DEBUG","eprof_proc() : info-params [ $hash : $id ]");



		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);


		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'email' => $gdata['data']->email);


		//invalid id
		if(!$hstatus)
		{
			//set status
			$vdata['error_message'] = $this->config->item('USER_UPD_PROFILE_UNKNOWN_REC_MSG');

			log_message("DEBUG","eprof_proc() : info [ DECRYPT FAILED ]");

			//view
			$this->load->view('user.eprof.frm.php',$vdata);
			return;
		}

		//get rec
		$gdata = $this->user_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$vdata['error_message'] = $this->config->item('USER_UPD_PROFILE_UNKNOWN_REC_MSG');

			log_message("DEBUG","eprof_proc() : info [ NOT IN DB ]");

			//view
			$this->load->view('user.eprof.frm.php',$vdata);
			return;
		}


		//set p-data
		$pdata               = null;
		$pdata['email']      = $gdata['data']->email;
		$pdata['mobile']     = trim($this->input->get_post('mobile' ));
		$pdata['name']       = trim($this->input->get_post('name' ));
		$pdata['updated_by'] = $this->etc->get_created_by();
		$pdata['id']         = $id;

		//upd8 it;-)
		$ddata = $this->user_model->update_profile($pdata);

		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message($this->config->item('USER_UPD_PROFILE_OK_MSG'));

		}
		else
		{
			//set status
			$this->etc->set_error_message($this->config->item('USER_UPD_PROFILE_ERR_MSG'));
		}

		//fwd
		redirect(site_url('admin'));
		return;


	}



}
/* End of file welcome.php */
/* Location: ./system/application/controllers/user.php */
