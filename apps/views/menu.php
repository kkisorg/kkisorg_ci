<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">KKIS Admin Site</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
        					        if ($this->etc->is_logged_in()) :
        					      ?>
                        <li><a href="<?=site_url('user/eprof')?>"><i class="fa fa-user fa-fw"></i> My Profile</a>
                        </li>
                        <li><a href="<?=site_url('user/chpass')?>"><i class="fa fa-gear fa-fw"></i> Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?=site_url('user/logout')?>" ><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                        <?php endif?>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
              				
              				<? if ($this->etc->is_logged_in()&&($this->etc->get_role_id()!=3)) : ?>	
              					<li>
              						<?php
              						//if ($this->etc->is_logged_in()&&($this->etc->get_role_id()==7 || $this->etc->get_role_id()==1)) :
              						
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Artikel<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('artikel_adm')?>">Artikel List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('artikel_adm/afrm')?>">Add New Artikel</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
                        
                        <li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Renungan<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('renungan_adm')?>">Renungan List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('renungan_adm/afrm')?>">Add New Renungan</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
                        
                        <li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Pengumuman<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('pengumuman_adm')?>">Pengumuman List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('pengumuman_adm/afrm')?>">Add New Pengumuman</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
                        
                        <li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Kegiatan<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('kegiatanliturgi_adm')?>">Kegiatan Liturgi List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('kegiatanliturgi_adm/afrm')?>">Add New Kegiatan Liturgi</a>
              						  </li>
              						  
              						  <li>
              							<a href="<?=site_url('kegiatan_adm')?>">Kegiatan Rohani List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('kegiatan_adm/afrm')?>">Add New Kegiatan Rohani</a>
              						  </li>
              							
              						  <li>
              							<a href="<?=site_url('laporan_kegiatan_adm')?>">Laporan Kegiatan List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('laporan_kegiatan_adm/afrm')?>">Add New Laporan Kegiatan</a>
              						  </li>
              							
              						</ul>
                          
              						<?php endif?>
              					</li>
                        
                        <li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Pelayanan<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('pelayanan_adm')?>">Pelayanan List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('pelayanan_adm/afrm')?>">Add New Pelayanan</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
                        
                        <li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Dombaku<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('dombaku_adm')?>">Dombaku List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('dombaku_adm/afrm')?>">Add New Dombaku</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
              				
              					
              					
              					<li>
              						<?php
              						if ($this->etc->is_logged_in()) :
              					
              						?>
              						<a href="#"><i class="fa fa-wrench fa-fw"></i>Settings<span class="fa arrow"></span></a>
              						<ul class="nav nav-second-level">
              					    <li>
              							<a href="<?=site_url('header_news_adm')?>">Header Image</a>
              
                						</li>
                					   
                						<li>
                							<a href="<?=site_url('page')?>">Pages</a>
                						
                						</li>
                              
						              </ul>
					
						          <?php endif?>
            					</li>
            				<? endif; //user role!=3
            				?>
            					
            					<li>
              						<?php
                            if ($this->etc->is_logged_in()):
              						?>
              						<a href="" ><i class="fa fa-edit fa-fw"></i>Bacaan Mingguan<span class="fa arrow"></span></a>
              						
              						<ul class="nav nav-second-level">
              						  <li>
              							<a href="<?=site_url('bacaanmingguan_adm')?>">Bacaan Mingguan List</a>
              						  </li>
              						    <li>
              							<a href="<?=site_url('bacaanmingguan_adm/afrm')?>">Add New Bacaan Mingguan</a>
              						  </li>
              							
              						</ul>
              						<?php endif?>
              					</li>
                      
                      <li>
              						<?php
              						if ($this->etc->is_logged_in()&&$this->etc->get_role_id()==1) :
              					
              						?>
              						<a href="#"><i class="fa fa-edit fa-fw"></i>User<span class="fa arrow"></span></a>
              						<ul class="nav nav-second-level">
              					    
                              
                					    <li>
                							<a href="<?=site_url('user')?>">User</a>
                
                						</li>
                						
                						<li>
                							<a href="<?=site_url('role')?>">User Roles</a>
                
                						</li>
                						
                						<li>
                							<a href="<?=site_url('resource')?>">Resource</a>
                
                						</li>
                						
                						<li>
                							<a href="<?=site_url('permission')?>">User Permissions</a>
                
                						</li>
                						<li>
                							<a href="<?=site_url('eventlog')?>">Event Log</a>
                
                						</li>
					    
						              </ul>
					
						          <?php endif?>
            					</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<?
 // 1-super-root
 // 2-admin
?>
		