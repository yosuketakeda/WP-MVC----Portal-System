<!-- Page -->
	<div class="page">
	  <style type="text/css">
	    @media only screen and (max-width: 768px) {
	  	  #dueTableContainer, #overdueTableContainer, #paidTableContainer {overflow-x: scroll;}
	    }
	  </style>
	  <div class="page-content">
		<!-- Panel Basic -->
		<div class="panel">
		  <div class="panel-body">
			  <ul class="nav nav-tabs float-center" style="font-size: 1.25rem;">
			  	<?php if (count($estimate_invoice) > 0) :
			  	foreach( $estimate_invoice as $i ) : ?>
			  	<li class="nav-item" style="text-align: center;">
			  	<a class="nav-link<?php echo ((isset($_GET['type']) && $_GET['type'] == $i) ? ' active' : (!isset($_GET['type']) && $i == 'estimates' ? ' active' : false) ); ?>" id="<?php echo $i; ?>Trigger" data-toggle="tab" href="javascript:void(0)">
			  		<?php echo ucwords($i); ?>
			  	</a></li>
			  	<?php endforeach; endif; ?>
			  </ul>
			  <br />
			  <div id="EstimateContainer">
			  	<table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" data-sort="false" id="exampleTableTools">
			  	<thead>
			  			<tr>
			  			<th>ID</th>
			  			<th>Project</th>
			  			<th>Total</th>
			  			<th>Due date</th>
			  			<th>Status</th>
			  			<th>Actions</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php if (count($estimates) > 0) :
			  		foreach( $estimates as $row ) : ?>
			  		<tr>
			  			<td><?php echo $row['id']; ?></td>
			  			<td><?php echo $row['project']; ?></td>
			  			<td><?php echo ($row['total'] != '--' ? '$' : false) . $row['total']; ?></td>
			  			<td><?php echo $row['due_date']; ?></td>
			  			<td><?php echo $row['status']; ?></td>
			  			<td>
			  				<a href="<?php echo site_url() . '/client/view_invoice/' . $row['id']; ?>" class="btn btn-xs btn-primary" target="_blank"
			  					data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="View">
			  					<span><i class="icon md-eye" aria-hidden="true"></i></span>
			  				</a>
			  			</td>
			  		</tr>
			  		<?php endforeach; endif; ?>
			  		</tbody>
			  	</table>
			  </div>
			  <div id="InvoiceContainer">
		  		<ul class="nav nav-tabs" style="font-size: 1.5rem;">
				<?php if (count($invoice_totals) > 0) :
				foreach( $invoice_totals as $key => $total ) : ?>
            	<li class="nav-item" style="width: 33%; text-align: center;">
								<a class="nav-link<?php echo ((isset($_GET['tab']) && $_GET['tab'] == $key) ? ' active' : (!isset($_GET['tab']) && $key == 'due' ? ' active' : false )); ?>" id="<?php echo $key; ?>Trigger" data-toggle="tab" href="javascript:void(0)"><?php echo ucwords($key); ?>
					<?php if ($key != 'paid') : ?>
					&nbsp;<p><?php echo (!empty($total) ? '$' : '&nbsp;') . $total; ?></p>
					<?php else : ?>
					<p>&nbsp;</p>
					<?php endif; ?>
				</a></li>
				<?php endforeach; endif; ?>
          		</ul>
				<br />
				<?php if (count($invoice_list) > 0) :
					foreach( $invoice_list as $key => $invoices ) : ?>
					<div id="<?php echo $key; ?>TableContainer">
						<table class="table table-hover dataTable table-striped w-full" id="<?php echo $key; ?>Table" data-sort="false" data-plugin="dataTable">
			  			<thead>
							<tr>
				  			<th>#</th>
				  			<th>Project</th>
				  			<th>Invoice date</th>
				  			<th>Due date</th>
				  			<th>Total</th>
				  			<th>Action</th>
							</tr>
			  			</thead>
			  			<tbody>
			   				<?php if (count($invoices) > 0) :
			   				foreach( $invoices as $row ) : ?>
			   				<tr>
				 				<td><?php echo $row['id']; ?></td>
				 				<td><?php echo $row['project']; ?></td>
				 				<td><?php echo $row['invoice_date']; ?></td>
				 				<td><?php echo $row['due_date']; ?></td>
				 				<td><?php echo ($row['total'] != '--' ? '$' : false) . $row['total']; ?></td>
				 				<td><a href="<?php echo site_url() . '/client/view_invoice/' . $row['id']; ?>" class="btn btn-sm btn-primary" target="_blank">View</a></td>
							</tr>
			   				<?php endforeach; endif; ?>
			  			</tbody>
					</table>
				</div>
				<?php endforeach; endif; ?>
				</div>
		  	</div>
		</div>
		<!-- End Panel Basic -->
   </div>
</div>

   <!-- Footer -->
   <footer class="site-footer">
	 <div class="site-footer-legal">© <?php echo date("Y"); ?> <a href="<?php echo 'https://drones-pov.com'; ?>" target="_blank">Dronespointofview</a></div>
   </footer>
