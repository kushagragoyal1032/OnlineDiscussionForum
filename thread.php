<?php
include 'partials/_db_connect.php';
?>

<?php
// this code for inserting comment for write a comment
$showAlert = false;
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['add'] == 'inserting')
{
    $thread_ID = $_GET['threadid'];
    $commentContent = $_POST['my_comment'];

    // this code is used to remove error while any user comment like ">" or "<" so we have to remove this 
    $commentContent = str_replace("<", "&lt", $commentContent);
    $commentContent = str_replace(">", "&gt", $commentContent); 


    // this part of code is used when user adding comment for that we are access userid, with 
    // that we can add user_id into the comment_user_id.
    $user_sno = $_POST['hiddensno'];
    
    $quer = "INSERT INTO `comments` (`comment_content`, `comment_thread_id`,`comment_user_id`) VALUES ('$commentContent', '$thread_ID','$user_sno')";
    $result = mysqli_query($con, $quer);

    if($result === true )
    {
        $showAlert = true;
    }
    else
    {
        $showAlert = false;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>My Forum</title>
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <?php
    if($showAlert)
    {
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>Your comment inserted Successfully !!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <?php

        $thread_ID = $_GET['threadid'];
        $quer = "SELECT * FROM `threads` WHERE thread_id=$thread_ID";
        $result = mysqli_query($con,$quer);
        while($row = mysqli_fetch_assoc($result))
        {
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];   
        }
            // this cos used to print name of the persone who ask this question
            
            $quer2 = "SELECT user_name FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($con,$quer2);
            $row2 = mysqli_fetch_assoc($result2);
            $comment_user_name = $row2['user_name'];
    ?>

    <div class="jumbotron jumbotron-fluid bg-dark text-white">
    <div class="container">
        <h1 class="display-4"><?php echo $thread_title ?></h1>
        <p class="lead"><?php echo $thread_desc.'.' ?></p>
        <hr><br><h2 class="text-warning"><b>Posted By:-  <i class="ms-3"><?php echo $comment_user_name ?></i></b></h2><br>
    </div>
    </div>

    <!-- <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $cat_name?> Forums</h1>
            <p class="lead"><?php echo $cat_desc?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p class="lead">
                <a class="btn btn-warning btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div> -->
    

    <div class="container my-5">
        <h1>Browse Comments-</h1><br>
    <?php
        $threadID = $_GET['threadid'];
        $quer = "SELECT * FROM `comments` WHERE comment_thread_id=$threadID";
        $result = mysqli_query($con,$quer);
        $noresult = true;

        while($row = mysqli_fetch_assoc($result))
        {
            $noresult = false;
            $id = $row['comment_id'];
            $comment = $row['comment_content'];

            // this code is used to print name of those who made comment on it
            $thread_user_id = $row['comment_user_id'];

            $quer2 = "SELECT user_name FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($con,$quer2);
            $row2 = mysqli_fetch_assoc($result2);
            $comment_user_name = $row2['user_name'];
        
            echo '<div class="media my-4">
                <img src="img/user_image.webp" width="40px" class="mr-3" alt="..."> <b class="text-info fs-5 ms-3"><i>'.$comment_user_name.'</i></b>
                <div class="media-body">
                     <h4 class="text-success"><i>'.$comment.'</i></h4>
                </div>
            </div><hr>';
        }
        
        if($noresult)
        {
            echo '<div class="jumbotron jumbotron-fluid bg-warning">
            <div class="container">
                <h1 class="display-4">There is no such Commnets related to this Question!!</h1>
                <p class="lead">Ask any question if you have...</p>
            </div>
            </div>';
        } 
        ?>
    </div>

    <hr class="mt-5">
    <hr>
    <?php
    if(isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true)
    {
    echo '<div class="container my-6">
        <br>
        <br><h1>Post your Comment-</h1>

        <div class="container" style="min-height: 400px;">
        <form method="POST">  
            <br>
            <div class="mb-3">
                <label for="exampleInputComment" class="form-label">Type Your Comment Here</label>
                <input type="text" class="form-control" id="exampleInputComment" name="my_comment">
            </div>
            <input type="hidden" name="hiddensno" value="'.$_SESSION['sno'].'">    
            <button type="submit" class="btn btn-primary" value="inserting" name="add">Submit</button>
        </form>
    </div>';
    }

    else
    {
        echo '<div class="container" style="min-height: 400px;">
        <hr><br><br><h1>Post your Comment-</h1>
        <i><h3 class="text-danger mt-4" >Please Login to put a comment..</h3></i>
        </div>';
    }

    ?>

    </div>

    <?php include 'partials/footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>