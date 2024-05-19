<?php

session_start();
if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] != true)) {
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$uzytkownicyNaStrone = 15;
$aktualnaStrona = isset($_GET['strona']) ? $_GET['strona'] : 1;
$start = ($aktualnaStrona - 1) * $uzytkownicyNaStrone;

$wynik = $polaczenie->query("SELECT COUNT(*) AS ile FROM uzytkownicy");
$wiersz = $wynik->fetch_assoc();
$wszyscyUzytkownicy = $wiersz['ile'];
$strony = ceil($wszyscyUzytkownicy / $uzytkownicyNaStrone);

$wynik = $polaczenie->query("SELECT * FROM uzytkownicy LIMIT $start, $uzytkownicyNaStrone");

$nazwaUzytkownika = $_SESSION['user'];

if (isset($_POST['OdbierzAdm']) && isset($_POST['ukrytyEditUzytkownikaAdm'])) {
    $idUzytkownika = $_POST['ukrytyEditUzytkownikaAdm'];
    $polaczenie->execute_query("UPDATE uzytkownicy SET administrator = 0 WHERE uzytkownik_id = ?", [$idUzytkownika]);
    header('Location: UzytkownicyAdm.php');
    exit();
}

if (isset($_POST['DajAdm']) && isset($_POST['ukrytyEditUzytkownikaUzy'])) {
    $idUzytkownika = $_POST['ukrytyEditUzytkownikaUzy'];
    $polaczenie->execute_query("UPDATE uzytkownicy SET administrator = 1 WHERE uzytkownik_id = ?", [$idUzytkownika]);
    header('Location: UzytkownicyAdm.php');
    exit();    
}

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
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="KategorieAdm.php">Kategorie</a>
                </li>
                <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="FirmyAdm.php">Firmy</a>
                </li>                
                <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="AplikowaniaAdm.php">Aplikowania</a>
                </li>
                <?php
                    echo '
                    <li class="nav-item dropdown border-white border border-1 rounded-3 mb-2"> 
                        <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        '.$_SESSION['user'].'
                        </a>
                        <form class="dropdown-menu UlubionyKolor p-4 row">
                            <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12" role="button">Profil</a>
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 mt-3 border-white rounded-4 col-12 text-light" role="button">Aplikowane</a>
                            <a href="Ulubione.php" active class="btn UlubionyKolor border-1 mt-3 border-white rounded-4 col-12 text-light" role="button">Ulubione</a>
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
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="KategorieAdm.php">Kategorie</a>
                </li>
                <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="FirmyAdm.php">Firmy</a>
                </li>               
                <li class="list-unstyled text-light border-white border border-bottom-0 border-start-0 border-end-0 border-1  p-2">
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="AplikowaniaAdm.php">Aplikowania</a>
                </li> 
                <?php
                echo '
                    <li class="nav-item dropdown border-white border border-start-0 border-end-0 border-1"> 
                        <a class="nav-link dropdown-toggle p-2 w-100 text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            '.$_SESSION['user'].'
                        </a>
                        <form class="dropdown-menu border-white border border-top-0 border-1 UlubionyKolor p-4 row w-100">
                            <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 text-light" role="button">Profil</a>
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 mt-3 border-white rounded-4 col-12 text-light" role="button">Aplikowane</a>
                            <a href="Ulubione.php" active class="btn UlubionyKolor border-1 mt-3 border-white rounded-4 col-12 text-light" role="button">Ulubione</a>
                            <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white text-light rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                        </form>
                    </li>';
                ?>
            </ul>
        </div>
        <div class="col-12 col-xl-10 AdminScroll min-vh-100">
            <div class="d-flex flex-wrap">
                <h1 class="text-center mx-auto">Zarządzanie użytkownikami</h1>               
            </div>            
                 
            <?php
                while ($zapytanie = $wynik->fetch_assoc()) {
                    echo '
                    <div class="d-flex flex-column flex-xxl-row align-items-center text-center UlubionyKolor my-2 rounded-5">
                        <div class="d-flex flex-column flex-xxl-row justify-content-between w-100 text-center UlubionyKolor text-light rounded-5 text-decoration-none">
                            <div class="mt-2 p-3 text-decoration-none text-light d-flex flex-column flex-xxl-row justify-content-between w-100 rounded-5 align-items-center">
                                <h5 class="fs-5 px-2"> id: ' . $zapytanie['uzytkownik_id'] . '</h5>
                                <h5 class="fs-5 px-2 AdminUzytkownik">' . $zapytanie['nick'] . '</h5>
                                <h5 class="fs-5 col-xxl-5 px-2 AdminUzytkownik text-wrap">' . $zapytanie['email'] . '</h5>
                                <h5 class="fs-5 px-2 AdminUzytkownik">';
                                    if ($zapytanie['administrator'] == 1)
                                    {
                                        echo "administrator";
                                    }
                                    else 
                                    {
                                        echo "użytkownik";
                                    }
                                echo
                             '</h5>
                            </div>
                            <div class="d-flex flex-column flex-xxl-row justify-content-center mx-3">';
                            $wynikUzytkownicy = $polaczenie->execute_query("SELECT COUNT(uzytkownik_id) as liczba FROM uzytkownicy WHERE uzytkownik_id = ? AND administrator = ?",[$zapytanie['uzytkownik_id'], 1]);
                            $uzytkownicyLiczba = $wynikUzytkownicy->fetch_assoc();
                            if($uzytkownicyLiczba['liczba'] > 0) 
                            {
                                echo '
                                <form method="post" class="d-flex flex-column flex-xxl-row align-items-center w-100">
                                    <input type="submit" name="OdbierzAdm" class="btn UlubionyKolor btn-secondary text-light border-3 rounded-5 px-5 my-2" value="Odbierz admina">
                                    <input type="number" value="'. $zapytanie['uzytkownik_id'] .'" name="ukrytyEditUzytkownikaAdm" hidden>                           
                                </form>';
                            }
                            else
                            {
                            echo ' 
                                <form method="post" class="d-flex flex-column flex-xxl-row align-items-center w-100">
                                    <input type="submit" name="DajAdm" class="btn UlubionyKolor btn-secondary text-light border-3 rounded-5 px-5 mx-3 my-2" value="Daj admina">
                                    <input type="number" value="'.$zapytanie['uzytkownik_id'].'" name="ukrytyEditUzytkownikaUzy" hidden>                           
                                </form>';
                            }                       
                            echo '</div>
                        </div>
                    </div>';
                }
            ?>
    
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
        </div>
    </div>
                                 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  <?php  
    $polaczenie->close();
  ?>
</html>