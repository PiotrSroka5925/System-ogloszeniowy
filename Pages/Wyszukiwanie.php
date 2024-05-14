<?php
 session_start();
 
 require_once "../PHPScripts/connect.php";

 $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

  $ogloszeniaNaStrone = 15;
  $aktualnaStrona = isset($_GET['strona']) ? $_GET['strona'] : 1;
  $start = ($aktualnaStrona - 1) * $ogloszeniaNaStrone;


  $zapytanie = "SELECT ogloszenia.*, firmy.nazwa_firmy FROM ogloszenia 
  JOIN firmy USING (firma_id) JOIN ogloszenie_umowy USING (umowa_id) JOIN ogloszenie_etaty USING (etat_id) JOIN ogloszenie_stanowiska USING(stanowisko_id) WHERE 1=1";
  if(isset($_GET['kategoria']))
  {
    $zapytanie.=" AND ogloszenie_id IN (SELECT ogloszenie_id FROM ogloszenie_kategorie INNER JOIN kategorie USING(kategoria_id) WHERE nazwa_kategorii IN ('".(implode("', '", $_GET['kategoria']))."'))";
  }
  if(isset($_GET['firma']))
  {
    $zapytanie.=" AND nazwa_firmy IN ('".(implode("', '", $_GET['firma']))."')";
  }
  if(isset($_GET['stanowisko']))
  {
    $zapytanie.=" AND nazwa_stanowiska IN ('".(implode("', '", $_GET['stanowisko']))."')";
  }
  
  if(isset($_GET['lokalizacja']))
  {
    $lokalizacja = $_GET['lokalizacja'];
    $zapytanie.= " AND (ogloszenia.lokalizacja LIKE '%$lokalizacja%' OR 
    lokalizacja LIKE '%$lokalizacja' OR
    lokalizacja LIKE '$lokalizacja%')";
  }
  if(isset($_GET['poziom_stanowiska']))
  {
    $zapytanie.=" AND ogloszenia.poziom_stanowiska IN ('".(implode("', '", $_GET['poziom_stanowiska']))."')";
  }
  if(isset($_GET['rodzaj_umowy']))
  {
    $zapytanie.=" AND rodzaj_umowy IN ('".(implode("', '", $_GET['rodzaj_umowy']))."')";
  }
  if(isset($_GET['wymiar_pracy']))
  {
    $zapytanie.=" AND wymiar_etatu IN ('".(implode("', '", $_GET['wymiar_pracy']))."')";
  }

  $zapytanie.=" ORDER BY ogloszenia.data_utworzenia DESC";
  echo $zapytanie;
  $wynik = $polaczenie->query($zapytanie);

  

if(isset($_SESSION['zalogowany']))
{              

  $nazwaUzytkownika = $_SESSION['user'];
  $wynikUlubione = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = '$nazwaUzytkownika'");
  $wierszUzytkownk = $wynikUlubione->fetch_assoc();

  $idUzytkownika = $wierszUzytkownk['uzytkownik_id'];


  $zapytanieStanowiska = "SELECT stanowisko_id, nazwa_stanowiska FROM ogloszenie_stanowiska";
  $wynikStanowiska = $polaczenie->query($zapytanieStanowiska);

  $zapytanieEtaty = "SELECT etat_id, wymiar_etatu FROM ogloszenie_etaty";
  $wynikEtaty = $polaczenie->query($zapytanieEtaty);

  $wynikRodzajePracy = $polaczenie->execute_query("SELECT rodzaj_pracy_id, rodzaj_pracy FROM ogloszenie_rodzaje_pracy");

  $zapytanieUmowy = "SELECT umowa_id, rodzaj_umowy FROM ogloszenie_umowy";
  $wynikUmowy = $polaczenie->query($zapytanieUmowy);

  $zapytanieKategorie = "SELECT kategoria_id, nazwa_kategorii FROM kategorie";
  $wynikKategorie = $polaczenie->query($zapytanieKategorie);

  $zapytanieFirmy = "SELECT firma_id, nazwa_firmy FROM firmy";
  $wynikFirmy = $polaczenie->query($zapytanieFirmy);

}

?>
<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wyszukiwanie</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/Other/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
  </head>
  <body class="d-flex flex-column min-vh-100 GlownaTlo">    
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
                        <a href="Aplikowania.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowania</a>
                        <a href="Ulubione.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Ulubione</a>
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
                        <a href="Aplikowania.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowania</a>
                        <a href="Ulubione.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Ulubione</a>
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

    <section class="container">
        <section class="my-5 text-center">                    
            <h1>67 542 <span class="mx-2">Sprawdzone oferty pracy</span></h1>                                        
            <p class="fs-4">od najlepszych pracodawców</p>               
        </section>
  <form method="get">
        <section class="row d-flex justify-content-center bg-secondary rounded-4 shadow-lg wyszukiwanie">
          <section class="row d-flex justify-content-center">
            <div class="col-8 col-xl-3 border border-dark rounded-1 border-2 my-2">
              <div class="d-flex row h-100">
                  <input type="search" class="border border-0 form-control bg-secondary-subtle" placeholder="Stanowisko">               
              </div>
            </div>

            <div class="col-8 col-xl-2 border border-dark rounded-1 bg-secondary-subtle border-2 my-2">
              <div class="dropdown row">
                      <select name="kategoria[]" class="col-12 col-md-10 w-100 LogowanieInput border-0 rounded-3" multiple size="3" required>                    
                        <?php while($rowKategoria = $wynikKategorie->fetch_assoc())
                        {
                            echo '<option value="'.$rowKategoria["nazwa_kategorii"].'">'.$rowKategoria["nazwa_kategorii"].'</option>';
                        }                      
                        ?>
                    </select>
              </div> 
            </div>

            <div class="col-8 col-xl-2 border border-dark rounded-1 border-2 my-2">
              <form class="d-flex row h-100">
                  <input type="search" class="border border-0 form-control bg-secondary-subtle" name="lokalizacja" placeholder="Lokalizacja">               
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
            
            <button type="submit" class="btn col-12 col-xl-2 btn-dark UlubionyKolor text-light rounded-5 sm-ms-5 my-2">Szukaj</button>

            </form>
          </section>                    
        </section>

        <section class="my-5 text-center">                    
          <h1>Wyszukane oferty</h1>                                                  
        </section>

        <section class="row">                      
        <?php
            while($ogloszenie = $wynik->fetch_assoc()) {
              $dataWaznosci = new DateTime($ogloszenie['data_waznosci']); 
              $dataUtworzenia = new DateTime($ogloszenie['data_utworzenia']);            
              $dzis = new DateTime();
                         
              $linkStart = '<a href="SzczegolyOglo.php?id='.$ogloszenie['ogloszenie_id'].'" class="ogloszenieMain my-3 border-0 rounded-4 shadow-lg px-3 text-decoration-none">';
              $linkEnd = '</a>';              
              if ($dataWaznosci > $dzis) {                                     
                echo '
                <div class="col-12 d-flex justify-content-center">
                    <a href="SzczegolyOglo.php?id='.$ogloszenie['ogloszenie_id'].'" class="ogloszenieMain my-3 row border-0 rounded-4 shadow-lg px-3 text-decoration-none">
                      <div class="row maxPierwszywOglo col-12">
                        <h5 class="text-light mt-3 text-break">'.$ogloszenie['nazwa_ogloszenia'].'</h5>                
                      </div>                                                                  
                      <div class="row mt-3">
                        <p class="text-light">'.str_replace(".", ",", $ogloszenie['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $ogloszenie['najw_wynagrodzenie']).' zł/mies</p>
                      </div>  
                      <div class="row">
                        <img src="'.$ogloszenie['zdjecie'].'" alt="" class="logoOgloszenia col-6">
                        <p class="fs-5 text-light mt-4 ms-2 col-6">'.$ogloszenie['nazwa_firmy'].'</p>
                      </div>
                      <div class="row">
                        <p class="text-light mt-3">'. $dataUtworzenia->format('d.m.Y').'</p>
                      </div>                         
                    </a>
                </div>';
              }              
            }
          ?>    
        </section>
        <div class="paginacja">
         
      </div>
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