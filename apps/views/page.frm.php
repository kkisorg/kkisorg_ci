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
                    <h1 class="page-header">Pages Editor</h1>
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
                  
                  <form action="<?=site_url('page/proc_page_list')?>" method="post" enctype="multipart/form-data">
				    <?=form_hidden($jData_Hidden);?>
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                <label for="page_name">Page</label>
                <select name="page_name">
					         <? foreach($page_list as $k=>$v): 
                  $selected = $k==$pagename?'selected':'';
                  ?> 
                  <option value="<?=$k;?>" <?=$selected;?> ><?=$k;?></option>
                  <? endforeach; ?>
                </select> 
            </div>
				    <input class="btn btn-primary" type="submit" name='Submit'  value="Submit" />
            </form>
            
            <? if(!$not_step2): ?>
      	    <hr />
            <form action="<?=site_url('page/proc')?>" method="post" enctype="multipart/form-data"> 
      			<?=form_hidden($jData_Hidden);?>
				    
            <p><h4 class="text-primary">Page Edit (<?=$pagename;?>)</h4></p>
            
            <? if($show_editor): ?>
            <div class="form-group">
                <label for="content">Page Content<font style="color:red;font-size:bolder"> * </font></label>
                <?php
                // Automatically calculates the editor base path based on the _samples directory.
                // This is usefull only for these samples. A real application should use something like this:
                // $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
                $sBasePath = PATH_FCK_EDITOR;
                $oFCKeditor = new FCKeditor('page') ;
                $oFCKeditor->BasePath	= $sBasePath ;
                $oFCKeditor->Value		=  $jData->page_v ;
                $oFCKeditor->Create() ;
                ?>
            </div>
				    <? endif; ?>
            
            <? if($show_image): ?>
				    <div class="form-group">
                <label for="file">Image<font style="color:red;font-size:bolder"> * </font></label>
                <input type="file" name="file" id="file" value=""  /> (.jpg, .png, .gif)
      					<br /><br />
      					<? if($jData->image!=''): ?>
      					<img src="<?=PATH_USERFILES;?>/page_header/<?=$jData->image;?>" />
      					<? endif; ?>
            </div>
            <? endif;?>
                    
				<input class="btn btn-primary" type="submit" name='Save'  value="Save" />
				 
				</form>
	      <? endif; ?>
				
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>
      
<!--// e-content //-->						
<?php include_once('footer.php')?>