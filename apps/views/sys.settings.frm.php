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
					System Settings
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
			<form action="<?=site_url('system_settings/proc')?>" method="post"> 
			<?=form_hidden($jData_Hidden);?>
				
			<div class="panel">
				<div class="acc-header">
				 <p><h5>System Settings</h5></p>
				</div>
				
				<div class="acc-content">
					
				<p>Please complete the form below.</p>
				<p>
  				<label>Mail URL:<font style="color:red;font-size:bolder"> * </font></label> 
					<input type="text" name="mail" maxlength="200" value="<?php echo set_value('mail', $jData['mail']);?>"       size="60"/>
				</p>
				<p> 
					<label>Yahoo Messenger:<font style="color:red;font-size:bolder"> * </font></label> 
					<input type="text" name="ym" maxlength="100" value="<?php echo set_value('ym', $jData['ym']);?>"       size="30"/> 
				</p>
				<p> 
					<label>Twitter:<font style="color:red;font-size:bolder"> * </font></label> 
					<input type="text" name="twitter" maxlength="20" value="<?php echo set_value('twitter',$jData['twitter']);?>"       size="30"/> 
				</p>
				<p> 
					<label>Facebook:</label> 
					<input type="text" name="fb" maxlength="100" value="<?php echo set_value('fb',$jData['fb']);?>"       size="60"/>  
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