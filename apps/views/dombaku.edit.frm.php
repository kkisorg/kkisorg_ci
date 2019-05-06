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
                    <h1 class="page-header">Dombaku &raquo; Edit &raquo; <?=$jData->title;?></h1>
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
                  
                  <form action="<?=site_url('dombaku_adm/efrm_proc')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <label for="name">Title<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" maxlength="200" value="<?php echo set_value('name',  $jData->title);?>" >
                    </div>
				    
				    <div class="form-group">
                        <label for="file">File<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="file" name="file" id="file" value=""  /> <p class="help-block">(.jpg, .png, .gif, .pdf)</p>
					    <br />
                        <? $fpath = FILEPATH_USERFILES."dombaku/".$jData->image;
                        if(file_exists($fpath)):?>
					    <a href="<?php echo base_url(); ?>gui/userfiles/dombaku/<?=$jData->image;?>">Download file</a>
                        <? endif ?>
                    </div>
				    
				    <div class="form-group">
                        <label for="publish">Publish<font style="color:red;font-size:bolder"> * </font></label>
                        <select name="publish">
					        <? foreach($jData_publish_list as $k=>$v){ 
          			        $selected = $k==$jData->publish?'selected':''; ?>
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