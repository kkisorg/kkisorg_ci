<? include("headerv2.php"); ?>


    <section id="blog" class="container">
        <div class="center">
            <h2>Contact Us</h2>

        </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-12">
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
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo set_value('name', isset($name) ? $name : null);?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo set_value('email', isset($email) ? $email : null);?>">
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="<?php echo set_value('mobile', isset($mobile) ? $mobile : null);?>">
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
            </div><!--/.row-->

         </div><!--/.blog-->

    </section><!--/#blog-->


<? include("footerv2.php"); ?>
