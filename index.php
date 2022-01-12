<?php
include 'partials/_db_connect.php';
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

    <!-- it is running when we are sign up and from there we are re-directing from handle_signup.php to index.php and then we check that the value
            of signupsuccess is true or false -->
    <?php
        if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true")
        {
            echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <strong>Sign-up Successfully !!</strong> Now you can login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false")
        {
            echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <strong>'.$_GET['show'].'</strong> Try again...
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>

    <!-- it is running when we are login and from there we are re-directing from handle_loginup.php to index.php and then we check that the value
            of loginsuccess is true or false -->

            <?php
        if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="true")
        {
            echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <strong>Login Successfully !!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false")
        {
            echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <strong>'.$_GET['loginError'].'</strong> Try again...
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/1400x300/?Rolls-Royce-car" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1400x300/?cars racingcar luxrycars" class="d-block w-100"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1400x300/?cars racingcar" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <div class="container my-4">
        <h2 class="text-center my-4"><b>MyFourm - Categories</b></h2>
        <div class="row my-4">

        <?php
        $quer = "SELECT * FROM `category`";
        $result = mysqli_query($con,$quer);
        while($row = mysqli_fetch_assoc($result))
        {
           $id = $row['category_id'];
           echo' <div class="col-md-4 my-4">
                <div class="card" style="width: 18rem;">
                    <img src="https://source.unsplash.com/500x400/?'.$row['category_name'].' " class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a href="threadlist.php?catid='.$id. '">' .$row['category_name'].'</a></h5>
                        <p class="card-text">' .$row['category_desc'].'</p>
                        <a href="threadlist.php?catid='.$id. '" class="btn btn-primary">View Forum</a>
                    </div>
                </div>
            </div>';
        }?>
        </div>
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