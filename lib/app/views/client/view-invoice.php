<!-- Page -->
    <div class="page">

      <div class="page-content">
        <!-- Panel -->
        <div class="panel">
          <div class="panel-body container-fluid">

			<?php if (!empty($old_invoice)) : ?>
			  <iframe src="<?php echo $old_invoice; ?>" height="750" class="container-fluid" style="border: none;"></iframe>
			<?php else : ?>

            <div class="row">
              <div class="col-lg-3">
                <h4>
                  <img class="mr-10" src="<?php echo DRONESPOV_IMAGE . 'dark-logo-fat.jpg'; ?>" alt="..." width="100" height="auto">
			  	</h4>
              </div>
              <div class="col-lg-3 offset-lg-6 text-right">
				<a class="font-size-20" href="javascript:void(0)"><?php echo ($invoice['is_estimate'] == '0' ? 'Invoice' : 'Estimate'); ?> #<?php echo $invoice['id']; ?></a>
              </div>
            </div>
			<hr />
              <div class="row">
                <div class="col-lg-3">
				<p>
					<?php foreach($invoice['admin_address'] as $addr) : ?>
					<br>
                	<span>
            			<?php echo $addr; ?>
                	</span>
					<?php endforeach; ?>
					<br>
                	<span>
            			<?php echo $invoice['admin_phone']; ?>
                	</span>
					<br>
                	<span>
            			<?php echo $invoice['admin_email']; ?>
                	</span>
				</p>
              	<p>
                	<br> Bill To:
                	<br>
                	<span class="font-size-20"><?php echo $invoice['company']; ?></span>
					<?php foreach($invoice['address'] as $addr) : ?>
					<br />
                	<span>
            			<?php echo $addr; ?>
                	</span>
					<?php endforeach; ?>
				</p>
				<br />
              	<h5>Project:</h5><p><?php echo $invoice['project']; ?></p>
              </div>
              <div class="col-lg-3 offset-lg-6 text-right">
                <br>
                <span><?php echo ($invoice['is_estimate'] == '0' ? 'Invoice' : 'Estimate'); ?> Date: <?php echo $invoice['invoice_date']; ?></span>
                <br>
                <span><?php echo ($invoice['is_estimate'] == '0' ? 'Due Date' : 'Expires'); ?>: <?php echo $invoice['due_date']; ?></span>
                <br>
                <span><?php echo 'Created by: ' . $invoice['created_by']; ?></span>
              </div>
            </div>
			<?php if (!empty($invoice['notes'])) : ?>
		  	<h5>Notes</h5>
		  	<p><?php echo $invoice['notes']; ?></p>
			<?php endif; ?>
            <div class="page-invoice-table table-responsive">
              <table class="table table-hover text-right" style="border: 1px solid #d4d4d4;">
                <thead>
                  <tr style="background: #e1e1e1;">
                    <th class="text-left">Item</th>
                    <th class="text-right">Amount</th>
                  </tr>
                </thead>
                <tbody>
				  <?php foreach ($invoice['items'] as $key => $item) : ?>
                  <tr>
                    <td class="text-left"><?php echo $item; ?></td>
                    <td class="text-right" style="border: 1px solid #d4d4d4;">$<?php echo $invoice['amounts'][$key]; ?></td>
                  </tr>
			  	  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="text-right clearfix">
              <div class="float-right">
				  <table class="table" style="border: none;">
                	<tbody>
                		<tr>
							<td class="text-right" style="border: none;">Tax (8.25%):&nbsp;&nbsp;&nbsp;</td>
                 			<td class="text-left" style="border: none;">$<?php echo $invoice['tax']; ?></td>
                		</tr>
              			<tr>
							<td class="text-right" style="border: none;">Total:&nbsp;&nbsp;&nbsp;</td>
                			<td class="text-left" style="border: none;">$<?php echo $invoice['total']; ?></td>
              			</tr>
					</tbody>
		  		</table>
              </div>
            </div>

            <div class="text-center">
              <a class="btn btn-animate btn-animate-side btn-info" href="<?php echo site_url() . (current_user_can('administrator') ? '/admin/download/' : '/client/download/') . $invoice['id']; ?>" target="_blank">
                <span><i class="icon md-download" aria-hidden="true"></i> Download</span>
			  </a>
            </div>
			<?php endif; ?>
          </div>
        </div>
        <!-- End Panel -->
      </div>
    </div>
    <!-- End Page -->

	<!-- Footer -->
    <footer class="site-footer">
 	 <div class="site-footer-legal">© <?php echo date("Y"); ?> <a href="<?php echo 'https://drones-pov.com'; ?>" target="_blank">Dronespointofview</a></div>
    </footer>
