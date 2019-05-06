<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=($content=='')?'Home - KKIS.org':substr(strip_tags($content),0,100).'...';?>">
    <meta name="author" content="">
    <meta property="og:image" content="<?=($thumbImg=='')?FILEPATH_UI.'images/logo.png':$thumbImg;?>">
    <meta property="og:title" content="<?=($title=='')?'Home - KKIS.org':$title.' - KKIS.org';?>"/>  
    <meta property="og:description" content="<?=($content=='')?'Home - KKIS.org':substr(strip_tags($content),0,100).'...';?>"/> 
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
    <title><?=($title=='')?'Home | KKIS':$title;?></title>
	
	<!-- core CSS -->
    <link href="<?=FILEPATH_UI;?>css/bootstrap.css" rel="stylesheet">
    <link href="<?=FILEPATH_UI;?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=FILEPATH_UI;?>css/animate.min.css" rel="stylesheet">
    <link href="<?=FILEPATH_UI;?>css/prettyPhoto.css" rel="stylesheet">
    <link href="<?=FILEPATH_UI;?>css/main.css" rel="stylesheet">
    <link href="<?=FILEPATH_UI;?>css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?=FILEPATH_UI;?>js/html5shiv.js"></script>
    <script src="<?=FILEPATH_UI;?>js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?=FILEPATH_UI;?>images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=FILEPATH_UI;?>images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=FILEPATH_UI;?>images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=FILEPATH_UI;?>images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?=FILEPATH_UI;?>images/ico/apple-touch-icon-57-precomposed.png">
    
</head><!--/head-->

<body class="homepage">

    <header id="header">

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=site_url()?>"><img src="<?=FILEPATH_UI;?>images/logo.png" alt="logo" width="100px"></a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="<?=site_url()?>">Home</a></li>
                        <li class="dropdown">    
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pelayanan</a>
                            <ul class="dropdown-menu">
                            <?
                                    //get pelayanan
                                    $mdata = $this->Pelayanan_model->get(array(
                                        'where' => ' AND display=1 AND pelayanan_id!=10 ',
                                        'order' => ' ORDER BY pelayanan_title asc'
                                                     ));
                                    $m_list = $mdata['data'];
                                    ?>
                                    <? foreach($m_list as $data){ 
                                        $seq      = array('content', 
                                              					  'content_details',
                                              					  'pelayanan',
                                              					  @rawurlencode("$data->pelayanan_id"),
                                              					  url_title("$data->pelayanan_title"),
                                              					  );
                					  ?>
                                <li><a href="<?=site_url($seq)?>"><?=string_line_cont($data->pelayanan_title,29);?></a></li>
                                <? } ?> 
                            </ul>
                        </li>
                        <li class="dropdown">    
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kegiatan Rohani </a>
                            <ul class="dropdown-menu">
                            <?
                                    $mdata = $this->Kegiatan_model->get(array(
                                              'where' => ' AND display=1 ',
                                              'order' => ' ORDER BY kegiatan_title asc'
                                                           ));
                                          $m_list = $mdata['data'];
                                          ?>
                                          <? foreach($m_list as $data){ 
                                              $seq      = array('content', 
                      					  'content_details',
                      					  'kegiatan',
                      					  @rawurlencode("$data->kegiatan_id"),
                      					  url_title("$data->kegiatan_title"),
                      					  );
                					  ?>
                                <li><a href="<?=site_url($seq)?>"><?=string_line_cont($data->kegiatan_title,30);?></a></li>
                                <? } ?> 
                            </ul>
                        </li>
                        <li class="dropdown">    
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kegiatan Liturgi </a>
                            <ul class="dropdown-menu">
                            <?
                                    $mdata = $this->Kegiatanliturgi_model->get(array(
                                                'where' => ' AND display=1 ',
                                                'order' => ' ORDER BY kegiatan_title asc'
                                                             ));
                                            $m_list = $mdata['data'];
                                            ?>
                                            <? foreach($m_list as $data){ 
                                                $seq      = array('content', 
                        					  'content_details',
                        					  'kegiatanliturgi',
                        					  @rawurlencode("$data->kegiatan_id"),
                        					  url_title("$data->kegiatan_title"),
                        					  );
                                    
                					  ?>
                                <li><a href="<?=site_url($seq)?>"><?=string_line_cont($data->kegiatan_title,28);?></a></li>
                                <? } ?> 
                            </ul>
                        </li> 
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Publikasi & Galeri</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=site_url('content/dombaku')?>">Dombaku</a></li>
                                <li><a href="http://eepurl.com/boiRoH">Berlangganan Dombaku</a></li>
                                <li><a href="<?=site_url('content/artikel');?>">Artikel</a></li>
                                <li><a href="<?=site_url('content/renungan');?>">Renungan</a></li>
                                <li><a href="<?=site_url('content/pengumuman');?>">Pengumuman</a></li>
                                <li><a href="<?=site_url('content/bacaanmingguan/');?>">Bacaan Dwimingguan</a></li>
                                <li><a href="https://www.facebook.com/kkis.org/photos_stream?ref=page_internal" target="_blank">Galeri</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Tentang KKIS</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=site_url('content/tentangkkis')?>">Latar Belakang KKIS</a></li>
                                <li><a href="<?=site_url('content/strukturorganisasi')?>">Struktur Organisasi KKIS</a></li>
                                <li><a href="<?=site_url('content/visimisikkis')?>">Visi & Misi KKIS</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=site_url('content/kontak')?>">Kontak</a>
                        </li>                    
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
		
    </header><!--/header-->