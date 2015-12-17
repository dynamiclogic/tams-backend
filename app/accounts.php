<?php
include "../config.php";
include 'db_functions.php';

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

<?php include_once 'header.php'; ?>

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
        $db = new DB_Functions();
        $users = $db->getAllUsers();

        foreach ($users as $user) {
          echo '<a href="read.php?user_id='.$user['user_id'].'" class="list-group-item">';
          echo '<h4 class="list-group-item-heading">';
          echo $user['firstname'] . ' ' . $user['lastname'];
          echo '</h4><p class="list-group-item-text">' . $user['username'] . '</p></a>';
          echo '<tr>';
          echo '<td>'. $user['user_id'] . '</td>';
          echo '<td>'. $user['firstname'] . '</td>';
          echo '<td>'. $user['lastname'] . '</td>';
          echo '<td>'. $user['username'] . '</td>';
          echo '<td>'. $user['email'] . '</td>';                  
          echo '<td>';
          if ($user['role'] == 0) echo 'Admin';
          else echo 'User';
          echo '</td>';
          echo '<td width=250>';
          echo '<a class="btn btn-default" href="editUser.php?user_id='.$user['user_id'].'">Edit</a>';
          echo '&nbsp;';
          echo '<a class="btn btn-danger" href="deleteUser.php?user_id='.$user['user_id'].'">Delete</a>';
          echo '</td>';
          echo '</tr>';
        }
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

<?php include_once 'footer.php'; ?>