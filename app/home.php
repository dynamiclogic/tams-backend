<?php
include "config.php";
include "db_functions.php";
session_start();
if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet" >
    <link href="<?php echo skin;?>css/styles.css" rel="stylesheet" >
    <script src="../js/jquery-1.11.2.min.js"> </script>
    <script src="../js/bootstrap.min.js" ></script>

    <!--Export-->
	<script type="text/javascript" src="export/tableExport.js" > </script>
	<script type="text/javascript" src="export/jquery.base64.js" ></script>

	<!--PNG-->
	<script type="text/javascript" src="export/html2canvas.js" ></script>

	<!--PDF-->
	<script type="text/javascript" src="export/jspdf/libs/sprintf.js" ></script>
	<script type="text/javascript" src="export/jspdf/jspdf.js" ></script>
	<script type="text/javascript" src="export/jspdf/libs/base64.js" ></script>
</head>

<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">TAMS</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>-->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Export <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a onClick ="$('#assets-table').tableExport({type:'kml',escape:'false',ignoreColumn:'[0,7,8]'});">KML</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'shape',escape:'false',ignoreColumn:'[0,7,8]'});">Shapefile</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'xml',escape:'false',ignoreColumn:'[0,7,8]'});">XML</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'json',escape:'false',ignoreColumn:'[0,7,8]'});">JSON</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'sql',escape:'false',ignoreColumn:'[0,7,8]'});">SQL</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'csv',escape:'false',ignoreColumn:'[0,7,8]'});">CSV</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'txt',escape:'false',ignoreColumn:'[0,7,8]'});">TXT</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'excel',escape:'false',ignoreColumn:'[0,7,8]'});">XLS</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search" _lpchecked="1">
        <div class="form-group">
          <input type="text" id="search" class="form-control search-input" placeholder="Search">
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right navbar-settings">
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <img id="settings-icon" src="<?php echo skin;?>img/gear-icon.png"/><span class="settings-label">Settings<span class="caret"></span></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">My Account</a></li>
            <li class="divider"></li>
            <li><a href="accounts.php">Manage Accounts</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>



    <div class="container">
			<div class="row">
				<div id="top-bar">
					<div id="left" class="column"><a href="create.php" class="btn btn-success">Create</a></div>
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
		                  <th>Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
             $temp_assets = array();

					   $db = new DB_Functions();
             $assets = $db->getActiveAssets();

	 				   foreach ($assets as $asset) {
                  //check for unique results
                  if (!in_array($asset['asset_id'], $temp_assets)) {
                    $temp_assets[] = $asset['asset_id'];;

                  echo '<a href="read.php?asset_id='.$asset['asset_id'].'" class="list-group-item">';
                  if ($asset['images']) {
                    echo '<img class="asset-image-table asset-image-table-mobile" src="data:image/png;base64,' . $asset['images'] . '"/>';
                  }
                  echo '<h4 class="list-group-item-heading">';
                  echo $asset['name'];
                  echo '</h4><p class="list-group-item-text">' . $asset['description'] . '</p></a>';
						   		echo '<tr>';
                  echo '<td>';
                  if ($asset['images']) {
                    echo '<img class="asset-image-table" src="data:image/png;base64,'. $asset['images'] . '"/>';
                  }
                  echo '</td>';
							   	echo '<td>'. $asset['asset_id'] . '</td>';
							   	echo '<td>'. $asset['name'] . '</td>';
							   	echo '<td>'. $asset['description'] . '</td>';
							   	echo '<td>'. $asset['type_value'] . '</td>';
							   	echo '<td>'. $asset['longitude'] . '<br>' . $asset['latitude'] . '</td>';
							   	echo '<td>'. $asset['created_by'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn btn-default" href="read.php?asset_id='.$asset['asset_id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?asset_id='.$asset['asset_id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?asset_id='.$asset['asset_id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
                 }
					   }
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->

    <script type="text/javascript">
    	jQuery(document).ready(function($) {
        $("#mobile-assets-table").append($(".list-group-item"));
    		$('.search-input').keyup(function(){
    			makeAjaxRequest();
    		});

            function makeAjaxRequest() {
                $.ajax({
                    url: 'search.php',
                    type: 'get',
                    data: {search: $('input#search').val()},
                    success: function(response) {
                      //if(screen.width > 767)
                        $('table#assets-table tbody').html(response);
                      //else
                        $('#mobile-assets-table').html(response);
                    }
                });
            }
    	});
    </script>

  </body>
</html>
