<?php

session_start();


if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']!=true))
{
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);


$adresPoprzedni = "http://". $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$adresObecny = $_SERVER['HTTP_REFERER'];
   

$zapytanieStanowiska = "SELECT stanowisko_id, nazwa_stanowiska FROM ogloszenie_stanowiska";
$wynikStanowiska = $polaczenie->query($zapytanieStanowiska);

$zapytanieEtaty = "SELECT etat_id, wymiar_etatu FROM ogloszenie_etaty";
$wynikEtaty = $polaczenie->query($zapytanieEtaty);


$zapytanieRodzajePracy = "SELECT rodzaj_pracy_id, rodzaj_pracy FROM ogloszenie_rodzaje_pracy";
$wynikRodzajePracy = $polaczenie->query($zapytanieRodzajePracy);


$zapytanieUmowy = "SELECT umowa_id, rodzaj_umowy FROM ogloszenie_umowy";
$wynikUmowy = $polaczenie->query($zapytanieUmowy);


$zapytanieKategorie = "SELECT kategoria_id, nazwa_kategorii FROM kategorie";
$wynikKategorie = $polaczenie->query($zapytanieKategorie);

$zapytanieFirmy = "SELECT firma_id, nazwa_firmy FROM firmy";
$wynikFirmy = $polaczenie->query($zapytanieFirmy);

$zdjecie = "../Images/Companies";

    function ImgUpload($Dir)
    {
        if(isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === 0){
            $UploadFile = $Dir . basename($_FILES['zdjecie']['name']);

            $UploadFile = str_replace(' ','',$UploadFile);
            $AllowExt = array('jpg', 'png', 'jpeg', 'gif');

            $ImgEx =pathinfo($_FILES['zdjecie']['name'], PATHINFO_EXTENSION);
            $ImgEx = strtolower($ImgEx);

            if(in_array($ImgEx, $AllowExt))
            {
                if($_FILES['zdjecie']['size'] > 5*1024*1024)
                {
                    return NULL;
                }
                if(move_uploaded_file($_FILES['zdjecie']['tmp_name'], $UploadFile))
                return $UploadFile;                
            }
            else
            {
                return NULL;
            }            
        }
        return NULL;
    }


    $zdjecieZapis = ImgUpload($zdjecie);

if(!isset($_SESSION['ogloszenie']))
{
    $_SESSION['ogloszenie'] = [];
}

if (!isset($_SESSION['benefity']))
{
    $_SESSION['benefity'] = [];
}
if (!isset($_SESSION['wymagania'])) 
{
    $_SESSION['wymagania'] = [];
}
if (!isset($_SESSION['obowiazki'])) 
{
    $_SESSION['obowiazki'] = [];
}

if (isset($_POST['Dodaj_obowiazek']))
{
    array_push($_SESSION['obowiazki'], $_POST['obowiazek']);
    header('Location: ' . $_SERVER['PHP_SELF']);  
    exit();
}

if (isset($_POST['Dodaj_wymaganie'])) 
{
    array_push($_SESSION['wymagania'], $_POST['wymaganie']);
    header('Location: ' . $_SERVER['PHP_SELF']);    
    exit();
}

if (isset($_POST['Dodaj_benefit'])) 
{
    array_push($_SESSION['benefity'], $_POST['benefit']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


if(isset($_POST['nazwa_ogloszenia']))
$_SESSION['ogloszenie']['nazwa_ogloszenia'] = $_POST['nazwa_ogloszenia'];

if(isset($_POST['lokalizacja']))
$_SESSION['ogloszenie']['lokalizacja'] = $_POST['lokalizacja'];

if(isset($_POST['kategoria[]']))
$_SESSION['ogloszenie']['kategoria[]'] = $_POST['kategoria[]'];

if(isset($_POST['firma']))
$_SESSION['ogloszenie']['firma'] = $_POST['firma'];

if(isset($_POST['stanowisko']))
$_SESSION['ogloszenie']['stanowisko'] = $_POST['stanowisko'];

if(isset($_POST['etat']))
$_SESSION['ogloszenie']['etat'] = $_POST['etat'];

if(isset($_POST['rodzajPracy']))
$_SESSION['ogloszenie']['rodzajPracy'] = $_POST['rodzajPracy'];

if(isset($_POST['umowa']))
$_SESSION['ogloszenie']['umowa'] = $_POST['umowa'];

if(isset($_POST['najm_wynagrodzenie']))
$_SESSION['ogloszenie']['najm_wynagrodzenie'] = $_POST['najm_wynagrodzenie'];  

if(isset($_POST['najw_wynagrodzenie']))
$_SESSION['ogloszenie']['najw_wynagrodzenie'] = $_POST['najw_wynagrodzenie'];

if(isset($_POST['dni_pracy']))
$_SESSION['ogloszenie']['dni_pracy'] = $_POST['dni_pracy'];

if(isset($_POST['godziny_pracy']))
$_SESSION['ogloszenie']['godziny_pracy'] = $_POST['godziny_pracy'];

if(isset($_POST['data_waznosci']))
$_SESSION['ogloszenie']['data_waznosci'] = $_POST['data_waznosci'];


if($adresPoprzedni != $adresObecny)
{
    $_SESSION['benefity'] = [];
    $_SESSION['wymagania'] = [];
    $_SESSION['obowiazki'] = [];
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
  <body class="d-flex flex-column min-vh-100">    
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
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="KategorieAdm.php">Kategorie</a>
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
        <div class="col-12 col-xl-10 min-vh-100">
            <div class="d-flex flex-wrap">
                <h1 class="text-center mx-auto">Dodawanie ogłoszenia</h1>
                <a href="Profil.php" active class="mx-auto btn btn-dark UlubionyKolor text-light rounded-5 sm-ms-5 my-2 text-center DodajAdmin" role="button">Dodaj kategorie</a>
            </div>     
            
            <form id="main-form"  method="post" enctype="multipart/form-data"></form>
            <form id="sub-form"  method="post"></form>

            <div class="mt-4 row UlubionyKolor rounded-5 text-light">
                <div class="row col-12">
                    <label for="nazwa_ogloszenia" class="col-md-2 col-12">Nazwa ogłoszenia:</label>
                    <input type="text" id="nazwa_ogloszenia" value="
                    <?php
                    if(isset($_SESSION['ogloszenie']['nazwa_ogloszenia']))
                        echo $_SESSION['ogloszenie']['nazwa_ogloszenia'];
                    ?>
                    " class="col-12 col-md-10" name="nazwa_ogloszenia" form="main-form" required>
                </div>                
                
                <div class="row col-12">
                    <label for="lokalizacja" class="col-md-2 col-12">Lokalizacja:</label>
                    <input type="text" id="lokalizacja" value="
                    <?php
                    if(isset($_SESSION['ogloszenie']['lokalizacja']))
                        echo $_SESSION['ogloszenie']['lokalizacja'];
                    ?>" class="col-12 col-md-10" name="lokalizacja" form="main-form" required>
                </div>              
                
                <div class="row col-12">
                    <label for="kategoria" class="col-md-2 col-12">Kategoria:</label>
                    <select name="kategoria[]" class="col-12 col-md-10" multiple size="3" required form="main-form">                    
                        <?php while($rowKategoria = $wynikKategorie->fetch_assoc())
                        {
                            echo '<option value="'.$rowKategoria["kategoria_id"].'" '.($_SESSION['ogloszenie']['kategoria[]']==$rowKategoria["kategoria_id"]?" selected":"").'>'.$rowKategoria["nazwa_kategorii"].'</option>';
                        }                            
                        ?>
                    </select>
                </div>
                
                <div class="row col-12">
                    <label for="firma" class="col-md-2 col-12">Firma:</label>
                    <select name="firma" class="col-12 col-md-10" required form="main-form">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowFirma = $wynikFirmy->fetch_assoc())
                        {
                            echo '<option value="'.$rowFirma["firma_id"].'" '.($_SESSION['ogloszenie']['firma']==$rowFirma["firma_id"]?" selected":"").'>'.$rowFirma["nazwa_firmy"].'</option>';
                        }                            
                        ?>
                    </select>
                </div>
                                    
                <div class="row col-12">
                    <label for="stanowisko" class="col-md-2 col-12">Stanowisko:</label>
                    <select name="stanowisko" class="col-12 col-md-10" required form="main-form">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowStanowisko = $wynikStanowiska->fetch_assoc())
                        {
                            echo '<option value="'.$rowStanowisko["stanowisko_id"].'" '.($_SESSION['ogloszenie']['stanowisko']==$rowStanowisko["stanowisko_id"]?" selected":"").'>'.$rowStanowisko["nazwa_stanowiska"].'</option>';
                        }                            
                        ?>
                    </select>
                </div>

                <div class="row col-12">
                    <label for="etat" class="col-md-2 col-12">Wymiar zatrudnienia:</label>
                    <select name="etat" required class="col-12 col-md-10" form="main-form">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowEtat = $wynikEtaty->fetch_assoc())
                        {
                            echo '<option value="'.$rowEtat["etat_id"].'" '.($_SESSION['ogloszenie']['etat']==$rowEtat["etat_id"]?" selected":"").'>'.$rowEtat["wymiar_etatu"].'</option>';
                        }                            
                        ?>
                    </select>
                </div>

                <div class="row col-12">
                    <label for="rodzajPracy" class="col-md-2 col-12">Rodzaj pracy:</label>
                    <select name="rodzajPracy" class="col-12 col-md-10" required form="main-form">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowRodzajPracy = $wynikRodzajePracy->fetch_assoc())
                        {
                            echo '<option value="'.$rowRodzajPracy["rodzaj_pracy_id"].'" '.($_SESSION['ogloszenie']['rodzajPracy']==$rowRodzajPracy["rodzaj_pracy_id"]?" selected":"").'>'.$rowRodzajPracy["rodzaj_pracy"].'</option>';
                        }                            
                        ?>
                    </select>
                </div>

                <div class="row col-12">
                    <label for="umowa" class="col-md-2 col-12">Rodzaj umowy:</label>
                    <select name="umowa" class="col-12 col-md-10" required form="main-form">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php
                            while($rowUmowa = $wynikUmowy->fetch_assoc())
                            {
                                echo '<option value="'.$rowUmowa["umowa_id"].'" '.($_SESSION['ogloszenie']['umowa']==$rowUmowa["umowa_id"]?" selected":"").'>'.$rowUmowa["rodzaj_umowy"].'</option>';
                            }                            
                        ?>
                    </select>
                </div>


                <div class="row col-12">
                    <label for="najm_wynagrodzenie" class="col-md-2 col-12">Najniższe wynagrodzenie:</label>
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10" value="
                    <?php
                        if(isset($_SESSION['ogloszenie']['najm_wynagrodzenie']))
                        echo $_SESSION['ogloszenie']['najm_wynagrodzenie'];
                    ?>" name="najm_wynagrodzenie" form="main-form" required>
                </div>                
                
                <div class="row col-12">
                    <label for="najw_wynagrodzenie" class="col-md-2 col-12">Najwyższe wynagrodzenie:</label>
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10" value="
                    <?php
                        if(isset($_SESSION['ogloszenie']['najw_wynagrodzenie']))
                        echo $_SESSION['ogloszenie']['najw_wynagrodzenie'];
                    ?>" name="najw_wynagrodzenie" form="main-form" required>
                </div>                                
                
                <div class="row col-12">
                    <label for="dni_pracy" class="col-md-2 col-12">Dni pracy:</label>                
                    <textarea value="<?php
                        if(isset($_SESSION['ogloszenie']['dni_pracy']))
                        echo $_SESSION['ogloszenie']['dni_pracy'];
                    ?>" name="dni_pracy" cols="30" form="main-form" rows="5"></textarea>
                </div>                
                
                <div class="row col-12">
                    <label for="godziny_pracy" class="col-md-2 col-12">Godziny pracy:</label>
                    <input type="number" class="col-12 col-md-10"  form="main-form" value="<?php
                        if(isset($_SESSION['ogloszenie']['godziny_pracy']))
                        echo $_SESSION['ogloszenie']['godziny_pracy'];
                    ?>" name="godziny_pracy">
                </div>                
                
                <div class="row col-12">
                    <label for="data_waznosci" class="col-md-2 col-12">Data ważności:</label>
                    <input type="date" class="col-12 col-md-10" value="
                    <?php
                        if(isset($_SESSION['ogloszenie']['data_waznosci']))
                        echo $_SESSION['ogloszenie']['data_waznosci'];
                    ?>" name="data_waznosci" form="main-form" required>
                </div>                
                
                <div class="row col-12">
                    <label for="zdjecie" class="col-md-2 col-12">Zdjęcie:</label>
                    <input type="file" class="col-12 col-md-10" name="zdjecie" form="main-form">
                </div>                

                <div class="row col-12">                    
                    <label for="obowiazek" class="col-md-2 col-12">Obowiązek:</label>
                    <div class="col-12 col-md-10">
                        <input type="text" name="obowiazek" form="sub-form">
                        <input type="submit" name="Dodaj_obowiazek" value="Dodaj obowiązek" form="sub-form">
                    </div>                                                      
                </div>

                <div class="row col-12 FormScroll" name="obowiazki">
                    <?php foreach ($_SESSION['obowiazki'] as $obowiazek) {
                        echo "<div>$obowiazek</div>";
                    } ?>
                </div>

                <div class="row col-12">                
                    <label for="obowiazek" class="col-md-2 col-12">Wymaganie:</label>
                    <div class="col-12 col-md-10">
                        <input type="text" name="wymaganie" form="sub-form">
                        <input type="submit" name="Dodaj_wymaganie" value="Dodaj wymaganie" form="sub-form">                   
                    </div>
                </div>

                <div class="row col-12 FormScroll" name="wymagania">
                    <?php foreach ($_SESSION['wymagania'] as $wymaganie) {
                        echo "<div>$wymaganie</div>";
                    } ?>
                </div>

                <div class="row col-12">                 
                    <label for="benefit" class="col-md-2 col-12">Benefit:</label>
                    <div class="col-12 col-md-10">
                        <input type="text" name="benefit" form="sub-form">
                        <input type="submit" name="Dodaj_benefit" value="Dodaj benefit" form="sub-form">       
                    </div>                                 
                </div>

                <div class="row col-12 FormScroll" name="benefity">
                    <?php foreach ($_SESSION['benefity'] as $benefit) {
                        echo "<div>$benefit</div>";
                    } ?>
                </div>
                
                <input type="submit" name="Dodaj_oglo" class="col-md-2 col-12" value="Dodaj ogłoszenie" form="main-form">
            </div>                                             
        </div>
    </div>
                                 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  <?php  
    $polaczenie->close();
  ?>
</html>