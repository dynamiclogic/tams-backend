<?php
include "../config.php";
include "db_functions.php";
session_start();
if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/tablefilter/tablefilter.js"></script>

<script type="text/javascript">
$(function() {
    populateAssets();
});

function loadingImg () {
	$('#assets_table table > tbody:first').html("<img style='width:30px;' src='../skin/default/img/loading.gif'/>");
}

//pull the table body
function populateAssets() {
	$('#top-bar-deleted').hide();
	$('#top-bar').show();
	$('#active-assets').addClass('active');
	$('#deleted-assets').removeClass('active');
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
	        reloadTableFilter();
	    }
	});
}

//pull the table body
function populateDeletedAssets() {
	$('#top-bar').hide();
	$('#top-bar-deleted').show();
	$('#active-assets').removeClass('active');
	$('#deleted-assets').addClass('active');
	$.ajax({
	    type: "GET", // HTTP method POST or GET
	    url: "deleted_assets_table.php", //Where to make Ajax calls
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
	        reloadTableFilter();
	    }
	});
}

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


var tf = null;
var filtersConfig = null;
function reloadTableFilter() {
	if (tf != null) {
		tf.destroy();
		tf = null;
		filtersConfig = null;
	}

	//Table Filter
	filtersConfig = {
        base_path: '/js/tablefilter/',
        paging: true,
        results_per_page: ['Records: ', [10,25,50,100]],
        remember_page_number: true,
        remember_page_length: true,
        alternate_rows: true,
        highlight_keywords: true,
        auto_filter: true,
        auto_filter_delay: 500, //milliseconds
        filters_row_index: 1,
        remember_grid_values: true,
        alternate_rows: true,
        rows_counter: true,
        rows_counter_text: "Rows: ",
        btn_reset: true,
        status_bar: true,
        msg_filter: 'Filtering...',
        col_9: 'none',
        col_10: 'none',
        col_11: 'none',
    };
    tf = new TableFilter('assets-table', filtersConfig);
    tf.init();
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
					<!--<div id="right" class="column">
						<select id="refresh_rate" class="form-control" onchange="refreshOnChange($(this));">
							<option value="0">No Refresh</option>
							<option value="1000">Every 1 sec</option>
							<option value="5000">Every 5 sec</option>
							<option value="10000">Every 10 sec</option>
							<option value="30000">Every 30 sec</option>
						</select>
					</div>-->
		    	</div>
		    	<div id="top-bar-deleted">
		    		<div class="column deleted-assets-bar" >DELETED ASSETS</div>
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
		                  	<th>Latitude</th>
		                  	<th>Longitude</th>
		                  	<th>Created By</th>
		                  	<th>Update At</th>
		                  	<th></th>
		                  	<th></th>
		                  	<th></th>
		                </tr>
		            </thead>
		            	<tbody>
		            		<tr>
		            			<td colspan="12">LOADING DATA...</td>
		            		</tr>
		            	</tbody>
		        </table>
    		</div>
    </div> <!-- /container -->

<script type="text/javascript">

</script>

<?php include_once 'footer.php'; ?>
