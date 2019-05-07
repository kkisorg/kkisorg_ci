<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: User_role_model.php
|--------------------------------------------------------------------------
| @Desc    : role model
| @Date    : 2010-04-02
| @Version : 1.0 
| @By      : bayugyug@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_role_model extends CI_Model
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
	function User_role_model()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();
	}


	/**
	| @name
	|      - add
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
	function add($pdata=null)
	{
		
		//fmt-params
		$name     = addslashes(trim($pdata['name']));
		$desc     = addslashes(trim($pdata['desc']));
		$parent   = addslashes(@intval(trim($pdata['parent'])));
		$by       = addslashes(trim($pdata['created_by']));

		//exec
		$sql = "
			 INSERT INTO user_roles (
			 	name, 
			 	description, 
			 	parentId, 
			 	created, 
			 	created_by
			 	) 
			 VALUES (
			 	'$name', 
			 	'$desc', 
			 	'$parent', 
			 	Now(), 
			 	'$by'
			 	)
		       ";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//get ref
		$ref = $this->db->insert_id();				

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");

		//return
		return array('status' => $ok, 'ref' => $ref);

	}


	/**
	| @name
	|      - update
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
	function update($pdata=null)
	{
		//fmt-params
		$id       = addslashes(trim($pdata['id']));
		$name     = addslashes(trim($pdata['name']));
		$desc     = addslashes(trim($pdata['desc']));
		$by       = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE user_roles 
			SET 
				name          = '$name', 
				description   = '$desc', 
				updated       = Now(), 
				updated_by    = '$by' 
			WHERE 
			    id='$id' 
			LIMIT 1";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();
		//tracing ;-)
		log_message("DEBUG","update() : info [ $sql : #$ok ] ");
		
		//return
		return array('status' => $ok);

	}


	/**
	| @name
	|      - delete
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
	function delete($pdata=null)
	{
		//fmt-params
		$id  = addslashes(trim($pdata['id']));

		//exec
		$sql = "DELETE FROM user_roles WHERE id='$id' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}



	/**
	| @name
	|      - select_by_id
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
	function select_by_id($pdata=null)
	{
		//fmt-params
		$data= null;
		$id  = addslashes(trim($pdata['id']));

		//exec
		$sql = "SELECT SQL_CALC_FOUND_ROWS
				* 
			FROM 
				user_roles 
			WHERE 
				id='$id' 
			LIMIT 1";
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
	|      - get
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
	function get($pdata=null)
	{
		
		//fmt-params
		$data     = array();
		$order    = addslashes(trim($pdata['order']));
		$limit    = addslashes(trim($pdata['limit']));

		//exec
		$sql = " SELECT 
				SQL_CALC_FOUND_ROWS 
				* 
			 FROM user_roles 
			
			 WHERE 1=1
			 
			     $order
			     $limit
			 ";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();
		$tot = 0;
		//get data
		if ($ok > 0)
		{
			foreach ($sth->result() as $row)
			{
			     $data[$row->id] = $row;
			}
			
			//exec
			$mtotal = $this->get_found_rows();
		}

		//tracing ;-)
		log_message("DEBUG","get() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data , 'total' => $mtotal );

	}
	
	/**
	| @name
	|      - select_by_name
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
	function select_by_name($pdata=null)
	{
		//fmt-params
		$data= null;
		$name= addslashes(trim($pdata['name']));
		$pid = addslashes(trim($pdata['id']));

		$pidwhr = ( $pdata['id']>0)?(" AND id!= '$pid' "):("");

		//exec
		$sql = "SELECT SQL_CALC_FOUND_ROWS
				* 
			FROM 
				user_roles 
			WHERE 
				name  ='$name' 
				$pidwhr 
			LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $data  = $sth->row();
		}

		//tracing ;-)
		log_message("DEBUG","select_by_name() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data  );

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
		$query = " SELECT FOUND_ROWS() as rows";
		$sth   = $this->db->query( $query );
		$row   = $sth->row_array();
		$total = intval($row['rows']);

		//just for sure
		log_message("DEBUG","get_found_rows() : total-rows = $total ");

		//give it back pls ;-)
		return $total;
	}	




}
?>