<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: Dombaku_model.php
|--------------------------------------------------------------------------
| @Desc    : Dombaku model
| @Date    : 2012-06-16
| @Version : 1.0
| @By      : gabriela.kartika@gmail.com
|
|
|
| @Modified By  :
| @Modified Date:
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dombaku_model extends CI_Model
{

	/**
	| @title
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

		//more
	}


	/**
	| @title
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
		$title         = addslashes(trim($pdata['title']));
		$short_desc   = addslashes(trim($pdata['short_desc'] ));
    	$image     		= addslashes(trim($pdata['image'] ));
		$publish      = addslashes(trim($pdata['publish'] ));
		$by           = addslashes(trim($pdata['created_by']));

		//exec
		$sql = "
			 INSERT INTO dombaku (
			 	title,
			 	short_desc,
			 	publish,
			 	datein,
			 	timein,
			 	created_by
			 	)
			 VALUES (
			 	'$title',
			 	'$short_desc',
			 	'$publish',
			 	curdate(),
			 	curtime(),
			 	'$by'
			 	)
		       ";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();

		//get ref
		$ref = $this->db->insert_id();

		//tracing ;-)
		log_message("DEBUG","add() : info [ $sql : #$ok #$ref ] ");

		//update image
    if($image!='')
    {
      $image = "dombaku_".$ref.".".$image;

      //exec
  		$sql = "UPDATE dombaku

  						SET
  						    image                       =  '$image',
  							updated                       =  now()

  						WHERE
  						    id='$ref'
  						LIMIT 1";

  		$sth = $this->db->query($sql);
  		$ok  = $this->db->affected_rows();

  		//tracing ;-)
		  log_message("DEBUG","add image() : info [ $sql : #$ok  ] ");
    }

		//return
		return array('status' => $ok, 'ref' => $ref);

	}


	/**
	| @title
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

    	//fmt-params
	  	$title         = addslashes(trim($pdata['title']));
		$short_desc   = addslashes(trim($pdata['short_desc'] ));
    	$image     		= addslashes(trim($pdata['image'] ));
		$publish      = addslashes(trim($pdata['publish'] ));

		$by         = addslashes(trim($pdata['updated_by']));

    	if($image!='')
    	{
      		$upd_img = "image =  '$image',";
    	}

		//exec
		$sql = "UPDATE dombaku
				SET
				title    = '$title',
				short_desc   = '$short_desc',
			  	$upd_img
			  	publish       = '$publish',
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
	| @title
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
		$id       = addslashes(trim($pdata['id']));
		$by       = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "UPDATE dombaku
			SET
				status        = '0',
				updated       = Now(),
				updated_by    = '$by'
			WHERE
			    id='$id'
			LIMIT 1";

		$sth = $this->db->query($sql);
		$ok  = $this->db->affected_rows();
		//tracing ;-)
		log_message("DEBUG","delete() : info [ $sql : #$ok ] ");

		//return
		return array('status' => $ok);

	}


	/**
	| @title
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
				dombaku
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
	| @title
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
		$where    = trim($pdata['where'] );

		//exec
		$sql = " SELECT
				SQL_CALC_FOUND_ROWS
				*
			 FROM dombaku

			 WHERE 1=1

			 AND status = 1

			     $where

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
	| @title
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
		$sql   = " SELECT FOUND_ROWS() as `rows`";
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
