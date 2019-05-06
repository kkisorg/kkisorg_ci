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
                    <h1 class="page-header">Header News &raquo; Create New</h1>
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
                  
                  <form action="<?=site_url('header_news_adm/afrm_proc')?>" method="post" enctype="multipart/form-data">
				    <h5>Please complete the form.</h5>
				    <div class="form-group">
                        <label for="name">Title<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" maxlength="200" value="<?php echo set_value('name', $name);?>">
                    </div>
				    
				    <div class="form-group">
                        <label for="short_desc">Short Description<font style="color:red;font-size:bolder"> * </font></label>
                        <textarea name="short_desc" cols="38" rows="6"><?php echo set_value('short_desc', $short_desc);?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="file">Image<font style="color:red;font-size:bolder"> * </font></label>
                        <input type="file" name="file" id="file" value=""  /> <p class="help-block">(.jpg, .png, .gif)</p>
					    <br />
					    <img src="<?=PATH_USERFILES;?>header_news/<?=$jData->image;?>" />
                    </div>
				    
				    <div class="form-group">
                        <label for="content">Content<font style="color:red;font-size:bolder"> * </font></label>
                        <?php
                        // Automatically calculates the editor base path based on the _samples directory.
                        // This is usefull only for these samples. A real application should use something like this:
                        // $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
                        $sBasePath = PATH_FCK_EDITOR;
                        $oFCKeditor = new FCKeditor('content') ;
                        $oFCKeditor->BasePath	= $sBasePath ;
                        $oFCKeditor->Value		= $content ;
                        $oFCKeditor->Create() ;
                        ?>
                    </div>
                    
				    <div class="form-group">
                        <label for="publish">Publish<font style="color:red;font-size:bolder"> * </font></label>
                        <select name="publish" id="publish">
					        <? foreach($jData_publish_list as $k=>$v){ ?>
					        <option value="<?=$k;?>"><?=$v;?></option>
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