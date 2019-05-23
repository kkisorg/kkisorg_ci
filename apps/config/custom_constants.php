<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('env_config.php');

define('SITE_URL', $config['base_url']);

define('DEFAULT_REMEMBER_ME_COOKIE_NAME', $config['DEFAULT_REMEMBER_ME_COOKIE_NAME']);
define('DEFAULT_REMEMBER_ME_COOKIE_MAX', $config['DEFAULT_REMEMBER_ME_COOKIE_MAX']);

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
define('DEFAULT_ADMIN_ID' , 1); //supaer admin ID ;-)
define('DEFAULT_ADMIN_BRANCH_ID', 2);

define('MAX_WRONG_ATTEMPT',    10);

define('HOME_TXT',  'Home');
define('HOME_URL',  '');

define('THUMBNAIL_ALBUMS_WIDTH',    '720');
define('THUMBNAIL_ALBUMS_HEIGHT',    '320');
?>
