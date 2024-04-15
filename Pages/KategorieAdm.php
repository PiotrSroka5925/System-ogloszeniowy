<?php

session_start();
if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']!=true))
{
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$ogloszeniaNaStrone = 5;
$aktualnaStrona = isset($_GET['strona']) ? $_GET['strona'] : 1;
$start = ($aktualnaStrona - 1) * $ogloszeniaNaStrone;

$zapytanie = "SELECT COUNT(*) AS ile FROM ogloszenia";
$wynik = $polaczenie->query($zapytanie);
$r = $wynik->fetch_assoc();
$wszystkieOgloszenia = $r['ile'];
$strony = ceil($wszystkieOgloszenia / $ogloszeniaNaStrone);

$zapytanie = "SELECT ogloszenia.*, firmy.nazwa_firmy FROM ogloszenia 
JOIN firmy ON ogloszenia.firma_id = firmy.firma_id 
LIMIT $start, $ogloszeniaNaStrone";
$wynik = $polaczenie->query($zapytanie)

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
  <body class="d-flex flex-column min-vh-100 ContainerAdmin">    
    <nav class="navbar navbar-expand-xl UlubionyKolor shadow-lg sticky-top" data-bs-theme="dark">
        <a href="StronaGlowna.php" class="border border-dark"><img src="../Images/Other/logo.png" class="d-none d-sm-block border border-dark" alt="logo"></a>
        <h2 class="text-light align-center text-center fs-2 fw-bold mt-2">Panel admina</h2>      
        <button class="navbar-toggler mx-3 border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="list-group navbar-nav d-block d-xl-none text-center">
            <li class="list-unstyled text-light border-0  p-2">
            <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
            </li>                        
            <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="OgloszeniaAdm.php">Ogłoszenia</a>
            </li>
            <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Firmy</a>
            </li>
            <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Użytkownicy</a>
            </li>
            <?php
                echo '
                <li class="nav-item dropdown border-white border border-1 rounded-3 mb-2"> 
                      <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      '.$_SESSION['user'].'
                      </a>
                      <form class="dropdown-menu UlubionyKolor p-4 row">
                        <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12" role="button">Profil</a>
                        <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                      </form>
                    </li>';
            ?>
        </ul>
        </div>
        </nav>
        
        <div class="container-fluid row containerAdmin" style="flex : 1"> 
            <div class="col-3 col-xl-2 d-none d-xl-block sidebar UlubionyKolor border border-start-0 border-end-0 border-bottom-0 border-2">
                <ul class="list-group">
                    <li class="list-unstyled text-light border-0 p-2"> 
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="StronaGlowna.php">Strona główna</a>
                    </li>                    
                    <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="OgloszeniaAdm.php">Ogłoszenia</a>
                    </li>
                    <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                        <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Firmy</a>
                    </li>
                    <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                        <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Użytkownicy</a>
                    </li>
                    <?php
                    echo '
                        <li class="nav-item dropdown border-white border border-start-0 border-end-0 border-1"> 
                            <a class="nav-link dropdown-toggle p-2 w-100 text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            '.$_SESSION['user'].'
                            </a>
                            <form class="dropdown-menu border-white border border-top-0 border-1 UlubionyKolor p-4 row w-100">
                                <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 text-light" role="button">Profil</a>
                                <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white text-light rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                            </form>
                        </li>';
                    ?>
                </ul>
            </div>
            <div class="col-12 col-xl-10 AdminScroll">
                <?php
                    while($zapytanie = $wynik->fetch_assoc()) {
                        $dataZBazy = $zapytanie['data_utworzenia']; 
                        $data = new DateTime($dataZBazy);
                        $formattedDate = $data->format('d.m.Y');
                
                        echo '
                        <div class="d-flex justify-content-center w-100">
                            <a href="SzczegolyOglo.php?id='.$zapytanie['ogloszenie_id'].'" class="ogloszenieMain w-100 my-3 border-0 rounded-4 px-3 text-decoration-none">
                                <div class="row maxPierwszywOglo">
                                    <h5 class="text-light mt-3 text-break">'.$zapytanie['nazwa_ogloszenia'].'</h5>                
                                </div>

                                <div class="row mt-5">
                                <p class="text-light">'.str_replace(".", ",", $zapytanie['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $zapytanie['najw_wynagrodzenie']).' zł/mies</p>
                                </div>
                                    
                                <div class="row">
                                    <img src="'.$zapytanie['zdjecie'].'" alt="" class="logoOgloszenia col-6">
                                    <p class="fs-5 text-light mt-4 ms-2 col-6">'.$zapytanie['nazwa_firmy'].'</p>
                                </div>
                                <div class="row">
                                    <p class="text-light mt-3">'.$formattedDate.'</p>
                                </div>                
                            </a>
                        </div>';
                    }
                ?>
                <div class="paginacja">
                    <?php
                    $liczbaStronDoPokazania = 5;
                    $start = max(1, $aktualnaStrona - 2);
                    $koniec = min($strony, $aktualnaStrona + 2);

                    if ($aktualnaStrona > 1) {
                        echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona - 1) . '">« Poprzednia</a> ';
                    }

                    if ($start > 1) {
                        echo '<a class="paginacjaNumery" href="?strona=1">1</a> ';
                        if ($start > 2) {
                            echo '<a class="text-dark text-decoration-none pagiancjaUkrycie" href="#">...</a> ';
                        }
                    }

                    for ($i = $start; $i <= $koniec; $i++) {
                        if ($i == $aktualnaStrona) {
                            echo '<span class="paginacjaNumeryCurrent border border-dark rounded-5 paginacjaNumery bg-light text-dark">' . $i . '</span> ';
                        } else {
                            echo '<a class="paginacjaNumery" href="?strona=' . $i . '">' . $i . '</a> ';
                        }
                    }

                    if ($koniec < $strony) {
                        if ($koniec < $strony - 1) {
                            echo '<a class="text-dark text-decoration-none pagiancjaUkrycie" href="#">...</a> ';
                        }
                        echo '<a class="paginacjaNumery" href="?strona=' . $strony . '">' . $strony . '</a> ';
                    }

                    if ($aktualnaStrona < $strony) {
                        echo '<a class="paginacjaNextPrev" href="?strona=' . ($aktualnaStrona + 1) . '">Następna »</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        

        <footer class="mt-auto UlubionyKolor border-white border border-start-0 border-bottom-0 border-end-0 border-1">
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