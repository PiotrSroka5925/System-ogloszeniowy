<?php

session_start();


if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']!=true))
{
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$edytowanie = isset($_GET['id'])?true:false;

$wynikStanowiska = $polaczenie->query("SELECT stanowisko_id, nazwa_stanowiska FROM ogloszenie_stanowiska");

$wynikEtaty = $polaczenie->query("SELECT etat_id, wymiar_etatu FROM ogloszenie_etaty");

$wynikRodzajePracy = $polaczenie->query("SELECT rodzaj_pracy_id, rodzaj_pracy FROM ogloszenie_rodzaje_pracy");

$wynikUmowy = $polaczenie->query("SELECT umowa_id, rodzaj_umowy FROM ogloszenie_umowy");

$wynikKategorie = $polaczenie->query("SELECT kategoria_id, nazwa_kategorii FROM kategorie");

$wynikFirmy = $polaczenie->query("SELECT firma_id, nazwa_firmy FROM firmy");


$katalog = "../Images/Companies/";

function ImgUpload($katalog)
{
    if(isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === 0){
        $SciezkaPliku = $katalog . basename($_FILES['zdjecie']['name']);

        $SciezkaPliku = str_replace(' ','',$SciezkaPliku);
        $Rozszerzenia = array('jpg', 'png', 'jpeg', 'gif');

        $RozszerzenieZdjecia =pathinfo($_FILES['zdjecie']['name'], PATHINFO_EXTENSION);
        $RozszerzenieZdjecia = strtolower($RozszerzenieZdjecia);

        if(in_array($RozszerzenieZdjecia, $Rozszerzenia))
        {
            if($_FILES['zdjecie']['size'] > 5*1024*1024)
            {
                return NULL;
            }
            if(move_uploaded_file($_FILES['zdjecie']['tmp_name'], $SciezkaPliku))
            return $SciezkaPliku;                
        }
        else
        {
            return NULL;
        }            
    }
    return NULL;
}

$zdjecieDodanie = ImgUpload($katalog);

$ok = true;

if(isset($_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['kategoria'], $_POST['firma'], $_POST['stanowisko'],
$_POST['etat'], $_POST['rodzajPracy'], $_POST['umowa'], $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'],
$_POST['godziny_pracy'], $_POST['data_waznosci'], $_POST['poziom_stanowiska']))
{
    $dataWaznosci = $_POST['data_waznosci'];
    $dzisiejszaData = date('Y-m-d');

    if ($dataWaznosci <= $dzisiejszaData) {
        $ok = false;
        $_SESSION['dataBlad'] = "Data ważności nie może być wcześniejsza lub równa dzisiejszej dacie!";
    }    
    elseif($_POST['najmn_wynagrodzenie']>$_POST['najw_wynagrodzenie'])
    {
        $ok = false;
        $_SESSION['wynagrodzenieBlad'] = "Najmniejsze wynagrodzenie jest większe niż największe!";
    }
    elseif(strlen($_POST['dni_pracy'])>70)
    {
        $ok = false;
        $_SESSION['dniPracyBlad'] = "Przekroczono limit 70 znaków!";
    }
    else
    {
        if(!isset($_POST['obowiazki']))    
        {
            $ok = false;
            $_SESSION['obowiazekBlad'] = "Dodaj obowiązek!";
        }
        else
        $_SESSION['obowiazki'] = $_POST['obowiazki'];

        if(!isset($_POST['wymagania']))    
        {
            $ok = false;
            $_SESSION['wymaganieBlad'] = "Dodaj wymaganie!";
        }
        else
        $_SESSION['wymagania'] = $_POST['wymagania'];

        if(!isset($_POST['benefity']))    
        {
            $ok = false;
            $_SESSION['benefitBlad'] = "Dodaj benefit!";
        }
        else
        $_SESSION['benefity'] = $_POST['benefity'];
    }
    
    $_SESSION['kategoria'] = $_POST['kategoria'];
    $_SESSION['nazwa_ogloszenia'] = $_POST['nazwa_ogloszenia'];
    $_SESSION['lokalizacja'] = $_POST['lokalizacja'];
    $_SESSION['firma'] = $_POST['firma'];
    $_SESSION['stanowisko'] = $_POST['stanowisko'];
    $_SESSION['umowa'] = $_POST['umowa'];
    $_SESSION['etat'] = $_POST['etat'];
    $_SESSION['rodzajPracy'] = $_POST['rodzajPracy'];
    $_SESSION['najmn_wynagrodzenie'] = $_POST['najmn_wynagrodzenie'];
    $_SESSION['najw_wynagrodzenie'] = $_POST['najw_wynagrodzenie'];
    $_SESSION['dni_pracy'] = $_POST['dni_pracy'];
    $_SESSION['godziny_pracy'] = $_POST['godziny_pracy'];
    $_SESSION['data_waznosci'] = $_POST['data_waznosci'];
    $_SESSION['poziom_stanowiska'] = $_POST['poziom_stanowiska'];
    $_SESSION['obowiazki'] = $_POST['obowiazki'];
    $_SESSION['wymagania'] = $_POST['wymagania'];
    $_SESSION['benefity'] = $_POST['benefity'];


    if($ok)
    {        
        unset($_SESSION['nazwa_ogloszenia'], $_SESSION['lokalizacja'], $_SESSION['kategoria'], $_SESSION['firma'], $_SESSION['stanowisko'],$_SESSION['umowa'],$_SESSION['etat'],$_SESSION['rodzajPracy'],
        $_SESSION['najmn_wynagrodzenie'], $_SESSION['najw_wynagrodzenie'], $_SESSION['dni_pracy'], $_SESSION['godziny_pracy'], $_SESSION['data_waznosci'], $_SESSION['obowiazki'], $_SESSION['wymagania'], $_SESSION['benefity'], $_SESSION['poziom_stanowiska']);

       if($edytowanie) 
       {
            $wynik= $polaczenie->execute_query("UPDATE ogloszenia SET nazwa_ogloszenia = ?, lokalizacja = ?, firma_id = ?, stanowisko_id = ?,umowa_id = ?, 
            etat_id = ? ,rodzaj_pracy_id = ? ,najmn_wynagrodzenie = ?, najw_wynagrodzenie = ?, dni_pracy = ?, godziny_pracy = ?, data_waznosci = ?, zdjecie = ?, poziom_stanowiska = ? WHERE ogloszenie_id = ?"
            , [$_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['firma'], $_POST['stanowisko'], $_POST['umowa'], $_POST['etat'], $_POST['rodzajPracy'], 
            $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'], $_POST['godziny_pracy'], $_POST['data_waznosci'], $zdjecieDodanie, $_POST['poziom_stanowiska'], $_GET['id']]);

            $zlapId = $_GET['id'];
            
            $wynik = $polaczenie->execute_query("DELETE FROM ogloszenie_kategorie WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['kategoria'] as $k)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_kategorie VALUES(NULL, ?, ?)", [$zlapId, $k]);
            }  

            $wynik = $polaczenie->execute_query("DELETE FROM ogloszenie_obowiazki WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['obowiazki'] as $ob)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_obowiazki VALUES(NULL, ?, ?)", [$ob, $zlapId]);
            }

            $wynik = $polaczenie->execute_query("DELETE FROM ogloszenie_wymagania WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['wymagania'] as $wym)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_wymagania VALUES(NULL, ?, ?)", [$wym, $zlapId]);
            }

            $wynik = $polaczenie->execute_query("DELETE FROM ogloszenie_benefity WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['benefity'] as $benef)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_benefity VALUES(NULL, ?, ?)", [$benef, $zlapId]);
            }
            
       }
       else
       {
            $wynik= $polaczenie->execute_query("INSERT INTO ogloszenia (ogloszenie_id, nazwa_ogloszenia, lokalizacja, firma_id, stanowisko_id ,umowa_id, 
            etat_id ,rodzaj_pracy_id ,najmn_wynagrodzenie, najw_wynagrodzenie, dni_pracy, godziny_pracy, data_waznosci, data_utworzenia, zdjecie, poziom_stanowiska) VALUES (NULL, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ?, ?, ?)"
            , [$_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['firma'], $_POST['stanowisko'], $_POST['umowa'], $_POST['etat'], $_POST['rodzajPracy'], 
            $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'], $_POST['godziny_pracy'], $_POST['data_waznosci'], date("Y-m-d"), $zdjecieDodanie, $_POST['poziom_stanowiska']]);

            $zlapId = $polaczenie->insert_id;
                
            foreach($_POST['kategoria'] as $k)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_kategorie VALUES(NULL, ?, ?)", [$zlapId, $k]);
            }  
            
            foreach($_POST['obowiazki'] as $ob)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_obowiazki VALUES(NULL, ?, ?)", [$ob, $zlapId]);
            }

            foreach($_POST['wymagania'] as $wym)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_wymagania VALUES(NULL, ?, ?)", [$wym, $zlapId]);
            }

            foreach($_POST['benefity'] as $benef)
            {        
                $wynik = $polaczenie->execute_query("INSERT INTO ogloszenie_benefity VALUES(NULL, ?, ?)", [$benef, $zlapId]);
            }
       }       
    }    
        
}
else
{
    unset($_SESSION['obowiazki'], $_SESSION['wymagania'], $_SESSION['benefity']);
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
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
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
                            <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
                            <a href="Ulubione.php" active class="btn UlubionyKolor border-1 mt-3 border-white rounded-4 col-12 text-light" role="button">Ulubione</a>
                            <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white text-light rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                        </form>
                    </li>';
                ?>
            </ul>
        </div>
        <div class="col-12 col-xl-10 min-vh-100">
            <div class="d-flex flex-wrap">
                <?php                    
                    if($edytowanie)
                    {
                        echo '<h1 class="text-center mx-auto">Edytowanie ogłoszenia</h1>';
                    }
                    else
                    {
                        echo '<h1 class="text-center mx-auto">Dodawanie ogłoszenia</h1>';
                    }
                ?>                      
            </div>     
            
              <?php
              if($edytowanie)
              {
                $wynik = $polaczenie-> execute_query("SELECT * FROM ogloszenia WHERE ogloszenie_id = ?", [$_GET['id']]);
                $ogloEdit = $wynik->fetch_assoc();
              }
              ?>
            <form class="m-1 p-2 UlubionyKolor rounded-5 text-light col-12" method="post" enctype="multipart/form-data">
                <div class="m-1">
                    <label for="nazwa_ogloszenia">Nazwa ogłoszenia:</label>
                    <input type="text" id="nazwa_ogloszenia" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="nazwa_ogloszenia" name="nazwa_ogloszenia" required value="<?php                    
                    if(isset($_SESSION['nazwa_ogloszenia']))
                    {
                        echo $_SESSION['nazwa_ogloszenia'];
                        unset($_SESSION['nazwa_ogloszenia']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['nazwa_ogloszenia'];                    
                    }?>">
                </div>                
                
                <div class="m-1">
                    <label for="lokalizacja">Lokalizacja:</label>
                    <input type="text" id="lokalizacja" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="lokalizacja" name="lokalizacja" required value="<?php                    
                    if(isset($_SESSION['lokalizacja']))
                    {
                        echo $_SESSION['lokalizacja'];
                        unset($_SESSION['lokalizacja']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['lokalizacja'];                    
                    }?>">
                </div>              

                <div class="m-1">
                    <label for="poziom_stanowiska">Poziom stanowiska:</label>
                    <input type="text" id="poziom_stanowiska" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="poziom_stanowiska" name="poziom_stanowiska" required value="<?php                    
                    if(isset($_SESSION['poziom_stanowiska']))
                    {
                        echo $_SESSION['poziom_stanowiska'];
                        unset($_SESSION['poziom_stanowiska']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['poziom_stanowiska'];                    
                    }?>">
                </div>   
                
                <div class="m-1">
                    <label for="kategoria">Kategoria:</label>
                    <?php
                        $id_kategoriiTab = [];
                        if(isset($_SESSION['kategoria']))
                        {                            
                            foreach($_SESSION['kategoria'] as $kategorie)
                            {
                                array_push( $id_kategoriiTab,$kategorie);
                            }                           
                        }
                        elseif($edytowanie)
                        {
                            $wynikKat = $polaczenie-> execute_query("SELECT * FROM ogloszenie_kategorie WHERE ogloszenie_id = ?", [$_GET['id']]);                            
                            while($katEdit = $wynikKat->fetch_assoc())
                            {
                                array_push( $id_kategoriiTab,$katEdit['kategoria_id']);
                            }  
                        }
                    ?>
                    <select name="kategoria[]" class="col-12 col-md-10 w-100 LogowanieInput border-0 rounded-3" multiple size="3" id="kategoria" required>                    
                        <?php while($wierszKategoria = $wynikKategorie->fetch_assoc())
                        {
                            echo '<option value="'.$wierszKategoria["kategoria_id"].'" '.(in_array($wierszKategoria["kategoria_id"],$id_kategoriiTab)?" selected":"").'>'.$wierszKategoria["nazwa_kategorii"].'</option>';
                        } 
                        if(isset($_SESSION['kategoria']))                           
                        unset($_SESSION['kategoria']);
                        ?>
                    </select>
                </div>
                
                <div class="m-1">
                    <label for="firma">Firma:</label>
                    <select name="firma" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="firma" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($wierszFirma = $wynikFirmy->fetch_assoc())
                        {
                            echo '<option value="'.$wierszFirma["firma_id"].'" '.($_SESSION['firma']==$wierszFirma["firma_id"]?" selected":($edytowanie && $ogloEdit["firma_id"] == $wierszFirma['firma_id']?" selected":"")).'>'.$wierszFirma["nazwa_firmy"].'</option>';
                        }                            
                        if(isset($_SESSION['firma']))                           
                        unset($_SESSION['firma']);
                        ?>
                    </select>
                </div>
                                    
                <div class="m-1">
                    <label for="stanowisko" >Stanowisko:</label>
                    <select name="stanowisko" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="stanowisko" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($wierszStanowisko = $wynikStanowiska->fetch_assoc())
                        {
                            echo '<option value="'.$wierszStanowisko["stanowisko_id"].'" '.($_SESSION['stanowisko']==$wierszStanowisko["stanowisko_id"]?" selected":($edytowanie && $ogloEdit["stanowisko_id"] == $wierszStanowisko['stanowisko_id']?" selected":"")).'>'.$wierszStanowisko["nazwa_stanowiska"].'</option>';
                        }     
                        if(isset($_SESSION['stanowisko']))                           
                        unset($_SESSION['stanowisko']);                       
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="etat">Wymiar zatrudnienia:</label>
                    <select name="etat" required class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="etat">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($wierszEtat = $wynikEtaty->fetch_assoc())
                        {
                            echo '<option value="'.$wierszEtat["etat_id"].'" '.($_SESSION['etat']==$wierszEtat["etat_id"]?" selected":($edytowanie && $ogloEdit["etat_id"] == $wierszEtat['etat_id']?" selected":"")).'>'.$wierszEtat["wymiar_etatu"].'</option>';
                        } 
                        if(isset($_SESSION['etat']))                           
                        unset($_SESSION['etat']);                           
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="rodzajPracy">Rodzaj pracy:</label>
                    <select name="rodzajPracy" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="rodzajPracy" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($wierszRodzajPracy = $wynikRodzajePracy->fetch_assoc())
                        {
                            echo '<option value="'.$wierszRodzajPracy["rodzaj_pracy_id"].'" '.($_SESSION['rodzajPracy']==$wierszRodzajPracy["rodzaj_pracy_id"]?" selected":($edytowanie && $ogloEdit["rodzaj_pracy_id"] == $wierszRodzajPracy['rodzaj_pracy_id']?" selected":"")).'>'.$wierszRodzajPracy["rodzaj_pracy"].'</option>';
                        }        
                        if(isset($_SESSION['rodzajPracy']))                           
                        unset($_SESSION['rodzajPracy']);                    
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="umowa">Rodzaj umowy:</label>
                    <select name="umowa" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="umowa" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php
                            while($wierszUmowa = $wynikUmowy->fetch_assoc())
                            {
                                echo '<option value="'.$wierszUmowa["umowa_id"].'" '.($_SESSION['umowa']==$wierszUmowa["umowa_id"]?" selected":($edytowanie && $ogloEdit["umowa_id"] == $wierszUmowa['umowa_id']?" selected":"")).'>'.$wierszUmowa["rodzaj_umowy"].'</option>';
                            }    
                            if(isset($_SESSION['umowa']))                           
                            unset($_SESSION['umowa']);                        
                        ?>
                    </select>
                </div>


                <div class="m-1">
                    <label for="najmn_wynagrodzenie">Najniższe wynagrodzenie:</label>
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="najmn_wynagrodzenie" name="najmn_wynagrodzenie" value="<?php                    
                    if(isset($_SESSION['najmn_wynagrodzenie']))
                    {
                        echo  $_SESSION['najmn_wynagrodzenie'];
                        unset($_SESSION['najmn_wynagrodzenie']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['najmn_wynagrodzenie'];                    
                    }?>" required>
                </div>                
                
                <div class="m-1">
                    <label for="najw_wynagrodzenie">Najwyższe wynagrodzenie:</label>
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="najw_wynagrodzenie" name="najw_wynagrodzenie" value="<?php                    
                    if(isset( $_SESSION['najw_wynagrodzenie']))
                    {
                        echo  $_SESSION['najw_wynagrodzenie'];
                        unset($_SESSION['najw_wynagrodzenie']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['najw_wynagrodzenie'];                    
                    }?>" required>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['wynagrodzenieBlad']))
                    {
                        echo $_SESSION['wynagrodzenieBlad'];
                        unset($_SESSION['wynagrodzenieBlad']);
                    }                
                    ?></p>
                </div>                                
                
                <div class="m-1">
                    <label for="dni_pracy">Dni pracy:</label>                
                    <textarea name="dni_pracy" class="w-100 bg-light border-0 rounded-3 LogowanieInput"  id="dni_pracy" cols="30" max="70" required rows="5"><?php                    
                    if(isset( $_SESSION['dni_pracy']))
                    {
                        echo  $_SESSION['dni_pracy'];
                        unset($_SESSION['dni_pracy']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['dni_pracy'];                    
                    }?></textarea>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['dniPracyBlad']))
                    {
                        echo $_SESSION['dniPracyBlad'];
                        unset($_SESSION['dniPracyBlad']);
                    }                
                    ?></p>
                </div>                
                
                <div class="m-1">
                    <label for="godziny_pracy">Godziny pracy:</label>
                    <input type="number" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="godziny_pracy" max="24" min="1" value="<?php                    
                    if(isset( $_SESSION['godziny_pracy']))
                    {
                        echo  $_SESSION['godziny_pracy'];
                        unset($_SESSION['godziny_pracy']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['godziny_pracy'];                    
                    }?>" required name="godziny_pracy">
                </div>                
                
                <div class="m-1">
                    <label for="data_waznosci">Data ważności:</label>
                    <input type="date" class="col-12 col-md-10 w-100 bg-light LogowanieInput border-0 rounded-3" id="data_waznosci" value="<?php                    
                    if(isset( $_SESSION['data_waznosci']))
                    {
                        echo  $_SESSION['data_waznosci'];
                        unset($_SESSION['data_waznosci']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['data_waznosci'];                    
                    }?>" name="data_waznosci" required>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['dataBlad']))
                    {
                        echo $_SESSION['dataBlad'];
                        unset($_SESSION['dataBlad']);
                    }                
                    ?></p>
                </div>                
                
                <div class="m-1 w-100">
                    <label class="mt-2 position-relative">Zdjęcie:
                        <div class="btn UlubionyKolor btn-light text-light rounded-5 w-100 my-2">Wybierz zdjęcie</div>
                        <p id="ZdjecieText" class="text-break"></p>
                        <input type="file" required id="zdjecie" class="col-12 col-md-10" style="opacity: 0; position: absolute; z-index:-1" name="zdjecie">
                    </label>                   
                </div>                
        

                <div class="p-2">                    
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Obowiązki</h2>
                        <button type="button" id="DodajObowiazek" class="SzczegolyIconAdm bg-transparent border-0 rounded-3 ms-4 p-1 dlt-btn">
                            <img src="../Images/Icons/dodawanie.png" class="SzczegolyIconAdm" alt="">
                        </button>
                    </div>                                        
                    <div id="PoleObowiazki" class="FormScroll">

                    </div>  
                    <p class="text-danger"><?php
                    if(isset($_SESSION['obowiazekBlad']))
                    {
                        echo $_SESSION['obowiazekBlad'];
                        unset($_SESSION['obowiazekBlad']);
                    }
                    ?></p>
                </div>
                
                <div class="p-2">
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Wymagania</h2>
                        <button type="button" id="DodajWymaganie" class="SzczegolyIconAdm rounded-3 bg-transparent border-0 ms-4 p-1 dlt-btn">
                        <img src="../Images/Icons/dodawanie.png" class="SzczegolyIconAdm" alt="">
                        </button>
                    </div>                
                    <div id="PoleWymagania" class="FormScroll">

                    </div>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['wymaganieBlad']))
                    {
                        echo $_SESSION['wymaganieBlad'];
                        unset($_SESSION['wymaganieBlad']);
                    }
                    ?></p>
                </div>
            
                <div class="p-2">
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Benefity</h2>
                        <button type="button" id="DodajBenefit" class="SzczegolyIconAdm bg-transparent border-0 rounded-3 ms-4 p-1 dlt-btn">
                        <img src="../Images/Icons/dodawanie.png" class="SzczegolyIconAdm" alt="">
                        </button>
                    </div>
                    <div id="PoleBenefity" class="FormScroll">

                    </div>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['benefitBlad']))
                    {
                        echo $_SESSION['benefitBlad'];
                        unset($_SESSION['benefitBlad']);
                    }
                    ?></p>
                </div>
                
                <?php                   
                    if($edytowanie)
                    {
                        echo '<input type="submit" class="PrzyciskDodawani btn UlubionyKolor btn-secondary text-light border-3 rounded-5 px-5 w-100 my-2" value="Edytuj ogłoszenie">';
                    }
                    else
                    {
                        echo '<input type="submit" class="PrzyciskDodawania btn UlubionyKolor btn-secondary text-light border-3 rounded-5 px-5 w-100 my-2" value="Dodaj ogłoszenie">';
                    }
                ?>                
            </form>                                             
        </div>
    </div>
                                 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!--Skrypt dla dynamicznego dodawania i usuwania obowiązków, wymagań, benefitów -->
    <script>       
        function DodajObowiazek(obowiazek)
        {        
            const imgUsun = document.createElement('img');
            imgUsun.src = '../Images/Icons/usun.png';
            imgUsun.alt = 'Usuń';
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'dlt-btn');
            const WyswietlanyObowiazek = document.createElement("div");
            WyswietlanyObowiazek.classList.add('FormOgloDiv');
            const ObowiazekInput = document.createElement("input");
            ObowiazekInput.type="text";
            ObowiazekInput.name="obowiazki[]";
            ObowiazekInput.value= obowiazek;
            ObowiazekInput.classList.add('bg-light', 'LogowanieInput', 'm-0', 'border-0', 'rounded-3', 'FormOgloInput');
            ObowiazekInput.setAttribute("required", "");
            const ObowiazekPrzycisk = document.createElement("button");
            ObowiazekPrzycisk.type = "button";        
            ObowiazekPrzycisk.style.backgroundColor = "transparent";            
            ObowiazekPrzycisk.addEventListener("click",function(){
                this.parentElement.remove();
            });
            const PoleObowiazkow = document.getElementById('PoleObowiazki');
            WyswietlanyObowiazek.appendChild(ObowiazekInput);
            WyswietlanyObowiazek.appendChild(ObowiazekPrzycisk);
            PoleObowiazkow.appendChild(WyswietlanyObowiazek);
            ObowiazekPrzycisk.appendChild(imgUsun);                    
            ObowiazekPrzycisk.style.border = "none";
        }
        document.getElementById('DodajObowiazek').addEventListener("click", ()=>{
            DodajObowiazek("");
        })

        function DodajWymaganie(wymaganie)
        {       
            const imgUsun = document.createElement('img');
            imgUsun.src = '../Images/Icons/usun.png';
            imgUsun.alt = 'Usuń';
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'dlt-btn');     
            const WyswietlaneWymaganie = document.createElement("div");
            const WymaganieInput = document.createElement("input");
            WyswietlaneWymaganie.classList.add('FormOgloDiv');
            WymaganieInput.type="text";
            WymaganieInput.name="wymagania[]";
            WymaganieInput.value= wymaganie;
            WymaganieInput.classList.add('bg-light', 'LogowanieInput', 'm-0', 'border-0', 'rounded-3', 'FormOgloInput');
            WymaganieInput.setAttribute("required", "");
            const WymaganiePrzycisk = document.createElement("button");
            WymaganiePrzycisk.type = "button";            
            WymaganiePrzycisk.style.backgroundColor = "transparent";
            WymaganiePrzycisk.addEventListener("click",function(){
                this.parentElement.remove();
            });
            const PoleWymaganie = document.getElementById('PoleWymagania');
            WyswietlaneWymaganie.appendChild(WymaganieInput);
            WyswietlaneWymaganie.appendChild(WymaganiePrzycisk);
            PoleWymaganie.appendChild(WyswietlaneWymaganie);
            WymaganiePrzycisk.appendChild(imgUsun);                    
            WymaganiePrzycisk.style.border = "none";
        }
        document.getElementById('DodajWymaganie').addEventListener("click", ()=>{
            DodajWymaganie("");
        })

        function DodajBenefit(benefit)
        {            
            const WyswietlanyBenefit = document.createElement("div");
            const BenefitInput = document.createElement("input");
            WyswietlanyBenefit.classList.add('FormOgloDiv');
            BenefitInput.type="text";
            BenefitInput.name="benefity[]";
            BenefitInput.value= benefit;
            BenefitInput.classList.add('bg-light', 'LogowanieInput' , 'm-0', 'border-0', 'rounded-3', 'FormOgloInput');
            BenefitInput.setAttribute("required", "");
            const BenefitPrzycisk = document.createElement("button");
            BenefitPrzycisk.type = "button";
            BenefitPrzycisk.style.backgroundColor = "transparent";
            BenefitPrzycisk.addEventListener("click",function(){
                this.parentElement.remove();
            });
            const PoleBenefity= document.getElementById('PoleBenefity');
            WyswietlanyBenefit.appendChild(BenefitInput);
            WyswietlanyBenefit.appendChild(BenefitPrzycisk);
            PoleBenefity.appendChild(WyswietlanyBenefit);
            const imgUsun = document.createElement('img');
            imgUsun.src = '../Images/Icons/usun.png';
            imgUsun.alt = 'Usuń';
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'dlt-btn');
            BenefitPrzycisk.appendChild(imgUsun);                    
            BenefitPrzycisk.style.border = "none";
        }
        document.getElementById('DodajBenefit').addEventListener("click", ()=>{
            DodajBenefit("");
        })


        document.querySelector("input[type=file]").addEventListener("change", function(){
            if(this.files[0])
            {
                document.getElementById('ZdjecieText').textContent=this.files[0].name;
            }
            else
            {
                document.getElementById('ZdjecieText').textContent="";
            }
        })

    </script>
    <?php
        //Generowanie obowiązków, wymagań, benefitów z bazy danych


        if($edytowanie)
        {
            $wynikObo = $polaczenie->execute_query("SELECT obowiazekText FROM ogloszenie_obowiazki WHERE ogloszenie_id = ?", [$_GET['id']]);

            echo "<script>";
            if($wynikObo->num_rows>0)
            {                
                while($wierszObowiazki = $wynikObo->fetch_assoc())
                {
                    echo "DodajObowiazek('".htmlspecialchars($wierszObowiazki['obowiazekText'])."');";
                }            
            }

            $wynikWym = $polaczenie->execute_query("SELECT wymaganieText FROM ogloszenie_wymagania WHERE ogloszenie_id = ?", [$_GET['id']]);
            if($wynikWym->num_rows>0)
            {                
                while($wierszWymagania = $wynikWym->fetch_assoc())
                {
                    echo "DodajWymaganie('".htmlspecialchars($wierszWymagania['wymaganieText'])."');";
                }            
            }

            $wynikBenef = $polaczenie->execute_query("SELECT benefitText FROM ogloszenie_benefity WHERE ogloszenie_id = ?", [$_GET['id']]);
            if($wynikBenef->num_rows>0)
            {                
                while($wierszBenefity = $wynikBenef->fetch_assoc())
                {
                    echo "DodajBenefit('".htmlspecialchars($wierszBenefity['benefitText'])."');";
                }                
            }
            echo "</script>";
        }
                        
        echo "<script>";
        if(isset($_SESSION['obowiazki']))
        {
            foreach($_SESSION['obowiazki'] as $obowiazek)
            {
                echo "DodajObowiazek('".htmlspecialchars($obowiazek)."');";
            }
        }

        if(isset($_SESSION['wymagania']))
        {
            foreach($_SESSION['wymagania'] as $wymaganie)
            {
                echo "DodajWymaganie('".htmlspecialchars($wymaganie)."');";
            }
        }

        if(isset($_SESSION['benefity']))
        {
            foreach($_SESSION['benefity'] as $benefit)
            {
                echo "DodajBenefit('".htmlspecialchars($benefit)."');";
            }
        }    
        echo "</script>";
        
    ?>
  </body>
  <?php  
    $polaczenie->close();
  ?>
</html>