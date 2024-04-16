<?php

session_start();

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$zapytanieOglo = "SELECT ogloszenia.*, 
ogloszenie_stanowiska.nazwa_stanowiska, 
ogloszenie_stanowiska.poziom_stanowiska,
ogloszenie_etaty.wymiar_etatu, 
ogloszenie_rodzaje_pracy.rodzaj_pracy, 
ogloszenie_umowy.rodzaj_umowy
FROM ogloszenia 
JOIN ogloszenie_stanowiska USING(stanowisko_id) 
JOIN ogloszenie_etaty ON ogloszenia.etat_id = ogloszenie_etaty.etat_id 
JOIN ogloszenie_rodzaje_pracy ON ogloszenia.rodzaj_pracy_id = ogloszenie_rodzaje_pracy.rodzaj_pracy_id 
JOIN ogloszenie_umowy ON ogloszenia.umowa_id = ogloszenie_umowy.umowa_id 
WHERE ogloszenie_id='{$_GET['id']}';";
$wynikOglo = $polaczenie->query($zapytanieOglo);

$zapytanieOgloFirma = "SELECT firmy.nazwa_firmy FROM ogloszenia JOIN firmy USING(firma_id) WHERE ogloszenie_id='{$_GET['id']}';";
$wynikOgloFirma = $polaczenie->query($zapytanieOgloFirma);
$wierszOgloFirma = $wynikOgloFirma ->  fetch_assoc();

$zapytanieObo = "SELECT * FROM ogloszenie_obowiazki WHERE ogloszenie_id='{$_GET['id']}';";
$wynikObo = $polaczenie->query($zapytanieObo);

$zapytanieBenef = "SELECT * FROM ogloszenie_benefity WHERE ogloszenie_id='{$_GET['id']}';";
$wynikBenef = $polaczenie->query($zapytanieBenef);

$zapytanieWymag = "SELECT * FROM ogloszenie_wymagania WHERE ogloszenie_id='{$_GET['id']}';";
$wynikWymag = $polaczenie->query($zapytanieWymag);



?>

<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Szczegóły ogłoszenia</title>    
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
                        <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 text-light" role="button">Profil</a>
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
                      <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
                    </li>                   
                    <li class="nav-item dropdown border-white border border-1 rounded-3"> 
                      <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      '.$_SESSION['user'].'
                      </a>
                      <form class="dropdown-menu UlubionyKolor p-4 row">
                        <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 text-light" role="button">Profil</a>
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
                        <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
                      </li>                     
                      <li class="nav-item" >
                        <a class="nav-link active mt-1 fs-5  marginChange" aria-current="page" href="Logowanie.php">Zaloguj się</a>
                      </li>
                    </ul>';
               }                                    
               ?>            
        </div>     
    </nav>
    
    <section class="container my-2">    
      <?php
            if($wynikOglo->num_rows > 0)
            {
              while ($rowOglo = $wynikOglo->fetch_assoc())
              {     
                $dataZBazy = $rowOglo['data_utworzenia']; 
                $data = new DateTime($dataZBazy);
                $formattedDate = $data->format('d.m.Y');
                echo '
                <section class="ogloszenie mt-2 rounded-3">
                    <div class="p-3">
                        <p class="text-light ms-3 fs-3">'.$rowOglo['nazwa_ogloszenia'].'</p>                    
                        <div class="d-flex">                     
                            <img src="'.$rowOglo['zdjecie'].'" class="logoSzczegolyOgloszenia ms-3 mt-1" alt="">
                            <p class="text-light ms-3 mt-4 fs-4">'.$wierszOgloFirma['nazwa_firmy'].'</p>
                        </div>
                    </div>            
                </section>

                <section class="ogloszenie mt-2 rounded-3">
                  <div class="p-3">                              
                      <div class="d-flex">                     
                      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d330519.21887411654!2d18.57307145776759!3d51.04068453577747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spl!2spl!4v1710008321774!5m2!1spl!2spl" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>      
                      </div>
                  </div>            
                </section>

                <section class="ogloszenie mt-2 rounded-3">
                    <div class="p-3">                               
                        <div class="row">                    
                            <div class="my-2 d-flex col-12 col-xl-4">
                                <img src="../Images/Icons/ADlocalization.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['lokalizacja'].'</p>                        
                            </div> 
                            
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/waznosc.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">Ważne do '.$formattedDate.'</p>                        
                            </div>

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/money.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.str_replace(".", ",", $rowOglo['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $rowOglo['najw_wynagrodzenie']).' zł/mies</p>                        
                            </div>  
                        </div>
                                            
                        <div class="row">
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/umowa.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['rodzaj_umowy'].'</p>                        
                            </div>  

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/czasPracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['wymiar_etatu'].'</p>                        
                            </div> 
                        </div>';    
                        
                        if($rowOglo['poziom_stanowiska'] != null)
                        {
                          echo '
                          <div class="row">
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/stanowisko.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['nazwa_stanowiska'].' - '.$rowOglo['poziom_stanowiska'].'</p>                        
                            </div>  

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/miejscePracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['rodzaj_pracy'].'</p>                        
                            </div> 
                          </div>';
                        }
                        else
                        {
                            echo '
                            <div class="row">
                              <div class="col-12 col-xl-4 my-2 d-flex">
                                  <img src="../Images/Icons/stanowisko.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                  <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['nazwa_stanowiska'].'</p>                        
                              </div>  

                              <div class="col-12 col-xl-4 my-2 d-flex">
                                  <img src="../Images/Icons/miejscePracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                  <p class="text-light ms-2 my-0 d-flex align-items-center">'.$rowOglo['rodzaj_pracy'].'</p>                        
                              </div> 
                            </div>   
                            ';
                        }

                         echo '
                    </div>            
                </section>
                                
                <section class="ogloszenie mt-2 rounded-3">

                      <h3 class="text-light mx-3 my-4">Twój zakres obowiązków</h3>

                      <div class="row m-2">
                      ';
                      if($wynikObo->num_rows > 0)
                      {
                        while ($rowObo = $wynikObo->fetch_assoc())
                        {
                          echo '
                          <div class="col-12 d-flex">
                              <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                              <p class="text-light ms-2">'.$rowObo['obowiazekText'].'</p>
                          </div>                          
                        ';    
                        }   
                      }   

                echo '
                  </div>
                </section>

                <section class="ogloszenie mt-2 rounded-3">

                    <h3 class="text-light mx-3 my-4">Nasze wymagania</h3>

                    <div class="row m-2">';
                    if($wynikWymag->num_rows > 0)
                    {
                      while ($rowWymag = $wynikWymag->fetch_assoc())
                      {
                        echo '
                        <div class="col-12 d-flex">
                            <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                            <p class="text-light ms-2">'.$rowWymag['wymaganieText'].'</p>
                        </div> ';                      
                      }
                    }
                    echo '
                    </div>            
                </section>

                <section class="ogloszenie mt-2 rounded-3">

                    <h3 class="text-light mx-3 my-4">Benefity</h3>

                    <div class="row m-2">';
                    if($wynikBenef->num_rows > 0)
                    {
                      while ($rowBenef = $wynikBenef->fetch_assoc())
                      {
                        echo '
                        <div class="col-12 d-flex">
                            <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                            <p class="text-light ms-2">'.$rowBenef['benefitText'].'</p>
                        </div> ';
                      }
                    }
                     
                    echo '
                    </div>            
                </section>

                <section class="ogloszenie mt-2 rounded-3">
                    <h3 class="text-light mx-3 my-4">'.$wierszOgloFirma['nazwa_firmy'].'</h3>    
                    <p class="text-light m-4 text-wrap w-50">'.$rowOglo['informacje'].'</p>      
                </section>';
              }
            }

      ?>
                   
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