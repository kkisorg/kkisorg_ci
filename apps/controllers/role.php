<?php
/*
|--------------------------------------------------------------------------
| @Filename: role.php
|--------------------------------------------------------------------------
| @Desc    : user controller
| @Date    : 2010-04-02
| @Version : 1.0 
| @By      : bayugyug@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class Role extends Controller 
{

	function Role()
	{
		parent::Controller();	
		
		//loaders here ;-)
		$this->load->database();
		
		//misc
		$this->load->helper('misc');
		
		//more
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
		$this->etc->check_permission('ROLE.LIST');

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
		$this->etc->check_permission('ROLE.ADD');

		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];

		//set data
		$vdata['jData_active_list'] = $this->config->item('DEFAULT_ACTIVE_INACTIVE_LIST');
		$vdata['jData_role_list']   = $rlist;
		
		//view
		$this->load->view('role.add.frm.php',$vdata);

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
		$this->etc->check_permission('ROLE.ADD');

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
			$this->load->view("role.view.php");
			return;

		}

		//set rules
		$this->set_rules_for_add();
	
		//chk rules
		if ($this->form_validation->run() == FALSE)
		{
		
			log_message("DEBUG","afrm_proc() : info [ VALIDATION FAILED ]");
			
			//fwd
			$this->load->view("role.add.frm.php");
			return;		
		}
		
		//set p-data
		$pdata               = null;
		$pdata['name']       = trim($this->input->get_post('name' ));;
		$pdata['desc']       = trim($this->input->get_post('description' ));;
		$pdata['created_by'] = $this->etc->get_created_by();
		
		
		//exec
		$pret                = $this->user_role_model->add($pdata);
		if(!$pret['status'])
		{
		
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_ADD_UNKNOWN_ERR_MSG'));

			//fwd
			$this->load->view("role.add.frm.php");
			return;
		}
		
		//okay
		$this->etc->set_success_message($this->config->item('ROLE_ADD_OK_MSG'));
		
		//fwd
		redirect(site_url("role/view"));
		return;
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
		$this->etc->check_permission('ROLE.EDIT');

		//params
		log_message("DEBUG","efrm() : info-params [ $hash : $id ]");
		
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);
		
		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_UPD_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url("role/view"));
			return;
		}
		 
		//get rec
		$gdata = $this->user_role_model->select_by_id( array('id' => $id) );
		
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_UPD_UNKNOWN_REC_MSG'));
		
			//fwd
			redirect(site_url("role/view"));
			return;
		}

		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];

		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'name' => $gdata['data']->name);
		
		
		//view
		$this->load->view('role.edit.frm.php',$vdata);

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
		$this->etc->check_permission('ROLE.EDIT');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));
		
		//params
		log_message("DEBUG","efrm_proc() : info-params [ $hash : $id ]");


	
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);


		//get rec
		$gdata = $this->user_role_model->select_by_id( array('id' => $id) );

		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'email' => $gdata['data']->email);
		
		
		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));
			
			log_message("DEBUG","efrm_proc() : info [ DECRYPT FAILED ]");
			
			//view
			$this->load->view('role.edit.frm.php',$vdata);
			return;
		}

	
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");

			//view
			$this->load->view('role.edit.frm.php',$vdata);
			return;
		}
		

		//set p-data
		$pdata               = null;
		$pdata['name']       = trim($this->input->get_post('name' ));
		$pdata['desc']       = trim($this->input->get_post('description' ));
		$pdata['updated_by'] = $this->etc->get_updated_by();
		$pdata['id']         = $id;
		
		//upd8 it;-)
		$ddata = $this->user_role_model->update($pdata);
		
		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message($this->config->item('ROLE_UPD_OK_MSG'));
		
		}
		else
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_UPD_ERR_MSG'));
		}

		//fwd
		redirect(site_url("role/view"));
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
		$this->etc->check_permission('ROLE.DELETE');

		//params
		log_message("DEBUG","dfrm() : info-params [ $hash : $id ]");
		
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);
		
		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));
			//fwd
			redirect(site_url("role/view"));
			return;
		}
		
		//get rec
		$gdata = $this->user_role_model->select_by_id( array('id' => $id) );
		
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));
		
			//fwd
			redirect(site_url("role/view"));
			return;
		}

		
		
		
		//fmt view data
		$vdata['jData_Total']    = 0;
		$vdata['jData']          = $gdata['data'];
		$vdata['jData_Hidden']   = array('id'=> $id, 'hash' => $hash);
		
		
		//view
		$this->load->view('role.delete.frm.php',$vdata);

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
		$this->etc->check_permission('ROLE.DELETE');

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
			redirect(site_url("role/view"));
			return;

		}

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));
			
			log_message("DEBUG","dfrm_proc() : info [ DECRYPT FAILED ]");
			
			//fwd
			redirect(site_url("role/view"));
			return;
		}

		//get rec
		$gdata = $this->user_role_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");
			
			//fwd
			redirect(site_url("role/view"));
			return;
		}
		
		//admin cant be deleted
		if($this->config->item('DEFAULT_ROLE_ROOT_ID') == $id ) 
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));

			log_message("DEBUG","dfrm_proc() : info [ SUPER-ROOT DELETE not ALLOWED ]");

			//fwd
			redirect(site_url("role/view"));
			return;
		}


		//delete it;-)
		$ddata = $this->user_role_model->delete(array(
								'id'         => $id,
							     )	
						           );
		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message($this->config->item('ROLE_DEL_OK_MSG'));
		
		}
		else
		{
			//set status
			$this->etc->set_error_message($this->config->item('ROLE_DEL_UNKNOWN_REC_MSG'));
		}

		//fwd
		redirect(site_url("role/view"));
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
		$this->etc->check_permission('ROLE.LIST');
		
		//sorting
		$sortdata   = array(
				"id"   ,   
				"name"  ,  
				"description",
				"created");

		//fmt params
		$fdata = fmt_ajx_params($sortdata);
		
		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");
		
		//role-list
		$rdata = $this->user_role_model->get();
		$rlist = $rdata['data'];
		$rdata['total'] = $rdata['total']==''?0:$rdata['total'];
		
		$json_str = $this->fmt_jason_data(
						$rlist, 
						$fdata['page'], 
						$rdata['total'],
						$fdata['draw']
						);
		
		//fmt view data
		$vdata['jData_Total']    = @intval($rdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Ajax']     = true;
		
		//view
		if(!$v)
		   $this->load->view('role.view.php',$vdata);
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
	function fmt_jason_data($role_list=null, $page=1, $total=0, $draw=1)
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
		foreach($role_list as $kk => $vv)
		{
			$mhash    = u_encrypt_hash($vv->id);
			//edit
			$seq      = array('role', 
					  'efrm', 
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$ehref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Edit</a>';
			$seq      = array('role', 
					  'dfrm', 
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$dhref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Delete</a>';
			$hrefs    = $ehref."&nbsp;&nbsp;".$dhref;

			 
			//delete
			$jres .= '     [ ' .
					'"'. addslashes( $vv->name  )  .'",'. 
					'"'. addslashes( $vv->description )  .'",'.
					'"'. addslashes( $vv->created ) .'",'.
					'"'. addslashes( $hrefs     )   .'" '. 
					"],\n";
		}
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
		$this->set_rules_for_add();
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
		//set local rules for add
		$this->form_validation->set_rules('name',         'Name',           'trim|required|callback_check_uniq_role');
		$this->form_validation->set_rules('description',  'Description',    'trim|required');
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
	function check_uniq_role()
	{
		//init params
		$pid     = intval($this->input->get_post('id', TRUE));
		$name    = trim($this->input->get_post('name', TRUE));
		$pdata   = array('id' => $pid , 'name' => $name);

		//chck from db
		$rdata   = $this->user_role_model->select_by_name($pdata);

		//len
		$is_len  = strlen($name)<=0 ? (false) : (true);

		//start chking
		if( !$is_len )
		{
			$this->form_validation->set_message(
					'check_uniq_role', 
					$this->config->item('ROLE_ADD_ERR_MSG_NAME_REQUIRED')
					);
			return false;
		}
		else if($rdata['status'])
		{
			$this->form_validation->set_message(
						'check_uniq_role', 
						$this->config->item('ROLE_ADD_ERR_MSG_NAME_ALREADY_USED')
						);
			return false;
		}
		else
		{
			return true;
		}
	}	
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/user.php */