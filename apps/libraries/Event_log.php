<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: Event_Log.php
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

class Event_log
{
	//private ;-)
	protected $CI;

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
		//loaders here ;-)
		//get obj
		$this->CI  =& get_instance();
		$this->CI->load->database();
	}


	/**
	| @name
	|      - dump
	|
	| @params
	|      -
	|
	| @return
	|      - ref-id
	|
	| @description
	|      -
	|
	**/
	function dump($msg=null)
	{
		$this->dmp($msg);
	}

	/**
	| @name
	|      - dmp
	|
	| @params
	|      -
	|
	| @return
	|      - ref-id
	|
	| @description
	|      -
	|
	**/
	function dmp($msg=null)
	{
		 //fmt-params
		$msg      = addslashes(trim($msg));
		$by       = addslashes(trim($this->CI->etc->get_created_by()));
		$uri      = @implode("\n", array(
					 $_SERVER['REMOTE_ADDR'],
					 $_SERVER['REQUEST_URI'],
					 $_SERVER['REQUEST_METHOD'],
					 $_SERVER['QUERY_STRING'],
					 $_SERVER['HTTP_USER_AGENT'],
				    ));
		$uri      = addslashes(trim($uri));


		//exec
		$sql = "
			 INSERT INTO event_log (
			 	remarks,
			 	uri,
			 	created,
			 	created_by
			 	)
			 VALUES (
			 	'$msg',
			 	'$uri',
			 	Now(),
			 	'$by'
			 	)
		       ";

		$sth = $this->CI->db->query($sql);
		$ok  = $this->CI->db->affected_rows();

		//get ref
		$ref = $this->CI->db->insert_id();

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");

		//return
		return array('status' => $ok, 'ref' => $ref);

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
		$limit    = addslashes(trim($pdata['limit'] ));

		//exec
		$sql = " SELECT
				SQL_CALC_FOUND_ROWS
				a.remarks,
				a.uri,
				a.created,
				(SELECT name FROM user WHERE id=a.created_by ) AS created_by
			 FROM event_log  a

			 WHERE 1=1

			     $order
			     $limit
			 ";
		$sth = $this->CI->db->query($sql);
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
		$sth   = $this->CI->db->query( $query );
		$row   = $sth->row_array();
		$total = intval($row['rows']);

		//just for sure
		log_message("DEBUG","get_found_rows() : total-rows = $total ");

		//give it back pls ;-)
		return $total;
	}




}
?>
