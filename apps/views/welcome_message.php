<?php 
/*
| header + menu
*/
include_once('header.php');
include_once('menu.php');
?>
<!--// s-content //-->	
			
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
                    <h1 class="page-header">Welcome to KKIS Admin Site.</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <? if ($this->etc->is_logged_in()&&($this->etc->get_role_id()!=3)) : ?>	
					  <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">Artikel</div>
                              <div></div>
                          </div>
                      </div>
                  </div>
                  <a href="<?=site_url('artikel_adm')?>">
                      <div class="panel-footer">
                          <span class="pull-left">View List</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">Renungan</div>
                              <div></div>
                          </div>
                      </div>
                  </div>
                  <a href="<?=site_url('renungan_adm')?>">
                      <div class="panel-footer">
                          <span class="pull-left">View List</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">Dombaku</div>
                              <div></div>
                          </div>
                      </div>
                  </div>
                  <a href="<?=site_url('dombaku_adm')?>">
                      <div class="panel-footer">
                          <span class="pull-left">View List</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">Pengumuman</div>
                              <div></div>
                          </div>
                      </div>
                  </div>
                  <a href="<?=site_url('pengumuman_adm')?>">
                      <div class="panel-footer">
                          <span class="pull-left">View List</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
            </div>
			</div>
		<? endif; ?>	
  </div>
    <!-- /#wrapper -->
    			
<!--// e-content //-->
<?php
if (!$this->etc->is_logged_in()) 
{
	redirect(site_url('user/login'));
}
?>								
<?php include_once('footer.php')?>