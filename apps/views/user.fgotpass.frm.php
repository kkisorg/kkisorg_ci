<?php 
/*
| header + menu
*/
include_once('header.php');
include_once('menu.php');

include(INCLUDE_PATH_FCK_EDITOR."fckeditor.php") ;
?>
<!--// s-content //-->	

            
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Forgot Password</h1>
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
                  
                  <form action="<?=site_url('user/fgotpass_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    
				    <div class="form-group">
                        <?=$jData->email?>
                    </div>
				    
				    <div class="form-group">
                        <label for="email">Email<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="email" maxlength="200" value="<?php echo set_value('email');?>" >
                    </div>
                    
                    
				<input class="btn btn-primary" type="submit" name='Submit'  value="Submit" />
				 
				</form>
				
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>
      
<!--// e-content //-->						
<?php include_once('footer.php')?>