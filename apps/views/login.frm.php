<? $flag_first = 1;
include_once('header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-5"><br />
          <img src="<?=BANNER_IMAGES;?>logo_2.png" alt="" class="img-responsive" >
        </div> 
    </div>            
    <div class="row">  
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Welcome to KKIS Admin Site. Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <?php
              			/*
              			| status msgs here ;-)
              			*/
              			include_once('msg.php');
              			?>
                    <form role="form" action="<?=site_url('user/logfrm_proc')?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name='me' value="1" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <div class="form-group">
                              <a href="<?=site_url('user/fgotpass')?>">Forgot Password</a>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input class="btn btn-lg btn-success btn-block" type="submit" name='Login'  value="Login" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<? include_once('footer.php'); ?>
