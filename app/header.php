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