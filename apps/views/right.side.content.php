            <div class="col-md-4">
                <ul class="link-list-ul">
                  <li class="link-list"><a href="<?=site_url('content/bacaanmingguan')?>">&#x27AD; Bacaan Dwimingguan</s</a></li>
                  <li class="link-list"><a href="<?=site_url('content/dombaku')?>">&#x27AD; Bulletin Dwimingguan</a></li>
		   <li class="link-list"><a href="http://eepurl.com/boiRoH">&#x27AD; Berlangganan Dombaku</a></li>
                </ul>
              </div>
            <div class="col-md-4">
              <div class="box-header box-gradient">&#x27AD; Lokasi Misa Bahasa Indonesia</div>
                <div class="box-content">
                <? 
                    $res = $this->Page_model->select_by_id(array(
                                                        'page_name' => 'Jadwal Misa',
                                                      )); 
                ?>
                <?=$res['data']->page_v;?>
    
                </div>
            </div>
        </div>
        <!-- /.row -->