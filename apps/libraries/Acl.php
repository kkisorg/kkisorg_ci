<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Access-list centralizd functions
|--------------------------------------------------------------------------
| @Desc    : 
| @Date    : 2010-08-24 
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|
|
| @Modified By  :  
| @Modified Date: 
*/
require_once '././_libs_/Zend/Acl.php';
require_once '././_libs_/Zend/Acl/Role.php';
require_once '././_libs_/Zend/Acl/Resource.php';


class Acl extends Zend_Acl 
{
	/**
	| @name
	|      - __construct
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
		//get instance
		$CI        = &get_instance();     
		$this->acl = new Zend_Acl();
		
		try
		{
			//more
			$CI->load->model('User_resource_model',  'user_resource_model');
			$CI->load->model('User_permission_model','user_permission_model');
			$CI->load->model('User_role_model',      'user_role_model');

			//role-list
			$rodata = $CI->user_role_model->get();
			$rolist = $rodata['data'];
 
			
			//set roles
			foreach($rolist as $KK => $VV)
			{   
				//Add the roles to the ACL
				$role = new Zend_Acl_Role($KK); 
				$VV->parentId != 0 ? $this->acl->addRole($role, $VV->parentId) : $this->acl->addRole($role);
			}

			//resource-list
			$rdata = $CI->user_resource_model->get( );
			$rlist = $rdata['data'];
			
			
			

			foreach($rlist as $KK => $VV)
			{   
				//Add the resources to the ACL
				$resource = new Zend_Acl_Resource($VV->id);
				$VV->parentId != 0 ?	$this->acl->add($resource, $VV->parentId) : $this->acl->add($resource);
			}


			//resource-list
			$rdata = $CI->user_permission_model->get( );
			$rlist = $rdata['data'];


			
      
			foreach($rlist as $KK => $VV)
			{ 	//Add the permissions to the ACL
				$this->acl->allow($VV->role, $VV->resource);
			}
			//Change this to whatever id your Super-Admin is...
			$this->acl->allow(DEFAULT_ADMIN_ID); 
		}
		catch(Exception $e)
		{
			//trigger_error("ERROR: info => " .$e->getMessage());
		}
		
	}
	
	
	
	
	
	/**
	| @name
	|      - getters
	|
	|
	**/
	function is_allowed($role, $resource) 
	{
	
		return $this->acl->isAllowed($role, $resource);// ? TRUE : FALSE;
	}
 
	function can_read($role, $resource) 
	{
		return $this->acl->isAllowed($role, $resource, 'uread')? TRUE : FALSE;
	}
	function can_write($role, $resource) 
	{
		return $this->acl->isAllowed($role, $resource, 'uwrite')? TRUE : FALSE;
	}
	function can_modify($role, $resource) 
	{
		return $this->acl->isAllowed($role, $resource, 'umodify')? TRUE : FALSE;
	}
	function can_delete($role, $resource) 
	{
		return $this->acl->isAllowed($role, $resource, 'udelete')? TRUE : FALSE;
	}
  	function can_publish($role, $resource) 
  	{
		return $this->acl->isAllowed($role, $resource, 'upublish')? TRUE : FALSE;
	}
}
?>