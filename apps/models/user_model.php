<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: User_model.php
|--------------------------------------------------------------------------
| @Desc    : user model
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

class User_model extends CI_Model
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
	function __construct()
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
		$email    = addslashes(trim($pdata['email']));
		$country  = addslashes(trim($pdata['country']));
		$mobile   = addslashes(trim($pdata['mobile']));
		$pass     = addslashes(trim($pdata['pass']));
		$name     = addslashes(trim($pdata['name']));
		$by       = addslashes(trim($pdata['created_by']));
		$role     = addslashes(trim($pdata['role']));
		$status   = addslashes(trim($pdata['status']));

		$expiry   = addslashes( trim($pdata['pass_expiry_days']));

		//exec
		$sql = "
			 INSERT INTO user (
			 	name,
			 	email,
			 	country,
			 	mobile,
			 	pass,
			 	role,
			 	status,
			 	pass_expiry_days,
			 	pass_expiry,
			 	created,
			 	created_by
			 	)
			 VALUES (
			 	'$name',
			 	'$email',
			 	'$country',
			 	'$mobile',
			 	'$pass',
			 	'$role',
			 	'$status',
			 	'$expiry',
			 	DATE_ADD(Now(), INTERVAL $expiry DAY),
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
		$email    = addslashes(trim($pdata['email']));
		$name     = addslashes(trim($pdata['name']));
		$country  = addslashes(trim($pdata['country']));
		$mobile   = addslashes(trim($pdata['mobile']));
		$role     = addslashes(trim($pdata['role']));
		$status   = addslashes(trim($pdata['status']));
		$by       = addslashes(trim($pdata['updated_by']));
		$expiry   = addslashes(trim($pdata['pass_expiry_days']));
		//exec
		$sql = "UPDATE user
			SET
				country   = '$country',
				mobile    = '$mobile',
				name      = '$name'  ,
				role      = '$role'  ,
				status    = '$status',
				pass_expiry_days = '$expiry',
			 	pass_expiry      = DATE_ADD(Now(), INTERVAL $expiry DAY),
				updated          = Now(),
				updated_by       = '$by'
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
		$sql = "DELETE FROM user WHERE id='$id' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","delete() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}



	/**
	| @name
	|      - select_by_mail
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
	function select_by_mail($pdata=null)
	{
		//fmt-params
		$data= null;
		$mail= addslashes(trim($pdata['mail']));
		$pid = addslashes(trim($pdata['id']));

		$pidwhr = ( $pdata['id']>0)?(" AND id!= '$pid' "):("");

		//exec
		$sql = "SELECT SQL_CALC_FOUND_ROWS
				* ,
				Now() > pass_expiry AS expired
			FROM
				user
			WHERE
				email  ='$mail'
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
		log_message("DEBUG","select_by_mail() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data  );

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
				* ,
				Now() > pass_expiry AS expired
			FROM
				user
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
		$id  = addslashes(trim($pdata['id']));
		$st  = addslashes(trim($pdata['status']));
		$by  = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE
				user
			SET
				status    ='$st' ,
				updated   =Now(),
				updated_by='$by'
			WHERE
				id='$id'
			LIMIT 1";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","set_status() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok);

	}


	/**
	| @name
	|      - set_wrong_pass
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
	function set_wrong_pass($pdata=null)
	{
		//fmt-params
		$id  = addslashes(trim($pdata['id']));
		$by  = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE
				user
			SET
				wrong     = wrong+1 ,
				updated   = Now(),
				updated_by= '$by'
			WHERE
				id='$id'
			LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","set_wrong_pass() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}
	/**
	| @name
	|      - rset_wrong_pass
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
	function rset_wrong_pass($pdata=null)
	{
		//fmt-params
		$id  = addslashes(trim($pdata['id']));
		$by  = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE
				user
			SET
				wrong     = 0 ,
				updated   = Now(),
				updated_by= '$by'
			WHERE
				id='$id'
			LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","rset_wrong_pass() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

	}

	/**
	| @name
	|      - set_login_ts
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
	function set_login_ts($pdata=null)
	{
		//fmt-params
		$id  = addslashes(trim($pdata['id']));

		//exec
		$sql = "UPDATE user SET  login=Now()  WHERE id='$id' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();


		//tracing ;-)
		log_message("DEBUG","set_login_ts() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok);

	}

	/**
	| @name
	|      - reset_login_ts
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
	function reset_login_ts($pdata=null)
	{
		//fmt-params
		$id  = addslashes(trim($pdata['id']));

		//exec
		$sql = "UPDATE user SET  login=NULL  WHERE id='$id' LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();


		//tracing ;-)
		log_message("DEBUG","set_login_ts() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok);

	}


	/**
	| @name
	|      - set_password
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
	function set_password($pdata=null)
	{

		//fmt-params
		$id  = addslashes(trim($pdata['id']));
		$pwd = addslashes(trim($pdata['pass']));//hash it in the controller
		$by  = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE user
			SET
				pass      = '$pwd',
				updated   = Now(),
				updated_by= '$by'
			WHERE
				id='$id'
			LIMIT 1";
		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//tracing ;-)
		log_message("DEBUG","set_password() : info [ $sql : #$ok ] ");


		//return
		return array('status' => $ok);

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
		$order    = isset($pdata['order']) ? addslashes(trim($pdata['order'])) : null;
		$limit    = isset($pdata['limit']) ? addslashes(trim($pdata['limit'])) : null;

		//exec
		$sql = " SELECT
				SQL_CALC_FOUND_ROWS
				*
			 FROM user

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
			$tot = $this->get_found_rows();
		}

		//tracing ;-)
		log_message("DEBUG","get() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok, 'data' => $data , 'total' => $tot );

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
		$query = " SELECT FOUND_ROWS() as `rows`";
		$sth   = $this->db->query( $query );
		$row   = $sth->row_array();
		$total = intval($row['rows']);

		//just for sure
		log_message("DEBUG","get_found_rows() : total-rows = $total ");

		//give it back pls ;-)
		return $total;
	}





	/**
	| @name
	|      - bfr_usr
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set user bfr
	|
	**/
	function bfr_usr($email='', $hash='', $kk='', $bfr='')
	{

		//fmt
		$email= addslashes( trim($email ));
		$hash = addslashes( trim($hash  ));
		$kk   = addslashes( trim($kk    ));
		$bfr  = addslashes( trim($bfr   ));

		//Insert to table
		$sql = "INSERT INTO user_buffer (
				email  ,
				hash   ,
				kk     ,
				bfr    ,
				created
				)
				VALUES(
				'$email'  ,
				'$hash'   ,
				'$kk'     ,
				'$bfr'    ,
				Now()
				)
			";
		$sth = $this->db->query($sql);

		if (!$sth) //Error adding rec
		{
		    return query_error_result(-2);
		}

		//Success
		$insert_id = $this->db->insert_id();

		log_message("DEBUG","bfr_usr() : info [ $sql : #$insert_id ] ");


		return $insert_id; //return the result_id instead
	}



	/**
	| @name
	|      - get_bfr_usr
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set user bfr
	|
	**/
	function get_bfr_usr($id='',$hash='')
	{


		//fmt
		$id    = addslashes($id);
		$email = addslashes($email);
		$hash  = addslashes($hash);
		//exec
		$sql   = "SELECT * FROM  user_buffer WHERE id='$id' AND hash='$hash' LIMIT 1";
		$sth   = $this->db->query($sql);
		$ok    = $sth->num_rows();
		$data  = array();

		log_message("DEBUG","get_bfr_usr() : info [ $sql : #$ok ] ");

		//get data
		if ($ok > 0)
		{
			$data  = $sth->row();
		}

		//return
		return array('status' => $ok, 'data' => $data  );
	}


	/**
	| @name
	|      - set_bfr_usr
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - set user bfr
	|
	**/
	function set_bfr_usr($id='')
	{

	    //fmt-params
	    $id  = addslashes(trim($id));


	    //exec
	    $sql = "UPDATE  user_buffer SET status=status+1 , updated=Now() WHERE id='$id' LIMIT 1";
	    $sth = $this->db->query($sql);
	    $ok  = $this->db->affected_rows();

	    log_message("DEBUG","set_bfr_usr() : info [ $sql : #$ok ] ");

	    //return
	    return array('status' => $ok);

	}

	/**
	| @name
	|      - update_profile
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
	function update_profile($pdata=null)
	{
		//fmt-params
		$id       = addslashes(trim($pdata['id']));
		$email    = addslashes(trim($pdata['email']));
		$country  = addslashes(trim($pdata['country']));
		$mobile   = addslashes(trim($pdata['mobile']));
		$by       = addslashes(trim($pdata['updated_by']));
		$name     = addslashes(trim($pdata['name']));
		//exec
		$sql = "UPDATE user
			SET
				country   = '$country',
				mobile    = '$mobile',
				name      = '$name',
				updated          = Now(),
				updated_by       = '$by'
			WHERE
			    id='$id'
			LIMIT 1";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();
		//tracing ;-)
		log_message("DEBUG","update_profile() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok);

	}

}//class
?>
