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
        "paginate": false,
        "searching": false,
        "ordering": false,
        "ajax": {
            "url": "<?=site_url('permission/ajx_view')?>",
            "type": "POST"
        },
        "aoColumnDefs"   : [
                         <?=$jData_Headers?>
                        ]                
    } );
	});
</script>
			
			<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Permission &raquo; List</h1>
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
                  <form action="<?=site_url('permission/perm_proc')?>" method="post">
                  <table id="datalist" class="display" cellspacing="0" width="100%"></table>
                  <br />
                  <input class="btn btn-primary" type="submit" name='Save'  value="Save"  />
					        <input class="btn btn-default" type="reset"  name='Reset' value="Reset" />
                  </form>
          </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->      
      </div>


<!--// e-content //-->						
<?php include_once('footer.php')?>