<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: User_permission_model.php
|--------------------------------------------------------------------------
| @Desc    : permission model
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

class User_permission_model extends CI_Model
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
	function User_permission_model()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();
		
		//more
		$this->load->model('User_role_model','user_role_model');

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
		$role     = addslashes(trim($pdata['role']));
		$resource = addslashes(trim($pdata['resource']));
		$status   = addslashes(trim($pdata['status']));
		$by       = addslashes(trim($pdata['created_by']));

		//exec
		$sql = "
			 INSERT INTO user_permissions (
			 	role, 
			 	resource, 
			 	status, 
			 	created, 
			 	created_by
			 	) 
			 VALUES (
			 	'$role', 
			 	'$resource', 
			 	'$status', 
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
		$role     = addslashes(trim($pdata['role']));
		$resource = addslashes(trim($pdata['resource']));
		$status   = addslashes(trim($pdata['status']));
		$by       = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE user_permissions 
			SET 
				role          = '$name', 
				resource      = '$desc', 
				status        = '$status', 
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
	|      - set_status
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
	function set_status($pdata=null)
	{
		//fmt-params
		$id       = addslashes(trim($pdata['id']));
		$status   = addslashes(trim($pdata['status']));
		$by       = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE user_permissions 
			SET 
				status        = '$status', 
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
		$sql = "DELETE FROM user_permissions WHERE id='$id' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}


	/**
	| @name
	|      - delete_all
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
	function delete_all($filter='')
	{
		//fmt-params
		$filter = addslashes(trim($filter));
		$xwhere = (strlen($filter)) ? (" AND role != '$filter' ") : ('');
		
		//exec
		$sql = "DELETE FROM user_permissions WHERE 1=1 $xwhere  ";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete_all() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}
	
	/**
	| @name
	|      - delete_by_pair
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
	function delete_by_pair($pdata=null)
	{
		//fmt-params
		$role= addslashes(intval(trim($pdata['role']    )));
		$res = addslashes(intval(trim($pdata['resource'])));

		//exec
		$sql = "DELETE FROM user_permissions WHERE role='$role' AND resource='$res' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete_by_pair() : info [ $sql : #$ok ] ");


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
				user_permissions 
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
	|      - select_by_pair
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
	function select_by_pair($pdata=null)
	{
		//fmt-params
		$data= null;
		$role  = addslashes(trim($pdata['role']));
		$res   = addslashes(trim($pdata['resource']));

		//exec
		$sql = "SELECT SQL_CALC_FOUND_ROWS
				* 
			FROM 
				user_permissions 
			WHERE 
				role     = '$role' 
				
				AND
				
				resource = '$res'
				
			ORDER BY id ASC
			
			LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $sth->num_rows();

		//get data
		if ($ok > 0)
		{
		   $data  = $sth->row();
		}

		//tracing ;-)
		log_message("DEBUG","select_by_role() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data  ,'flag' => $ok ? @intval($data->status) : 0 );


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
		$order    = trim($pdata['order']);
		$limit    = trim($pdata['limit'] );

		//exec
		$sql = " SELECT 
				SQL_CALC_FOUND_ROWS 
				* 
			 FROM user_permissions
			
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
			     $data[] = $row;
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


	/**
	| @name
	|      - getX
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
	function getX($pdata=null)
	{
		
		//fmt-params
		$data     = array();
		$order    = addslashes(trim($pdata['order']));
		$limit    = addslashes(trim($pdata['limit']));

		//exec
		$sql = " SELECT 
				SQL_CALC_FOUND_ROWS 
				b.id   as resource,
				b.name as resource_name,
				a.id   as role, 
				a.name as role_name,
				( SELECT status FROM user_permissions WHERE role=a.id AND resource=b.id ) AS status 

			FROM

				user_roles a,

				user_resources b

			ORDER BY 1,3

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
				//get all roles
				$data[] = $row;
			}
			
			//exec
			$mtotal = $this->get_found_rows();
		}

		//tracing ;-)
		log_message("DEBUG","getX() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data , 'total' => $mtotal );

	}



}
?>