<?php

session_start();
if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']!=true))
{
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);


?>
<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/Other/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
  </head>
  <body class="d-flex flex-column min-vh-100">    
      <nav class="navbar navbar-expand-lg UlubionyKolor shadow-lg sticky-top" data-bs-theme="dark">    
        <a href="StronaGlowna.php" class="border border-dark"><img src="../Images/Other/logo.png" class="d-none d-sm-block border border-dark" alt="logo"></a>
        <a class="navbar-brand fs-3 fw-bold" href="StronaGlowna.php">MoonWork</a>
        <button class="navbar-toggler mx-3 border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                      <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
                    </li> 
                    <li class="nav-item lewyNav">
                      <a class="nav-link active mt-1 fs-5 marginChange" aria-current="page" href="OgloszeniaAdm.php">Panel admina</a>
                    </li>
                    <li class="nav-item dropdown border-white border border-1 rounded-3"> 
                      <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      '.$_SESSION['user'].'
                      </a>
                      <form class="dropdown-menu UlubionyKolor p-4 row">                        
                        <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12" role="button">Wyloguj</a>           
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
                        <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                      </form>
                    </li>
                  </ul>';
                    
                }                 
               }                                               
               ?>            
        </div>
    </nav>

    <section class="container my-2">
                
        <section class="ogloszenie mt-2 rounded-3">
            <div class="p-3">                          
                <div class="d-flex">                     
                    <img src="../Images/Profile/mineTheWorld.png" class="Profilowe ms-1 mt-1" alt="">                    
                    <p class="text-light ms-1 mt-4 fs-2 w-100">Piotr Sroka</p>                                                                                                                                                                                                                                                                                       
                </div>
                <div class="mt-3">
                    <p class="text-light">Programista - Web developer</p>
                    <div class="d-flex">
                        <img src="../Images/Icons/localization.png" class="ObowiazekIcon" alt="">
                        <p class="text-light">Słopnice</p>
                    </div>
                </div>                
            </div>   
            <button class="btn-dark border-light rounded-3 bg-dark border-1 mt-1 ms-3 mb-3 EditBtnProf">
                <a href="" class="text-decoration-none text-light">Edytuj</a>
            </button>                         
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">
            
            <h3 class="text-light mx-3 my-4">Dane kontaktowe</h3>                                                                                
            <div>
                <p class="text-light ms-3">Email: piotr09sroka@interia.pl</p> 
                <p class="text-light ms-3">Telefon : 442 253 424</p>
            </div>                                                          
        </section>

        <section class="ogloszenie mt-2 rounded-3">
            <h3 class="text-light mx-3 my-4">Podsumowanie zawadowe</h3>    
            <p class="text-light m-4 text-wrap w-50">orem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fermentum imperdiet metus ac elementum. Suspendisse at posuere ligula. Ut sed purus ut tortor finibus ultrices. Curabitur placerat, velit et vestibulum vestibulum, felis ligula porta mauris, in varius lectus felis eget ante. Curabitur urna dolor, euismod in tempor eget, iaculis eu lorem. Vivamus tempus pretium sem, non facilisis quam fringilla non. Sed porttitor lorem a dolor porttitor aliquam. Etiam tristique tellus sed velit sagittis congue. Nam pharetra felis sit amet sem tincidunt, quis placerat nisi cursus. Fusce tincidunt porta gravida.</p>                  
        </section>

        
        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Doświadczenie zawodowe</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 mt-3">
                        <p class="mt-1">Kasjer / styczeń 2008 - luty 2021</p>
                        <p>Stokota (Kraków)</p>
                        <p>obłsuga klienta</p>
                    </div>                    
                </div>                               
            </div>                                  

            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 mt-3">
                        <p class="mt-1">Kasjer / styczeń 2008 - luty 2021</p>
                        <p>Stokota (Kraków)</p>
                        <p>obłsuga klienta</p>
                    </div>                
                </div>                               
            </div>                                  
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Wykształcenie</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 mt-3">
                        <p class="mt-1">Zespół Szkół Technicznych i Ogólnokształcacych im. Jana Pawła II / wrzesień 2020 - obecnie</p>
                        <p>Programowanie</p>
                        <p>średnie</p>
                    </div>                   
                </div>                               
            </div>                                              
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Języki</h3>               
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 d-flex mt-3">
                        <p class="mt-1">Angielski</p>
                        <p class="mt-1"> - średnio zaawansowany</p>
                    </div>                    
                </div>
                
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 d-flex mt-3">
                        <p class="mt-2">Polski</p>
                        <p class="mt-2"> - ojczysty</p>
                    </div>                  
                </div>                               
            </div>                                              
        </section>

        <section class="ogloszenie mt-2 rounded-3">
            <h3 class="text-light mx-3 my-4">Umiejętności</h3>    
            <p class="text-light m-4 text-wrap w-50">orem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fermentum imperdiet metus ac elementum. Suspendisse at posuere ligula. Ut sed purus ut tortor finibus ultrices. Curabitur placerat, velit et vestibulum vestibulum, felis ligula porta mauris, in varius lectus felis eget ante. Curabitur urna dolor, euismod in tempor eget, iaculis eu lorem. Vivamus tempus pretium sem, non facilisis quam fringilla non. Sed porttitor lorem a dolor porttitor aliquam. Etiam tristique tellus sed velit sagittis congue. Nam pharetra felis sit amet sem tincidunt, quis placerat nisi cursus. Fusce tincidunt porta gravida.</p>                 
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">
            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Kursy, szkolenia, certyfikaty</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 mt-3">
                        <p class="mt-1">Szkolenie C++ / maj 2014</p>                    
                        <p>Maciej Bąk</p>
                    </div>                    
                </div>                               
            </div>                                                               
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Organizacje, Aktywności, Stowarzyszenia</h3>               
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 mt-3">
                        <p class="mt-1">Jakas organizacja / kwiecień 2017 - kwiecień 2023</p>   
                        <p>Warszawa</p>                                         
                        <p>fsffsfsfddsadsa</p>
                    </div>                   
                </div>                               
            </div>                                                               
        </section>

        <section class="ogloszenie mt-2 rounded-3">
            <h3 class="text-light mx-3 my-4">Hobby</h3>    
            <p class="text-light m-4 text-wrap w-50">gra w życie</p>                  
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Linki</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                    <div class="text-light ms-3 my-2">
                        <a href="https://github.com/PiotrSroka2005" class="text-decoration-none text-light">Github</a>
                    </div>                   
                </div>                               
            </div>                                                               
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
  <?php  
    $polaczenie->close();
  ?>
</html>