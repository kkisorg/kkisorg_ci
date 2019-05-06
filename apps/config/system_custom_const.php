<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| System Wide Customized includes
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


/*
|
| @global constants + system configs
|
|
*/


define('SERVER_USED', 1);


if(SERVER_USED==1)
{
	/*if ($_SERVER['HTTPS'] != "on") {
		define('SITE_URL', 'https://kkis.org/kkis');
		define('PATH_USERFILES',  'https://kkis.org/kkis/gui/userfiles/');
	}else{
		define('SITE_URL', 'http://kkis.org/kkis');
		define('PATH_USERFILES',  'http://kkis.org/kkis/gui/userfiles/');
	}*/
  //define('SITE_URL', 'http://staging.kkis.org');
  define('SITE_URL', 'https://kkis.org');

  //path image
  define('FILEPATH_USERFILES',  './gui/userfiles/');
  
  //path image
  define('BANNER_IMAGES',  SITE_URL.'/gui/kkisv2/images/');
  define('PATH_USERFILES',  SITE_URL.'/gui/userfiles/');
  //define('PATH_USERFILES',  'https://kkis.org/kkis/gui/userfiles/');
  
  //define('FILEPATH_UI',  '/gui/kkis/');
  define('FILEPATH_UI',  SITE_URL.'/gui/kkisv2/');
  
  define('FILEPATH_CAPTCHA',  './gui/captcha/');
  define('URL_CAPTCHA',  SITE_URL.'/gui/captcha/');
  define('FONTPATH_CAPTCHA',  '/gui/fonts/BodoniFLF-Bold.ttf');
  
  define('FILEPATH_UI_DATATABLES',  '/gui/kkis/DataTables-1.10.2/');
  
  
  
}

define('EMAIL_KONTAK_ROMO',         'cinta.kkis@gmail.com');
define('EMAIL_KONTAK',         'kkis.contact@gmail.com');

define('DEFAULT_LANG',         1);
define('DEFAULT_LANG_NAME',     'Default');
define('PATH_FCK_EDITOR',     SITE_URL.'/gui/fckeditor/');
define('INCLUDE_PATH_FCK_EDITOR',     './gui/fckeditor/');

define('PER_PAGE',  10);

define('THUMBNAIL_WIDTH',   115);
define('THUMBNAIL_HEIGHT',   79);




//more
define('DEFAULT_DB', 'default');
define('MIN_PASSWD_LEN', 6);
define('MAX_PASSWD_LEN', 20);
define('MIN_FILTER_LEN', 3);

define('DEFAULT_LANGUAGE','english');

//url's
define('DEFAULT_LOGGED_OUT_PAGE','user/logout');
define('DEFAULT_LOGGED_IN_PAGE', 'user/login');
define('DEFAULT_DENIED_PAGE',    'user/denied');

define('DEFAULT_USER_VIEW',      'user/view');
define('DEFAULT_USER_ADD',       'user/afrm');
define('DEFAULT_USER_EDIT',      'user/efrm');
define('DEFAULT_USER_PROF',      'user/eprof');

//root-ids
define('DEFAULT_ROLE_ROOT_ID', 1); //root
define('DEFAULT_ADMIN_ID'    , 1); //supaer admin ID ;-)
define('DEFAULT_ADMIN_BRANCH_ID'    , 2);


define('MAX_WRONG_ATTEMPT',    10);


//cookie
define('DEFAULT_ENC_HASH',       md5('##kkis!!') );
define('DEFAULT_ENC_HASH_MORE', '1dc73517d547ab1dc73517d547ab431dc73517d547ab43f6a92051e4f69495f6a92051e4f6949543f6a92051e4f69495');
define('DEFAULT_REMEMBER_ME_COOKIE_NAME', '_remember_hehehe_me_');
define('DEFAULT_REMEMBER_ME_COOKIE_MAX',  15);//number of days

define('HOME_TXT',  'Home');
define('HOME_URL',  '');

//email
define('DEFAULT_EMAIL_FROM',    'admin@kkis.org');
define('DEFAULT_EMAIL_NAME_FROM',    'admin@kkis.org');
define('DEFAULT_EMAIL_SUBJECT', 'Someone sent message to you');

define('THUMBNAIL_ALBUMS_WIDTH',    '720');
define('THUMBNAIL_ALBUMS_HEIGHT',    '320');
?>