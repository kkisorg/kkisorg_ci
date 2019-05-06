<?php 
/*
| header + menu
*/
include_once('header.php');
include_once('menu.php');
?>
<!--// s-content //-->	

            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Kegiatan &raquo; Delete</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!--//status//-->
			<?php
			/*
			| status msgs here ;-)
			*/
			include_once('msg.php');
			?>
			<!--//status//-->
            <div class="row">
                <div class="col-lg-12">
                  
                  <form action="<?=site_url('kegiatan_adm/dfrm_proc')?>" method="post">
				    <?=form_hidden($jData_Hidden);?>
				    <fieldset> 
								<legend id="searchby" class="searchstyle1">Confirm</legend> 

								<div class=""> 
									<p class="text-danger"> 
									You are about to delete this record.
									<br/>
									( This can not be undone. )
									</p>
										<ul>
										  <li><p class=''>Title</p>&nbsp;<?=$jData->kegiatan_title ?></li>
										</ul>
									

								</div>

								<input type="submit" value="Delete" name="submitDel" class="btn btn-danger" /> 
								&nbsp;
								<input type="submit" value="Cancel" name="submitCancel" class="btn btn-default"/> 
							</fieldset> 
				 
				</form>
				
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>
      
<!--// e-content //-->						
<?php include_once('footer.php')?>