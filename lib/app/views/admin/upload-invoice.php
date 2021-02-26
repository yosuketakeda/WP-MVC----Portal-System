	<!-- Page -->
    <div class="page">

	  <style type="text/css">
	  	.autocomplete-items {
		  position: absolute; border: 1px solid #d4d4d4; border-bottom: none; border-top: none; z-index: 99; top: 100%; left: 0; right: 0;
	  	}
	  	.autocomplete-items div {
		  padding: 10px; cursor: pointer; background-color: #fff; border-bottom: 1px solid #d4d4d4;
	  	}
	  	.autocomplete-items div:hover {
		  background-color: #e9e9e9;
	  	}
	  	.autocomplete-active {
		  background-color: DodgerBlue !important; color: #ffffff;
	  	}
		.dropify-wrapper .dropify-message span.file-icon {
			font-size: 20px;
		}
	  </style>

      <div class="page-content container-fluid">
		<div class="row">
		   <div class="col-xl-6">

              <!-- Panel Floating Labels -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo (!empty($edit_data) ? ($edit_data['is_estimate'] == 1 ? __( 'Edit Estimate #', 'dronespov' ) : __( 'Edit Invoice #', 'dronespov' ) ) . $edit_data['ID'] : false ); ?>
		           <?php echo (empty($edit_data) ? '<button id="upload-trigger" class="btn btn-md btn-info float-right"><span><i class="icon md-upload" aria-hidden="true"></i></span></button>' : false ); ?></h3>
            </div>
            <div class="panel-body container-fluid">
		        <?php
		        $uploaded = ((isset($_GET['uploaded']) && $_GET['uploaded'] == 'true') ? true : false);
		        $row = (!empty($edit_data) ? maybe_unserialize($edit_data['row']) : false );
		        global $dronespov_create_invoice_message;
  		      if ($dronespov_create_invoice_message) : ?>
  			      <br /><div class="alert alert-primary" role="alert"><?php echo $dronespov_create_invoice_message; ?></div><br />
  		      <?php endif; ?>
            <form autocomplete="off" id="create" method="post" action="">
  					  <div class="form-group form-material floating row" data-plugin="formMaterial">
						    <div class="col-xl-6">
							    <div class="radio-custom radio-default">
								    <input id="estimate" type="radio" class="form-control" name="type" value="1" <?php checked('1', $edit_data['is_estimate'], true); ?>>
								    <label for="estimate" class="">Estimate</label>
							    </div>
						    </div>
                <div class="col-xl-6">
							   <div class="radio-custom radio-default">
  								<input id="invoice" type="radio" class="form-control" name="type" value="0" <?php echo (!empty($edit_data) ? checked('0', $edit_data['is_estimate'], false) : 'checked'); ?>/>
								<label for="invoice" class="">Invoice</label>
							</div>
						</div>
  				  </div>
				  	<div class="form-group form-material floating" data-plugin="formMaterial">
						<select class="form-control" name="bill_to" required>
					  		<option>&nbsp;</option>
					  		<?php if (count($user_list) > 0 ) :
					  		foreach($user_list as $user) : ?>
						  	<option value="<?php echo $user['id']; ?>" <?php selected($user['id'], $edit_data['bill_to'], true); ?>><?php echo $user['name'] . ' [' . $user['company'] . ']'; ?></option>
					  		<?php endforeach;
					  		endif; ?>
						</select>
						<label class="floating-label">Bill to</label>
				  	</div>
					<div class="form-group form-material floating" data-plugin="formMaterial">
						<input id="project" type="text" class="form-control" name="project" value="<?php echo (!empty($edit_data) ? base64_decode($edit_data['project']) : false); ?>" placeholder="" <?php echo (!$uploaded ? 'required' : false); ?> />
						<label class="floating-label">Project Name</label>
				  	</div>
					<div id="item_row">
				  		<div class="form-group form-material row">
                    		<div class="col-md-5">
                        		<input id="item" type="text" name="row[item][]" value="<?php echo (!empty($edit_data) ? array_keys($row[0])[0] : false); ?>" class="form-control item" <?php echo (!$uploaded ? 'required' : false); ?>/>
                        		<label class="">Item</label>
                    		</div>
					  		<div class="col-md-5">
                        		<input id="amount" type="number" name="row[amount][]" class="form-control" value="<?php echo (!empty($edit_data) ? $row[0][array_keys($row[0])[0]] : false); ?>" <?php echo (!$uploaded ? 'required' : false); ?>/>
                        		<label class="">Amount</label>
                    		</div>
					  		<div class="col-md-2">
							<a class="btn btn-xs btn-danger" id="delete_item" href="javascript:void(0)">
			  				   <span><i class="icon md-delete" aria-hidden="true"></i></span>
			  				 </a>
                    		</div>
                  		</div>
					</div>
					<div id="item_row_append_to">
						<?php if (is_array($row) && count($row) > 1) :
							unset($row[0]);
							foreach ($row as $value) :
							?>
							<div class="form-group form-material row">
	                    		<div class="col-md-5">
	                        		<input id="item" type="text" name="row[item][]" value="<?php echo (!empty($edit_data) ? array_keys($value)[0] : false); ?>" class="form-control item" <?php echo (!$uploaded ? 'required' : false); ?>/>
	                        		<label class="">Item</label>
	                    		</div>
						  		<div class="col-md-5">
	                        		<input id="amount" type="number" name="row[amount][]" class="form-control amount" value="<?php echo (!empty($edit_data) ? $value[array_keys($value)[0]] : false); ?>" <?php echo (!$uploaded ? 'required' : false); ?>/>
	                        		<label class="">Amount</label>
	                    		</div>
						  		<div class="col-md-2">
								<a class="btn btn-xs btn-danger" id="delete_item" href="javascript:void(0)">
				  				   <span><i class="icon md-delete" aria-hidden="true"></i></span>
				  				 </a>
	                    		</div>
	                  		</div>
						<?php endforeach; endif; ?>
					</div>
					<a href="javascript:void(0);" id="more_items" class="btn btn-info btn-sm">More items</a>
					<div class="form-group form-material floating">
                      <input id="tax" type="number" class="form-control" name="tax" data-plugin="formMaterial"  value="<?php echo (!empty($edit_data) ? $edit_data['tax'] : false); ?>" <?php echo (!$uploaded ? 'required' : false); ?> />
                      <label class="">Tax amount</label>
                    </div>
					<div class="form-group form-material floating" data-plugin="formMaterial">
                      <input id="total_amount" type="number" min="0" step="1" class="form-control" name="total"  value="<?php echo (!empty($edit_data) ? $edit_data['total'] : false); ?>" readonly <?php echo (!$uploaded ? 'required' : false); ?> />
                      <label class="">Total</label>
                    </div>
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                      <textarea class="form-control" rows="6" name="notes"><?php echo (!empty($edit_data) ? str_replace('<br />', "", stripslashes(base64_decode($edit_data['notes']))) : false); ?></textarea>
                      <label class="floating-label">Description</label>
                    </div>
                    <div class="form-group form-material row">
                      <div class="col-md-6">
                          <input type="date" name="invoice_date" class="form-control" value="<?php echo ((!empty($edit_data) && $edit_data['invoice_date'] != '0000-00-00') ? date("Y-m-d", strtotime($edit_data['invoice_date'])) : false); ?>" <?php echo (!$uploaded ? 'required' : false); ?>/>
                          <label class="">Invoice date</label>
                      </div>
					  <div class="col-md-6">
                          <input type="date" name="due_date" class="form-control" value="<?php echo ((!empty($edit_data) && $edit_data['due_date'] != '0000-00-00') ? date("Y-m-d", strtotime($edit_data['due_date'])) : false); ?>" <?php echo (!$uploaded ? 'required' : false); ?>/>
                          <label class="">Due date</label>
                      </div>
                    </div>
					<?php wp_nonce_field( 'dronespov_new_invoice' ); ?>
					<?php echo (!empty($edit_data) ? '<input type="hidden" name="edit" value="' . $edit_data['ID'] . '" />' : false ); ?>
					<?php echo ($uploaded ? '<input type="hidden" name="uploaded" value="1" />' : false); ?>
					<div class="form-group">
                    	<button type="submit" class="btn btn-primary" name="dronespov-new-invoice"><?php echo (!empty($edit_data) ? 'Update' : 'Create' ); ?></button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End Panel Floating Labels -->

		  </div>

		  <div class="col-xl-6" id="upload">

		     <!-- Panel Floating Labels -->
		     <div class="panel">
		  	 	<div class="panel-body container-fluid">
		  	 	<?php $row = (!empty($edit_data) ? maybe_unserialize($edit_data['row']) : false );
		  	 	global $dronespov_upload_invoice_message;
		  	 	if ($dronespov_upload_invoice_message) : ?>
		  		 	<div class="alert alert-primary" role="alert"><?php echo $dronespov_upload_invoice_message; ?></div><br />
		  	 	<?php endif; ?>
		  	   	<form autocomplete="off" method="post" action="" enctype="multipart/form-data">
              <div class="form-group form-material floating row" data-plugin="formMaterial">
                <div class="col-xl-6">
                  <div class="radio-custom radio-default">
                    <input id="upload_estimate" type="radio" class="form-control" name="upload_type" value="1" />
                    <label for="upload_estimate" class="">Estimate</label>
                  </div>
                </div>
                <div class="col-xl-6">
                 <div class="radio-custom radio-default">
                  <input id="upload_invoice" type="radio" class="form-control" name="upload_type" value="0" checked />
                <label for="upload_invoice" class="">Invoice</label>
              </div>
            </div>
            </div>
		  		 	<div class="form-group form-material floating" data-plugin="formMaterial">
		  			 	<select class="form-control" name="bill_to" required>
		  				 <option>&nbsp;</option>
		  				 <?php if (count($user_list) > 0 ) :
		  				 foreach($user_list as $user) : ?>
		  				 <option value="<?php echo $user['id']; ?>" <?php selected($user['id'], $edit_data['bill_to'], true); ?>><?php echo $user['name'] . ' [' . $user['company'] . ']'; ?></option>
		  				 <?php endforeach;
		  				 endif; ?>
		  			 	</select>
		  			 	<label class="floating-label">Bill to</label>
		  		 	</div>
		  		 	<div class="form-group form-material floating" data-plugin="formMaterial">
		  		   		<input type="number" min="0" step="1" class="form-control" name="invoice_id"  value="" required />
						<label class="floating-label">Invoice ID</label>
		  		 	</div>
		  		 	<div class="form-group">
		  		   		<input type="file" id="old_invoice" name="old_invoice" data-default-file="" data-height="250" data-max-file-size="2M" data-allowed-file-extensions="pdf" required>
		  		 	</div>
		  		 	<?php wp_nonce_field( 'dronespov_upload_new_invoice' ); ?>
		  		 	<div class="form-group">
		  			 	<button type="submit" class="btn btn-primary" name="dronespov-upload-invoice">Upload</button>
		  		 	</div>
		  	   	</form>
		  	 	</div>
		     </div>
		     <!-- End Panel Floating Labels -->

		  </div>

      </div>
    </div>
    <!-- End Page -->

	<div id="item_row_copy" style="display:none;">
		<div class="form-group form-material row">
			<div class="col-md-5">
				<input id="item" type="text" name="row[item][]" value="" class="form-control item" required/>
				<label class="">Item</label>
			</div>
			<div class="col-md-5">
				<input id="amount" type="number" name="row[amount][]" class="form-control" value="" required/>
				<label class="">Amount</label>
			</div>
			<div class="col-md-2">
			<a class="btn btn-xs btn-danger" id="delete_item" href="javascript:void(0)">
			   <span><i class="icon md-delete" aria-hidden="true"></i></span>
			 </a>
			</div>
		</div>
	</div>
	</div>

    <!-- Footer -->
    <footer class="site-footer">
      <div class="site-footer-legal">© <?php echo date("Y"); ?> <a href="<?php echo 'https://drones-pov.com'; ?>" target="_blank">Dronespointofview</a></div>
    </footer>
