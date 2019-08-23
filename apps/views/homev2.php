<? include "headerv2.php"; ?>
<?
//get header news

$hdata = $this->Header_news_model->get(array(
                'where' => ' AND status=1 and publish=1 ',
                'order' => ' ORDER BY id desc'
                             ));
$header_list = $hdata['data'];

$accordNm = array('collapseOne1','collapseTwo1','collapseThree1','collapseFour1');
?>
    <section id="main-slider" class="no-margin">
        <div id="main-slider-ct" class="carousel" data-ride="carousel" data-interval="5000">
            <ol class="carousel-indicators">
                <?
    			        $i=0;
    			        foreach($header_list as $header){
    			        if($i==0){$active = 'class="active"';}
                ?>
                <li data-target="#main-slider" data-slide-to="<?=$i;?>" <?=$active;?> ></li>
				        <? $i++;$active='';} ?>
            </ol>
            <div class="carousel-inner">
                <?
        			    $j=1;
        			    foreach($header_list as $header){
        			    if($j==1){$active_item = 'class="item active"';}
                        $arr_exp = explode('.',$header->image);
                        $img = $header->id.'.'.$arr_exp[1];

                        $seq      = array('content',
        					  'content_details',
        					  'main',
        					  @rawurlencode("$header->id"),
        					  url_title("$header->title"),
        					  );
                ?>
                <div <?=$active_item;?> style="background-image: url(<?=PATH_USERFILES.'header_news/'.$img;?>)">
                <a href="<?=site_url($seq);?>"><span class="clickable"></span></a>
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <!--<div class="carousel-content">
                                    <h1 class="animation animated-item-1"><?=$header->title;?></h1>
                                    <h2 class="animation animated-item-2"><?=$header->short_desc;?></h2>
                                    <a class="btn-slide animation animated-item-3" href="<?=site_url($seq);?>">Read More</a>
                                </div>-->
                            </div>

                        </div>
                    </div>
                </div><!--/.item-->
                <? $j++;$active_item='class="item"';} ?>

            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->

    <section id="middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 wow fadeInDown">
                    <div class="accordion">
                        <h2>Artikel</h2>
                        <?
                          //get artikel
                          $mdata = $this->Artikel_model->get(array(
                              'where' => ' AND display=1 ',
                              'order' => ' ORDER BY artikel_id desc',
                              'limit' => ' LIMIT 4'
                                           ));
                          $m_list = $mdata['data'];
                        ?>

                        <div class="panel-group" id="accordion1">

                          <?
                          $i=0;
                          foreach($m_list as $art){
                              $seq      = array('content',
                                    					  'content_details',
                                    					  'artikel',
                                    					  @rawurlencode("$art->artikel_id"),
                                    					  url_title("$art->artikel_title"),
                                    					  );

              					  ?>
                          <div class="panel panel-default">
                            <div class="panel-heading active">
                              <h3 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?=$accordNm[$i];?>">
                                  <?=$art->artikel_title;?>
                                  <i class="fa fa-angle-right pull-right"></i>
                                </a>
                              </h3>
                            </div>

                            <div id="<?=$accordNm[$i];?>" class="panel-collapse collapse <?=$i==0?'in':'';?>">
                              <div class="panel-body">
                                <?=word_limiter(strip_tags($art->artikel_content,20));?>
                                <p><a class="btn btn-warning" href="<?=site_url($seq)?>">Selanjutnya</a></p>
                              </div>
                            </div>
                          </div>
                          <? $i++; } ?>

                        </div><!--/#accordion1-->
                    </div>
                </div>


                <div class="col-sm-6 wow fadeInDown">

                    <div class="skill">
                        <h2>Renungan</h2>
                        <?
                          //get renungan
                          $rdata = $this->Renungan_model->get(array(
                              'where' => ' AND display=1 ',
                              'order' => ' ORDER BY renungan_id desc',
                              'limit' => ' LIMIT 3'
                                           ));
                          $r_list = $rdata['data'];
                        ?>
                        <?
                          foreach($r_list as $ren){
                              $seq      = array('content',
                                					  'content_details',
                                					  'renungan',
                                					  @rawurlencode("$ren->renungan_id"),
                                					  url_title("$ren->renungan_title"),
                                					  );

              					  ?>
                        <div class="progress-wrap">
                            <a href="<?=site_url($seq)?>"><h3><?=$ren->renungan_title;?></h3></a>
                            <div class="progress">
                              <div class="progress-bar color0" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">

                              </div>
                            </div>
                        </div>
                        <? } ?>

                    </div>

                    <div class="skill">
                        <h2>Jadwal Misa KKIS</h2>
                        <iframe height="220" width="100%" border=0 src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;mode=AGENDA&amp;
height=155&amp;wkst=1&amp;hl=id&amp;bgcolor=%23999999&amp;src=calendar.kkis%40gmail.com&amp;color=%23b3b3b3&amp;ctz=Asia%2FSingapore" style=" border:0px #777 " width="100%" height="130" frameborder="0" scrolling="no">
</iframe>
                    </div>

                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#middle-->

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 wow fadeInDown">
                   <div class="tab-wrap">
                        <div class="media">
                        <?
                        //get pengumuman
                        $pdata = $this->Pengumuman_model->get(array(
                            'where' => ' AND display=1 ',
                            'order' => ' ORDER BY pengumuman_id desc',
                            'limit' => ' LIMIT 5'
                                         ));
                        $p_list = $pdata['data'];
                        ?>
                            <div class="parrent pull-left">
                                <ul class="nav nav-tabs nav-stacked">
                                    <?  $i=0;
                                      foreach($p_list as $pen){
                                          $seq      = array('content',
                                      					  'content_details',
                                      					  'pengumuman',
                                      					  @rawurlencode("$pen->pengumuman_id"),
                                      					  url_title("$pen->pengumuman_title"),
                                      					  );
                        					  ?>
                                    <li class="<?=$i==0?'active':'';?>"><a href="#tab<?=$i;?>" data-toggle="tab" class="tehnical"><?=$pen->pengumuman_title;?></a></li>
                                    <? $i++; } ?>
                                </ul>
                            </div>

                            <div class="parrent media-body">
                                <div class="tab-content">
                                    <?  $i=0;
                                      foreach($p_list as $pen){
                                          $seq      = array('content',
                                      					  'content_details',
                                      					  'pengumuman',
                                      					  @rawurlencode("$pen->pengumuman_id"),
                                      					  url_title("$pen->pengumuman_title"),
                                      					  );
                        					  ?>

                                     <div class="tab-pane fade <?=$i==0?'active in':'';?>" id="tab<?=$i;?>">
                                        <p><?=word_limiter(strip_tags($pen->pengumuman_content),40);?></p>
                                        <p><a class="btn btn-warning" href="<?=site_url($seq)?>">Selanjutnya</a></p>
                                     </div>
                                     <? $i++; } ?>
                                </div> <!--/.tab-content-->
                            </div> <!--/.media-body-->
                        </div> <!--/.media-->
                    </div><!--/.tab-wrap-->
                </div><!--/.col-sm-6-->

                <div class="col-xs-12 col-sm-4 wow fadeInDown">
                    <div class="testimonial">
                        <h2>Dombaku</h2>
                         <?
                          $mdata = $this->Dombaku_model->get(array(

                            'where' => ' AND publish = 1',
                            'order' => ' order by datein desc',
                            'limit' => " LIMIT 5",
                          ));
                          $m_list = $mdata['data'];
                         ?>
                         <?
                              foreach($m_list as $row){
                              $seq      = array('content',
                  					  'content_details',
                  					  'dombaku',
                  					  @rawurlencode("$row->id"),
                  					  url_title("$row->title"),
                  					  );

                              $fpath = FILEPATH_USERFILES."dombaku/".$row->image;

                              //if(file_exists($fpath)){
                      		    //$fl = '<a href="'.base_url().'gui/userfiles/dombaku/'.$row->image.'"><img src="'.SITE_URL.'/gui/images/pdf-icon.png" width="30" /></a>';
                              $fl = '<a href="'.PATH_USERFILES.'dombaku/'.$row->image.'"><img src="'.SITE_URL.'/gui/images/pdf-icon.png" width="30" /></a>';
                              //}
              					  ?>
                         <div class="media testimonial-inner">
                            <div class="pull-left">
                                <?=$fl;?>
                            </div>
                            <div class="media-body">
                                <p><?=$row->title;?></p>

                            </div>
                         </div>
                         <? } ?>

                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#content-->

    <section id="partner">
        <div class="container">
            <div class="center wow fadeInDown">
                <?
                  //get renungan
                  $rdata = $this->Renungan_model->get(array(
                      'where' => ' AND display=1 ',
                      'order' => ' ORDER BY renungan_id desc',
                      'limit' => ' LIMIT 1'
                                   ));
                  $r_list = $rdata['data'];
                ?>
                <? foreach($r_list as $ren){
                      $seq      = array('content',
                      					  'content_details',
                      					  'renungan',
                      					  @rawurlencode("$ren->renungan_id"),
                      					  url_title("$ren->renungan_title"),
                      					  );
    					  ?>
                <h2><?=$ren->renungan_title;?></h2>
                <p class="lead"><i class="fa fa-quote-left"></i> <?=strip_tags($ren->renungan_content);?> <i class="fa fa-quote-right"></i></p>
                <? } ?>
            </div>

        </div><!--/.container-->
    </section><!--/#partner-->

    <section id="feature" >
        <div class="container">
           <div class="center wow fadeInDown">
                <h2>Pelayanan</h2>
                <p class="lead"><i class="fa fa-quote-left"></i> Mintalah maka akan diberikan kepadamu; carilah, maka kamu akan mendapatkan; ketoklah maka pintu akan dibukakan bagimu.Karena setiap orang yang meminta, menerima dan setiap orang yang mencari mendapat dan setiap orang yang mengetok, baginya pintu dibukakan. <i class="fa fa-quote-right"></i> <br> <i>- Mat 7:7-8 -</i></p>
            </div>

            <div class="row">
                <div class="features">

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
                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-tag"></i>
                            <a href="<?=site_url($seq);?>"><h2><?=$data->pelayanan_title;?></h2></a>
                        </div>
                    </div><!--/.col-md-4-->
                    <? } ?>

                </div><!--/.services-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->

    <section id="recent-works">
        <div class="container">
            <div class="center wow fadeInDown">
                <h2>Kegiatan Rohani</h2>
                <p class="lead"><i class="fa fa-quote-left"></i> Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, disitu Aku ada di tengah-tengah mereka. <i class="fa fa-quote-right"></i> <br><i>- Mat 18:20 -</i></p>
            </div>

            <div class="row">
                <?
                          $mdata = $this->Kegiatan_model->get(array(
                                    'where' => ' AND display=1 ',
                                    'order' => ' ORDER BY kegiatan_title asc'
                                                 ));
                                $m_list = $mdata['data'];
                  ?>
                  <?  $i=1;
                      foreach($m_list as $data){
                        $seq      = array('content',
            					  'content_details',
            					  'kegiatan',
            					  @rawurlencode("$data->kegiatan_id"),
            					  url_title("$data->kegiatan_title"),
            					  );
      					  ?>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="recent-work-wrap">
                        <a href="<?=site_url($seq);?>"><img class="img-responsive" src="<?=FILEPATH_UI;?>images/rohani/<?=$i;?>.jpg" alt=""></a>
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <h3><a href="<?=site_url($seq)?>"><?=$data->kegiatan_title;?></a> </h3>
                                <p><?=trim(word_limiter(strip_tags($data->kegiatan_content),20));?></p>
                                <p><a class="btn btn-warning" href="<?=site_url($seq);?>">Selanjutnya</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <? $i++; } ?>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#recent-works-->

    <section id="services" class="service-item">
	   <div class="container">
            <div class="center wow fadeInDown">
                <h2>Kegiatan Liturgi</h2>
                <p class="lead"><i class="fa fa-quote-left"></i> Akulah jalan dan kebenaran dan hidup. Tidak ada seorangpun yang datang kepada Bapa, kalau tidak melalui Aku. <i class="fa fa-quote-right"></i> <br><i>- Yoh 14:6 -</i></p>
            </div>

            <div class="row">
                <?
                        $mdata = $this->Kegiatanliturgi_model->get(array(
                            'where' => ' AND display=1 ',
                            'order' => ' ORDER BY kegiatan_title asc'
                                         ));
                        $m_list = $mdata['data'];
                ?>
                <?
                    $i=1;
                    foreach($m_list as $data){
                    $seq      = array('content',
            					  'content_details',
            					  'kegiatanliturgi',
            					  @rawurlencode("$data->kegiatan_id"),
            					  url_title("$data->kegiatan_title"),
            					  );
    					  ?>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap wow fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="<?=FILEPATH_UI;?>images/services/services<?=$i++;?>.png">
                        </div>
                        <div class="media-body">
                            <a href="<?=site_url($seq)?>"><h3 class="media-heading"><?=$data->kegiatan_title;?></h3></a>
                        </div>
                    </div>
                </div>
                <? } ?>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->

    <section id="conatcat-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="media contact-info wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="pull-left">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h2>Ingin tahu info lebih lanjut?</h2>
                            <p>Anda dapat menghubungi kami <a href="<?=site_url('content/kontak');?>">disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section><!--/#conatcat-info-->

    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="center">
            <h3>Lokasi Misa Berbahasa Indonesia</h3>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="widget">
                        <h3>Minggu I:</h3>
                        <ul>
                            <li>Gereja Our Lady Perpetual Succour (OLPS)</li>
                            <li>31 Siglap Hill<br> Singapore 456085 <a href="https://www.google.com/maps/place/31+Siglap+Hill,+Singapore+456085"><i class="fa fa-map-marker"></i></a></li>
                            <li>Pukul 15.30</li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-4 col-sm-6">
                    <div class="widget">
                        <h3>Sabtu II (Misa Senja):</h3>
                        <ul>
                            <li>Gereja Our Lady Star of the Sea</li>
                            <li>10 Yishun Street 22<br> Singapore 768579 <a href="https://www.google.com/maps/place/10+Yishun+Street+22,+Singapore+768579"><i class="fa fa-map-marker"></i></a></li>
                            <li>Pukul 18.30</li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-4 col-sm-6">
                    <div class="widget">
                        <h3>Minggu II & IV :</h3>
                        <ul>
                            <li>Gereja St. Bernadette</li>
                            <li>12 Zion Road<br> Singapore 247731 <a href="https://www.google.com/maps/place/12+Zion+Rd,+Singapore+247731"><i class="fa fa-map-marker"></i></a></li>
                            <li>Pukul 15.30</li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-4 col-sm-6">
                    <div class="widget">
                        <h3>Minggu III :</h3>
                        <ul>
                            <li>Gereja St Mary of the Angels (SMOTA)</li>
                            <li>5 Bukit Batok East Ave 2<br> Singapore 659918 <a href="https://www.google.com/maps/place/5+Bukit+Batok+East+Avenue+2,+Singapore+659918"><i class="fa fa-map-marker"></i></a></li>
                            <li>Pukul 15.00</li>

                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-4 col-sm-6">
                    <div class="widget">
                        <h3>Minggu V:</h3>
                        <ul>
                            <li>Gereja Blessed Sacrament</li>
                            <li>1 Commonwealth Drive<br> Singapore 149603 <a href="https://www.google.com/maps/place/1+Commonwealth+Dr,+Singapore+149603"><i class="fa fa-map-marker"></i></a></li>
                            <li>Pukul 15.30</li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

<? include "footerv2.php"; ?>
