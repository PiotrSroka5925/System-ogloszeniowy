<?php

session_start();

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

?>

<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel admina</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/Other/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
  </head>
  <body class="d-flex flex-column min-vh-100">    
    <nav class="navbar navbar-expand-lg UlubionyKolor shadow-lg" data-bs-theme="dark">
        <a href="StronaGlowna.php" class="border border-dark"><img src="../Images/Other/logo.png" class="d-none d-sm-block border border-dark" alt="logo"></a>
        <h1 class="text-light align-center text-center">Panel admina</h1>      
        <button class="navbar-toggler mx-3 border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="list-group navbar-nav d-block d-sm-none">
            <li class="list-unstyled text-light border-0  p-2">
            <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Strona główna</a>
            </li>
            <?php
                echo '
                <li class="nav-item dropdown border-white border border-start-0 border-end-0 border-1"> 
                    <a class="nav-link dropdown-toggle p-2 text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    '.$_SESSION['user'].'
                    </a>
                    <form class="dropdown-menu UlubionyKolor p-4 row w-100">
                        <a href="Profil.php" class="text-decoration-none text-light fs-5 col-12 marginChange">Profil</a>
                        <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                    </form> 
                </li>';
            ?>
        </ul>
        </div>
        </nav>
        
            <div class="container-fluid row mt-auto" style="flex : 1"> 
            <div class="col-3 col-xl-2 d-none d-sm-block UlubionyKolor border border-start-0 border-end-0 border-2">
                <ul class="list-group">
                    <li class="list-unstyled text-light border-0 p-2"> 
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
                    </li>
                    <?php
                    echo '
                        <li class="nav-item dropdown border-white border border-start-0 border-end-0 border-1"> 
                            <a class="nav-link dropdown-toggle p-2 text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            '.$_SESSION['user'].'
                            </a>
                            <form class="dropdown-menu border-white border border-top-0 border-1 UlubionyKolor p-4 row w-100">
                                <a href="Profil.php" class="text-decoration-none text-light fs-5 col-12 marginChange">Profil</a>
                                <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white text-light rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                            </form>
                        </li>';
                    ?>
                </ul>
            </div>
            <div class="col-9 col-xl-10">
                My Content
            </div>
            </div>
        

        <footer class="mt-auto UlubionyKolor border-top-1">
            <div class="row m-3">
            <div class="col-12 col-xl-2 d-flex">
                <p class="text-light"><i class="bi bi-telephone-fill"></i> +48 676 543 353</p>
            </div>
            
            <div class="col-12 col-xl-2 d-flex">
                <p class="text-light"><i class="bi bi-envelope-fill"></i> contactus@wp.pl</p>
            </div>          
            </div>         
        </footer>
                  
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  <?php  
    $polaczenie->close();
  ?>
</html>