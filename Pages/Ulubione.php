<?php
session_start();
 
require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$ogloszeniaNaStrone = 15;
$aktualnaStrona = isset($_GET['strona']) ? $_GET['strona'] : 1;
$start = ($aktualnaStrona - 1) * $ogloszeniaNaStrone;

if (isset($_POST['polubione_x']) && isset($_POST['polubione_y'])) {
    $idukryte = $_POST['ukrytyPolubione'];
    $polaczenie->execute_query("DELETE FROM ulubione WHERE ogloszenie_id = ?", [$idukryte]);
    header('Location: Ulubione.php');
    exit();
}

$wynik = $polaczenie->query("SELECT COUNT(*) AS ile FROM ulubione");
$wiersz = $wynik->fetch_assoc();
$wszystkieOgloszenia = $wiersz['ile'];
$strony = ceil($wszystkieOgloszenia / $ogloszeniaNaStrone);

$nazwaUzytkownika = $_SESSION['user'];

$wynik = $polaczenie->execute_query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = ?", [$nazwaUzytkownika]);
$wierszUzytkownk = $wynik->fetch_assoc();

$idUzytkownika = $wierszUzytkownk['uzytkownik_id'];

$wynik = $polaczenie->execute_query("SELECT ogloszenia.*, firmy.nazwa_firmy FROM ogloszenia 
JOIN firmy ON ogloszenia.firma_id = firmy.firma_id 
JOIN ulubione ON ogloszenia.ogloszenie_id = ulubione.ogloszenie_id 
WHERE ulubione.uzytkownik_id = ? 
ORDER BY ogloszenia.data_utworzenia DESC 
LIMIT ?, ?", [$idUzytkownika, $start, $ogloszeniaNaStrone]);

?>

<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ulubione</title>    
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
                        <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
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
                        <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>                     
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
          <h1>Ulubione ogłoszenia</h1>                                                  
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
                    <a href="SzczegolyOglo.php?id='.$ogloszenie['ogloszenie_id'].'" class="ogloszenieMain my-3 border-0 rounded-4 shadow-lg px-3 row text-decoration-none">
                      <div class="col-12 col-md-9">
                          <div class="row maxPierwszywOglo">
                            <h5 class="text-light mt-3 text-break">'.$ogloszenie['nazwa_ogloszenia'].'</h5>                                        
                          </div>

                          <div class="row mt-5">
                            <p class="text-light">'.str_replace(".", ",", $ogloszenie['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $ogloszenie['najw_wynagrodzenie']).' zł/mies</p>
                          </div>
                            
                          <div class="row">
                              <img src="'.$ogloszenie['zdjecie'].'" alt="" class="logoOgloszenia col-6">
                              <p class="fs-5 text-light mt-4 ms-2 col-6">'.$ogloszenie['nazwa_firmy'].'</p>
                          </div>
                          <div class="row">
                            <p class="text-light mt-3">'. $dataUtworzenia->format('d.m.Y').'</p>
                          </div>      
                      </div>                                                     
                      <form method="post" class="col-12 col-md-3 m-auto">                 
                        <input type="image" src="../Images/Icons/polubione.png" class="SzczegolyIconMain rounded-3 m-auto dlt-btn" name="polubione" alt="polubione">                          
                        <input type="number" value="'.$ogloszenie['ogloszenie_id'].'" name="ukrytyPolubione" hidden>
                      </form> 
                    </a>                     
                </div>';              
              }
              else
              {
                echo '
                <div class="col-12 d-flex justify-content-center">
                    <a href="SzczegolyOglo.php?id='.$ogloszenie['ogloszenie_id'].'" class="bg-secondary w-100 my-3 border-0 rounded-4 shadow-lg px-3 row text-decoration-none">
                      <div class="col-12 col-md-9">
                        <div class="row maxPierwszywOglo">
                            <h5 class="text-light mt-3 text-break">'.$ogloszenie['nazwa_ogloszenia'].'</h5>                                        
                          </div>

                          <div class="row mt-5">
                            <p class="text-light">'.str_replace(".", ",", $ogloszenie['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $ogloszenie['najw_wynagrodzenie']).' zł/mies</p>
                          </div>
                            
                          <div class="row">
                              <img src="'.$ogloszenie['zdjecie'].'" alt="" class="logoOgloszenia col-6">
                              <p class="fs-5 text-light mt-4 ms-2 col-6">'.$ogloszenie['nazwa_firmy'].'</p>
                          </div>
                          <div class="row">
                            <p class="text-light mt-3">'. $dataUtworzenia->format('d.m.Y').'</p>
                          </div>      
                      </div>                                                     
                    <form method="post" class="col-12 col-md-3 m-auto">                 
                        <input type="image" src="../Images/Icons/polubione.png" class="SzczegolyIconMain rounded-3 m-auto dlt-btn" name="polubione" alt="polubione">                          
                        <input type="number" value="'.$ogloszenie['ogloszenie_id'].'" name="ukrytyPolubione" hidden>
                    </form> 
                    </a>                     
                </div>';
              }
            }
          ?>         
        </section>
        <div class="paginacja">
          <?php
          if($strony > 1 )
          {
            $liczbaStronDoPokazania = 5;
            $start = max(1, $aktualnaStrona - 2);
            $koniec = min($strony, $aktualnaStrona + 2);

            if ($aktualnaStrona > 1)
            {
                echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona - 1) . '">« Poprzednia</a> ';
            }

            if ($start > 1)
            {
                echo '<a class="paginacjaNumery" href="?strona=1">1</a> ';
                if ($start > 2)
                {
                    echo '<a class="text-dark text-decoration-none pagiancjaUkrycie" href="#">...</a> ';
                }
            }

            for ($i = $start; $i <= $koniec; $i++)
            {
                if ($i == $aktualnaStrona)
                {
                    echo '<span class="paginacjaNumeryCurrent border border-dark rounded-5 paginacjaNumery bg-light text-dark">' . $i . '</span> ';
                }
                else
                {
                    echo '<a class="paginacjaNumery" href="?strona=' . $i . '">' . $i . '</a> ';
                }
            }

            if ($koniec < $strony)
            {
                if ($koniec < $strony - 1)
                {
                    echo '<a class="text-dark text-decoration-none pagiancjaUkrycie" href="#">...</a> ';
                }
                echo '<a class="paginacjaNumery" href="?strona=' . $strony . '">' . $strony . '</a> ';
            }

            if ($aktualnaStrona < $strony)
            {
                echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona + 1) . '">Następna »</a>';
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