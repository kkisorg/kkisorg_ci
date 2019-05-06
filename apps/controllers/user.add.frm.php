<?php 
/*
| header + menu
*/
include_once('header.php');
include_once('menu.php');
?>
<!--// s-content //-->	
<script type="text/javascript" charset="utf-8">
	window.addEvent('domready', function(){
		
		//set no-data 
		var jDataTot = "<?=$jData_Total?>";
		
	});
</script>
			<!--//title//-->
			<div class="grid_16">
				<h2>
					User &raquo; New
				</h2>
			</div>
			<!--//title//-->
			<!--//status//-->
			<?php
			/*
			| status msgs here ;-)
			*/
			include_once('msg.php');
			?>
			<!--//status//-->
			<div class="grid_2">
				<div class="block" id="forms"> 
				&nbsp;
				</div>
			</div>
			
			
			
			<!--form start here-->
			 
			<div class="grid_16">
			<form action="<?=site_url('user/afrm_proc')?>" method="post">
				
			<div class="panel">
				<div class="acc-header">
				 <p><h5>User Profile</h5></p>
				</div>
				
				<div class="acc-content">
					
				<p>Please complete the form below. </p>
				<p> 
					<label>Email<font color="red">*</font></label> 
					<input type="text" name="email" maxlength="100" value="<?php echo set_value('email');?>" size="30"/> 
				</p>
				<p> 
					<label>Name<font color="red">*</font></label> 
					<input type="text" name="name" maxlength="100" value="<?php echo set_value('name');?>"       size="30"/> 
				</p>
				<p> 
					<label>Password<font color="red">*</font></label> 
					<input type="password" name="pass1" maxlength="100" value="<?php echo set_value('pass1');?>"   size="30"/> 
				</p>
				<p> 
					<label>Confirm Password<font color="red">*</font></label> 
					<input type="password" name="pass2" maxlength="100" value="<?php echo set_value('pass2');?>"   size="30"/> 
				</p>
				<p> 
					<label>Mobile</label> 
					<input type="text" name="mobile" maxlength="20" value="<?php echo set_value('mobile');?>"       size="30"/> 
				</p>
				<p> 
					<label>Role</label> 
					<select name="role">
						<?php foreach($jData_role_list as $kk => $vv) {?>
							<option value="<?=$kk?>" <?php echo set_select('role', $kk); ?> ><?=$vv->name?></option>
						<?php } ?>
					</select>
				</p>
				<p> 
					<label>Branch</label> 
					<select name="branch">
						<?php foreach($jData_branch as $branch) {?>
						<option value="<?=$branch->id?>" <?php echo set_select('branch', $branch->id); ?> ><?=$branch->name?></option>
						<?php } ?>
					</select>
					(only for Admin Branch Role)
				</p>
				
				<p> 
					<label>Status</label> 
					<select name="status">
						<?php foreach($jData_active_list as $kk => $vv) {?>
						<option value="<?=$kk?>" <?php echo set_select('status', $kk); ?> ><?=$vv?></option>
						<?php } ?>
					</select>
				</p>
				
				<p> 
					<label>Password Expiry Date</label> 
					<select name="pass_expiry_days">
						<?php foreach($jData_pexpiry_list as $kk => $vv) {?>
						<option value="<?=$kk?>" <?php echo set_select('pass_expiry_days', $kk); ?> ><?=$vv?></option>
						<?php } ?>
					</select>
				</p>
				
				<p>
				<input class="confirm button" type="submit" name='Save'  value="Save" />
				</p>
				
	      </div>
	    </div>
	    
	    </form>
	    </div>
      
			
			
			
			
			<div class="clear"></div>
						
			
<script type="text/javascript"> 
window.addEvent('domready', function() {
	// round menu item
	var myRound3 = new Rounded($$("#menufilter"));
	var myRound4 = new Rounded($$("#searchby"));
	
});
</script>

			
<!--// e-content //-->						
<?php include_once('footer.php')?>