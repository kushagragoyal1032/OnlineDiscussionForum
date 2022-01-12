<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include '_db_connect.php';


$showAlert = false;

$name = $_POST["user_name"];
$email_id = $_POST["user_email"];
$U_password = $_POST["user_pass"];
$Uc_password = $_POST["user_cpass"];

$Existquer = "select * from users where user_email = '$email_id'";
$result = mysqli_query($con,$Existquer);
$Existnum = mysqli_num_rows($result);

if($Existnum > 0)
{
  $showError = "Email already in use!!";
}

else
{
  if($U_password == $Uc_password)
  {
//   $P_hash = password_hash($U_password, PASSWORD_DEFAULT);  
  $quer = "insert into users(user_name,user_email, user_Pass) values ('$name', '$email_id', '$U_password')";
  $result = mysqli_query($con,$quer);
    if($result)
    {
        $showAlert = true;
        header("location:/forum/index.php?signupsuccess=true");
        exit();
    }
  }
  else
  {
    $showError = "Passwords do not match !!";
  }

}
header("location:/forum/index.php?signupsuccess=false&show='$showError'");
  exit();

$con->close();

}

?>