<!DOCTYPE html>
<html lang="en">
<head>
<title>TAMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet" >
    <link href="<?php echo skin;?>css/styles.css" rel="stylesheet" >
    <script src="../js/jquery-1.11.2.min.js"> </script>

    <script src="../js/bootstrap.min.js" ></script>

    <!--Export-->
	<script type="text/javascript" src="export/tableExport.js" > </script>
	<script type="text/javascript" src="export/jquery.base64.js" ></script>
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
        <li id="active-assets"><a href="home.php" onclick="loadingImg();populateAssets()">Active Assets <span class="sr-only">(current)</span></a></li>
        <li id="deleted-assets"><a href="#" onclick="loadingImg();populateDeletedAssets()">Deleted Assets <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Export <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a onClick ="$('#assets-table').tableExport({type:'csv',escape:'false',ignoreColumn:'[0,9,10,11]'});">CSV</a></li>

          </ul>
        </li>
      </ul>
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