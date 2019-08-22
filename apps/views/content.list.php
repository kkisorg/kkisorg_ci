<? include("headerv2.php"); ?>


    <section id="blog" class="container">
        <div class="center">
            <h2><?=$page_title1;?></h2>
        </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-12">
                <div align="center"><?=$list;?></div>
                <div class="pagination pagination-centered">
      						<?=isset($gData_pagination)?$gData_pagination:null;?>
      					</div>
                </div>
            </div><!--/.row-->

         </div><!--/.blog-->

    </section><!--/#blog-->


<? include("footerv2.php"); ?>
