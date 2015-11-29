<?php
include "config.php";
include "db_functions.php";
session_start();
if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

<script type="text/javascript">

//pull the table body
function populateAssets() {
	$.ajax({
	    type: "GET", // HTTP method POST or GET
	    url: "assets_table.php", //Where to make Ajax calls
	    //dataType:"text", // Data type, HTML, json etc.
	    dataType: 'html',
	    /*data: {
	        name: $('#name').val(),
	        address: $('#address').val(),
	        city: $('#city').val()
	    },*/
	    success: function(data) {
	        $('#assets_table table > tbody:first').html(data);
	        //alert(data);
	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	        //On error, we alert user
	        //alert(thrownError);
	    },
	    complete: function() {
	    	d = new Date();
	        $('#last_refreshed').html("Last Refreshed:<br>" + d.toLocaleString()); 
	        $("#mobile-assets-table").html("");
	        $("#mobile-assets-table").html($(".list-group-item"));
	    }
	});
}

window.onload = populateAssets;

var interval;

// refresh the table every x seconds
function timedRefresh(timeoutPeriod) {
	clearInterval(interval);
	interval=0;

	if (timeoutPeriod != 0) {
		interval = setInterval(populateAssets, timeoutPeriod);
	}
}

function refreshOnChange(thisObj) {
	timedRefresh(thisObj.val());
}

</script>

<?php include_once 'header.php'; ?>

    <div class="container" id="assets_table">
    		<div class="row">
				<div id="top-bar">
					<div id="left" class="column">
						<a href="create.php" class="btn btn-large btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Asset</a>
					</div>
					<div id="center" class="column">
						<span id="last_refreshed"></span>
					</div>
					<div id="right" class="column">
						<select id="refresh_rate" class="form-control" onchange="refreshOnChange($(this));">
							<option value="0">No Refresh</option>
							<option value="1000">Every 1 sec</option>
							<option value="5000">Every 5 sec</option>
							<option value="10000">Every 10 sec</option>
							<option value="30000">Every 30 sec</option>
						</select>
					</div>
		    </div>
		  </div>

			<div class="row">
        		<span id="mobile-assets-table"></span>
				<table class="table table-striped table-bordered" id="assets-table">
		            <thead>
		            	<tr>
                      		<th>Image</th>
		                  	<th>AssetId</th>
		                  	<th>Name</th>
		                  	<th>Description</th>
		                  	<th>Type</th>
		                  	<th>Location</th>
		                  	<th>Created By</th>
		                  	<th>Update At</th>
		                  	<th colspan="3" align="center">Actions</th>
		                </tr>
		            </thead>
		            	<tbody>
		            		<tr>
		            			<td colspan="9">LOADING DATA...</td>
		            		</tr>
		            	</tbody>
		        </table>
    		</div>
    </div> <!-- /container -->

<?php include_once 'footer.php'; ?>
