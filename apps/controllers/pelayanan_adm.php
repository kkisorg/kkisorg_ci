<?php
/*
|--------------------------------------------------------------------------
| @Filename: pelayanan_adm.php
|--------------------------------------------------------------------------
| @Desc    : Blog Adm
| @Date    : 2012-06-16
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class Pelayanan_adm extends Controller 
{

	function Pelayanan_adm()
	{
		parent::Controller();	
		
		//loaders here ;-)
		$this->load->database();
		
		//misc
		$this->load->helper('misc');
		
		//more
		$this->load->model('Pelayanan_model',     'pelayanan_model');
		
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
	| @contentription
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
	| @contentription
	|      - default controller ( view list )
	|
	**/
	function view()
	{
		//perms
		$this->etc->check_permission('PELAYANAN.LIST');

		$this->ajx_view(false);		
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
	| @contentription
	|      - default controller ( view list )
	|
	**/
	function ajx_view($v=true)
	{
	
		//globals here ;-)
		global $g_SYSTEM_DATA;

		//fmt
		$name   = trim($g_SYSTEM_DATA['_REQUEST']['search']['value']);
	
    
        //perms
		$this->etc->check_permission('PELAYANAN.LIST');
	
		//sorting
		$sortdata   = array(
				"pelayanan_id"  , 
				"created_date"  ,
				"display",
				);

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");
	
		//role-list
		$rdata = $this->pelayanan_model->get(array(
						'order' => $fdata['order'],
						'limit' => $fdata['limit'],
						'where' => $this->fmt_filter(),
		                             ));
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
		
		//set data
		$vdata['jName']     = $name;
    

		//view
		if(!$v)
		   $this->load->view('pelayanan.view.php',$vdata);
		else
		   echo $json_str;
		
	}


	
	/**
	| @name
	|      - fmt_filter
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @contentription
	|      - default controller ( view list )
	|
	**/
	function fmt_filter()
	{
		//globals here ;-)
		global $g_SYSTEM_DATA;
		
		//fmt
		$name   = trim($g_SYSTEM_DATA['_REQUEST']['search']['value']);

		$xwhere = '';
		$bfr    = array();
		
		//dmp
		$dmp   = @var_export($g_SYSTEM_DATA['_REQUEST'],true);
		log_message("DEBUG","fmt_filter() : params [ $dmp ]");


		//dummy xtra
		$bfr[]  = " AND 2=2 ";
		if(strlen($name)>=MIN_FILTER_LEN)
		{
			//fmt
			$name   = addslashes($name);
			$bfr[]  =" pelayanan_title like '%$name%' ";
		}	
		
		//fmt
		$xwhere = @implode(" AND ", $bfr) ;
		//give it back;
		return $xwhere;
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
	| @contentription
	|      - jason-data formatter
	|
	**/
	function fmt_jason_data($plist=null, $page=1, $total=0, $draw=1)
	{
	
		//alist
		
		//init jason-data
		$jres = "{\"draw\": $draw,
			    \"recordsTotal\" : $total,
          \"recordsFiltered\": $total,
			    \"data\": [
			   ";
		//more
		foreach($plist as $kk => $vv)
		{
			$mhash    = u_encrypt_hash($vv->pelayanan_id);
			//edit
			$seq      = array('pelayanan_adm', 
					  'efrm', 
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->pelayanan_id"),
					  );
			$ehref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Edit</a>';
			$seq      = array('pelayanan_adm', 
					  'dfrm', 
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->pelayanan_id"),
					  );
			$dhref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Delete</a>';
			$hrefs    = $ehref."&nbsp;&nbsp;".$dhref;

      $publish = $vv->display==1?'Published':'Not Published';
			//delete
			$jres .= '     [ ' .
					'"'. ( $vv->pelayanan_title  )  .'",'. 
					'"'. addslashes( substr($vv->created_date,0,10)  )  .'",'.
					'"'. addslashes( $publish  )  .'",'.
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
	|      - afrm
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @contentription
	|      - show the add form for new
	|
	**/
	function afrm()
	{
		//perms
		$this->etc->check_permission('PELAYANAN.ADD');

		
		$vdata['jData_Cal']         = 1;
		//set data
		$vdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');

		
		//view
		$this->load->view('pelayanan.add.frm.php',$vdata);

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
	| @contentription
	|      - process new user profile
	|
	**/
	function afrm_proc()
	{
		//perms
		$this->etc->check_permission('PELAYANAN.ADD');
    
		//get chk post
		$id   = trim($this->input->get_post('id'   , true));
		$hash = trim($this->input->get_post('hash' , true));
		
		//set p-data
		$pdata               = null;
		$pdata['name']       = quotes_to_entities(trim($this->input->get_post('name'   , true)));
    	$pdata['content']       = trim($this->input->get_post('content', true));
    	$pdata['publish']       = trim($this->input->get_post('publish'    , true));
    
	
    
		$pdata['created_by']  = $this->etc->get_created_by();

		//params
		log_message("DEBUG","afrm_proc() : info-params [ $hash : $id ]");


		//cancel?
		if(!$this->input->get_post('Save'))
		{
			//set status
			log_message("DEBUG","afrm_proc() : info [ NOT CLICKED ]");
			
			//fwd
			$this->load->view('pelayanan.add.frm.php',$pdata);
			return;            

		}

		//set rules
		$this->set_rules_for_add();
	
		//chk rules
		if ($this->form_validation->run() == FALSE)
		{
		
			log_message("DEBUG","afrm_proc() : info [ VALIDATION FAILED ]");
			$pdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');
		  
			
			//fwd
			$this->load->view('pelayanan.add.frm.php',$pdata);
			return;		          
		}
		
	
		//exec
		$pret                = $this->pelayanan_model->add($pdata);
		if(!$pret['status'])
		{
		
			//set status
			$this->etc->set_error_message('Failed to saved.');

			//fwd
			$this->load->view('pelayanan.add.frm.php',$pdata);
			return;            
		}
		
		
		
		
		//okay
		$this->etc->set_success_message('Successfully saved data.');
		
		//fwd
		redirect(site_url("pelayanan_adm/view"));
		
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
	| @contentription
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
	| @contentription
	|      - set rules for add user    
	|
	**/	
	function set_rules_for_add()
	{
		//set local rules for add
		$this->form_validation->set_rules('name',     'Pelayanan Title',       'trim|required');
		$this->form_validation->set_rules('content',     'Pelayanan Content',       'trim|required');
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
	| @contentription
	|      - show the edit form confirmation msg
	|
	**/
	function efrm($hash=null,$id=0)
	{
		//perms
		$this->etc->check_permission('PELAYANAN.EDIT');

		//params
		log_message("DEBUG","efrm() : info-params [ $hash : $id ]");
		
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);
		
		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}
		
		//get rec
		$gdata = $this->pelayanan_model->select_by_id( array('id' => $id) );
		
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
		
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}

		
		$vdata['jData_Cal']         = 1;
		
		
		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'name' => $gdata['data']->pelayanan_title);
		//set data
		$vdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');

		
		$vdata['mhash']  = u_encrypt_hash($id);
	
		
		//view
		$this->load->view('pelayanan.edit.frm.php',$vdata);
                     
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
	| @contentription
	|      - show the edit form
	|
	**/
	function efrm_proc()
	{
		//perms
		$this->etc->check_permission('PELAYANAN.EDIT');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));
		
		//params
		log_message("DEBUG","efrm_proc() : info-params [ $hash : $id ]");


	
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);


		//get rec
		$gdata = $this->pelayanan_model->select_by_id( array('id' => $id) );

				
		$vdata['jData_Cal']         = 1;

		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash);
		$vdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');
		
		
		//invalid id
		if(!$hstatus)           
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data');
			
			log_message("DEBUG","efrm_proc() : info [ DECRYPT FAILED ]");
			
			//view
			$this->load->view('pelayanan.edit.frm.php',$vdata);
			return;            
		}

	
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data');

			log_message("DEBUG","efrm_proc() : info [ NOT IN DB ]");

			//view
			$this->load->view('pelayanan.edit.frm.php',$vdata);
			return;
		}
		//set rules
		$this->set_rules_for_modify();

		//chk rules
		if ($this->form_validation->run() == FALSE)
		{
			
		    
            $vdata['mhash']  = u_encrypt_hash($id);

		
			log_message("DEBUG","efrm_proc() : info [ VALIDATION FAILED ]");

			//fwd
			$this->load->view('pelayanan.edit.frm.php',$vdata);
			return;		
		}
  
    
		//set p-data
		$pdata               = null;
		$pdata['name']       = quotes_to_entities(trim($this->input->get_post('name'   , true)));
		$pdata['content']    = trim($this->input->get_post('content', true));

		//sdt
    	$pdata['publish']       = trim($this->input->get_post('publish'    , true));
    	
	

		$pdata['created_by'] = $this->etc->get_created_by();
		$pdata['updated_by'] = $this->etc->get_updated_by();
		$pdata['id']         = $id;
	
	
		//upd8 it;-)
		$ddata = $this->pelayanan_model->update($pdata);
		
		if($ddata['status'])
		{ 
			//set status
			$this->etc->set_success_message('Successfully updated data.');
		
		}
		else
		{
			//set status
			$this->etc->set_error_message('Failed to update data.');
		}

		//fwd
		redirect(site_url("pelayanan_adm/view"));
		
        
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
	| @contentription
	|      - show the delete form confirmation msg
	|
	**/
	function dfrm($hash=null,$id=0)
	{
		//perms
		$this->etc->check_permission('PELAYANAN.DELETE');

		//params
		log_message("DEBUG","dfrm() : info-params [ $hash : $id ]");
		
		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);
		
		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}
		
		//get rec
		$gdata = $this->pelayanan_model->select_by_id( array('id' => $id) );
		
		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
		
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}

		
		
		
		//fmt view data
		$vdata['jData_Total']    = 0;
		$vdata['jData']          = $gdata['data'];
		$vdata['jData_Hidden']   = array('id'=> $id, 'hash' => $hash);
		
		
		//view
		$this->load->view('pelayanan.delete.frm.php',$vdata);
                     
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
	| @contentription
	|      - show the delete form confirmation msg
	|
	**/
	function dfrm_proc()
	{
		//perms
		$this->etc->check_permission('PELAYANAN.DELETE');

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
			redirect(site_url("pelayanan_adm/view"));
			return;

		}

		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);

		//invalid id
		if(!$hstatus)
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
			
			log_message("DEBUG","dfrm_proc() : info [ DECRYPT FAILED ]");
			
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}

		//get rec
		$gdata = $this->pelayanan_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");
			
			//fwd
			redirect(site_url("pelayanan_adm/view"));
			return;
		}
		
    
		//delete it;-)
		$ddata = $this->pelayanan_model->delete(array(
								'id'         => $id,
								'updated_by' => $this->etc->get_updated_by(),
							     )	
						           );
		if($ddata['status'])
		{
			//set status
			$this->etc->set_success_message('Successfully deleted data.');
		
		}
		else
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');
		}

		//fwd
		redirect(site_url("pelayanan_adm/view"));
		return;
		
		
	}

}
/* End of file pelayanan.php */
/* Location: ./apps/controllers/pelayanan.php */