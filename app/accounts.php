<?php
include "config.php";
include 'database.php';

session_start();
if(empty($_SESSION['login_user']))
{
  header('Location: index.php');
}

if ( !empty($_POST)) {
    // keep track validation errors
  $firstnameError = null;
  $username = null;
  $password = null;


    // keep track post values
  $firstname = $_POST['firstname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $role = $_POST['role'];

    // validate input
  $valid = true;
  if (empty($firstname)) {
    $firstnameError = 'Please enter First Name';
    $valid = false;
  }

  if (empty($username)) {
    $usernameError = 'Please enter Username';
    $valid = false;
  }

  if (empty($password)) {
    $passwordError = 'Please enter Password';
    $valid = false;
  }

  if($role == "Admin") $role = 0;
  else $role = 1;

  if ($valid) {
    $pdo = Database::connect();

      //ASSET
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $assetSql = "INSERT INTO users (firstname,username, lastname, email, role, password) values(?, ?, ?, ?, ?, ?)";
    $assetQuery = $pdo->prepare($assetSql);
    $assetQuery->execute(array($firstname,$username, $lastname, $email, $role, password_hash($password, PASSWORD_DEFAULT)));

    Database::disconnect();
    header("Location: accounts.php");
  }
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
            <li><a onClick ="$('#assets-table').tableExport({type:'xml',escape:'false',ignoreColumn:'[0,7,8]'});">XML</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'json',escape:'false',ignoreColumn:'[0,7,8]'});">JSON</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'sql',escape:'false',ignoreColumn:'[0,7,8]'});">SQL</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'csv',escape:'false',ignoreColumn:'[0,7,8]'});" download="expenses.csv">CSV</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'txt',escape:'false',ignoreColumn:'[0,7,8]'});">TXT</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'excel',escape:'false',ignoreColumn:'[0,7,8]'});">XLS</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'doc',escape:'false',ignoreColumn:'[0,7,8]'});">Word</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'powerpoint',escape:'false',ignoreColumn:'[0,7,8]'});">PowerPoint</a></li>
            <li class="divider"></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'png',escape:'false',ignoreColumn:'[0,7,8]'});">PNG</a></li>
            <li><a onClick ="$('#assets-table').tableExport({type:'pdf',escape:'false',ignoreColumn:'[0,7,8]'});">PDF</a></li>
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
              <li><a href="#">Manage Accounts</a></li>
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
     <div id="left" class="column"><a class="btn btn-primary" data-toggle="modal" data-target="#modal" id="newuser">+ New User</a></div>
   </div>
 </div>

 <div class="row">
  <span id="mobile-assets-table"></span>
  <table class="table table-striped table-bordered" id="assets-table">
    <thead>
      <tr>
        <th>UserId</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $pdo = Database::connect();

      $sql = 'SELECT * FROM users ORDER BY user_id DESC';
      foreach ($pdo->query($sql) as $row) {
        echo '<a href="read.php?userId='.$row['user_id'].'" class="list-group-item">';
        echo '<h4 class="list-group-item-heading">';
        echo $row['firstname'] . ' ' . $row['lastname'];
        echo '</h4><p class="list-group-item-text">' . $row['username'] . '</p></a>';
        echo '<tr>';
        echo '<td>'. $row['user_id'] . '</td>';
        echo '<td>'. $row['firstname'] . '</td>';
        echo '<td>'. $row['lastname'] . '</td>';
        echo '<td>'. $row['username'] . '</td>';
        echo '<td>'. $row['email'] . '</td>';                  
        echo '<td>';
        if ($row['role'] == 0) echo 'Admin';
        else echo 'User';
        echo '</td>';
        echo '<td width=250>';
        echo '<a class="btn btn-default" href="editUser.php?userId='.$row['user_id'].'">Edit</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-danger" href="deleteUser.php?userId='.$row['user_id'].'">Delete</a>';
        echo '</td>';
        echo '</tr>';
      }
      Database::disconnect();
      ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Create User</h4>
      </div>
      <div class="modal-body">

        <div class="well bs-component">
          <form class="form-horizontal" action="accounts.php" method="post">
            <fieldset>
              <div class="form-group <?php echo !empty($usernameError)?'has-error':'';?>">
                <label class="col-lg-2 control-label" for="inputDefault">Username</label>
                <div class="col-lg-10">
                  <input name="username" type="text" placeholder="Username" value="<?php echo !empty($username)?$username:'';?>" onkeyup="validateFields();" class="form-control" id="username">
                  <?php if (!empty($usernameError)): ?>
                    <span class="help-inline"><?php echo $usernameError;?></span>
                  <?php endif;?>
                </div>
              </div>
              <div class="form-group <?php echo !empty($firstnameError)?'has-error':'';?>">
                <label class="col-lg-2 control-label" for="inputDefault">First Name</label>
                <div class="col-lg-10">
                  <input name="firstname" type="text" placeholder="First Name" value="<?php echo !empty($firstname)?$firstname:'';?>" onkeyup="validateFields();" class="form-control" id="firstname">
                  <?php if (!empty($firstnameError)): ?>
                    <span class="help-inline"><?php echo $firstnameError;?></span>
                  <?php endif;?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Last Name</label>
                <div class="col-lg-10">
                  <input name="lastname" type="text" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo !empty($lastname)?$lastname:'';?>">
                </div>
              </div>
              <div class="form-group <?php echo !empty($passwordError)?'has-error':'';?>">
                <label class="col-lg-2 control-label" for="inputDefault">Password</label>
                <div class="col-lg-10">
                  <input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>" onkeyup="validateFields();" class="form-control" id="password" >
                  <?php if (!empty($passwordError)): ?>
                    <span class="help-inline"><?php echo $passwordError;?></span>
                  <?php endif;?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Confirm Password</label>
                <div class="col-lg-10">
                  <input name="confirm-password" type="password" id="confirm-password" class="form-control" placeholder="Password" onkeyup="validateFields(); checkPass(); return false;">
                  <span id="confirmMessage" class="confirmMessage"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                  <input name="email" type="email" id="lat" class="form-control" placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Admin?</label>
                    <input type="checkbox" name="role" value="Admin" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="create-btn">Create User</button>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
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
<script>
  $(function() {
    validateFields();
  });

  function checkPass() {
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('password');
    var pass2 = document.getElementById('confirm-password');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
      }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
      }
    }  

    function validateFields() {
      document.getElementById("create-btn").disabled = true;
      var password = document.getElementById('password').value;
      var confirmPasswod = document.getElementById('confirm-password').value;
      var firstname = document.getElementById('firstname').value;
      var username = document.getElementById('username').value;

      if (password != "" && firstname != "" && username != "" && password == confirmPasswod) {
        document.getElementById("create-btn").disabled = false;
      }

    }
  </script>

</body>
</html>