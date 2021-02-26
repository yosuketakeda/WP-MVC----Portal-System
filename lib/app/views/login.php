	<body class="animsition page-login-v3 layout-full" style="background-color: #232324; height: auto;">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

	<div class="brand" style="text-align: center; margin-top: 15px;margin-bottom: 10px;">
		<a href="<?php echo site_url(); ?>">
		<img class="brand-img text-center" src="<?php echo DRONESPOV_IMAGE . 'logo.png'; ?>" height="100" width="auto" alt="...">
		</a>
	</div>
    <!-- Page -->
    <div class="page vertical-align text-center" style="height: auto;" data-animsition-in="fade-in" data-animsition-out="fade-out">
      <div class="page-content vertical-align-middle" style="padding: 0px 30px;">
		  <div class="panel">
            <div class="panel-body">
		  		<?php global $dronespov_login_message;
		  			if ($dronespov_login_message) : ?>
		  				<div class="alert alert-primary" role="alert"><?php echo $dronespov_login_message; ?></div>
		  			<?php endif; ?>

          			<form method="post" name="dronespov-login" action="" autocomplete="off">
            			<div class="form-group form-material floating" data-plugin="formMaterial">
              				<input type="email" class="form-control empty" id="inputEmail" name="email" required>
              				<label class="floating-label" for="inputEmail">Email</label>
            			</div>
            			<div class="form-group form-material floating" data-plugin="formMaterial">
              				<input type="password" class="form-control empty" id="inputPassword" name="password" required>
              				<label class="floating-label" for="inputPassword">Password</label>
            			</div>
            			<div class="form-group clearfix">
              				<div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                				<input type="checkbox" id="remember" name="remember">
                				<label for="inputCheckbox">Remember me</label>
              				</div>
              				<a class="float-right" target="_blank" href="<?php echo esc_url( wp_lostpassword_url( get_home_url() ) ); ?>">Forgot password?</a>
            			</div>
						<?php wp_nonce_field( 'dronespov_login' ); ?>
            			<button type="submit" name="dronespov-login" class="btn btn-primary btn-block sign-in">Sign in</button>
          			</form>

          			<p>Don't have an account? <a href="<?php echo site_url() . '/register'; ?>">Sign Up</a></p>
        		</div>
      		</div>

			<footer class="page-copyright page-copyright-inverse">
				<p>© <?php echo date("Y"); ?>. All RIGHT RESERVED.</p>
			</footer>
    	</div>
	</div>
    <!-- End Page -->

