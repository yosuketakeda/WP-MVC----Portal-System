		<!-- Page -->
		<div class="page">
  			<div class="page-header">
				<h1 class="page-title">Account</h1>
			</div>

			<div class="page-content container-fluid">
	  		<div class="row">
	  		   <div class="col-xl-6">

	                <!-- Panel Floating Labels -->
	                <div class="panel">
	                  <div class="panel-heading">
	                    <h3 class="panel-title"><?php echo (!empty($edit_data) ? __( 'Update invoice #', 'dronespov' ) . $edit_data['ID'] : false ); ?></h3>
	                  </div>
	                  <div class="panel-body container-fluid">
	  					<?php $row = (!empty($edit_data) ? maybe_unserialize($edit_data['row']) : false );
	  					global $dronespov_account_message;
	  		  			if ($dronespov_account_message) : ?>
	  		  				<div class="alert alert-primary" role="alert"><?php echo $dronespov_account_message; ?></div><br />
	  		  			<?php endif; ?>
	                    <form autocomplete="off" id="account" method="post" action="">
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_name" id="_dronespov_company_name" value="<?php echo esc_attr($company); ?>" required/>
  							  <label class="floating-label" for="_dronespov_company_name"><?php _e('Company name', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_email" id="_dronespov_company_email" value="<?php echo esc_attr($email); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_email"><?php _e('Company email', 'dronespov'); ?></label>
						  	</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_phone" id="_dronespov_company_phone" value="<?php echo esc_attr($phone); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_phone"><?php _e('Phone Number', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_street" id="_dronespov_company_street" value="<?php echo esc_attr($street); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_street"><?php _e('Street Address', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_city" id="_dronespov_company_city" value="<?php echo esc_attr($city); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_city"><?php _e('City', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_state" id="_dronespov_company_state" value="<?php echo esc_attr($state); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_state"><?php _e('State', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <input type="text" class="form-control" name="_dronespov_company_zip" id="_dronespov_company_zip" value="<?php echo esc_attr($zip); ?>"  required/>
  							  <label class="floating-label" for="_dronespov_company_zip"><?php _e('ZIP', 'dronespov'); ?></label>
							</div>
							<div class="form-group form-material floating" data-plugin="formMaterial">
							  <label class="" for="_dronespov_company_country"><?php _e('Country', 'dronespov'); ?></label>
							  <select class="form-control" name="_dronespov_company_country" id="_dronespov_company_country" required>
							    <?php foreach ($countries as $value) : ?>
							    <option value="<?php echo $value; ?>" <?php selected($value, $country, true); ?>><?php echo $value; ?></option>
							    <?php endforeach; ?>
							  </select>
							</div>
						  <input type="hidden" name="_dronespov_company_email_pre" value="<?php echo esc_attr($email); ?>" />
	  					  <?php wp_nonce_field( 'dronespov_account_nonce' ); ?>
	  					  <div class="form-group">
	                      	<button type="submit" class="btn btn-primary" name="dronespov_account"><?php echo __('Update', 'dronespov' ); ?></button>
	                      </div>
	                    </form>
	                  </div>
	                </div>
	                <!-- End Panel Floating Labels -->

	  		  </div>
	        </div>
	      </div>
	      <!-- End Page -->

		</div>

		<!-- Footer -->
		<footer class="site-footer">
		  <div class="site-footer-legal">© <?php echo date("Y"); ?> <a href="<?php echo 'https://drones-pov.com'; ?>" target="_blank">Dronespointofview</a></div>
		</footer>
