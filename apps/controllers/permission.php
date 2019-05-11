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

class Permission extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();

		//misc
		$this->load->helper('misc');

		//more
		$this->load->model('User_resource_model',  'user_resource_model');
		$this->load->model('User_permission_model','user_permission_model');
		$this->load->model('User_role_model',      'user_role_model');
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
		$this->etc->check_permission('PERMISSION.LIST');

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
	| @description
	|      - default controller ( view list )
	|
	**/
	function ajx_view($v=true)
	{
		//perms
		$this->etc->check_permission('PERMISSION.LIST');

		//sorting
		$sortdata   = array();

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");

		//perms-list
		$rdata = $this->user_resource_model->get( );
		$rlist = $rdata['data'];


		//role-list
		$rodata = $this->user_role_model->get();
		$rolist = $rodata['data'];

		$buff   = '';
		//$buff .= "{id: \"resource\" ,    caption: \"Resource\",    sortable: false},\n";
    $buff .= "{
                 \"sTitle\"   : \"Resource\",
                 \"sName\"    : \"resource\",
                 \"sType\"    : \"string\",
                 \"aTargets\" : [ 0 ],
                 \"bSortable\": false,
               },\n";
		//set headers
		$z=0;
    foreach($rolist as $kk => $vv)
		{
			//ignore ;-) root
			if($this->config->item('DEFAULT_ROLE_ROOT_ID') == $kk )
				continue;
			$buff1 = '"'. $vv->name.'"';
			$buff2 = '"'. ucfirst($vv->name).'"';
			//$buff .= "{id: $buff1 ,    caption: $buff2,    sortable: false},\n";
      $buff .= "{
                 \"sTitle\"   : $buff2,
                 \"sName\"    : $buff1,
                 \"sType\"    : \"string\",
                 \"aTargets\" : [ $z ],
                 \"bSortable\": false,
               },\n";
		  $z++;
    }
		$buff = substr($buff, 0, strlen($buff)-2);

		log_message("DEBUG","ajx_view() : HDRS [ $buff ]");

		$rdata['total'] = $rdata['total']==''?0:$rdata['total'];

		$json_str = $this->fmt_jason_data(
						$rlist,
						$fdata['page'],
						$rdata['total'],
						$rolist,
						$fdata['draw']
						);

		//fmt view data
		$vdata['jData_Total']    = @intval($rdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Headers']  = $buff;
		$vdata['jData_Ajax']     = true;

		//view
		if(!$v)
		   $this->load->view('permission.view.php',$vdata);
		else
		   echo $json_str;

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
	function ajx_view_ori($v=true)
	{
		//perms
		$this->etc->check_permission('PERMISSION.LIST');

		//sorting
		$sortdata   = array();

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");

		//perms-list
		$rdata = $this->user_resource_model->get( );
		$rlist = $rdata['data'];


		//role-list
		$rodata = $this->user_role_model->get();
		$rolist = $rodata['data'];

		$buff   = '';
		$buff .= "{id: \"resource\" ,    caption: \"Resource\",    sortable: false},\n";
		//set headers
		foreach($rolist as $kk => $vv)
		{
			//ignore ;-) root
			if($this->config->item('DEFAULT_ROLE_ROOT_ID') == $kk )
				continue;
			$buff1 = '"'. $vv->name.'"';
			$buff2 = '"'. ucfirst($vv->name).'"';
			$buff .= "{id: $buff1 ,    caption: $buff2,    sortable: false},\n";
		}
		$buff = substr($buff, 0, strlen($buff)-2);

		log_message("DEBUG","ajx_view() : HDRS [ $buff ]");

		$rdata['total'] = $rdata['total']==''?0:$rdata['total'];

		$json_str = $this->fmt_jason_data(
						$rlist,
						$fdata['page'],
						$rdata['total'],
						$rolist,
						$fdata['draw']
						);

		//fmt view data
		$vdata['jData_Total']    = @intval($rdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Headers']  = $buff;
		$vdata['jData_Ajax']     = true;

		//view
		if(!$v)
		   $this->load->view('permission.view.php',$vdata);
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
	function fmt_jason_data($ldata=null, $page=1, $total=0, $rolist=null, $draw=1)
	{

		//init jason-data
		$jres = "{\"draw\": $draw,
			    \"recordsTotal\" : $total,
          \"recordsFiltered\": $total,
			    \"data\": [
			   ";

		//more
		foreach($ldata as $kk => $vv)
		{
			$status_buff = null;
			foreach($rolist as $KK => $VV)
			{
				//ignore ;-) root
				if($this->config->item('DEFAULT_ROLE_ROOT_ID') == $KK )
					continue;


				//get the flag
				$pmdata = $this->user_permission_model->select_by_pair(array(
										'role'     => $KK,
										'resource' => $vv->id,
										      ));
				$status_str   = $pmdata['flag'];
				//chkbox
				$status_str_ck = ($status_str>0) ? (' checked ') : ('');
				$status_str_v  = @implode('-', array($KK, $vv->id));
				$status_str_box= "<input type='checkbox' name='chkperms[]' value='$status_str_v' $status_str_ck />";//"<input type='checkbox' name='chkperms[]' value='$status_str_v' $status_str_ck />";
				$status_buff .= '"'. $status_str_box   .   '",';


			}
			$status_buff  = substr($status_buff, 0, strlen($status_buff)-1);
			//delete
			$jres .= '     [ ' .
					'"'. addslashes( $vv->name  )  .'",'.
					$status_buff.
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
	|      - perm_proc
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - process permission settings
	|
	**/
	function perm_proc()
	{
		//perms
		$this->etc->check_permission('PERMISSION.EDIT');

		//get
		$perms = $this->input->get_post('chkperms');

		$dmp   = @var_export($perms, true);
		//params
		log_message("DEBUG","perm_proc() : settings [ $dmp ]");


		$mx    = @count($perms);
		$ok    = 0;
		if($mx > 0)
		{
			//truncate ;-)
			$this->user_permission_model->delete_all( $this->config->item('DEFAULT_ROLE_ROOT_ID') );

			//new ins
			for($i=0; $i < $mx; $i++)
			{
				list($role, $resource) = @explode('-',$perms[$i]);
				$role     = @intval($role);
				$resource = @intval($resource);
				//fmt-params
				$pdata               = null;
				$pdata['role']       = $role;
				$pdata['resource']   = $resource;
				$pdata['status']     = "1";
				$pdata['created_by'] = $this->etc->get_created_by();
				//exec
				$ret= $this->user_permission_model->add( $pdata );
				$ok = ($ret) ? ($ok+1) : ($ok);
			}
		}


		if($ok)
		{
			//set status
			$this->etc->set_success_message($this->config->item('RESOURCE_UPD_OK_MSG'));
		}


		//fwd
		redirect(site_url("permission/view"));
		return;


	}
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/user.php */
