<?php
/*
|--------------------------------------------------------------------------
| @Filename: page.php
|--------------------------------------------------------------------------
| @Desc    : page controller
| @Date    : 2012-06-22
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class Page extends CI_Controller 
{

	function Page()
	{
		parent::__construct();	
		
		//loaders here ;-)
		$this->load->database();
		
		//misc
		$this->load->helper('misc');
		
		$this->load->model('Page_model','page');
		
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
        $this->view();
		
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
	function view($lang_id=0)
	{
        //perms
		$this->etc->check_permission('PAGE');
		
		
		//set data
		$vdata['jData_Total']        = 0;
		$vdata['jData']              = $gdata['data'];
		$vdata['jData_Hidden']       = array('lang_id'=>$lang_id);

        $vdata['page_list']   = $this->config->item('PAGE_LIST');
 
        $vdata['not_step2'] = 1;
    
		//view
		$this->load->view('page.frm.php',$vdata);
		
	}
	
	
	/**
	| @name
	|      - proc_page_list
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
	function proc_page_list()
	{
    //perms
		$this->etc->check_permission('PAGE');
		
		$pdata['page_name']   = trim($this->input->get_post('page_name' ));
		
		$vdata['page_list']   = $this->config->item('PAGE_LIST');
		$pdata['show_editor'] = $vdata['page_list'][$pdata['page_name']]['show_editor'];
		$pdata['show_image'] = $vdata['page_list'][$pdata['page_name']]['show_image'];
	
        //get rec
		$gdata = $this->page->select_by_id($pdata);
   
		
		//set data
		$vdata['jData_Total']        = 0;
		$vdata['jData']              = $gdata['data'];
		$vdata['jData_Hidden']       = array('page_name'=> $pdata['page_name'],'lang_id'=>$pdata['lang_id'],'show_editor'=>$pdata['show_editor'],'show_image'=>$pdata['show_image']);

        
        $vdata['pagename'] = $pdata['page_name'];
		$vdata['show_editor'] = $pdata['show_editor'];
		$vdata['show_image'] = $pdata['show_image']==0?0:1;
		
		//view
		$this->load->view('page.frm.php',$vdata);
		
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
		$this->etc->check_permission('PAGE');

		//set p-data
		$pdata               = null;
		$pdata['page']        = trim($this->input->get_post('page' ));
		$pdata['page_name']   = trim($this->input->get_post('page_name' ));
		
        $pdata['show_editor'] = trim($this->input->get_post('show_editor' ));
        $page_name = $pdata['page_name'];
    
        //get rec
		$gdata = $this->page->select_by_id( array('page_name' => $pdata['page_name']) );
		
		if($gdata['data']->show_editor)
		{
            //set rules
            $this->form_validation->set_rules('page',  'Page Content',     'trim|required');
		}
		else
		{
            $this->form_validation->set_rules('page',  'Page Content',     'trim');
        }

		if($_FILES["file"]["size"]!=0)
        {
            if ((($_FILES["file"]["type"] != "image/gif")
              && ($_FILES["file"]["type"] != "image/jpeg")
              && ($_FILES["file"]["type"] != "image/pjpeg")
              && ($_FILES["file"]["type"] != "image/png"))
                  || $_FILES["file"]["error"] > 0 )
            {

    
                //$this->etc->set_error_message('Invalid file. (Only support .jpg/.png/.gif)');
                
                //view
                  $this->load->view('page.frm.php',$vdata);
                  return;
            }
        }
        
		
		//chk rules
		if ($this->form_validation->run() == TRUE)
		{ 
            $img =   $gdata['data']->image;
            $pdata['image'] = $img;
            
            if ($_FILES["file"]["size"]>0)
            {
            
                $img_arr = explode('.',$_FILES["file"]["name"]);
            
                $pdata['image']       =  md5(str_replace(' ','_',$page_name).$pdata['lang_id']).".".$img_arr[1];
            
            }
      
   
  		    //upd8 it;-)
  		    $ddata = $this->page->save($pdata);

            if($ddata['status'])
            {
                //copy files
                if ($_FILES["file"]["size"]>0)
                {
                  $filename = md5(str_replace(' ','_',$page_name).$pdata['lang_id']).".".$img_arr[1]; 
                  @unlink(FILEPATH_USERFILES.$img);
                  
                    $res = move_uploaded_file($_FILES["file"]["tmp_name"], FILEPATH_USERFILES.'page_header/'.$filename);
               
                
                    //resize
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = FILEPATH_USERFILES.'page_header/'.$filename;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = BANNER_HOME_WIDTH;
                    $config['height'] = BANNER_HOME_HEIGHT;
                    $config['new_image'] = FILEPATH_USERFILES.'page_header/'.$filename;
                               
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
                $this->etc->set_success_message($this->config->item('PAGE_OK_MSG'));
            
            }
            else
            {
                //set status
                $this->etc->set_error_message($this->config->item('PAGE_ERR_MSG'));
            }
      
            //fwd
            redirect(site_url('page/view/'.$pdata['lang_id']));
            return;
            
  		
		}
		else
		{
		    $vdata['jData_Total']        = 0;
  		    $vdata['jData']              = $gdata['data'];
  		    $vdata['jData_Hidden']       = array('page_name'=> $pdata['page_name']);  
            $vdata['page_list']   = $this->config->item('PAGE_LIST');
            //view
		    $this->load->view('page.frm.php',$vdata);
    }
		
		
	}
	
	

 }
/* End of file page.php */
/* Location: ./system/application/controllers/page.php */

