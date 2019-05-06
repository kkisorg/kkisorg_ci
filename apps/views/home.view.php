<? include('header_front.php'); ?>

<?
//get header news

$hdata = $this->Header_news_model->get(array(
                'where' => ' AND status=1 and publish=1 ',
                'order' => ' ORDER BY id desc'
                             ));
$header_list = $hdata['data'];

?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <? include('menu_front.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                <div id="customCarousel" class="carousel slide" data-ride="carousel">
                
                <!-- Indicators -->
                <!--<ol class="carousel-indicators">
                  <? 
			        $i=1;
			        foreach($header_list as $header){ 
			        if($i==1){$active = 'class="active"';}
                    ?>
				    <li data-target="#customCarousel" data-slide-to="<?=$i;?>" <?=$active;?> ></li>
				    <? $i++;$active='';} ?>
                </ol>
                -->
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                <? 
			    $j=1;
			    foreach($header_list as $header){ 
			    if($j==1){$active_item = 'class="active item"';}
                $arr_exp = explode('.',$header->image);
                $img = $header->id.'.'.$arr_exp[1];
                
                $seq      = array('content', 
					  'content_details',
					  'main',
					  @rawurlencode("$header->id"),
					  url_title("$header->title"),
					  );
                ?>
                  <div <?=$active_item;?>>
                    <a href="<?=site_url($seq);?>"><img src="<?=PATH_USERFILES.'header_news/'.$img;?>" alt="">
                    <div class="custom-carousel-caption">
                      <!-- <h3><?=$header->title;?></h3>
					  <p><?=$header->short_desc;?></p> -->
                    </div></a>
                  </div>
                <? $j++;$active_item='class="item"';} ?>	  
                </div>
              
                <!-- Controls -->
                <a class="left carousel-control" href="#customCarousel" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#customCarousel" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
              </div>
		
		<iframe src="https://www.google.com/calendar/embed?title=Jadwal%20Misa%20KKIS&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;mode=AGENDA&amp;height=155&amp;wkst=1&amp;hl=id&amp;bgcolor=%23FFFFFF&amp;src=calendar.kkis%40gmail.com&amp;color=%231B887A&amp;ctz=Asia%2FSingapore" style=" border:solid 1px #777 " width="100%" height="130" frameborder="0" scrolling="no"></iframe>
          
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4">         
                <div style="margin-top:30px;" class="fb-like-box" data-href="https://www.facebook.com/kkis.org" data-width="100%" data-height="100%" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="true"></div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <hr>
        
        <!-- Content Row -->
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <!--artikel-->
              <div class="col-md-6">
                  <?
                    //get artikel
                    $mdata = $this->Artikel_model->get(array(
                        'where' => ' AND display=1 ',
                        'order' => ' ORDER BY artikel_id desc',
                        'limit' => ' LIMIT 1'
                                     ));
                    $m_list = $mdata['data'];
                    ?>
                    
                  <h2><a href="<?=site_url('content/artikel')?>"><div class="box-gradient"><span style="margin-left:5px;">&#x27AD; Artikel</span></div></a></h2>
                  <? foreach($m_list as $art){ 
                        $seq      = array('content', 
					  'content_details',
					  'artikel',
					  @rawurlencode("$art->artikel_id"),
					  url_title("$art->artikel_title"),
					  );
					  ?>
                  <a href="<?=site_url($seq)?>"><h4><?=$art->artikel_title;?></h4></a>
                  <h6 class="text-muted"><?=substr($art->created_date,0,10);?></h6>
                  <p><?=character_limiter(strip_tags($art->artikel_content,50));?></p>
                  <? } ?>
                  <a class="btn btn-warning" href="<?=site_url($seq)?>">Selanjutnya</a>
                  <p style="text-align:right;"><a href="<?=site_url('content/artikel')?>"><u>Lihat artikel selanjutnya</u></a></p>
              </div>
              <!--renungan-->
              <div class="col-md-6">
                    <?
                    //get renungan
                    $rdata = $this->Renungan_model->get(array(
                        'where' => ' AND display=1 ',
                        'order' => ' ORDER BY renungan_id desc',
                        'limit' => ' LIMIT 1'
                                     ));
                    $r_list = $rdata['data'];
                    ?>
                  <h2><a href="<?=site_url('content/renungan')?>"><div class="box-gradient"><span style="margin-left:5px;">&#x27AD; Renungan</span></div></a></h2>
                  <? foreach($r_list as $ren){ 
                        $seq      = array('content', 
					  'content_details',
					  'renungan',
					  @rawurlencode("$ren->renungan_id"),
					  url_title("$ren->renungan_title"),
					  );
					  ?>
                  <a href="<?=site_url($seq)?>"><h4><?=$ren->renungan_title;?></h4></a>
                  <h6 class="text-muted"><?=substr($ren->created_date,0,10);?></h6>
                  <p><?=character_limiter(strip_tags($ren->renungan_content,50));?></p>
                  <? } ?>
                  <a class="btn btn-warning" href="<?=site_url($seq)?>">Selanjutnya</a>
                  <p style="text-align:right;"><a href="<?=site_url('content/renungan')?>"><u>Lihat renungan selanjutnya</u></a></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <!--pengumuman-->
              <div class="col-md-10">
                    <?
                    //get pengumuman
                    $pdata = $this->Pengumuman_model->get(array(
                        'where' => ' AND display=1 ',
                        'order' => ' ORDER BY pengumuman_id desc',
                        'limit' => ' LIMIT 5'
                                     ));
                    $p_list = $pdata['data'];
                    ?>
                  <h2><a href="<?=site_url('content/pengumuman')?>"><div class="box-gradient"><span style="margin-left:5px;">&#x27AD; Pengumuman</span></div></a></h2>
                  <? $i=0;
                    foreach($p_list as $pen){ 
                        $seq      = array('content', 
					  'content_details',
					  'pengumuman',
					  @rawurlencode("$pen->pengumuman_id"),
					  url_title("$pen->pengumuman_title"),
					  );
					  if($i<1){
					  ?>
                  <a href="<?=site_url($seq)?>"><h4><?=$pen->pengumuman_title;?></h4></a>
                  <h6 class="text-muted"><?=substr($pen->created_date,0,10);?></h6>
                  <p><?=character_limiter(strip_tags($pen->pengumuman_content,50));?></p>
                  <a class="btn btn-warning" href="<?=site_url($seq)?>">Selanjutnya</a>
                  <? } $i++; } ?>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-md-8">
                <ul class="content-list-ul">
                  <? $i=0;
                        foreach($p_list as $pen){ 
                        $seq      = array('content', 
					  'content_details',
					  'pengumuman',
					  @rawurlencode("$pen->pengumuman_id"),
					  url_title("$pen->pengumuman_title"),
					  );
					  if($i>0){
					  ?>  
                  <li class="content-list"><a href="<?=site_url($seq)?>"><?=$pen->pengumuman_title;?></a></li>
                  <? }$i++; } ?>
                  <li><br /><p style="text-align:right;"><a href="<?=site_url('content/pengumuman')?>"><u>Lihat pengumuman selanjutnya</u></a></p></li>
                </ul>
              </div>
              </div>
            <hr>
          </div>
            <br />
            
<? include('right.side.content.php'); ?>
       
<? include('footer_front.php'); ?>