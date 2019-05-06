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
                    <h1 class="page-header">Role &raquo; Edit &raquo; <?=$jData->name;?></h1>
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
                  
                  <form action="<?=site_url('role/efrm_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <label for="name">Title<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" maxlength="200" value="<?php echo set_value('name',  $jData->name);?>" >
                    </div>
				    
				    <div class="form-group">
                        <label for="description">Description<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" name="description" maxlength="255" value="<?php echo set_value('description',$jData->description);?>"  placeholder="Enter Description"/> 
                    </div>
				    
				    <div class="form-group">
                        <label for="publish">Publish<font style="color:red;font-size:bolder"> * </font></label>
                        <select name="publish">
					        <? foreach($jData_publish_list as $k=>$v){ 
          			        $selected = $k==$jData->display?'selected':''; ?>
					        <option value="<?=$k;?>" <?=$selected;?> ><?=$v;?></option>
					        <? } ?>
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