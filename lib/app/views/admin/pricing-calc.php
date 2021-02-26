<div class="page">
  <script type="text/javascript">
  function computePricing(){
      var sqft = document.getElementById('sqft').value;
      var insurance = document.getElementById('insurance').value;
      var itotal = (sqft * insurance);
      var tsqft = (+itotal + +sqft);
      var dtotal = (tsqft * .10);
      document.getElementById('itotal').innerHTML = "Insurance SQFT = "+itotal;
      document.getElementById('tsqft').innerHTML = "Total Square Feet = "+tsqft;
      document.getElementById('dtotal').innerHTML = "Total = $"+dtotal;
  }
  </script>

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-xl-6">
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Price Calculator</h3>
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
                <div class="form-group form-material floating">
                  <input class="form-control" id="sqft" type="number" min="1" max="1000000" value="" onchange="computePricing()">
                  <label for="sqft" class="">Square Footage</label>
                </div>
              </div>
              <div class="col-xl-6">
               <div class="form-group form-material floating">
                 <input class="form-control" id="insurance" type="number" min="-1" max="100" value=".10" step=".1" onchange="computePricing()">
                <label for="insurance" class="">Insurance SQFT (default 10%)</label>
              </div>
            </div>
          </div>
          </form>
          <h2 id="itotal"></h2>
          <h2 id="tsqft"></h2>
          <h2 id="dtotal"></h2>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Footer -->
<footer class="site-footer">
  <div class="site-footer-legal">© <?php echo date("Y"); ?> <a href="<?php echo 'https://drones-pov.com'; ?>" target="_blank">Dronespointofview</a></div>
</footer>
