<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: System_settings_model.php
|--------------------------------------------------------------------------
| @Desc    : System_settings_model
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

class System_settings_model extends CI_Model
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
	function System_settings_model()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();
		
		//more
	}


/**
	| @name
	|      - select_sys_settings
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
	function select_sys_settings()
	{

		//exec
		$sql = "SELECT 
  				sys_v
			 FROM
			     sys_settings
			 WHERE  sys_k='BTF_MAIL_URL'
			";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $mail_url  = $sth->row()->sys_v;
		}

		//tracing ;-)
		log_message("DEBUG","select_sys_settings() : info [ $sql : #$ok ] ");
		
		//exec
		$sql = "SELECT 
  				sys_v
			 FROM
			     sys_settings
			 WHERE  sys_k='BTF_YM'
			";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $ym  = $sth->row()->sys_v;
		}

		//tracing ;-)
		log_message("DEBUG","select_sys_settings() : info [ $sql : #$ok ] ");
		
		//exec
		$sql = "SELECT 
  				sys_v
			 FROM
			     sys_settings
			 WHERE  sys_k='BTF_TWITTER'
			";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $twitter  = $sth->row()->sys_v;
		}

		//tracing ;-)
		log_message("DEBUG","select_sys_settings() : info [ $sql : #$ok ] ");
		
		//exec
		$sql = "SELECT 
  				sys_v
			 FROM
			     sys_settings
			 WHERE  sys_k='BTF_FB'
			";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $fb  = $sth->row()->sys_v;
		}

		//tracing ;-)
		log_message("DEBUG","select_sys_settings() : info [ $sql : #$ok ] ");

    $data = array('mail'=>$mail_url, 'ym'=>$ym, 'twitter'=>$twitter, 'fb'=>$fb);
    
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
	function save($pdata=null)
	{

		//fmt-params
		$mail_url           = addslashes(trim($pdata['mail'] ));
		$ym      = addslashes(trim($pdata['ym']));
		$twitter      = addslashes(trim($pdata['twitter']));
		$fb         = addslashes(trim($pdata['fb']));

    
		$sql = "delete from sys_settings where sys_k in ('BTF_MAIL_URL','BTF_YM','BTF_TWITTER','BTF_FB')";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete() : info [ $sql : #$ok #$ref ] ");
		
		
		//exec
		$sql = "
			INSERT INTO sys_settings (
				sys_k  ,
				sys_v  ,
				datein ,
				timein
			) 
			VALUES (
				'BTF_MAIL_URL'   ,
				'$mail_url'  ,
				curdate() , 
				curtime() 
			)		       
			";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");
		
		//exec
		$sql = "
			INSERT INTO sys_settings (
				sys_k  ,
				sys_v  ,
				datein ,
				timein
			) 
			VALUES (
				'BTF_YM'   ,
				'$ym'  ,
				curdate() , 
				curtime() 
			)		       
			";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");
		
		//exec
		$sql = "
			INSERT INTO sys_settings (
				sys_k  ,
				sys_v  ,
				datein ,
				timein
			) 
			VALUES (
				'BTF_TWITTER'   ,
				'$twitter'  ,
				curdate() , 
				curtime() 
			)		       
			";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();
		
		//exec
		$sql = "
			INSERT INTO sys_settings (
				sys_k  ,
				sys_v  ,
				datein ,
				timein
			) 
			VALUES (
				'BTF_FB'   ,
				'$fb'  ,
				curdate() , 
				curtime() 
			)		       
			";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");
		

    
    
    
    return array('status'=>$ok);
	}   

	
	

}
?>