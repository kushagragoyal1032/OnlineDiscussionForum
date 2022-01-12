<?php

session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand mx-3" href="/forum/index.php">Myforum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum/index.php">Home</a>
            </li>
           
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Car Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';


                // this code is used for to print categories into the header categories 

                $quer = "SELECT * FROM `category`";
                $result = mysqli_query($con,$quer);
                while($row = mysqli_fetch_assoc($result))
                {
                    $id = $row['category_id'];

                   echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$id.'">'.$row['category_name'].'</a></li>';
                    // <li><a class="dropdown-item" href="#">Another action</a></li>
                }    


                echo '</ul>
            </li>
            <li class="nav-item">
                <a class="nav-link mx-2">Contact Us</a>
            </li>
        </ul>';
            
             
            
            if(isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true)
            {
                echo '<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" action="search.php" method="GET">
                <input type="search" class="form-control form-control-dark" name="search" placeholder="Search..." aria-label="Search">
                <button type="submit" class="btn btn-danger mx-2" >Search</button>
            
                <p class="text-light my-0 mx-4 mt-1 d-flex">Welcome: <b class="ms-2 text-warning">'.$_SESSION['username'].'</b></p>
                <a href="partials/handle_logout.php"><button type="button" class="btn btn-outline-warning me-2">Logout</button></a>
                </form>';
            }

            else
            {
              
                echo '<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" action="search.php" method="GET">
                <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                <button type="submit" class="btn btn-danger mx-2" >Search</button>
                
                
                
                <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Login</button>

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#signupModal">Signup</button>
                </form>';
            }   

                
echo '</div> 
    </div>
    
</nav>';

?>

<?php include 'partials/login_modal.php'; ?>
<?php include 'partials/signup_modal.php'; ?>