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
                    <h1 class="page-header">User Profile</h1>
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
                  
                  <form action="<?=site_url('user/eprof_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <?=$jData->email?>
                    </div>
				    
				    <div class="form-group">
                        <label for="name">Name<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="name" maxlength="100" value="<?php echo set_value('name', $jData->name);?>" >
                    </div>
				    
				    <div class="form-group">
                        <label for="mobile">Mobile<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="mobile" maxlength="20" value="<?php echo set_value('mobile',$jData->mobile);?>">
                    </div>
                    
                    
				<input class="btn btn-primary" type="submit" name='Update'  value="Update" />
				 
				</form>
				
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>
      
<!--// e-content //-->						
<?php include_once('footer.php')?>