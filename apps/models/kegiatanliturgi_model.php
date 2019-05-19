<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| @Filename: Kegiatanliturgi.php
|--------------------------------------------------------------------------
| @Desc    : kegiatan_liturgi model
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

class Kegiatanliturgi_model extends CI_Model
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
	| @contentription
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
	| @name
	|      - add
	|
	| @params
	|      -
	|
	| @return
	|      - result set + status + ref-id
	|
	| @contentription
	|      -
	|
	**/
	function add($pdata=null)
	{

		//fmt-params
		$name         = addslashes(trim($pdata['name']));
		$content   = addslashes(trim($pdata['content'] ));
		$publish      = addslashes(trim($pdata['publish'] ));
		$by           = addslashes(trim($pdata['created_by']));

		//exec
		$sql = "
			 INSERT INTO kegiatan_liturgi (
			 	kegiatan_title,
			 	kegiatan_content,
			 	display,
			 	created_date,
			 	created_by
			 	)
			 VALUES (
			 	'$name',
        		'$content',
			 	'$publish',
			 	now(),
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
	| @contentription
	|      -
	|
	**/
	function update($pdata=null)
	{
		//fmt-params
		$id       = addslashes(trim($pdata['id']));

    	//fmt-params
	  	$name         = addslashes(trim($pdata['name']));
		$content   = addslashes(trim($pdata['content'] ));
		$publish      = addslashes(trim($pdata['publish'] ));
		$by         = addslashes(trim($pdata['updated_by']));


		//exec
		$sql = "UPDATE kegiatan_liturgi
				SET
				kegiatan_title    = '$name',
				kegiatan_content   = '$content',
			  	display       = '$publish',
				modified_date       = Now(),
				modified_by    = '$by'
			WHERE
			    kegiatan_id='$id'
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
	| @contentription
	|      -
	|
	**/
	function delete($pdata=null)
	{
		//fmt-params
		$id       = addslashes(trim($pdata['id']));
		$by       = addslashes(trim($pdata['updated_by']));

		//exec
		$sql = "DELETE FROM kegiatan_liturgi
			WHERE
			    kegiatan_id='$id'
			LIMIT 1";

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
	| @contentription
	|      -
	|
	**/
	function select_by_id($pdata=null)
	{
		//fmt-params
		$data= null;
		$id  = addslashes(trim($pdata['id']));
        $where = $pdata['where'];

		//exec
		$sql = "SELECT SQL_CALC_FOUND_ROWS
				*
			FROM
				kegiatan_liturgi
			WHERE
				kegiatan_id='$id'
				$where
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
	| @contentription
	|      - result set + status
	|
	**/
	function get($pdata=null)
	{

		//fmt-params
		$data     = array();
        $order    = isset($pdata['order']) ? trim($pdata['order']) : ' ORDER BY kegiatan_id desc ';
		$limit    = isset($pdata['limit']) ? trim($pdata['limit']) : null;
		$where    = isset($pdata['where']) ? trim($pdata['where']) : null;

		//exec
		$sql = " SELECT
				SQL_CALC_FOUND_ROWS
				*
			 FROM kegiatan_liturgi

			 WHERE 1=1


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
	| @name
	|      - get_found_rows
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @contentription
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
