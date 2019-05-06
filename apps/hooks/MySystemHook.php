<?php
/*
|--------------------------------------------------------------------------
| @Filename: MySystemHook.php
|--------------------------------------------------------------------------
| @Desc    : hook class
| @Date    : 2010-04-02
| @Version : 1.0 
| @By      : bayugyug@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class MySystemHook 
{

	function MySystemHook()
	{
	}
	
	
	/**
	| @name
	|      - pre_loader
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
	function pre_loader($req=null)
	{
		global $g_SYSTEM_DATA;
		
		//save it ;-)
		$g_SYSTEM_DATA['_REQUEST']  = $_REQUEST;
		$g_SYSTEM_DATA['_SERVER']   = $_SERVER;
		$g_SYSTEM_DATA['_GET']      = $_GET;
		$g_SYSTEM_DATA['_POST']     = $_POST;
	}
	
	
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/user.php */