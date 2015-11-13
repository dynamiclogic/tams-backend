<?php
include 'db_connect.php';
$pdo   = DB_Connect::connect();
$count = 0;

session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
    // username and password sent from Form
    $username = $_POST['username'];
    //$password=md5($_POST['password']); 
    
    $password = $_POST['password'];
    
    $sql = "SELECT user_id, password FROM users WHERE username='$username'";
    
    foreach ($pdo->query($sql) as $row) {
        if (!password_verify($password, $row['password'])) exit();
        $count++;
        // If result matched $myusername and $mypassword, table row must be 1 row
        if ($count == 1) {
            $_SESSION['login_user'] = $row['user_id'];
            echo $row['user_id'];
        }
    }
}
?>