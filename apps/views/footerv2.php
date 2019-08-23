
    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    &copy; 2016 KKIS
                </div>
                <div class="col-sm-8">
                    <ul class="pull-right">
                    	<li><a href="<?=site_url();?>">Home</a></li>
                    	<li><a href="<?=site_url('content/kontak');?>">Kontak</a></li>
                        <li><a href="http://eepurl.com/boiRoH">Berlangganan Dombaku</a></li>
                        <li><a href="https://www.facebook.com/kkis.org/" target="_blank">Follow us &nbsp;<i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="<?=FILEPATH_UI;?>js/jquery.js"></script>
    <script src="<?=FILEPATH_UI;?>js/bootstrap.min.js"></script>
    <script src="<?=FILEPATH_UI;?>js/jquery.prettyPhoto.js"></script>
    <script src="<?=FILEPATH_UI;?>js/jquery.isotope.min.js"></script>
    <script src="<?=FILEPATH_UI;?>js/main.js"></script>
    <script src="<?=FILEPATH_UI;?>js/wow.min.js"></script>

    <!-- Whatsapp -->
    <style>
    .float{
    	position:fixed;
    	width:60px;
    	height:60px;
    	bottom:40px;
    	right:40px;
    	background-color:#25d366;
    	color:#FFF;
    	border-radius:50px;
    	text-align:center;
        font-size:30px;
    	box-shadow: 2px 2px 3px #999;
        z-index:100;
    }

    .my-float{
    	margin-top:16px;
    }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=6585917218" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
</body>
</html>
