<? include('header_front.php'); ?>
<? include('menu_front.php'); ?>


    <!-- Page Content -->
    <div class="container">
        
        <!-- Content Row -->
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <!--artikel-->
              <div class="col-md-10">
                  <h2>Contact Us</h2>
                            <? if($flag=='ok'){ ?>
					        <p class="alert alert-success"><b>Your enquiry has been submitted</b></p>
					        <? }elseif($flag=='emptymsg'){ ?>
					        <p class="alert alert-danger"><b>Message cannot be empty.</b></p>
					        <? }elseif($flag=='errcaptcha'){ ?>
					        <p class="alert alert-danger"><b>You must submit the word that appears in the image</b></p>
					        <? } ?>
                  <form action="<?=site_url('/content/kontak_process');?>" class="form-horizontal" method="post" role="form">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo set_value('name', $name);?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo set_value('email', $email);?>">
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="<?php echo set_value('mobile', $mobile);?>">
                  </div>
                  <div class="form-group">
                    <label for="type">To</label>
                    <select id="type" name="type" class="form-control">
                      <option value="publikasi">Publikasi</option>
                      <option value="romo">Romo</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" placeholder="Enter Message"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="message">Submit the word you see below: (case sensitive)</label>
                  <? 
                    echo '<br />'.$img_src.'<br /><br />';
                    echo '<input type="text" name="captcha" value="" class="form-control" id="captcha" placeholder="Enter word" />';
                  ?>
                  </div>
                  <input type="hidden" name="keyadd" value="<?=$keyadd;?>" />
                  <button type="submit" class="btn btn-warning">Submit</button>
                </form>
                            
              </div>
            </div>
          </div>
 
            
<? include('right.side.content.php'); ?>       
<? include('footer_front.php'); ?>
