<?
 // 1-super-root
 // 2-admin
?>
			<div class="grid_16">
				<div id="menustayl1" class=""  >
				   <div id="menustayl2" class="menustyle2" > 
				<ul class="nav main" >
					<li>
						<a href="<?=site_url('/admin')?>">My Home</a>
						<?php
							if ($this->etc->is_logged_in()) :
					        ?>
						<ul>
							<li>
								<a href="<?=site_url('user/chpass')?>">Change Password</a>
							</li>
							<li>
								<a href="<?=site_url('user/eprof')?>">My Profile</a>
							</li>
						</ul>
						<?php endif?>
					</li>
					
					<li>
						<?php
						//if ($this->etc->is_logged_in()&&($this->etc->get_role_id()==7 || $this->etc->get_role_id()==1)) :
              if ($this->etc->is_logged_in()):
						?>
						<a href="" >Artikel</a>
						
						<ul>
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
						<a href="" >Renungan</a>
						
						<ul>
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
						<a href="" >Pengumuman</a>
						
						<ul>
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
						<a href="" >Kegiatan</a>
						
						<ul>
						  <li>
							<a href="<?=site_url('kegiatan_adm')?>">Kegiatan List</a>
						  </li>
						    <li>
							<a href="<?=site_url('kegiatan_adm/afrm')?>">Add New Kegiatan</a>
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
						<a href="" >Pelayanan</a>
						
						<ul>
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
						<a href="" >Dombaku</a>
						
						<ul>
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
						<a href="#">Settings</a>
						<ul>
					    <li>
							<a href="<?=site_url('header_news_adm')?>">Header Image</a>

						</li>
					   
						<li>
							<a href="<?=site_url('page')?>">Pages</a>
						
						</li>
              
              <?php
    						if ($this->etc->is_logged_in()&&$this->etc->get_role_id()==1) :
    					
    						?>
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
						
					  <?php endif?>
					    
						
						
						</ul>
					
						<?php endif?>
					</li>
					<li>
					        <?php
					        if ($this->etc->is_logged_in()) :
					        ?>
					        	<a href="<?=site_url('user/logout')?>" >Logout</a>
					        <?php endif?>
					</li>
				</ul>
				
				</div>
			    </div>
			</div>
			
			<div class="clear"></div>
			