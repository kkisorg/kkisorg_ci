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
        "filter":false,
        "ajax": {
            "url": "<?=site_url('eventlog/ajx_view')?>",
            "type": "POST"
        },
        "aoColumnDefs"   : [
                         {
                           "sTitle"   : "Remarks",
                           "sName"    : "remarks",
                           "sType"    : "string",
                           "aTargets" : [ 0 ],           
                           "bSortable": true,           
                         },
                        {
                           "sTitle"    : "IP",
                           "sName"    : "uri",
                           "sType"    : "Date",
                           "aTargets" : [ 1 ],            
                           "bSortable": true,            
                        },
                        {
                           "sTitle"    : "Created",
                           "sName"    : "created",
                           "sType"    : "string",
                           "aTargets" : [ 2 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "By",
                           "sName"     : "created_by",
                           "sType"    : "string",
                           "aTargets" : [ 3 ],            
                           "bSortable": true,          
                        }
                        ]                
    } );
	});
</script>
			<!--//status//-->
			<?php
			/*
			| status msgs here ;-)
			*/
			include_once('msg.php');
			?>
			<!--//status//-->
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Event Log</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="row">
                <div class="col-lg-12">
                  
                  <table id="datalist" class="display" cellspacing="0" width="100%"></table>
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>


<!--// e-content //-->						
<?php include_once('footer.php')?>

