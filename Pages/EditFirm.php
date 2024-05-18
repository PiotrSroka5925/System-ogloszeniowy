<?php

session_start();
if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']!=true))
{
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_POST['ukrytyeditFirm'])) 
{
    $idukryte = $_POST['ukrytyeditFirm'];
} 
else 
{
    if (isset($_GET['id']))
    {
        $idukryte = $_GET['id'];
    } 
    else
    {
        $idukryte = "";
    }
}

if ($idukryte != null) {
    $resultFirmaEdit = $polaczenie->execute_query("SELECT * FROM firmy WHERE firma_id = ?", [$idukryte]);
    $firma = $resultFirmaEdit->fetch_assoc();
} else {
    $_SESSION['komunikatId'] = "Brak identyfikatora kategorii.";
}


$wszystkoOk= true;

$nazwa_firmy="";
$informacje_firmy= "";


if (isset($_POST['Edytuj_firm']) && $idukryte!= null) 
{
    if (isset($_POST['nazwa_firmy'])) {
        $nazwa_firmy = $_POST['nazwa_firmy'];  
        $_SESSION['nazwa_firmy'] = $_POST['nazwa_firmy'];
    }
    
    if (isset($_POST['informacje_firmy'])) {
        $informacje_firmy = $_POST['informacje_firmy'];  
        $_SESSION['informacje_firmy'] = $_POST['informacje_firmy'];
    }

    $result = $polaczenie->execute_query("SELECT firma_id FROM firmy WHERE nazwa_firmy = ? AND firma_id != ?",[$nazwa_firmy, $idukryte]);

    if(strlen($nazwa_firmy) == 0) 
    {
        $wszystkoOk = false;
        $_SESSION['komunikatNazw'] = "Podaj nazwę firmy!";
    } 
    else
    {
        if(strlen($informacje_firmy) == 0) 
        {
            $wszystkoOk = false;
            $_SESSION['komunikatNazw'] = "Podaj informację o firmie!";
        }        

        if (strlen($nazwa_firmy) > 90) 
        {
            $wszystkoOk = false;
            $_SESSION['komunikatNazw'] = "Przekroczono limit znaków!";   
        }

        if($result->num_rows > 0) 
        {
            $wszystkoOk = false;
            $_SESSION['komunikatNazw'] = "Firma o tej nazwie już istnieje!";
        }

        if(strlen($informacje_firmy) > 255)
        {
            $wszystkoOk = false;
            $_SESSION['komunikatInfo'] = "Przekroczono limit znaków!";
        }
    }                  
    
    if($wszystkoOk == true)
    {                       
        unset($_SESSION['nazwa_firmy'], $_SESSION['informacje_firmy']);

        $polaczenie->query("UPDATE firmy SET nazwa_firmy = '{$nazwa_firmy}', informacje = '{$informacje_firmy}' WHERE firma_id = '{$idukryte}'");        
        header("Location: EditFirm.php?id={$idukryte}");
        exit();
    }
}



$FirmyNaStrone = 15;
$aktualnaStrona = isset($_GET['strona']) ? $_GET['strona'] : 1;
$start = ($aktualnaStrona - 1) * $FirmyNaStrone;

$zapytanie = "SELECT COUNT(*) AS ile FROM firmy";
$wynik = $polaczenie->query($zapytanie);
$r = $wynik->fetch_assoc();
$wszystkieFirmy = $r['ile'];
$strony = ceil($wszystkieFirmy / $FirmyNaStrone);

$zapytanie = "SELECT * FROM firmy
LIMIT $start, $FirmyNaStrone";
$wynik = $polaczenie->query($zapytanie);

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
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="UzytkownicyAdm.php">Użytkownicy</a>
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
                    <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="UzytkownicyAdm.php">Użytkownicy</a>
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
                <h1 class="text-center mx-auto">Edycja firmy</h1>            
            </div>            

            <form  method="post" class="mt-4 p-3 w-100 UlubionyKolor rounded-5 text-light">
            <input type="hidden" name="ukrytyeditFirm" value="<?php echo $idukryte ?>">
                <div class="p-3">
                    <label for="nazwa_firmy" class="mb-2">Nazwa firmy:</label>
                    <input type="text" class="w-100 LogowanieInput border-0 rounded-3 mb-2" name="nazwa_firmy" value="<?php                   
                        echo  $firma['nazwa_firmy'];                        
                     ?>" id="nazwa_firmy" required>
                    <?php
                        if(isset($_SESSION['komunikatNazw']))
                        echo '<p class="text-danger">' . $_SESSION['komunikatNazw'] . '</p>';
                        unset($_SESSION['komunikatNazw']);
                    ?>
                    <label for="informcje_firmy" class="mb-2">Informacje o firmie:</label>
                    <textarea name="informacje_firmy" class="w-100 LogowanieInput border-0 rounded-3" cols="30" required rows="5" id="informcje_firmy"><?php
                         echo  $firma['informacje'];
                    ?></textarea>          
                    <?php
                        if(isset($_SESSION['komunikatInfo']))
                        echo '<p class="text-danger">' . $_SESSION['komunikatInfo'] . '</p>';
                        unset($_SESSION['komunikatInfo'])
                    ?>          
                </div>                
                                                
                <input type="submit" name="Edytuj_firm" class="PrzyciskDodawania m-3 btn UlubionyKolor btn-secondary text-light rounded-5 sm-ms-5 my-2"  value="Edytuj Firmę"> 
                
                <?php
                    if(isset($_SESSION['komunikatId']))
                    echo '<p class="text-danger">' . $_SESSION['komunikatId'] . '</p>';
                    unset($_SESSION['komunikatId']);
                ?>
            </form> 
                 
                  
        </div>
    </div>
                                 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  <?php  
    $polaczenie->close();
  ?>
</html>