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
                    <h1 class="page-header">User &raquo; Edit &raquo; <?=$jData->name;?></h1>
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
                  
                  <form action="<?=site_url('user/efrm_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <label for="name">Name<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="name" maxlength="100" value="<?php echo set_value('name', $jData->name);?>" >
                    </div>
				    
				    <div class="form-group">
                        <label for="mobile">Mobile<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="mobile" maxlength="20" value="<?php echo set_value('mobile',$jData->mobile);?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
					    <select name="role">
						<?php foreach($jData_role_list as $kk => $vv) 
						      {
						      	$ksel = ($kk == $jData->role) ? (' selected ') : (set_select('role', $kk));
						      ?>
							<option value="<?=$kk?>" <?=$ksel?> ><?=$vv->name?></option>
						<?php } ?>
					    </select>
                    </div>
				    
				    <div class="form-group">
                        <label for="status">Status</label>
					    <select name="status">
						<?php foreach($jData_active_list as $kk => $vv) 
						     {
						     	$ksel = ($kk == $jData->status) ? (' selected ') : (set_select('status', $kk));
						     ?>
						<option value="<?=$kk?>" <?=$ksel?> ><?=$vv?></option>
						<?php } ?>
					    </select>                    
					</div>
                    
                    <div class="form-group">
                        <label for="pass_expiry_days">Password Expiry Date</label>
                        <select name="pass_expiry_days">
					        <?php foreach($jData_pexpiry_list as $kk => $vv) 
					        {
						        $ksel = ($kk == $jData->pass_expiry_days) ? (' selected ') : (set_select('pass_expiry_days', $kk));
					        ?>
					        <option value="<?=$kk?>" <?=$ksel?> ><?=$vv?></option>
					        <?php } ?>
				        </select>
                    </div>
                    
				<input class="btn btn-primary" type="submit" name='Save'  value="Save" />
				 
				</form>
				
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>
      
<!--// e-content //-->						
<?php include_once('footer.php')?>