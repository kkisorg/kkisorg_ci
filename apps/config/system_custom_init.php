<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| System Wide Customized includes
|--------------------------------------------------------------------------
| @Desc    : 
| @Date    : 2009-08-24 
| @Version : 1.0 
| @By      : bayugyug@gmail.com
|
|
| @Modified By  :  
| @Modified Date: 
*/
//set libs
@ini_set('include_path',ini_get('include_path'). PATH_SEPARATOR . APPPATH . '/libraries/');
//UTF-8 supports ;-)
@mb_language('uni');
@mb_internal_encoding('UTF-8');

include_once('system_custom_const.php');
//include_once('gw.php.libs.init.php');

?>
