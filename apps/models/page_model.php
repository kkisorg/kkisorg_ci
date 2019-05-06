<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: Page_model.php
|--------------------------------------------------------------------------
| @Desc    : Page_model
| @Date    : 2011-05-10
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends Model
{

	/**
	| @name
	|      - constructor
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
	function Page_model()
	{
		parent::Model();

		//loaders here ;-)
		$this->load->database();
		
		//more
	}


/**
	| @name
	|      - select_page
	|
	| @params
	|      - 
	|
	| @return
	|      - result set + status
	|
	| @description
	|      - 
	|
	**/	
	function select_by_id($pdata)
	{
        $page_name = addslashes(trim($pdata['page_name']));
        
		//exec
		$sql = "SELECT
          *
			 FROM
			     pages
			 WHERE  page_k='$page_name'
			";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $data  = $sth->row();
		}

		//tracing ;-)
		log_message("DEBUG","select_by_id() : info [ $sql : #$ok ] ");
		
		//return
		return array('status' => $ok, 'data' => $data  );


	}

	
  
  /**
	| @name
	|      - save
	|
	| @params
	|      - 
	|
	| @return
	|      - result set + status + ref-id
	|
	| @description
	|      - 
	|
	**/		
	function save($pdata)
	{

		//fmt-params
		$page_name           = addslashes(trim($pdata['page_name'] ));
		$page           = addslashes(trim($pdata['page'] ));
		$image          = addslashes(trim($pdata['image'] ));
		$show_editor             = addslashes(trim($pdata['show_editor'] ));

        $res = $this->select_by_id($pdata);
        
        if($res['status']==0)
        {
            $sql = "insert into
                    pages(page_k,page_v,image,show_editor,datein,timein)
                    values('$page_name','$page','$image','$show_editor',curdate(),curtime())
                    ";
                    
            $sth = $this->db->query($sql);
            $ok  = $this->db->affected_rows();
    
            //tracing ;-)
            log_message("DEBUG","save() : info [ $sql : #$ok #$ref ] ");
        }
        else
        {
            if($image!='')
            { $upd_img = ",image = '$image'"; }
            
            $sql = "update  
                  pages 
                set 
                  page_v = '$page',
                  show_editor = '$show_editor'
                  $upd_img
                where
                  page_k = '$page_name' limit 1";
            $sth = $this->db->query($sql);
            $ok  = $this->db->affected_rows();
    
            //tracing ;-)
            log_message("DEBUG","update() : info [ $sql : #$ok #$ref ] ");
		}

    return array('status'=>$ok);
	}
	
	
	/**
	| @title
	|      - get_data_page
	|
	| @params
	|      - 
	|
	| @return
	|      -
	|
	| @description
	|      - result set + status
	|
	**/
	function get_data_page($pdata=null)
	{
		
		//fmt-params
		$data     = array();
        $page_k  = strtolower(addslashes(trim($pdata['key'])));
        
      
		//exec
		$sql = " SELECT 
				SQL_CALC_FOUND_ROWS 
				* 
			 FROM pages
			
			 WHERE 1=1
			 AND LOWER(page_k) = '$page_k'  
			 LIMIT 1   
			 ";

		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();
		$tot = 0;
		
		//get data
		if ($ok > 0)
		{
			foreach ($sth->result() as $row)
			{
			     $data[] = $row;
			}
			
			//exec
			$mtotal = $this->get_found_rows();
		}
		
		//tracing ;-)
		log_message("DEBUG","get_data_page() : info [ $sql : #$ok ] ");
		
		

		//return
		return $data[0];

	}
	
	/**
	| @name
	|      - get_found_rows
	|
	| @params
	|      - 
	|
	| @return
	|      -
	|
	| @description
	|      - get max rows of the select ( as if there's no LIMIT clause )
	|
	**/
	function get_found_rows()
	{
		//init
		$total = 0;
		$sql   = " SELECT FOUND_ROWS() as rows";
		$sth   = $this->db->query( $sql );
		$row   = $sth->row_array();
		$total = intval($row['rows']);

		//just for sure
		log_message("DEBUG","get_found_rows() : total-rows = $total ");

		//give it back pls ;-)
		return $total;
	}	
  

	
  


}
?>