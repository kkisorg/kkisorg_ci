<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


//trap-the incoming get-query-string
$hook['pre_system'][] = array(
                                'class'    => 'MySystemHook',
                                'function' => 'pre_loader',
                                'filename' => 'MySystemHook.php',
                                'filepath' => 'hooks',
                                'params'   => array($_REQUEST)
                                );
/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */