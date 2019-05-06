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
                    <h1 class="page-header">Change Password</h1>
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
                  
                  <form action="<?=site_url('user/chpass_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <?=$jData->email?>
                    </div>
				    
				    <div class="form-group">
                        <label for="oldpass">Old Password<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="password" name="oldpass" maxlength="200" value="<?php echo set_value('oldpass');?>" >
                    </div>
				    
				    <div class="form-group">
                        <label for="pass1">New Password<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="password" name="pass1" maxlength="200" value="<?php echo set_value('pass1');?>" >
                    </div>
                    
                    <div class="form-group">
                        <label for="pass2">Confirm Password<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="password" name="pass2" maxlength="200" value="<?php echo set_value('pass2');?>">
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