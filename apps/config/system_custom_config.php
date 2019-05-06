<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| System Wide Customized config key-value pairs
|--------------------------------------------------------------------------
| @Desc    : 
| @Date    : 2011-04-27
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/


//sample Key-Value pair config
$config['ENC-HASH']             = DEFAULT_ENC_HASH;
$config['MORE-HASH']            = DEFAULT_ENC_HASH_MORE;


//remember-me
$config['DEFAULT_REMEMBER_ME_COOKIE_NAME'] = DEFAULT_REMEMBER_ME_COOKIE_NAME;
$config['DEFAULT_REMEMBER_ME_COOKIE_MAX']  = DEFAULT_ENC_HASH_MORE;//max days old


//use ALL-CAPS key ;-)
$config['DEFAULT_RECORD_LIMIT'] = 10;


//root-id
$config['DEFAULT_ADMIN_ID']     = DEFAULT_ADMIN_ID; //su-root ID ;-)

//inactive-user
$config['DEFAULT_INACTIVE_USER_STATUS'] = 0;

//active-list
$config['DEFAULT_ACTIVE_INACTIVE_LIST'] = array('1' => 'Active' , '0' => 'In-Active');
$config['DEFAULT_PUBLISH_NOTPUBLISH_LIST'] = array('1' => 'Published' , '0' => 'Not Published');

//time
$config['TIME_DAY'] = array('AM', 'PM');

//expiry-list
$config['DEFAULT_PASSWORD_EXPIRY_DATE'] = '5000';
$config['COMBO_LIST_PASSWORD_EXPIRY'  ] = array(
                                          '3'    => '3  days',
                                          '7'    => '7  days',
                                          '30'   => '30 days',
                                          $config['DEFAULT_PASSWORD_EXPIRY_DATE'] => 'Never',
                                          );
                                          
//@user-module
$config['USER_DEL_UNKNOWN_REC_MSG']              = "Oops, no record found!";
$config['USER_DEL_OK_MSG']                       = "User successfully de-activated.";
$config['USER_ADD_UNKNOWN_ERR_MSG']              = "Oops, something wrong with the new data.";
$config['USER_ADD_ERR_MSG_MAIL_REQUIRED']        = "Email is required.";
$config['USER_ADD_ERR_MSG_MAIL_ALREADY_USED']    = "Email already exists in the system.";
$config['USER_ADD_ERR_MSG_PASS_CONF_DONT_MATCH'] = "Password and Password confirmation doesn't match.";
$config['USER_ADD_OK_MSG']                       = "User successfully added.";
$config['USER_UPD_UNKNOWN_REC_MSG']              = $config['USER_DEL_UNKNOWN_REC_MSG'];
$config['USER_UPD_OK_MSG']                       = "User successfully updated.";
$config['USER_UPD_ERR_MSG']                      = "Oops,user update failed.";

//@role-module
$config['ROLE_DEL_UNKNOWN_REC_MSG']              = "Oops, no record found!";
$config['ROLE_DEL_OK_MSG']                       = "Role successfully de-activated.";
$config['ROLE_ADD_UNKNOWN_ERR_MSG']              = "Oops, something wrong with the new data.";
$config['ROLE_ADD_ERR_MSG_NAME_REQUIRED']        = "Role name is required.";
$config['ROLE_ADD_ERR_MSG_NAME_ALREADY_USED']    = "Role name already exists in the system.";
$config['ROLE_ADD_OK_MSG']                       = "Role successfully added.";
$config['ROLE_UPD_UNKNOWN_REC_MSG']              = $config['ROLE_DEL_UNKNOWN_REC_MSG'];
$config['ROLE_UPD_OK_MSG']                       = "Role successfully updated.";
$config['ROLE_UPD_ERR_MSG']                      = "Oops,role update failed.";



//@resource-module
$config['RESOURCE_DEL_UNKNOWN_REC_MSG']              = "Oops, no record found!";
$config['RESOURCE_DEL_OK_MSG']                       = "Resource successfully de-activated.";
$config['RESOURCE_ADD_UNKNOWN_ERR_MSG']              = "Oops, something wrong with the new data.";
$config['RESOURCE_ADD_ERR_MSG_NAME_REQUIRED']        = "Resource name is required.";
$config['RESOURCE_ADD_ERR_MSG_NAME_ALREADY_USED']    = "Resource name already exists in the system.";
$config['RESOURCE_ADD_OK_MSG']                       = "Role successfully added.";
$config['RESOURCE_UPD_UNKNOWN_REC_MSG']              = $config['ROLE_DEL_UNKNOWN_REC_MSG'];
$config['RESOURCE_UPD_OK_MSG']                       = "Resource successfully updated.";
$config['RESOURCE_UPD_ERR_MSG']                      = "Oops,resource update failed.";


//@perms
$config['RESOURCE_UPD_OK_MSG']                       = "Permission settings successfully updated.";

//@login
$config['USER_LOGIN_ERROR']                          = "Invalid email and/or password.";
$config['USER_LOGIN_ERROR_MAX']                      = "This account has been blocked by the system.";
$config['USER_LOGIN_PASS_EXPIRED']                   = "This account's password already expired.";
$config['USER_LOGIN_IN_ACTIVE']                      = "This account's status already in-active.";

//@change-pass
$config['CHANGE_PWD_ERR_NO_DATA']                    = "Oops, no record found!";  
$config['CHANGE_PWD_UNKNOWN_ERR_MSG']                = "Oops, something wrong with the new data.";
$config['CHANGE_PWD_OK_MSG']                         = "Password successfully updated.";
$config['CHANGE_PWD_ERR_NOT_MATCH']                  = $config['USER_ADD_ERR_MSG_PASS_CONF_DONT_MATCH'];
$config['CHANGE_PWD_OLD_NOT_MATCH']                  = "Old password doesn't match.";

$config['FORGOT_PWD_UNKNOWN_ERR_MSG']                = "Oops, something wrong with the new data.";
$config['FORGOT_PWD_OK_MSG']                         = "Password successfully updated to <_PASS_>";
$config['FORGOT_PWD_ERR_NO_DATA']                    = "Invalid email address.";  
$config['FORGOT_PWD_FROM_EMAIL']                     = "admin@kkis.org";  
$config['FORGOT_PWD_SUBJ_EMAIL']                     = "IES: New Password"; 
$config['FORGOT_PWD_MESG_EMAIL']                     = "
Hi <_NAME_>,\n\n

Your new password is <_PASS_>\n\n

Thanks,\n
Tech Team.
"; 


$config['FORGOT_PWD_CONF_EMAIL']                     = "
Hi <_NAME_>,\n\n

You have requested to update your password.\n\n
Please click the url below: 
(or copy & paste it in your browser)


<_URL_>


Thanks,\n
Tech Team.
";
$config['FORGOT_PWD_CONF_URL']                       = "user/fgotpass_conf";

$config['FORGOT_PWD_CONF_EMAIL_SENT']                = "Please check your inbox. Reset password sent!";
$config['FORGOT_PWD_CONF_ALREADY']                   = "Reset password already confirmed.";  
//@mails
$config['DEFAULT_FROM_EMAIL']                        = "admin@kkis.org";  
$config['DEFAULT_SUBJ_EMAIL']                        = "KKIS";  

//@reset
$config['RESET_PWD_OK_MSG']                          = "<_MAIL_>'s password successfully changed to <_PASS_>";


//@unlock
$config['USER_ULOCK_WPASS_UNKNOWN_REC_MSG']          = "Oops, no record found!";
$config['USER_ULOCK_WPASS_OK_MSG']                   = "User successfully unlocked.";


//@sys-settings
$config['USER_SYS_SETTINGS_OK_MSG']               = "System settings successfully updated.";
$config['USER_SYS_SETTINGS_ERR_MSG']              = "Oops, system settings update failed.";
$config['USER_SYS_SETTINGS_UNKNOWN_REC_MSG']      = "Oops, no system settings record found!";

//@page
$config['PAGE_OK_MSG']               = "Page successfully updated.";
$config['PAGE_ERR_MSG']              = "Oops, page update failed.";
$config['PAGE_UNKNOWN_REC_MSG']      = "Oops, no page record found!";

//@update profile
$config['USER_UPD_PROFILE_OK_MSG']               = "Profile successfully updated.";
$config['USER_UPD_PROFILE_ERR_MSG']              = "Oops, user profile update failed.";
$config['USER_UPD_PROFILE_UNKNOWN_REC_MSG']      = "Oops, no profile record found!";

//page
$config['PAGE_LIST'] = array(
                          'Tentang KKIS'    =>  array('show_editor'=>1),
                          'Jadwal Misa'    =>  array('show_editor'=>1),
                        );




?>