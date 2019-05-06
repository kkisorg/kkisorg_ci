		<div class="grid_5" style="padding-left:300px;">
			  <div class="block" id="forms"> 
			  
			  	<div id="menufilter" class=""> 
			     
			     
				<form action="<?=site_url('user/logfrm_proc')?>" method="post"> 
					<fieldset>
						<legend id="searchby" class="searchstyle1">Login</legend> 
						
							<p> 
								<label>Email</label> 
								<input type="text" name="email"    maxlength="100" value="<?php echo set_value('email');?>"      size="30"/> 
							</p>
							<p> 
								<label>Password</label> 
								<input type="password" name="pass" maxlength="200" value="<?php echo set_value('pass');?>"       size="30"/> 
							</p>


							<input class="confirm button" type="submit" name='Login'  value="Submit" />

							<input class="confirm button" type="reset"  name='Reset' value="Reset" />
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=site_url('user/fgotpass')?>">Forgot Password</a>

							<br/><br/>
							Remember Me<input class="confirm button" type="checkbox"  name='me' value="1" />


					</fieldset> 
				</form> 
				
				</div>
			  </div>
		</div>
		<div class="clear"></div>
					
			
<script type="text/javascript"> 
window.addEvent('domready', function() {
	// round menu item
	var myRound3 = new Rounded($$("#menufilter"));
	var myRound4 = new Rounded($$("#searchby"));
	
});
</script>

		