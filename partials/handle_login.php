<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    include '_db_connect.php';

$email_id = $_POST["user_email"];
$U_password = $_POST["user_pass"];

$quer = "select * from users where user_email = '$email_id' and user_pass = '$U_password'";

$result = mysqli_query($con,$quer);
$num = mysqli_num_rows($result);

if($num == 1)
{
    //   $qu = "select Name from user1 where Email = '$email_id'";
    //   $row = $con->query($qu);
      $row = mysqli_fetch_assoc($result);      // fetch the name from the table

      session_start();
      $_SESSION['isloggedin'] = true;
      $_SESSION['sno'] = $row["sno"];  // this used to save id of logged in user
      $_SESSION['username'] = $row["user_name"];
      header("location:/forum/index.php?loginsuccess=true");
      exit();
}
else
{

  $showLoginError = "User does not exist or invalid email and password !!";
  header("location:/forum/index.php?loginError=$showLoginError&loginsuccess=false");
 
}
$con->close();
}
?>
