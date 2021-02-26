<!-- Page -->
    <div class="page">
      <div class="page-header">
        <h1 class="page-title">Trash</h1>
      </div>
	  <style type="text/css">
	  	@media only screen and (max-width: 768px) {
	  		#TableContainer {overflow-x: scroll;}
		}
	  </style>
      <div class="page-content">
        <!-- Panel Basic -->
        <div class="panel">
		<div class="panel-body">
  			<div id="TableContainer">
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" data-sort="false" id="exampleTableTools">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Company</th>
                  <th>Project</th>
                  <th>Total</th>
                  <th>Due date</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Deleted</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
				<?php if (count($invoices) > 0) :
				foreach( $invoices as $row ) : ?>
				<tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['company']; ?></td>
                  <td><?php echo $row['project']; ?></td>
				  <td><?php echo ($row['total'] != '--' ? '$' : false) . $row['total']; ?></td>
                  <td><?php echo $row['due_date']; ?></td>
                  <td><?php echo $row['payment']; ?><br />
					<span><?php echo $row['change_pay']; ?></span>
				  </td>
				  <td><?php echo $row['status']; ?></td>
				  <td><?php echo $row['delete_date']; ?></td>
				  <td>
				  <a class="btn btn-xs btn-warning" href="<?php echo wp_nonce_url( '?restore=' . $row['id'], 'restore_nonce_' . $row['id'] ); ?>"
					   data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="Restore">
				   <i class="icon md-undo" aria-hidden="true"></i>
				  </a>
				  <a class="btn btn-xs btn-danger" href="<?php echo wp_nonce_url( '?delete_parma=' . $row['id'], 'delete_parma_nonce_' . $row['id'] ); ?>"
					  data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="Permanently Delete">
				   <i class="icon md-delete" aria-hidden="true"></i>
				  </a>
			  	  </td>
                </tr>
				<?php endforeach; endif; ?>
              </tbody>
            </table>
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
