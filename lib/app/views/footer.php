<?php do_action( 'doronespov_footer' ); ?>

<?php $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (false !== strpos($path, 'admin/create_invoice')) : ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {

		function autocomplete(inp, arr) {
  			var currentFocus;
  			inp.addEventListener("input", function(e) {
      			var a, b, i, val = this.value;
      			closeAllLists();
      			if (!val) { return false;}
      				currentFocus = -1;
      				a = document.createElement("DIV");
      				a.setAttribute("id", this.id + "autocomplete-list");
      				a.setAttribute("class", "autocomplete-items");
      				this.parentNode.appendChild(a);
      				for (i = 0; i < arr.length; i++) {
        				if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          					b = document.createElement("DIV");
          					b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          					b.innerHTML += arr[i].substr(val.length);
          					b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          					b.addEventListener("click", function(e) {
              					inp.value = this.getElementsByTagName("input")[0].value;
              					closeAllLists();
          					});
          					a.appendChild(b);
        				}
      				}
  				});
  				inp.addEventListener("keydown", function(e) {
      			var x = document.getElementById(this.id + "autocomplete-list");
      			if (x) x = x.getElementsByTagName("div");
      			if (e.keyCode == 40) {
        			currentFocus++;
        			addActive(x);
      			} else if (e.keyCode == 38) {
        			currentFocus--;
        			addActive(x);
      			} else if (e.keyCode == 13) {
        			e.preventDefault();
        			if (currentFocus > -1) {
          				if (x) x[currentFocus].click();
        			}
      			}
  			});
  			function addActive(x) {
    			if (!x) return false;
    			removeActive(x);
    			if (currentFocus >= x.length) currentFocus = 0;
    			if (currentFocus < 0) currentFocus = (x.length - 1);
    				x[currentFocus].classList.add("autocomplete-active");
  				}
  				function removeActive(x) {
    				for (var i = 0; i < x.length; i++) {
      					x[i].classList.remove("autocomplete-active");
    				}
				}
				function closeAllLists(elmnt) {
    				var x = document.getElementsByClassName("autocomplete-items");
    				for (var i = 0; i < x.length; i++) {
      					if (elmnt != x[i] && elmnt != inp) {
        					x[i].parentNode.removeChild(x[i]);
      					}
    				}
  				}
  				document.addEventListener("click", function (e) {
      				closeAllLists(e.target);
  				});
			}

			var projects = [
			<?php if (count($project_list) > 0 ) :
				foreach($project_list as $project) :
					echo '"' . $project . '", ';
				endforeach;
			endif; ?>
			];

			var items = [
			<?php if (count($item_list) > 0 ) :
				foreach($item_list as $item) :
					echo '"' . $item . '", ';
				endforeach;
			endif; ?>
			];

			var taxes = [
			<?php if (count($tax_list) > 0 ) :
				foreach($tax_list as $item) :
					echo '"' . $item . '", ';
				endforeach;
			endif; ?>
			];

			autocomplete(document.getElementById("project"), projects);
			autocomplete(document.getElementById("tax"), taxes);
			document.querySelectorAll("#item").forEach(function(item, index){
				autocomplete(item, items);
			});

			jQuery('#more_items').click(function() {
				var html = jQuery('#item_row_copy').html();
				jQuery('#item_row_append_to').append(html);
				document.querySelectorAll("#item").forEach(function(item, index){
					autocomplete(item, items);
				});
			});

			function appendTotal() {
				var value = jQuery('input[name="row[amount][]"]').map(function(){return jQuery(this).val();}).get();
				var tax = jQuery('input[name="tax"]').val();
				var total = 0;
				for (var i = 0; i <= value.length; i++) {
				    total += value[i] << 0;
				}
				total = (total + parseInt(tax));

				jQuery('#total_amount').val(total);
			}

			jQuery(document).delegate('#amount', 'change paste keyup keydown click', function(){
				appendTotal();
			});
			jQuery(document).delegate('#tax', 'change paste keyup keydown click', function(){
				appendTotal();
			});
			jQuery(document).delegate('#taxautocomplete-list', 'change paste keyup keydown click', function(){
				appendTotal();
			});

			jQuery(document).delegate('#delete_item', 'click', function(){
				jQuery(this).closest('.form-group').remove();
				appendTotal();
			});

			<?php if ( !isset($_POST['dronespov-upload-invoice']) ) : ?>
			jQuery('#upload').hide();
			<?php endif ?>
			jQuery('#upload-trigger').on('click', function() {
				jQuery('#upload').toggle();
			});
		});
	</script>
<?php endif;

if (false !== strpos($path, 'client/list_invoice') || false !== strpos($path, 'admin/list_invoice')) : ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {

			if (jQuery('#dueTrigger').hasClass('active') ) {
				jQuery('#dueTableContainer').show();
				jQuery('#overdueTableContainer, #paidTableContainer').hide();
			}

			if (jQuery('#overdueTrigger').hasClass('active') ) {
				jQuery('#overdueTableContainer').show();
				jQuery('#dueTableContainer, #paidTableContainer').hide();
			}

			if (jQuery('#paidTrigger').hasClass('active') ) {
				jQuery('#paidTableContainer').show();
				jQuery('#overdueTableContainer, #dueTableContainer').hide();
			}

			jQuery('#dueTrigger').on('click', function() {
				jQuery('#dueTableContainer').show();
				jQuery('#overdueTableContainer, #paidTableContainer').hide();

				var queryParams = new URLSearchParams(window.location.search);
				queryParams.set("tab", "due");
				queryParams.set("type", "invoices");
				window.history.replaceState(null, null, "?"+queryParams);
				//window.location.search = queryParams;
			});

			jQuery('#overdueTrigger').on('click', function() {
				jQuery('#overdueTableContainer').show();
				jQuery('#dueTableContainer, #paidTableContainer').hide();

				var queryParams = new URLSearchParams(window.location.search);
				queryParams.set("tab", "overdue");
				queryParams.set("type", "invoices");
				window.history.replaceState(null, null, "?"+queryParams);
				//window.location.search = queryParams;
			});

			jQuery('#paidTrigger').on('click', function() {
				jQuery('#paidTableContainer').show();
				jQuery('#overdueTableContainer, #dueTableContainer').hide();

				var queryParams = new URLSearchParams(window.location.search);
				queryParams.set("tab", "paid");
				queryParams.set("type", "invoices");
				window.history.replaceState(null, null, "?"+queryParams);
				//window.location.search = queryParams;
			});

			if (jQuery('#estimatesTrigger').hasClass('active') ) {
				jQuery('#EstimateContainer').show();
				jQuery('#InvoiceContainer').hide();
			}

			if (jQuery('#invoicesTrigger').hasClass('active') ) {
				jQuery('#InvoiceContainer').show();
				jQuery('#EstimateContainer').hide();
			}

			jQuery('#estimatesTrigger').on('click', function() {
				jQuery('#EstimateContainer').show();
				jQuery('#InvoiceContainer').hide();

				var queryParams = new URLSearchParams(window.location.search);
				queryParams.set("type", "estimates");
				window.history.replaceState(null, null, "?"+queryParams);
				//window.location.search = queryParams;
			});

			jQuery('#invoicesTrigger').on('click', function() {
				jQuery('#InvoiceContainer').show();
				jQuery('#EstimateContainer').hide();

				var queryParams = new URLSearchParams(window.location.search);
				queryParams.set("type", "invoices");
				window.history.replaceState(null, null, "?"+queryParams);
				//window.location.search = queryParams;
			});
		});
	</script>
<?php endif; ?>


<script type="text/javascript">
  (function(document, window, $){
	'use strict';

	var Site = window.Site;
	$(document).ready(function(){
	  Site.run();
	});
  })(document, window, jQuery);
</script>

</body>
</html>
