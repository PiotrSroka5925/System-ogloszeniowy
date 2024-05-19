<?php
session_start();
require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$ogloszeniaNaStrone = 15;
$aktualnaStrona = isset($_GET['strona']) ? (int)$_GET['strona'] : 1;
$start = ($aktualnaStrona - 1) * $ogloszeniaNaStrone;

$dzis = new DateTime();
$dzisFormat = $dzis->format('Y-m-d');

$zapytanie = "SELECT ogloszenia.*, firmy.nazwa_firmy FROM ogloszenia 
JOIN firmy USING (firma_id) JOIN ogloszenie_umowy USING (umowa_id) JOIN ogloszenie_etaty USING (etat_id) JOIN ogloszenie_rodzaje_pracy USING (rodzaj_pracy_id) JOIN ogloszenie_stanowiska USING(stanowisko_id) WHERE 1=1";

$warunki = "";

if(isset($_GET['kategoria'])) {
    $warunki .= " AND ogloszenie_id IN (SELECT ogloszenie_id FROM ogloszenie_kategorie INNER JOIN kategorie USING(kategoria_id) WHERE nazwa_kategorii IN ('" . implode("', '", $_GET['kategoria']) . "'))";
}
if(isset($_GET['firma'])) {
    $warunki .= " AND nazwa_firmy IN ('" . implode("', '", $_GET['firma']) . "')";
}
if(isset($_GET['stanowisko'])) {
    $warunki .= " AND nazwa_stanowiska IN ('" . implode("', '", $_GET['stanowisko']) . "')";
}
if(isset($_GET['lokalizacja'])) {
    $lokalizacja = $_GET['lokalizacja'];
    $warunki .= " AND (ogloszenia.lokalizacja LIKE '%$lokalizacja%' OR 
    lokalizacja LIKE '%$lokalizacja' OR
    lokalizacja LIKE '$lokalizacja%')";
}
if(isset($_GET['poziom_stanowiska'])) {
    $warunki .= " AND ogloszenia.poziom_stanowiska IN ('" . implode("', '", $_GET['poziom_stanowiska']) . "')";
}
if(isset($_GET['rodzaj_umowy'])) {
    $warunki .= " AND rodzaj_umowy IN ('" . implode("', '", $_GET['rodzaj_umowy']) . "')";
}
if(isset($_GET['wymiar_pracy'])) {
    $warunki .= " AND wymiar_etatu IN ('" . implode("', '", $_GET['wymiar_pracy']) . "')";
}
if(isset($_GET['tryb_pracy'])) {
    $warunki .= " AND rodzaj_pracy IN ('" . implode("', '", $_GET['tryb_pracy']) . "')";
}
$zapytanie .= $warunki;

$zapytanie .= " AND data_waznosci > '" . $dzisFormat . "' ORDER BY ogloszenia.data_utworzenia DESC LIMIT $start, $ogloszeniaNaStrone";

$wynik = $polaczenie->query($zapytanie);

$zapytanieCount = "SELECT COUNT(*) AS ile FROM ogloszenia 
JOIN firmy USING (firma_id) JOIN ogloszenie_umowy USING (umowa_id) JOIN ogloszenie_etaty USING (etat_id) JOIN ogloszenie_rodzaje_pracy USING (rodzaj_pracy_id) JOIN ogloszenie_stanowiska USING(stanowisko_id) WHERE 1=1";
$zapytanieCount .= $warunki;
$zapytanieCount .= " AND data_waznosci > '" . $dzisFormat . "'";
$wynikStrony = $polaczenie->query($zapytanieCount);
$wiersz = $wynikStrony->fetch_assoc();

$wszystkieOgloszenia = $wiersz['ile'];
$strony = ceil($wszystkieOgloszenia / $ogloszeniaNaStrone);

$wynikPoziomStanowiska = $polaczenie->query("SELECT DISTINCT poziom_stanowiska FROM ogloszenia");

if(isset($_SESSION['zalogowany'])) {              
    $nazwaUzytkownika = $_SESSION['user'];
    $wynikUlubione = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = '$nazwaUzytkownika'");
    $wierszUzytkownk = $wynikUlubione->fetch_assoc();
    $idUzytkownika = $wierszUzytkownk['uzytkownik_id'];   
}

$wynikStanowiska = $polaczenie->query("SELECT stanowisko_id, nazwa_stanowiska FROM ogloszenie_stanowiska");
$wynikEtaty = $polaczenie->query("SELECT etat_id, wymiar_etatu FROM ogloszenie_etaty");
$wynikRodzajePracy = $polaczenie->execute_query("SELECT rodzaj_pracy_id, rodzaj_pracy FROM ogloszenie_rodzaje_pracy");
$wynikUmowy = $polaczenie->query("SELECT umowa_id, rodzaj_umowy FROM ogloszenie_umowy");
$wynikKategorie = $polaczenie->query("SELECT kategoria_id, nazwa_kategorii FROM kategorie");
$wynikFirmy = $polaczenie->query("SELECT firma_id, nazwa_firmy FROM firmy");

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
            if(isset($_SESSION['zalogowany'])) {
                if($_SESSION['administrator']==1) {
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
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
                            <a href="Ulubione.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Ulubione</a>
                            <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                        </form>
                        </li>
                    </ul>';                                  
                } else {
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
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
                            <a href="Ulubione.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Ulubione</a>
                            <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                        </form>
                        </li>
                    </ul>';                    
                }                 
            } else {
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
        <section class="row d-flex justify-content-center mt-5 bg-secondary rounded-4 shadow-lg p-2 wyszukiwanie">
          <form method="get" action="Wyszukiwanie.php" class="d-flex justify-content-center row wyszukiwanie">
            <section class="row d-flex justify-content-center text-center align-items-center">          
            
              <div class="col-8 col-xl-3 border border-dark rounded-1 bg-secondary-subtle border-2 my-2">
                <div class="dropdown row">            
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center pierwszySzczegol" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Stanowiska
                  </button>
                  <select name="stanowisko[]" class="dropdown-menu rounded-3" multiple>                    
                        <?php while($wierszStanowisko = $wynikStanowiska->fetch_assoc()) {
                            echo '<option class="rounded-2" value="'.$wierszStanowisko["nazwa_stanowiska"].'">'.$wierszStanowisko["nazwa_stanowiska"].'</option>';
                        }                      
                        ?>
                  </select>
                </div> 
              </div>     
            
              <div class="col-8 col-xl-3 border border-dark rounded-1 bg-secondary-subtle border-2 my-2">
                <div class="dropdown row">            
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Kategorie
                  </button>
                                  
                  <select name="kategoria[]" class="dropdown-menu rounded-3" multiple>                    
                    <?php while($wierszKategoria = $wynikKategorie->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszKategoria["nazwa_kategorii"].'">'.$wierszKategoria["nazwa_kategorii"].'</option>';
                    }                      
                    ?>
                  </select>
                                          
                </div> 
              </div>

              <input type="search" class="border border-dark rounded-1 border-2 col-8 col-xl-3 LokalizacjaInput text-dark" name="lokalizacja" placeholder="Lokalizacja">                                                 
            
              <div class="col-8 col-xl-3 border border-dark bg-secondary-subtle rounded-1 border-2 my-2">
                <div class="dropdown row">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Firmy
                  </button>                             
                  <select name="firma[]" class="dropdown-menu rounded-3"  multiple >
                    <option value="" disabled selected hidden>Wybierz...</option>
                    <?php while($wierszFirma = $wynikFirmy->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszFirma["nazwa_firmy"].'" >'.$wierszFirma["nazwa_firmy"].'</option>';
                    }                                                 
                    ?>
                  </select>             
                </div>    
              </div>
            </section>                                   
            <section class="row szczegolowe-wysz">
              
              <div class="dropdown col-12 col-xl-3  border border-0 rounded-1 my-2 border-2">
                <div class="dropdown row">
                  <button class="btn dropdown-toggle border border-0 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Poziom stanowiska
                  </button>
                
                  <select name="poziom_stanowiska[]" class="dropdown-menu rounded-3 col-12" multiple>                    
                    <?php while($wierszPoziomStanowiska = $wynikPoziomStanowiska->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszPoziomStanowiska["poziom_stanowiska"].'">'.$wierszPoziomStanowiska["poziom_stanowiska"].'</option>';
                    }                      
                    ?>
                  </select>   
                </div>                       
              </div> 
                        
              <div class="dropdown col-12 col-xl-3 border border-0 rounded-1  border-2 my-2">
                <div class="dropdown row">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Rodzaj umowy
                  </button>
                  <select name="rodzaj_umowy[]" class="dropdown-menu rounded-3 col-12" multiple>                    
                    <?php while($wierszUmowy = $wynikUmowy->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszUmowy["rodzaj_umowy"].'">'.$wierszUmowy["rodzaj_umowy"].'</option>';
                    }                      
                    ?>
                  </select> 
                </div>  
              </div> 
                        
              <div class="dropdown col-12 col-xl-2 border border-0 rounded-1  border-2 my-2">
                <div class="dropdown row">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Wymiar pracy
                  </button>
                  <select name="wymiar_pracy[]" class="dropdown-menu rounded-3 col-12" multiple>                    
                    <?php while($wierszEtaty = $wynikEtaty->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszEtaty["wymiar_etatu"].'">'.$wierszEtaty["wymiar_etatu"].'</option>';
                    }                      
                    ?>
                  </select> 
                </div>
              
              </div> 
                        
              <div class="dropdown col-12 col-xl-2 border border-0 my-2">
                <div class="dropdown row d-flex justify-content-center">
                  <button class="btn dropdown-toggle border border-0 fw-bold text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tryb pracy
                  </button>
                  <select name="tryb_pracy[]" class="dropdown-menu rounded-3 col-12" multiple>                    
                    <?php while($wierszRodzajePracy = $wynikRodzajePracy->fetch_assoc()) {
                        echo '<option class="rounded-2" value="'.$wierszRodzajePracy["rodzaj_pracy"].'">'.$wierszRodzajePracy["rodzaj_pracy"].'</option>';
                    }                      
                    ?>
                  </select> 
                </div>            
              </div> 
            
            <button type="submit" class="btn col-12 col-xl-2 btn-dark UlubionyKolor text-light rounded-5 sm-ms-5 my-2">Szukaj</button>
                      
            </section>                    
          </form>
        </section>

        <section class="my-5 text-center">                    
          <h1>Najnowsze oferty</h1>                                                  
        </section>

        <section class="row">                      
          <?php
            while($ogloszenie = $wynik->fetch_assoc()) {
              $dataWaznosci = new DateTime($ogloszenie['data_waznosci']); 
              $dataUtworzenia = new DateTime($ogloszenie['data_utworzenia']);            
              $dzis = new DateTime();
                                                 
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
          <?php
          if ($strony > 1) {
              $liczbaStronDoPokazania = 5;
              $start = max(1, $aktualnaStrona - 2);
              $koniec = min($strony, $aktualnaStrona + 2);

              // Zbieranie parametrów wyszukiwania
              $TablicaStringowLinku = $_GET;
              unset($TablicaStringowLinku['strona']); // Usunięcie parametru strona, aby móc go dodać osobno
              $StringLinku = http_build_query($TablicaStringowLinku);

              if ($aktualnaStrona > 1) {
                  echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona - 1) . '&' . $StringLinku . '">« Poprzednia</a> ';
              }

              if ($start > 1) {
                  echo '<a class="paginacjaNumery" href="?strona=1&' . $StringLinku . '">1</a> ';
                  if ($start > 2) {
                      echo '<a class="text-dark text-decoration-none paginacjaUkrycie" href="#">...</a> ';
                  }
              }

              for ($i = $start; $i <= $koniec; $i++) {
                  if ($i == $aktualnaStrona) {
                      echo '<span class="paginacjaNumeryCurrent border border-dark rounded-5 paginacjaNumery bg-light text-dark">' . $i . '</span> ';
                  } else {
                      echo '<a class="paginacjaNumery" href="?strona=' . $i . '&' . $StringLinku . '">' . $i . '</a> ';
                  }
              }

              if ($koniec < $strony) {
                  if ($koniec < $strony - 1) {
                      echo '<a class="text-dark text-decoration-none paginacjaUkrycie" href="#">...</a> ';
                  }
                  echo '<a class="paginacjaNumery" href="?strona=' . $strony . '&' . $StringLinku . '">' . $strony . '</a> ';
              }

              if ($aktualnaStrona < $strony) {
                  echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona + 1) . '&' . $StringLinku . '">Następna »</a>';
              }
          }
          ?>
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
