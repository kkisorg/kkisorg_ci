<?php
/*
|--------------------------------------------------------------------------
| @Filename: eventlog.php
|--------------------------------------------------------------------------
| @Desc    : user controller
| @Date    : 2010-04-02
| @Version : 1.0
| @By      : bayugyug@gmail.com
|
|
|
| @Modified By  :
| @Modified Date:
*/

class Eventlog extends CI_Controller
{

	function Eventlog()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();

		//misc
		$this->load->helper('misc');

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
		//view
		$this->view();
	}

	/**
	| @name
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
		$this->etc->check_permission('EVENT.LIST');

		$this->ajx_view(false);
	}


	/**
	| @name
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
		//perms
		$this->etc->check_permission('EVENT.LIST');

		//sorting
		$sortdata   = array(
				"remarks",
				"uri"  ,
				"created",
				"created_by");

		//fmt params
		$fdata = fmt_ajx_params($sortdata);

		//dmp
		$dmp   = @var_export($fdata,true);
		log_message("DEBUG","ajx_view() : params [ $dmp ]");

		//role-list
		$rdata = $this->event_log->get(array(
						'order' => $fdata['order'],
						'limit' => $fdata['limit'],
		                              ));
		$rlist = $rdata['data'];
		$rdata['total'] = $rdata['total']==''?0:$rdata['total'];
		//('status' => $ok, 'data' => $data , 'total' => $tot );
		$json_str = $this->fmt_jason_data(
						$rlist,
						$fdata['page'],
						$rdata['total'],
						$fdata['draw']
						);

		//fmt view data
		$vdata['jData_Total']    = @intval($rdata['total']);
		$vdata['jData_Str']      = $json_str;
		$vdata['jData_Ajax']     = true;

		//view
		if(!$v)
		   $this->load->view('eventlog.view.php',$vdata);
		else
		   echo $json_str;

	}

	/**
	| @name
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
	function fmt_jason_data($pdata=null, $page=1, $total=0, $draw=1)
	{

		//init jason-data
		$jres = "{\"draw\": $draw,
			    \"recordsTotal\" : $total,
          \"recordsFiltered\": $total,
			    \"data\": [
			   ";
		//more
		foreach($pdata as $kk => $vv)
		{
			list($ip, $uri, $meth, $qry, $ua) = @explode("\n",$vv->uri);
			//delete
			$jres .= '     [ ' .
					'"'. addslashes( $vv->remarks  )  .'",'.
					'"'. addslashes( "$ip : $uri" )   .'",'.
					'"'. addslashes( $vv->created )   .'",'.
					'"'. addslashes( $vv->created_by) .'" '.
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
	| @name
	|      - export
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
	function export()
	{

		//chk perms
		$this->etc->check_permission('EVENT.Export');

		//export it ;-)
		log_message("DEBUG","#XPORT-export [ ]");

		//fmt date-params  [array('sdt' => $sdt, 'edt' => $edt, 'disp' => $disp);]
		$this->load->helper('misc');

		$rdata      = $this->event_log->get();



		$dmp        = @var_export($rdata['data'], true);
		log_message("DEBUG","csv-data [ $dmp ]");


		//download csv
		$this->download_csv($rdata['data']);


	}

	/**
	| @name
	|      - download_csv
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - fwd the necessary header for CSV downloading
	|
	**/
	function download_csv($edata=null,$hdrs=null)
	{


		//fmt filename
		//$hdr = 'Events Log\n';
		$pre = sprintf("%s-%s", 'Events.Log', date("Ymd"));;

		//load helper
		$this->load->helper('misc');
		$csv = u_generate_uuid("$pre-").'.csv';
		$more= @count($edata);
		$rec = null;

		for($i=0; $i<$more; $i++)
		{
			$jdata   = $edata[$i];

			$dmp     = @var_export($pdata, true);

			log_message('DEBUG',"download_csv() : dmp# [ $dmp ]");

			$j = 0;
			foreach($jdata as $k=>$v)
		  {
         $pdata[$j] = $v;
         $j++;
      }

			$rec    .= @join(',',array(
							"\"$pdata[0]\"",
							"\"$pdata[1]\"",
							"\"$pdata[2]\"",
							"\"$pdata[3]\"",
				         ) )."\n";
		}
		//helper ;-)
		set_downloadable_csv($rec, $hdr, $csv);
		die();
	}

 }
/* End of file welcome.php */
/* Location: ./system/application/controllers/user.php */
