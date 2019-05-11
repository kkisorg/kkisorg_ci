<?php
/*
|--------------------------------------------------------------------------
| @Filename: dombaku.php
|--------------------------------------------------------------------------
| @Desc    : Dombaku
| @Date    : 2012-06-16
| @Version : 1.0
| @By      : gabriela.kartika@gmail.com
|
|
|
| @Modified By  :
| @Modified Date:
*/

class Dombaku_adm extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();

		//misc
		$this->load->helper('misc');

		//more
		$this->load->model('Dombaku_model','dombaku_model');

	}


	/**
	| @title
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
	| @title
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
		$this->etc->check_permission('DOMBAKU.LIST');

		$this->ajx_view(false);
	}

	/**
	| @title
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

		//globals here ;-)
		global $g_SYSTEM_DATA;

		//fmt
		$title   = trim($g_SYSTEM_DATA['_REQUEST']['search']['value']);


    //perms
		$this->etc->check_permission('DOMBAKU.LIST');

		//sorting
		$sortdata   = array(
				"title"  ,
				"publish",
				"expired_dt",
				);

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");

		//role-list
		$rdata = $this->dombaku_model->get(array(
						'order' => $fdata['order'],
						'limit' => $fdata['limit'],
						'where' => $this->fmt_filter(),
		                             ));
		$rlist = $rdata['data'];
		//('status' => $ok, 'data' => $data , 'total' => $tot );
		$json_str = $this->fmt_jason_data(
						$rlist,
						$fdata['page'],
						$rdata['total']
						);

		//fmt view data
		$vdata['jData_Total']    = @intval($rdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Ajax']     = true;

		//set data
		$vdata['jName']     = $title;


		//view
		if(!$v)
		   $this->load->view('dombaku.view.php',$vdata);
		else
		   echo $json_str;

	}



	/**
	| @title
	|      - fmt_filter
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
	function fmt_filter()
	{
		//globals here ;-)
		global $g_SYSTEM_DATA;

		//fmt
		$title   = trim($g_SYSTEM_DATA['_REQUEST']['search']['value']);

		$xwhere = '';
		$bfr    = array();

		//dmp
		$dmp   = @var_export($g_SYSTEM_DATA['_REQUEST'],true);
		log_message("DEBUG","fmt_filter() : params [ $dmp ]");


		//dummy xtra
		$bfr[]  = " AND 2=2 ";
		if(strlen($title)>=MIN_FILTER_LEN)
		{
			//fmt
			$title   = addslashes($title);
			$bfr[]  =" title like '%$title%' ";
		}

		//fmt
		$xwhere = @implode(" AND ", $bfr) ;
		//give it back;
		return $xwhere;
	}

	/**
	| @title
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
			$mhash    = u_encrypt_hash($vv->id);
			//edit
			$seq      = array('dombaku_adm',
					  'efrm',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$ehref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Edit</a>';
			$seq      = array('dombaku_adm',
					  'dfrm',
					  @rawurlencode( $mhash ) ,
					  @rawurlencode("$vv->id"),
					  );
			$dhref    = '<a class="btn btn-primary btn-xs" href="'.site_url($seq).'">Delete</a>';
			$hrefs    = $ehref."&nbsp;&nbsp;".$dhref;

      $publish = $vv->publish==1?'Published':'Not Published';
			//delete
			$jres .= '     [ ' .
					'"'. addslashes( $vv->title  )  .'",'.
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
	| @title
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
		$this->etc->check_permission('DOMBAKU.ADD');


		$vdata['bdata'] = $blist;
		$vdata['jData_Cal']         = 1;
		//set data
		$vdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');


		//view
		$this->load->view('dombaku.add.frm.php',$vdata);

	}


	/**
	| @title
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
		$this->etc->check_permission('DOMBAKU.ADD');

		//get chk post
		$id   = trim($this->input->get_post('id'   , true));
		$hash = trim($this->input->get_post('hash' , true));


		//set p-data
		$pdata               = null;
		$pdata['title']       = trim($this->input->get_post('title'   , true));
    	$pdata['short_desc'] = trim($this->input->get_post('short_desc', true));

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
			$this->load->view('dombaku.add.frm.php',$pdata);
			return;

		}

		//set rules
		$this->set_rules_for_add();

		//chk rules
		if ($this->form_validation->run() == FALSE)
		{

			log_message("DEBUG","afrm_proc() : info [ VALIDATION FAILED ]");
			$pdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');


			$pdata['bdata'] = $blist;

			//fwd
			$this->load->view('dombaku.add.frm.php',$pdata);
			return;
		}
		else
		{
      if($_FILES["file"]["size"]!=0)
		  {
    		if ((($_FILES["file"]["type"] != "image/gif")
            && ($_FILES["file"]["type"] != "image/jpeg")
            && ($_FILES["file"]["type"] != "image/pjpeg")
            && ($_FILES["file"]["type"] != "image/png")
            && ($_FILES["file"]["type"] != "application/pdf"))
                || $_FILES["file"]["error"] > 0 )
        {


          //$this->etc->set_error_message('Invalid file. (Only support .jpg/.png/.gif)');

          //view
    		  $this->load->view('dombaku.add.frm.php',$vdata);

        }
      }
    }

		if ($_FILES["file"]["size"]>0)
		{

		  $img_arr = explode('.',$_FILES["file"]["name"]);

      $pdata['image']       =  $img_arr[1];
    }


		//exec
		$pret                = $this->dombaku_model->add($pdata);
		if(!$pret['status'])
		{

			//set status
			$this->etc->set_error_message('Failed to saved.');

			//fwd
			$this->load->view('dombaku.add.frm.php',$pdata);
			return;
		}


		//copy files
		if ($_FILES["file"]["size"]>0)
		{
		  $filename = "dombaku_".$pret['ref'].".".$img_arr[1];

	    $res = move_uploaded_file($_FILES["file"]["tmp_name"], FILEPATH_USERFILES."dombaku/".$filename);

	    //resize
	    $config['image_library'] = 'gd2';
      $config['source_image'] = FILEPATH_USERFILES.'dombaku/'.$filename;
      //$config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      //$config['width'] = '720';//THUMBNAIL_ALBUMS_WIDTH;
     // $config['height'] = THUMBNAIL_ALBUMS_HEIGHT;
      $config['new_image'] = FILEPATH_USERFILES.'dombaku/'.$filename;

      $this->load->library('image_lib', $config);

      $this->image_lib->initialize($config);
      //$this->image_lib->resize();
      $this->image_lib->clear();
      unset($config);

      if ( ! $this->image_lib->resize())
      {
          //echo $this->image_lib->display_errors(); die;
      }

    }

		//okay
		$this->etc->set_success_message('Successfully saved data.');

		//fwd
		//redirect(site_url("dombaku_adm/view"));
		$mhash    = u_encrypt_hash($pret['ref']);
		$seq      = array('dombaku_adm',
                  'efrm',
                  @rawurlencode( $mhash ) ,
                  @rawurlencode($pret['ref']),
                  );
        redirect(site_url($seq));

		return;
	}

	/**
	| @title
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
	| @title
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
		$this->form_validation->set_rules('title',     'Dombaku Title',       'trim|required');
	}



	/**
	| @title
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
		$this->etc->check_permission('DOMBAKU.EDIT');

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
			redirect(site_url("dombaku_adm/view"));
			return;
		}

		//get rec
		$gdata = $this->dombaku_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');

			//fwd
			redirect(site_url("dombaku_adm/view"));
			return;
		}


		$vdata['jData_Cal']         = 1;


		//set data
		$vdata['jData_Total']       = 0;
		$vdata['jData']             = $gdata['data'];
		$vdata['jData_Hidden']      = array('id'=> $id, 'hash' => $hash, 'title' => $gdata['data']->title);
		//set data
		$vdata['jData_publish_list'] = $this->config->item('DEFAULT_PUBLISH_NOTPUBLISH_LIST');

		//view
		$this->load->view('dombaku.edit.frm.php',$vdata);

	}




	/**
	| @title
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
		$this->etc->check_permission('DOMBAKU.EDIT');

		//get chk post
		$id   = trim($this->input->get_post('id'));
		$hash = trim($this->input->get_post('hash'));

		//params
		log_message("DEBUG","efrm_proc() : info-params [ $hash : $id ]");



		//calc-hash
		$hstatus = u_decrypt_hash($id, $hash);


		//get rec
		$gdata = $this->dombaku_model->select_by_id( array('id' => $id) );


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
			$this->load->view('dombaku.edit.frm.php',$vdata);
			return;
		}


		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data');

			log_message("DEBUG","efrm_proc() : info [ NOT IN DB ]");

			//view
			$this->load->view('dombaku.edit.frm.php',$vdata);
			return;
		}
		//set rules
		$this->set_rules_for_modify();

		//chk rules
		if ($this->form_validation->run() == FALSE)
		{


			log_message("DEBUG","efrm_proc() : info [ VALIDATION FAILED ]");

			//fwd
			$this->load->view('dombaku.edit.frm.php',$vdata);
			return;
		}

    if($_FILES["file"]["size"]!=0)
	  {
  		if ((($_FILES["file"]["type"] != "image/gif")
          && ($_FILES["file"]["type"] != "image/jpeg")
          && ($_FILES["file"]["type"] != "image/pjpeg")
          && ($_FILES["file"]["type"] != "image/png")
          && ($_FILES["file"]["type"] != "application/pdf"))
              || $_FILES["file"]["error"] > 0 )
      {


        //$this->etc->set_error_message('Invalid file. (Only support .jpg/.png/.gif)');

        //view
  		  $this->load->view('dombaku.edit.frm.php',$vdata);
  		  return;
      }
    }

		//set p-data
		$pdata               = null;
		$pdata['title']       = trim($this->input->get_post('title'   , true));

		//sdt
		$pdata['short_desc']      = trim($this->input->get_post('short_desc'    , true));
    	$pdata['publish']       = trim($this->input->get_post('publish'    , true));

		$pdata['created_by'] = $this->etc->get_created_by();
		$pdata['updated_by'] = $this->etc->get_updated_by();
		$pdata['id']         = $id;


	  $img =   $gdata['data']->image;


		if ($_FILES["file"]["size"]>0)
		{

		  $img_arr = explode('.',$_FILES["file"]["name"]);

      $pdata['image']       =  "dombaku_".$id.".".$img_arr[1];
    }

		//upd8 it;-)
		$ddata = $this->dombaku_model->update($pdata);

		if($ddata['status'])
		{
		  //copy files
  		if ($_FILES["file"]["size"]>0)
  		{
  		  $filename = "dombaku_".$id.".".$img_arr[1];
  		  @unlink(FILEPATH_USERFILES.$img);

  	    $res = move_uploaded_file($_FILES["file"]["tmp_name"], FILEPATH_USERFILES.'dombaku/'.$filename);


  	    //resize
  	    $config['image_library'] = 'gd2';
        $config['source_image'] = FILEPATH_USERFILES.'dombaku/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = THUMBNAIL_ALBUMS_WIDTH;
        $config['height'] = THUMBNAIL_ALBUMS_HEIGHT;
        $config['new_image'] = FILEPATH_USERFILES.'dombaku/'.$filename;

        $this->load->library('image_lib', $config);

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        unset($config);

        if ( ! $this->image_lib->resize())
        {
            //echo $this->image_lib->display_errors(); die;
        }
      }

			//set status
			$this->etc->set_success_message('Successfully updated data.');

		}
		else
		{
			//set status
			$this->etc->set_error_message('Failed to update data.');
		}

		//fwd
		//redirect(site_url("dombaku_adm/view"));
		$mhash    = u_encrypt_hash($id);
		$seq      = array('dombaku_adm',
                  'efrm',
                  @rawurlencode( $mhash ) ,
                  @rawurlencode($id),
                  );
        redirect(site_url($seq));

		return;


	}



	/**
	| @title
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
		$this->etc->check_permission('DOMBAKU.DELETE');

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
			redirect(site_url("dombaku_adm/view"));
			return;
		}

		//get rec
		$gdata = $this->dombaku_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');

			//fwd
			redirect(site_url("dombaku_adm/view"));
			return;
		}




		//fmt view data
		$vdata['jData_Total']    = 0;
		$vdata['jData']          = $gdata['data'];
		$vdata['jData_Hidden']   = array('id'=> $id, 'hash' => $hash);


		//view
		$this->load->view('dombaku.delete.frm.php',$vdata);

	}


	/**
	| @title
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
		$this->etc->check_permission('DOMBAKU.DELETE');

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
			redirect(site_url("dombaku_adm/view"));
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
			redirect(site_url("dombaku_adm/view"));
			return;
		}

		//get rec
		$gdata = $this->dombaku_model->select_by_id( array('id' => $id) );

		//invalid id
		if(!$gdata['status'])
		{
			//set status
			$this->etc->set_error_message('There is something wrong with the data.');

			log_message("DEBUG","dfrm_proc() : info [ NOT IN DB ]");

			//fwd
			redirect(site_url("dombaku_adm/view"));
			return;
		}


		//delete it;-)
		$ddata = $this->dombaku_model->delete(array(
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
		redirect(site_url("dombaku_adm/view"));
		return;


	}

}
/* End of file dombaku.php */
/* Location: ./apps/controllers/dombaku.php */
