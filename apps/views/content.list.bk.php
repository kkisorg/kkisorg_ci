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
                  <h2><?=$page_title1;?></h2>
                  <br />
                  <?=$list;?>
                  
                  <div class="pagination pagination-centered">
						<?=$gData_pagination;?>
					</div>
              </div>
            </div>
          </div>
          
<? include('right.side.content.php'); ?>            
<?php include_once('footer_front.php')?>