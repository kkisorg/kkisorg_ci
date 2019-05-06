<?php
/*
|--------------------------------------------------------------------------
| System Wide Helper
|--------------------------------------------------------------------------
| @Desc    : 
| @Date    : 2011-04-27 
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|
|
| @Modified By  :  
| @Modified Date: 
*/

 
/**
*
*  @u_remember_me_set
*
*  @description
*      - set the remember me
*        
*
*  @parameters
*      - id/email
*
*  @return
*      -  
*              
*/
if ( ! function_exists('u_remember_me_set'))
{
	function u_remember_me_set($remember_me='')
	{
		//get obj
		$CI  =& get_instance();
		$CI->load->helper('cookie');
		
		//get
		$kuki_name = DEFAULT_REMEMBER_ME_COOKIE_NAME;
		$kuki_max  = DEFAULT_REMEMBER_ME_COOKIE_MAX;
		$raw       = get_cookie($kuki_name);
		$ip        = $_SERVER['REMOTE_ADDR'];
		delete_cookie($kuki_name);
		
		//set
		$res       = $remember_me;
		//We must be setting the remember me setting
		$cookie    = array(
		                   'name'   => $kuki_name,
		                   'value'  => $res,
		                   'expire' => (60*60*24*$kuki_max),
		                  );
		log_message("DEBUG","u_remember_me_set($ip) : set-info#$res [ $remember_me : $raw ]");
		
		$dmp       = @var_export($_COOKIE,true);
		log_message("DEBUG","u_remember_me_set($ip) : pre-info# [ $dmp ]");
		
		//set it ;-)
		set_cookie($cookie);
		
		$dmp       = @var_export($_COOKIE,true);
		log_message("DEBUG","u_remember_me_set($ip) : post-info# [ $dmp ]");

		//give it back ;-)
		return true;
	}
}

/**
*
*  @u_remember_me_get
*
*  @description
*      - get the remember me
*        
*
*  @parameters
*      - 
*
*  @return
*      - true/false
*              
*/
if ( ! function_exists('u_remember_me_get'))
{
	function u_remember_me_get()
	{
		//get obj
		$CI  =& get_instance();
		$CI->load->helper('cookie');
		
		//get
		$kuki_name = DEFAULT_REMEMBER_ME_COOKIE_NAME;
		$raw       = trim(get_cookie($kuki_name));
		$dmp       = @var_export($_COOKIE,true);
		$ip        = $_SERVER['REMOTE_ADDR'];
		log_message("DEBUG","u_remember_me_get($ip) : info#$kuki_name [ $raw : $dmp ]");
		
		//give it back ;-)
		return $raw;
	}
}


/**
*
*  @u_remember_me_decrypt
*
*  @description
*      - double-check the cookie value
*        
*
*  @parameters
*      - raw
*
*  @return
*      - result
*              
*/
if ( ! function_exists('u_remember_me_decrypt'))
{
	function u_remember_me_decrypt($raw='')
	{
		//fmt
		$raw         = trim($raw);
		if(!strlen($raw)) return null;
		
		//get obj
		$CI          =& get_instance();
		$hash        = DEFAULT_ENC_HASH;
		$more_hash   = DEFAULT_ENC_HASH_MORE;
		$ip          = $_SERVER['REMOTE_ADDR'];
		//get hash
		list($x1,$ehash,$fhash,$x2) = @explode('-', $raw,4);
		
		
		
		//decrypt ;-)
		$res         = substr($ehash, 4, strlen($ehash)-8);
		$res         = strrev("$res");
		
		
		$fhash_raw   = @md5( $hash . $more_hash .$res );
		
		
		log_message("DEBUG","u_remember_me_decrypt($ip) : fhash#$fhash_raw:$fhash [ raw=$raw ]");
		
		
		//calc
		$status      = (strlen($x1) and strlen($x2) and strlen($res) and $fhash_raw == $fhash) ? ($res) : (null);
		log_message("DEBUG","u_remember_me_decrypt($ip) : info#$status:$res [ $x1,$ehash,$x2 ]");
		
		
		//give it back ;-)
		return $status;
	}
}

/**
*
*  @u_remember_me_encrypt
*
*  @description
*      - calculate the uniq id
*        
*
*  @parameters
*      - prefix
*
*  @return
*      - uniq-id
*              
*/
if ( ! function_exists('u_remember_me_encrypt'))
{
	function u_remember_me_encrypt($pfx='')
	{
		//fmt
		$pfx         = trim($pfx);
		if(!strlen($pfx)) return null;

		//calc		
		$tok1      = hash('sha1',uniqid(rand(), true));
		$tok2      = hash('sha1',uniqid(rand(), true));
		//more
		$mtok1       = substr($tok1,-8);
		$mtok2       = substr($tok2,-8);
		$ip          = $_SERVER['REMOTE_ADDR'];
		
		$mtok1a      = substr($tok1,0,4);
		$mtok2a      = substr($tok2,0,4);
		$pfx         = strrev("$pfx");
		
		//get obj
		$CI          =& get_instance();
		$hash        = DEFAULT_ENC_HASH;
		$more_hash   = DEFAULT_ENC_HASH_MORE;
		$fhash       = @md5( $hash . $more_hash .$pfx );
		
		log_message("DEBUG","u_remember_me_encrypt($ip) : fhash#$fhash [ raw=$pfx ]");
		
		$ref_id      = sprintf("%s-%s-%s-%s",
					$mtok1, 
					$mtok1a.$pfx.$mtok2a,//@md5( $hash . $more_hash .$pfx ),
					$fhash,
					$mtok2
				      );
		
		log_message("DEBUG","u_remember_me_encrypt($ip) : info#$pfx [ $ref_id ]");
		//give it back ;-)
		return $ref_id;
	}
}
/**
*
*  @u_remember_me_unset
*
*  @description
*      - un-set the remember me
*        
*
*  @parameters
*      - id/email
*
*  @return
*      -  
*              
*/
if ( ! function_exists('u_remember_me_unset'))
{
	function u_remember_me_unset()
	{
		//get obj
		$CI  =& get_instance();
		$CI->load->helper('cookie');
		
		//get
		$kuki_name = DEFAULT_REMEMBER_ME_COOKIE_NAME;
		$ip        = $_SERVER['REMOTE_ADDR'];
		log_message("DEBUG","u_remember_me_unset($ip) : un-set-info#$kuki_name [ ]");
		
		$dmp       = @var_export($_COOKIE,true);
		log_message("DEBUG","u_remember_me_unset($ip) : pre-info# [ $dmp  ]");

		//refresh
		delete_cookie($kuki_name);
		$dmp       = @var_export($_COOKIE,true);
		log_message("DEBUG","u_remember_me_unset($ip) : post-info# [ $dmp  ]");

		u_remember_me_get();//just for debugging
		//give it back ;-)
		return true;
	}
}


/**
*
*  @u_send_mail
*
*  @description
*      - send email
*        
*
*  @parameters
*      - 
*
*  @return
*      - void
*              
*/
if ( ! function_exists('u_send_mail'))
{
	function u_send_mail($pdata=null)
	{
		//get obj
		$CI  =& get_instance();
		$CI->load->library('email');
		
		//fmt params
		$frm = trim($pdata['from']);
		$to  = trim($pdata['to'  ]);
		$cc  = trim($pdata['cc'  ]);
		$bcc = trim($pdata['bcc' ]);
		$sub = trim($pdata['sub' ]);
		$msg = trim($pdata['msg' ]);
		
		//double-chk
		if(!strlen($frm)) $frm = $CI->config->item('DEFAULT_FROM_EMAIL');
		if(!strlen($sub)) $sub = $CI->config->item('DEFAULT_SUBJ_EMAIL');
		
		//to+from
		$CI->email->from($frm, $frm);
		$CI->email->to(  $to ); 
		
		//cc
		if(!strlen($cc))
			$CI->email->cc( $cc ); 
		//bcc
		if(!strlen($bcc))
			$CI->email->bcc( $bcc ); 
			
		//subj
		$CI->email->subject($sub);
		
		//msg
		$CI->email->message($msg);
		
		//send
		$ret = $CI->email->send();
		$dmp = $CI->email->print_debugger();
		
		log_message("DEBUG","u_send_mail() : info#$ret [ $dmp ]");
	}
}
/**
*
*  @u_set_status_msg_ok
*
*  @description
*      - set session status msg
*        
*
*  @parameters
*      - msg
*
*  @return
*      - void
*              
*/
if ( ! function_exists('u_set_status_msg_ok'))
{
	function u_set_status_msg_ok($msg='')
	{
		//get obj
		$CI  =& get_instance();
		$msg = $CI->session->flashdata('success_msg'). $msg;
		$CI->session->set_flashdata('success_msg', $msg);
	}
}

/**
*
*  @u_set_status_msg
*
*  @description
*      - set session status msg
*        
*
*  @parameters
*      - msg
*
*  @return
*      - void
*              
*/
if ( ! function_exists('u_set_status_msg'))
{
	function u_set_status_msg($msg='')
	{
		//get obj
		$CI  =& get_instance();
		$msg = $CI->session->flashdata('error_msg'). $msg;
		$CI->session->set_flashdata('error_msg', $msg);
	}
}
/**
*
*  @u_decrypt_hash
*
*  @description
*      - calculate the uniq id
*        
*
*  @parameters
*      - prefix
*
*  @return
*      - uniq-id
*              
*/
if ( ! function_exists('u_decrypt_hash'))
{
	function u_decrypt_hash($pfx='',$raw='')
	{
		//fmt
		$pfx         = trim($pfx);
		if(!strlen($pfx)) return null;


		
		//get obj
		$CI          =& get_instance();
		$hash        = $CI->config->item('ENC-HASH');
		$more_hash   = $CI->config->item('MORE-HASH');
		$calculated  = @md5( $hash . $more_hash .$pfx );
		list($x1,$hash,$x2) = @explode('-', $raw,3);
		
		//calc
		$status      = (strlen($x1) and strlen($x2) and $hash == $calculated) ? (1) : (0);
		
		
		log_message("DEBUG","u_decrypt_hash() : info#$status [ $pfx : $raw ] calculate# [ $hash == $calculated ]");
		
		
		//give it back ;-)
		return $status;
	}
}


/**
*
*  @u_encrypt_hash
*
*  @description
*      - calculate the uniq id
*        
*
*  @parameters
*      - prefix
*
*  @return
*      - uniq-id
*              
*/
if ( ! function_exists('u_encrypt_hash'))
{
	function u_encrypt_hash($pfx='')
	{
		//fmt
		$pfx         = trim($pfx);
		if(!strlen($pfx)) return null;

		//calc		
		$tok1      = hash('sha1',uniqid(rand(), true));
		$tok2      = hash('sha1',uniqid(rand(), true));
		//more
		$mtok1       = substr($tok1,-8);
		$mtok2       = substr($tok2,-8);
		
		//get obj
		$CI          =& get_instance();
		$hash        = $CI->config->item('ENC-HASH');
		$more_hash   = $CI->config->item('MORE-HASH');
		$ref_id      = sprintf("%s-%s-%s",
					$mtok1, 
					@md5( $hash . $more_hash .$pfx ),
					$mtok2
				      );
		
		//give it back ;-)
		return $ref_id;
	}
}


/**
| @name
|      - fmt_ajx_params
|
| @params
|      - 
|
| @return
|      - 
|
| @description
|      - formatter for ajx parameters
|
**/
function fmt_ajx_params($sortdata=array())
{
	//globals here ;-)
	global $g_SYSTEM_DATA;
	//print_r($g_SYSTEM_DATA['_REQUEST']);
	$CI          =& get_instance();
	//fmt-params
	//$page        = isset($g_SYSTEM_DATA['_REQUEST']['page']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['page']     ) : (1);
	$start        = isset($g_SYSTEM_DATA['_REQUEST']['start']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['start']     ) : (1);
	$perPage     = isset($g_SYSTEM_DATA['_REQUEST']['length']  ) ? trim($g_SYSTEM_DATA['_REQUEST']['length']  ) : ($CI->config->item('DEFAULT_RECORD_LIMIT'));
	$order_col   = isset($g_SYSTEM_DATA['_REQUEST']['order'][0]['column']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['order'][0]['column']     ) : (0);	
	$sortby      = isset($g_SYSTEM_DATA['_REQUEST']['columns'][$order_col]['name']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['columns'][$order_col]['name']    ) : ('');
	$sortOrder   = isset($g_SYSTEM_DATA['_REQUEST']['order'][0]['dir']) ? trim($g_SYSTEM_DATA['_REQUEST']['order'][0]['dir']) : ('ASC');
	$page        = @intval($page);
	$perPage     = @intval($perPage);
	//$start       = ($page * $perPage) - ($perPage)   ;
	//$limit_str   = " LIMIT $start  , $perPage ";
	$limit_str   = " LIMIT $start  , $perPage ";
	$sortOrder   = @preg_match("/^(asc|desc)$/i",$sortOrder) ? ($sortOrder) : ('');
	$order       = (@in_array($sortby, $sortdata) and @count($sortdata)) ? (" ORDER BY $sortby $sortOrder ") : ('');
    $draw        = isset($g_SYSTEM_DATA['_REQUEST']['draw']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['draw']     ) : (1);
    
	//give it back ;-)
	return array(
		'order'      => $order       ,
		'limit'      => $limit_str   ,
		'page'       => $page        , 
		'perPage'    => $perPage     ,
		'sort'       => $sortby      ,
		'sortOrder'  => $sortOrder   ,
		'start'      => $start       ,
		'draw'       => $draw        ,
		);

}

function fmt_ajx_params_mootables($sortdata=array())
{
	//globals here ;-)
	global $g_SYSTEM_DATA;
	$CI          =& get_instance();
	//fmt-params
	$page        = isset($g_SYSTEM_DATA['_REQUEST']['page']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['page']     ) : (1);
	$perPage     = isset($g_SYSTEM_DATA['_REQUEST']['perPage']  ) ? trim($g_SYSTEM_DATA['_REQUEST']['perPage']  ) : ($CI->config->item('DEFAULT_RECORD_LIMIT'));
	$sortby      = isset($g_SYSTEM_DATA['_REQUEST']['sort']     ) ? trim($g_SYSTEM_DATA['_REQUEST']['sort']     ) : ('');
	$sortOrder   = isset($g_SYSTEM_DATA['_REQUEST']['sortOrder']) ? trim($g_SYSTEM_DATA['_REQUEST']['sortOrder']) : ('ASC');
	$page        = @intval($page);
	$perPage     = @intval($perPage);
	$start       = ($page * $perPage) - ($perPage)   ;
	$limit_str   = " LIMIT $start  , $perPage ";
	$sortOrder   = @preg_match("/^(asc|desc)$/i",$sortOrder) ? ($sortOrder) : ('');
	$order       = (@in_array($sortby, $sortdata) and @count($sortdata)) ? (" ORDER BY $sortby $sortOrder ") : ('');

	//give it back ;-)
	return array(
		'order'      => $order       ,
		'limit'      => $limit_str   ,
		'page'       => $page        , 
		'perPage'    => $perPage     ,
		'sort'       => $sortby      ,
		'sortOrder'  => $sortOrder   ,
		'start'      => $start       ,
		);

}

/**
*
*  @set_downloadable_csv
*
*  @description
*      - generic csv downloader
*
*  @parameters
*      - sql
*      - header
*      - csvfile
*
*  @return
*      - 
*              
*/
function set_downloadable_csv($data='', $header='', $csv='')
{
	
	//flush to browser
	@header("Content-Disposition: attachment; filename=" . urlencode($csv));    
	@header("Content-Type: application/force-download");
	@header("Content-Description: File Transfer");             
	@flush();
	
	//title
	echo "$header";

	//rows
	echo $data;

}


/*
*  @lang
*       - get text based on the language
*  @parameters
*		- language_key, id of the text
*  @return
*       - STRING
*/
function lang($language_key = '')
{
	if($language_key == '')
	{
		return '';
	}
	$CI = &get_instance();
	return $CI->user->text($language_key);
}


/**
*
*  @u_web_caller
*
*  @description
*      - call a web url
*
*  @parameters
*      - url
*
*  @return
*      - result
*              
*/
if ( ! function_exists('u_web_caller'))
{
	function u_web_caller($url='')
	{
		//http
		include_once('HTTP/Request.php');
		
		$url      = trim($url);
		
		//sanity
		$url_pat="@^(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)$@ix";
		//chk it
		if(! @preg_match($url_pat , $url, $matches) )
		{
			log_message('DEBUG',"u_web_caller() : Url INIT FAILED! [ $url ]");
			return null;
		}
			
			
		//fwd
		$req      = new HTTP_Request();
		$req->setMethod(HTTP_REQUEST_METHOD_GET);
		$req->setURL($url);

		//get the response code
		$req_code = (! PEAR::isError($req->sendRequest())) ? ($req->getResponseCode()) : (800);
		$body     = ($req_code == 200) ?  trim($req->getResponseBody()) : '';


		log_message('DEBUG',"u_web_caller() : get-url! [ $req_code / $url / $body ]");
		
		 
		//give it back ;-)
		return array('status' => (200 == $req_code) ? (true) : (false), 'code' => $req_code, 'res' => $body );


	}
}



/**
*
*  @u_web_curl
*
*  @description
*      - call a web url using CURL
*
*  @parameters
*      - pdata
*
*          ex:
*           array(
*                url         => url to send the request to 
*                post_fields => key/value pairs ( POST-DATA , urlencoded already )
*                is_proxy    => 1 / 0 if using proxy
*                proxy       => proxy url 
*                ua          => user-agent
*                header      => array of key/value pairs (HEADERS)
*                 )
*
*
*
*
*  @return
*      - result
*              
*/
if ( ! function_exists('u_web_curl'))
{

	function u_web_curl($pdata=null)
	{
		//init handle
		$url = trim($pdata['url']);
		$ch  = @curl_init();

		//sanity
		$url_pat="@^(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)$@ix";
		
		//just checking ;-)
		if(!$ch or !@preg_match($url_pat , $url, $matches) )
		{	
			log_message('DEBUG',"u_web_curl() : Curl INIT FAILED! [ $url ]");
			return null;
		}

		//opts
		@curl_setopt ($ch,  CURLOPT_URL, $url);
		@curl_setopt ($ch , CURLOPT_HEADER        , 1);
		@curl_setopt ($ch , CURLOPT_FOLLOWLOCATION, 1);
		@curl_setopt ($ch , CURLOPT_RETURNTRANSFER, 1);        
		@curl_setopt ($ch , CURLOPT_AUTOREFERER   , 1);        
		@curl_setopt ($ch , CURLOPT_CONNECTTIMEOUT   , 600);
		@curl_setopt ($ch , CURLOPT_TIMEOUT          , 600);
		@curl_setopt ($ch , CURLE_OPERATION_TIMEOUTED, 600);// 10 mins

		//headers
		if(@is_array($pdata['header']))
		{
		      @curl_setopt($ch,CURLOPT_HTTPHEADER,$pdata['header']);
		}
		//post
		if($pdata['post'])
		{
		  @curl_setopt($ch, CURLOPT_POST, 1);               
		  @curl_setopt($ch, CURLOPT_POSTFIELDS, $pdata['post_fields']); 
		}

		//proxy
		if($pdata['is_proxy'])
		   @curl_setopt($ch, CURLOPT_PROXY, $pdata['proxy']);

		//u.a.
		if(strlen(trim($pdata['ua'])))
		   @curl_setopt($ch, CURLOPT_USERAGENT, $pdata['ua']); 

		//set
		$res      = @curl_exec($ch);
		$cinfo    = @curl_getinfo($ch);
		$cerror   = @curl_error($ch);
		$hsize    = $cinfo["header_size"];
		$body     = @substr($res, $hsize );
		$req_code = $cinfo["http_code"];  

		//dmp      
		$dmp      = @var_export($cinfo, true);

		log_message('DEBUG',"u_web_curl() : curl-dump [ $dmp ]");

		//free
		@curl_close($ch);

		//give it back ;-)
		return array(
			  'status' => (false === $cbody or 200 != $req_code) ? (0) : (1),
			  'code'   => $req_code,
			  'res'    => $body
			  );
	}
}



/*
*   NUMBER FORMAT
*   param: number, decimal
*
*/
function n($number,$decimals=2){
    return number_format($number,$decimals,'.','');
}






/**
*
*  @u_generate_uuid
*
*  @description
*      - calculate the uniq id
*        
*
*  @parameters
*      - prefix
*
*  @return
*      - uniq-id
*              
*/
if ( ! function_exists('u_generate_uuid'))
{
	function u_generate_uuid($pfx='')
	{

		//fmt
		//sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		$s1        = uniqid(rand(), true);
		$s2        = uniqid(rand(), true);
		$tok1      = hash('sha1',$s1);
		$tok2      = hash('sha1',$s2);
		$tok3      = md5($s1);
		$tok4      = md5($s2);
		$tok5      = md5($tok1.$tok2);
		$ref_id    = @strtoupper(trim($pfx)). 
				sprintf("%s-%s-%s-%s-%s",
				substr($tok1,0,8),
				substr($tok2,-4),
				substr($tok3,0,4),
				substr($tok4,-4),
				substr($tok5,0,12));
		//give it back ;-)
		return $ref_id;
	}
}


/**
*
*  base64url_encode
*
*  @description
*      - ecnode base64 string URL
*
*
*  @parameters
*      - url
*
*  @return
*      - encode string url
*
*/
if ( ! function_exists('base64url_encode'))
{
	function base64url_encode($plainText)
	{
	  $base64 = base64_encode($plainText);
	  $base64url = strtr($base64, '+/=', '-_~');
	  return $base64url;
	}
}

/**
*
*  base64url_decode
*
*  @description
*      - decrypt base64 for URL
*
*
*  @parameters
*      - url
*
*  @return
*      - decode string
*
*/
if ( ! function_exists('base64url_decode'))
{
	function base64url_decode($encoded) {
	  $base64 = strtr($encoded,'-_~','+/=');
	  $plainText = base64_decode($base64);
	  return $plainText;
	}
}


  
/**
*
*  @check_content_type
*
*  @description
*      - get manually the mime type
*
*  @parameters
*      - filename
*      
*      
*      
*
*  @return
*      - true/false
*              
*/

if ( ! function_exists('check_content_type'))
{

	function check_content_type($filename) 
	{
		//manual
		$mime_types = array(

		    'txt' => 'text/plain',
		    'csv' => 'text/csv',
		    'htm' => 'text/html',
		    'html'=> 'text/html',
		    'php' => 'text/html',
		    'css' => 'text/css',
		    'js'  => 'application/javascript',
		    'json' => 'application/json',
		    'xml' => 'application/xml',
		    'swf' => 'application/x-shockwave-flash',
		    'flv' => 'video/x-flv',

		    // images
		    'png' => 'image/png',
		    'jpe' => 'image/jpeg',
		    'jpeg'=> 'image/jpeg',
		    'jpg' => 'image/jpeg',
		    'gif' => 'image/gif',
		    'bmp' => 'image/bmp',
		    'ico' => 'image/vnd.microsoft.icon',
		    'tiff'=> 'image/tiff',
		    'tif' => 'image/tiff',
		    'svg' => 'image/svg+xml',
		    'svgz'=> 'image/svg+xml',

		    // archives
		    'zip' => 'application/zip',
		    'rar' => 'application/x-rar-compressed',
		    'exe' => 'application/x-msdownload',
		    'msi' => 'application/x-msdownload',
		    'cab' => 'application/vnd.ms-cab-compressed',

		    // audio/video
		    'mp3' => 'audio/mpeg',
		    'qt'  => 'video/quicktime',
		    'mov' => 'video/quicktime',

		    // adobe
		    'pdf' => 'application/pdf',
		    'psd' => 'image/vnd.adobe.photoshop',
		    'ai'  => 'application/postscript',
		    'eps' => 'application/postscript',
		    'ps'  => 'application/postscript',

		    // ms office
		    'doc' => 'application/msword',
		    'rtf' => 'application/rtf',
		    'xls' => 'application/vnd.ms-excel',
		    'ppt' => 'application/vnd.ms-powerpoint',

		    // open office
		    'odt' => 'application/vnd.oasis.opendocument.text',
		    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		//ext
		$parts = @pathinfo($filename);
		$ext   = strtolower(trim($parts['extension']));
		if (array_key_exists($ext, $mime_types)) 
		{
		   $mime = $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) 
		{
		    $finfo    = finfo_open(FILEINFO_MIME);
		    $mimetype = finfo_file($finfo, $filename);
		    finfo_close($finfo);
		    $mime     = $mimetype;
		}
		else 
		{
		    $mime = 'application/octet-stream';
		}

		
		return $mime ;
	}

}

/**
*
*  @get_grey_box
*
*  @description
*      - pop-up box
*
*  @parameters
*      - href
*      - name
*      - title
*      - W
*      - Y
*      
*      
*      
*
*  @return
*      - true/false
*              
*/

if ( ! function_exists('get_grey_box'))
{

	function get_grey_box($href='#', $name='Click', $title='Details', $x=720, $y=550) 
	{
		return "<a href='$href' onclick=\"return GB_showCenter('$title', this.href,$x,$y);\">$name</a>";
	}
}	


// function to parse a video <entry>
function parseVideoEntry($entry) {      
  $obj= new stdClass;
  
  // get nodes in media: namespace for media information
  $media = $entry->children('http://search.yahoo.com/mrss/');
  $obj->title = $media->group->title;
  $obj->description = $media->group->description;
  
  // get video player URL
  $attrs = $media->group->player->attributes();
  $obj->watchURL = $attrs['url']; 
  
  // get video thumbnail
  $attrs = $media->group->thumbnail[0]->attributes();
  $obj->thumbnailURL = $attrs['url']; 
        
  // get <yt:duration> node for video length
  $yt = $media->children('http://gdata.youtube.com/schemas/2007');
  $attrs = $yt->duration->attributes();
  $obj->length = $attrs['seconds']; 
  
  // get <yt:stats> node for viewer statistics
  $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
  $attrs = $yt->statistics->attributes();
  $obj->viewCount = $attrs['viewCount']; 
  
  // get <gd:rating> node for video ratings
  $gd = $entry->children('http://schemas.google.com/g/2005'); 
  if ($gd->rating) { 
    $attrs = $gd->rating->attributes();
    $obj->rating = $attrs['average']; 
  } else {
    $obj->rating = 0;         
  }
    
  // get <gd:comments> node for video comments
  $gd = $entry->children('http://schemas.google.com/g/2005');
  if ($gd->comments->feedLink) { 
    $attrs = $gd->comments->feedLink->attributes();
    $obj->commentsURL = $attrs['href']; 
    $obj->commentsCount = $attrs['countHint']; 
  }
  
  // get feed URL for video responses
  $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
  $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
  2007#video.responses']"); 
  if (count($nodeset) > 0) {
    $obj->responsesURL = $nodeset[0]['href'];      
  }
     
  // get feed URL for related videos
  $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
  $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
  2007#video.related']"); 
  if (count($nodeset) > 0) {
    $obj->relatedURL = $nodeset[0]['href'];      
  }

  // return object to caller  
  return $obj;      
}  
    
     
function get_youtube_details($vid)
{
  $vid = trim($vid);
  
  // set video data feed URL
  $feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $vid;

  // read feed into SimpleXML object
  $entry = simplexml_load_file($feedURL);
  
  // parse video entry
  $video = parseVideoEntry($entry);
  
  return $video;
  
}

function is_broswer_mobile()
{
    
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/android.+mobile|avantgo|bada\/|ipad|iphone|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    return true;
    else
    return false;
}

function string_line_cont($str,$len)
{
  $cntlooplen = ceil(strlen($str)/$len); 
  if(strlen($str) > $len){
    for($i=0; $i<=$cntlooplen; $i++){
      if($i==0) $title = substr($str,0,$len);
      else $title .= "<br>".substr($str,$i*$len,$len);
    }
  }
  else{
    $title = $str;
  }
  
  return $title;
}    