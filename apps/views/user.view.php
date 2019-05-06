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
            "url": "<?=site_url('user/ajx_view')?>",
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
                           "sTitle"    : "Email",
                           "sName"    : "email",
                           "sType"    : "string",
                           "aTargets" : [ 1 ],            
                           "bSortable": true,            
                        },
                        {
                           "sTitle"    : "Role",
                           "sName"    : "role",
                           "sType"    : "Date",
                           "aTargets" : [ 2 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Status",
                           "sName"    : "status",
                           "sType"    : "Date",
                           "aTargets" : [ 3 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Created",
                           "sName"    : "created",
                           "sType"    : "Date",
                           "aTargets" : [ 4 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Password Expiry",
                           "sName"    : "pass_expiry",
                           "sType"    : "Date",
                           "aTargets" : [ 5 ],            
                           "bSortable": true,          
                        },
                        {
                           "sTitle"    : "Action",
                           "sType"    : "string",
                           "aTargets" : [ 6 ],            
                           "bSortable": false,          
                        }
                        ]                
    } );
	});
</script>
			
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User</h1>
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
                  
                  <p><a href="<?=site_url('user/afrm')?>" class="btn btn-primary"><b>Create a new user</b></a></p>
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>


<!--// e-content //-->						
<?php include_once('footer.php')?>