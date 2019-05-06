<? include("headerv2.php"); ?>


    <section id="blog" class="container">
        <div class="center">
            <h2><?=$title;?></h2>
            <? if($type=='pengumuman' || $type=='renungan' || $type=='artikel'): ?>
            <!--<div class="entry-meta">
                <span id="publish_date"><?=substr($gData->created_date,0,10);?></span>
            </div>-->
            <? endif; ?>
            
        </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-12">
                  <? if($type=='main'): ?>
                  <img src="<?=$img;?>" alt="" class="img-responsive" />
                  <? endif; ?>
                  <p><?=$content;?></p>
                </div>
            </div><!--/.row-->

         </div><!--/.blog-->

    </section><!--/#blog-->


<? include("footerv2.php"); ?>