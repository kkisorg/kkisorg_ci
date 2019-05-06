<?php 
/*
| header + menu
*/
include_once('header.php');
include_once('menu.php');
?>
<!--// s-content //-->	
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {

	
	 $('#datalist').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?=site_url('dombaku_adm/ajx_view')?>",
            "type": "POST"
        },
        "aoColumnDefs"   : [
                         {
                           "sTitle"   : "Title",
                           "sName"    : "title",
                           "sType"    : "string",
                           "aTargets" : [ 0 ],           
                           "bSortable": true,           
                         },
                        {
                           "sTitle"    : "Status",
                           "sName"    : "publish",
                           "sType"    : "string",
                           "aTargets" : [ 1 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Action",
                           "sType"    : "string",
                           "aTargets" : [ 2 ],            
                           "bSortable": false,          
                        }
                        ]                
    } );
	});
</script>
			
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dombaku</h1>
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
                 <!-- Begin MailChimp Signup Form -->
		  <link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
		  <style type="text/css">
			  #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
			  /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			    We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		  </style>
                  
                  <table id="datalist" class="display" cellspacing="0" width="100%"></table>
                  
                  <p><a href="<?=site_url('dombaku_adm/afrm')?>" class="btn btn-primary"><b>Create a new content</b></a></p>
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>


<!--// e-content //-->						
<?php include_once('footer.php')?>