<? include('header_front.php'); ?>
<? include('menu_front.php'); ?>

<!-- Page Content -->
    <div class="container">
        
        <!-- Content Row -->
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <!--artikel-->
              <div class="col-md-12">
                  <h2><?=$title;?></h2>
                  <? if($type=='pengumuman' || $type=='renungan' || $type=='artikel'): ?>
                  <h6 class="text-muted"><?=substr($gData->created_date,0,10);?></h6>
                  <? endif; ?>
                  <hr />
                  <? if($type=='main'): ?>
                  <img src="<?=$img;?>" alt="" class="img-responsive" />
                  <? endif; ?>
                  <p><?=$content;?></p>
              </div>
            </div>
          </div>
        
          
            
<? include('right.side.content.php'); ?>       
<? include('footer_front.php'); ?>
