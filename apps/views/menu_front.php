<!-- Navigation -->
    <nav class="navbar navbar-fixed-top navbar-custom" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-link">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=site_url('home');?>">
                    <!--<img class="visible-xs" src="<?=BANNER_IMAGES;?>logo_kkis.png" width="40">--> <!-- this one will be visible on mobile -->
		    <!--<img class="hidden-xs" src="<?=BANNER_IMAGES;?>kkis_logo.png" width="150">--> <!-- this one will be visible on everything else -->
                    <img src="<?=BANNER_IMAGES;?>kkis_logo.png" width="150"  alt="" class="img-responsive" >
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="menu-link">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?=site_url('home');?>">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Pelayanan</a>
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
                  <li><a href="<?=site_url($seq)?>"><?=$data->pelayanan_title;?></a></li>
                  <? } ?> 
                  
                 <!-- specialize for two level dropdown menu -->
		  <!-- <li>
		    <ul class="dropdown-menu">
		      <li>
			<?
			//get Ucapan Terima Kasih
			$mdata = $this->Pelayanan_model->get(array(
			    'where' => ' AND display=1 AND pelayanan_id=10 ',
			    'order' => ' ORDER BY pelayanan_title asc'
					));
			$m_list = $mdata['data'];
			$data = $m_list[0];
			$seq      = array('content', 
					  'content_details',
					  'pelayanan',
					  @rawurlencode("$data->pelayanan_id"),
					  url_title("$data->pelayanan_title"),
					  );                    
			?>		    
			<a href="<?=site_url($seq)?>"><?=$data->pelayanan_title;?></a>		      
		      </li>
		    </ul>
		  </li> -->
		  
                        </ul>
                    </li>
                    <li>
                        <a href="#">Kegiatan</a>
                        <ul class="dropdown-menu">
                            <li>
                        <a href="#">Kegiatan Rohani</a>
                        
                        <ul class="dropdown-menu">
                    <?
                    //get kegiatan
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
                  <li><a href="<?=site_url($seq)?>"><?=$data->kegiatan_title;?></a></li>
                  <? } ?>   
                        </ul>
                        
                        </li>
                        
                        <li>
                        <a href="#">Kegiatan Liturgi</a>
                        
                        <ul class="dropdown-menu">
                    <?
                    //get kegiatan
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
                  <li><a href="<?=site_url($seq)?>"><?=$data->kegiatan_title;?></a></li>
                  <? } ?>   
                        </ul>
                        
                        </li>
                        
                        </ul>
                        
                    </li>
                    <!--<li>
                        <a href="<?=site_url('content/pengumuman')?>">Pengumuman</a>
                    </li>-->
                    
                    
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Publikasi & Galeri</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=site_url('content/dombaku')?>">Dombaku</a></li>
                            <li><a href="https://www.facebook.com/kkis.org/photos_stream?ref=page_internal" target="_blank">Galeri</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Tentang KKIS</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=site_url('content/tentangkkis')?>">Latar Belakang KKIS</a></li>
                            <li><a href="<?=site_url('content/strukturorganisasi')?>">Struktur Organisasi KKIS</a></li>
                            <li><a href="<?=site_url('content/visimisi')?>">Visi & Misi KKIS</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?=site_url('content/kontak')?>">Kontak</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
				