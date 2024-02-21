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
    <title>Strona główna</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
  </head>
  <body class="d-flex flex-column min-vh-100">    
      <nav class="navbar navbar-expand-lg UlubionyKolor shadow-lg" data-bs-theme="dark">    
        <a href="#" class="border border-dark"><img src="../Images/logo.png" class="d-none d-sm-block border border-dark" alt="logo"></a>
        <a class="navbar-brand fs-3 fw-bold" href="#">MoonWork</a>
        <button class="navbar-toggler mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
               if(isset($_SESSION['zalogowany']))
               {
                if($_SESSION['administrator']==1)
                {
                 
                  echo '
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                  <li class="nav-item">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Strona główna</a>
                  </li> 
                  <li class="nav-item lewyNav">
                    <a class="nav-link active mt-1 fs-5 marginChange" aria-current="page" href="#">Panel admina</a>
                  </li>
                  <li class="nav-item dropdown border-white border border-1 rounded-3"> 
                  <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  '.$_SESSION['user'].'
                  </a>
                  <form class="dropdown-menu UlubionyKolor p-4 row">
                    <a href="Profil.php" class="text-decoration-none text-light fs-5 col-12 marginChange">Profil</a>
                    <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                  </form>
                  </li>
                  </ul>';
                  

                
                }  
                else
                {
                 
                  echo '
                  <ul class="navbar-nav me-auto mb-2 lewyNav mb-lg-0"> 
                  <li class="nav-item lewyNav">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Strona główna</a>
                  </li>                   
                  <li class="nav-item dropdown border-white border border-1 rounded-3"> 
                  <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  '.$_SESSION['user'].'
                  </a>
                  <form class="dropdown-menu UlubionyKolor p-4 row">
                    <a href="Profil.php" class="text-decoration-none text-light fs-5 col-12 marginChange">Profil</a>
                    <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                  </form>
                  </li>
                  </ul>';
                    
                }                 
               }   
               else
               {
                  echo '
                    <ul class="navbar-nav me-auto mb-2 lewyNav mb-lg-0"> 
                    <li class="nav-item lewyNav">
                      <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Strona główna</a>
                    </li>                     
                    <li class="nav-item" >
                      <a class="nav-link active mt-1 fs-5  marginChange" aria-current="page" href="Logowanie.php">Zaloguj się</a>
                    </li>
                    </ul>';
               }                                    
               ?>            
        </div>      
    </nav>

    <section class="container">
        <section class="my-5 text-center">                    
            <h1>67 542 <span class="mx-2">Sprawdzone oferty pracy</span></h1>                                        
            <p class="fs-4">od najlepszych pracodawców</p>               
        </section>
    
        <section class="row d-flex justify-content-center bg-secondary rounded-3 shadow-lg wyszukiwanie">
          <section class="row d-flex justify-content-center">
            <div class="col-8 col-xl-3 border border-dark rounded-1 border-2 my-2">
              <form class="d-flex row h-100">
                  <input type="search" class="border border-0 form-control bg-secondary-subtle" placeholder="Stanowisko">               
              </form>
            </div>

            <div class="col-8 col-xl-2 border border-dark rounded-1 bg-secondary-subtle border-2 my-2">
                <div class="dropdown row">
                    <button class="btn dropdown-toggle text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Kategorie
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div> 
            </div>

            <div class="col-8 col-xl-2 border border-dark rounded-1 border-2 my-2">
                <form class="d-flex row h-100">
                    <input type="search" class="border border-0 form-control bg-secondary-subtle" placeholder="Lokalizacja">               
                </form>
            </div>

            <div class="col-8 col-xl-2 border border-dark bg-secondary-subtle rounded-1 border-2 my-2">
                <div class="dropdown row">
                    <button class="btn dropdown-toggle text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Odległość
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>    
            </div>
          </section>                                   
          <section class="row szczegolowe-wysz">
            
              <div class="dropdown col-12 col-xl-3 border border-0 rounded-1 my-2 border-2 pierwszySzczegol">
                  <button class="btn dropdown-toggle border border-0 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Poziom stanowiska 
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item text-wrap" href="#">Something else here</a></li>
                  </ul>
                </div> 
            

            
              <div class="dropdown col-12 col-xl-2 border border-0 rounded-1  border-2 my-2">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Rodzaj umowy
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
              </div> 
            

            
              <div class="dropdown col-12 col-xl-2 border border-0 rounded-1  border-2 my-2">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Wymiar pracy
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
              </div> 
            

            
              <div class="dropdown col-12 col-xl-2 border border-0 my-2">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tryb pracy
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
              </div> 
            
            <button type="button" class="btn col-12 col-xl-2 btn-dark UlubionyKolor text-light rounded-5 sm-ms-5 my-2">Szukaj</button>
          </section>                    
        </section>

        <section class="my-5 text-center">                    
          <h1>Najnowsze oferty</h1>                                                  
        </section>

        <section class="row my-5">                      
          <a href="SzczegolyOglo.php" class="col-12 col-xl-4 ogloszenie border-0 rounded-4 shadow-lg text-decoration-none">
          
              <h5 class="text-light mt-3">Sprzedawca na stanowisku mięsnym</h5>
              <p class="text-light">4500 - 5000 zł/mies</p>
              <div class="d-flex">
                <img src="../Images/stokrotka.png" alt="" class="logoOgloszenia">
                <p class="fs-5 text-light mt-4 ms-2">Stokrotka</p>
              </div>              
              <p class="text-light mt-3">07.01.2024</p>                  
          </a>          
        </section>
        
    </section>

  
    
      <footer class="mt-auto UlubionyKolor">
        <div class="row m-3">
          <div class="col-12 col-xl-2 d-flex">
            <p class="text-light"><i class="bi bi-telephone-fill"></i> +48 676 543 353</p>
          </div>
          
          <div class="col-12 col-xl-2 d-flex">
            <p class="text-light"><i class="bi bi-envelope-fill"></i> contactus@wp.pl</p>
          </div>          
        </div>         
      </footer>
    
  
            
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>