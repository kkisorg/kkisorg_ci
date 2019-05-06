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
            "url": "<?=site_url('resource/ajx_view')?>",
            "type": "POST"
        },
        "aoColumnDefs"   : [
                         {
                           "sTitle"   : "Name",
                           "sName"    : "name",
                           "sType"    : "string",
                           "aTargets" : [ 0 ],           
                           "bSortable": true,           
                         },
                        {
                           "sTitle"    : "Description",
                           "sName"    : "description",
                           "sType"    : "string",
                           "aTargets" : [ 1 ],            
                           "bSortable": true,            
                        },
                        {
                           "sTitle"    : "Created",
                           "sName"    : "created",
                           "sType"    : "Date",
                           "aTargets" : [ 2 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Action",
                           "sType"    : "string",
                           "aTargets" : [ 3 ],            
                           "bSortable": false,          
                        }
                        ]                
    } );
	});
</script>
			
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Resource</h1>
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
                  
                  <table id="datalist" class="display" cellspacing="0" width="100%"></table>
                  
                  <p><a href="<?=site_url('resource/afrm')?>" class="btn btn-primary"><b>Create a new content</b></a></p>
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>


<!--// e-content //-->						
<?php include_once('footer.php')?>