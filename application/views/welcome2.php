
<!-- Contact Section -->
<div id="contact" class="page">
<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="span12">
            <div class="title-page">
                 <img src="<?php echo base_url('static/images/logo.png');?>" width="40%"></img><br><br>
                <!--<h2 class="title">Welcome</h2>-->
                <h3 class="title-description">Please login</h3><br>
                <?php echo form_open("login");?>
					<input type="text" name="creds" placeholder="Firstname Lastname"></input><br>
					<input type="password" name="password" placeholder="Password"></input><br>
					<input type="submit" value="Login"></input>
				<?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Js -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
<script src="static/_include/js/bootstrap.min.js"></script> <!-- Bootstrap -->
<script src="static/_include/js/supersized.3.2.7.min.js"></script> <!-- Slider -->
<script src="static/_include/js/waypoints.js"></script> <!-- WayPoints -->
<script src="static/_include/js/waypoints-sticky.js"></script> <!-- Waypoints for Header -->
<script src="static/_include/js/jquery.isotope.js"></script> <!-- Isotope Filter -->
<script src="static/_include/js/jquery.fancybox.pack.js"></script> <!-- Fancybox -->
<script src="static/_include/js/jquery.fancybox-media.js"></script> <!-- Fancybox for Media -->
<script src="static/_include/js/jquery.tweet.js"></script> <!-- Tweet -->
<script src="static/_include/js/plugins.js"></script> <!-- Contains: jPreloader, jQuery Easing, jQuery ScrollTo, jQuery One Page Navi -->
<script src="static/_include/js/main.js"></script> <!-- Default JS -->
<!-- End Js -->

</body>
</html>