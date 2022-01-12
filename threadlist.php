<?php
include 'partials/_db_connect.php';
?>

<?php
// this code for inserting title and desc for ask a question in database
$showAlert = false;
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['add'] == 'inserting')
{
    $catid = $_GET['catid'];
    $title = $_POST['my_title'];
    $desc = $_POST['my_desc'];

    // this code is used to remove error while any user comment like ">" or "<" so we have to remove this 
    $desc = str_replace("<", "&lt", $desc);
    $desc = str_replace(">", "&gt", $desc); 

    $title = str_replace("<", "&lt", $title);
    $title = str_replace(">", "&gt", $title); 


    // this part of code is used when user adding question for that we are access userid, with 
    // that we can add user_id into the thread_user_id.

    $user_sno = $_POST['hiddensno'];
    
    $quer = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$title', '$desc', '$catid', '$user_sno');";
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
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>inserted Successfully !!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <?php

        $catID = $_GET['catid'];
        $quer = "SELECT * FROM `category` WHERE category_id=$catID";
        $result = mysqli_query($con,$quer);
        while($row = mysqli_fetch_assoc($result))
        {
            $cat_name = $row['category_name'];
            $cat_desc = $row['category_desc'];
        }
    ?>

    <div class="container my-4">
        <div class="jumbotron bg-light">
            <h1 class="display-4">Welcome to <?php echo $cat_name?> Forums </h1>
            
            <p class="lead"><?php echo $cat_desc?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p class="lead">
                <a class="btn btn-warning btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>


    <div class="container">
        <h1>Browse Questions</h1><br>

        <?php
        // $catID = $_GET['catid'];
        $quer = "SELECT * FROM `threads` WHERE thread_cat_id=$catID";
        $result = mysqli_query($con,$quer);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result))
        {
            $noresult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $time = $row['thread_timestamp'];

            //this code is used to fetch name of the user from user table in considered where thread_user_id present  
            $thread_user_id = $row['thread_user_id'];
            $quer2 = "SELECT user_name FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($con,$quer2);
            $row2 = mysqli_fetch_assoc($result2);
            $comment_user_name = $row2['user_name'];
        
            echo '<div class="media my-4">
                <img src="img/user_image.webp" width="40px" class="mr-3" alt="..."> <b class="text-info fs-5 ms-3"><i>'.$comment_user_name.'</i></b>
                <div class="media-body">
                    <h5 class="mt-0"><a class="text-success" href="thread.php?threadid='.$id.'" >'.$title.'</a></h5>
                    '.$desc.'
                </div>
            </div>
            <b class="text-secondary"> On '.$time.'</b>
            <hr>';

            
        }
        
        if($noresult)
        {
            echo '<div class="jumbotron jumbotron-fluid bg-warning">
            <div class="container">
                <h1 class="display-4">There is no such Question related to this !!</h1>
                <p class="lead">Ask any question if you have...</p>
            </div>
            </div>';
        } 
        ?>
    </div>

    <hr class="mt-5">
    <hr>
    <?php
   
    if(isset($_SESSION["isloggedin"]) && $_SESSION["isloggedin"] == true)
    {
        echo '<div class="container" style="min-height: 400px;">
            <form method="POST" action="threadlist.php?catid='.$catID.'">
                    
        <br>
        <h3><b><i>Ask your Question :- </i></b></h3><br>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle" name="my_title" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputDesc" class="form-label">Description</label>
            <input type="text" class="form-control" id="exampleInputDesc" name="my_desc">
        </div>
        <input type="hidden" name="hiddensno" value="'.$_SESSION['sno'].'">
        <button type="submit" class="btn btn-primary" value="inserting" name="add">Submit</button>
        </form>
        </div>';
    }

    else
    {
       echo '<div class="container" style="min-height: 400px;">
        <h3><b><i>Ask your Question :- </i></b></h3><br>
        <i><h3 class="text-danger">Please Login to ask a question..</h3></i>
        </div>';
    }
    ?>


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