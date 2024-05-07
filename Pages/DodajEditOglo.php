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


$zdjecie = "../Images/Companies/";

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

$zdjecieDodanie = ImgUpload($zdjecie);

$ok = true;

if(isset($_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['kategoria'], $_POST['firma'], $_POST['stanowisko'],
$_POST['etat'], $_POST['rodzajPracy'], $_POST['umowa'], $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'],
$_POST['godziny_pracy'], $_POST['data_waznosci']))
{
    if($_POST['najmn_wynagrodzenie']>$_POST['najw_wynagrodzenie'])
    {
        $ok = false;
        $_SESSION['wynagrodzenieBlad'] = "Najmniejsze wynagrodzenie jest większe niż największe!";
    }
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


    if($ok)
    {        
        unset($_SESSION['nazwa_ogloszenia'], $_SESSION['lokalizacja'], $_SESSION['kategoria'], $_SESSION['firma'], $_SESSION['stanowisko'],$_SESSION['umowa'],$_SESSION['etat'],$_SESSION['rodzajPracy'],
        $_SESSION['najmn_wynagrodzenie'], $_SESSION['najw_wynagrodzenie'], $_SESSION['dni_pracy'], $_SESSION['godziny_pracy'], $_SESSION['data_waznosci'], $_SESSION['obowiazki'], $_SESSION['wymagania'], $_SESSION['benefity']);

       if($edytowanie) 
       {
            $result= $polaczenie->execute_query("UPDATE ogloszenia SET nazwa_ogloszenia = ?, lokalizacja = ?, firma_id = ?, stanowisko_id = ?,umowa_id = ?, 
            etat_id = ? ,rodzaj_pracy_id = ? ,najmn_wynagrodzenie = ?, najw_wynagrodzenie = ?, dni_pracy = ?, godziny_pracy = ?, data_waznosci = ?, zdjecie = ? WHERE ogloszenie_id = ?"
            , [$_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['firma'], $_POST['stanowisko'], $_POST['umowa'], $_POST['etat'], $_POST['rodzajPracy'], 
            $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'], $_POST['godziny_pracy'], $_POST['data_waznosci'], $zdjecieDodanie, $_GET['id']]);

            $zlapId = $_GET['id'];

            $result = $polaczenie->execute_query("DELETE FROM ogloszenie_kategorie WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['kategoria'] as $k)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_kategorie VALUES(NULL, ?, ?)", [$zlapId, $k]);
            }  

            $result = $polaczenie->execute_query("DELETE FROM ogloszenie_obowiazki WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['obowiazki'] as $ob)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_obowiazki VALUES(NULL, ?, ?)", [$ob, $zlapId]);
            }

            $result = $polaczenie->execute_query("DELETE FROM ogloszenie_wymagania WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['wymagania'] as $wym)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_wymagania VALUES(NULL, ?, ?)", [$wym, $zlapId]);
            }

            $result = $polaczenie->execute_query("DELETE FROM ogloszenie_benefity WHERE ogloszenie_id= ?", [$_GET['id']]);

            foreach($_POST['benefity'] as $benef)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_benefity VALUES(NULL, ?, ?)", [$benef, $zlapId]);
            }
       }
       else
       {
            $result= $polaczenie->execute_query("INSERT INTO ogloszenia (ogloszenie_id, nazwa_ogloszenia, lokalizacja, firma_id, stanowisko_id ,umowa_id, 
            etat_id ,rodzaj_pracy_id ,najmn_wynagrodzenie, najw_wynagrodzenie, dni_pracy, godziny_pracy, data_waznosci, data_utworzenia, zdjecie) VALUES (NULL, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ?, ?)"
            , [$_POST['nazwa_ogloszenia'], $_POST['lokalizacja'], $_POST['firma'], $_POST['stanowisko'], $_POST['umowa'], $_POST['etat'], $_POST['rodzajPracy'], 
            $_POST['najmn_wynagrodzenie'], $_POST['najw_wynagrodzenie'], $_POST['dni_pracy'], $_POST['godziny_pracy'], $_POST['data_waznosci'], date("Y-m-d"), $zdjecieDodanie]);

            $zlapId = $polaczenie->insert_id;
                
            foreach($_POST['kategoria'] as $k)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_kategorie VALUES(NULL, ?, ?)", [$zlapId, $k]);
            }  
            
            foreach($_POST['obowiazki'] as $ob)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_obowiazki VALUES(NULL, ?, ?)", [$ob, $zlapId]);
            }

            foreach($_POST['wymagania'] as $wym)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_wymagania VALUES(NULL, ?, ?)", [$wym, $zlapId]);
            }

            foreach($_POST['benefity'] as $benef)
            {        
                $result = $polaczenie->execute_query("INSERT INTO ogloszenie_benefity VALUES(NULL, ?, ?)", [$benef, $zlapId]);
            }
       }       
    }    
        
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
                $result = $polaczenie-> execute_query("SELECT * FROM ogloszenia WHERE ogloszenie_id = ?", [$_GET['id']]);
                $ogloEdit = $result->fetch_assoc();
              }
              ?>
            <form class="m-1 p-2 UlubionyKolor rounded-5 text-light col-12" method="post" enctype="multipart/form-data">
                <div class="m-1">
                    <label for="nazwa_ogloszenia">Nazwa ogłoszenia:</label>
                    <input type="text" id="nazwa_ogloszenia" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" name="nazwa_ogloszenia" required value="<?php                    
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
                    <input type="text" id="lokalizacja" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" name="lokalizacja" required value="<?php                    
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
                            $resultKat = $polaczenie-> execute_query("SELECT * FROM ogloszenie_kategorie WHERE ogloszenie_id = ?", [$_GET['id']]);                            
                            while($katEdit = $resultKat->fetch_assoc())
                            {
                                array_push( $id_kategoriiTab,$katEdit['kategoria_id']);
                            }  
                        }
                    ?>
                    <select name="kategoria[]" class="col-12 col-md-10 w-100 bg-secondary border-0 rounded-3 text-light" multiple size="3" required>                    
                        <?php while($rowKategoria = $wynikKategorie->fetch_assoc())
                        {
                            echo '<option value="'.$rowKategoria["kategoria_id"].'" '.(in_array($rowKategoria["kategoria_id"],$id_kategoriiTab)?" selected":"").'>'.$rowKategoria["nazwa_kategorii"].'</option>';
                        } 
                        if(isset($_SESSION['kategoria']))                           
                        unset($_SESSION['kategoria']);
                        ?>
                    </select>
                </div>
                
                <div class="m-1">
                    <label for="firma">Firma:</label>
                    <select name="firma" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowFirma = $wynikFirmy->fetch_assoc())
                        {
                            echo '<option value="'.$rowFirma["firma_id"].'" '.($_SESSION['firma']==$rowFirma["firma_id"]?" selected":($edytowanie && $ogloEdit["firma_id"] == $rowFirma['firma_id']?" selected":"")).'>'.$rowFirma["nazwa_firmy"].'</option>';
                        }                            
                        if(isset($_SESSION['firma']))                           
                        unset($_SESSION['firma']);
                        ?>
                    </select>
                </div>
                                    
                <div class="m-1">
                    <label for="stanowisko" >Stanowisko:</label>
                    <select name="stanowisko" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowStanowisko = $wynikStanowiska->fetch_assoc())
                        {
                            echo '<option value="'.$rowStanowisko["stanowisko_id"].'" '.($_SESSION['stanowisko']==$rowStanowisko["stanowisko_id"]?" selected":($edytowanie && $ogloEdit["stanowisko_id"] == $rowStanowisko['stanowisko_id']?" selected":"")).'>'.$rowStanowisko["nazwa_stanowiska"].'</option>';
                        }     
                        if(isset($_SESSION['stanowisko']))                           
                        unset($_SESSION['stanowisko']);                       
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="etat">Wymiar zatrudnienia:</label>
                    <select name="etat" required class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light">
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowEtat = $wynikEtaty->fetch_assoc())
                        {
                            echo '<option value="'.$rowEtat["etat_id"].'" '.($_SESSION['etat']==$rowEtat["etat_id"]?" selected":($edytowanie && $ogloEdit["etat_id"] == $rowEtat['etat_id']?" selected":"")).'>'.$rowEtat["wymiar_etatu"].'</option>';
                        } 
                        if(isset($_SESSION['etat']))                           
                        unset($_SESSION['etat']);                           
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="rodzajPracy">Rodzaj pracy:</label>
                    <select name="rodzajPracy" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php while($rowRodzajPracy = $wynikRodzajePracy->fetch_assoc())
                        {
                            echo '<option value="'.$rowRodzajPracy["rodzaj_pracy_id"].'" '.($_SESSION['rodzajPracy']==$rowRodzajPracy["rodzaj_pracy_id"]?" selected":($edytowanie && $ogloEdit["rodzaj_pracy_id"] == $rowRodzajPracy['rodzaj_pracy_id']?" selected":"")).'>'.$rowRodzajPracy["rodzaj_pracy"].'</option>';
                        }        
                        if(isset($_SESSION['rodzajPracy']))                           
                        unset($_SESSION['rodzajPracy']);                    
                        ?>
                    </select>
                </div>

                <div class="m-1">
                    <label for="umowa">Rodzaj umowy:</label>
                    <select name="umowa" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" required>
                        <option value="" disabled selected hidden>Wybierz...</option>
                        <?php
                            while($rowUmowa = $wynikUmowy->fetch_assoc())
                            {
                                echo '<option value="'.$rowUmowa["umowa_id"].'" '.($_SESSION['umowa']==$rowUmowa["umowa_id"]?" selected":($edytowanie && $ogloEdit["umowa_id"] == $rowUmowa['umowa_id']?" selected":"")).'>'.$rowUmowa["rodzaj_umowy"].'</option>';
                            }    
                            if(isset($_SESSION['umowa']))                           
                            unset($_SESSION['umowa']);                        
                        ?>
                    </select>
                </div>


                <div class="m-1">
                    <label for="najmn_wynagrodzenie">Najniższe wynagrodzenie:</label>
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" name="najmn_wynagrodzenie" value="<?php                    
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
                    <input type="number" min="0" step="0.01" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" name="najw_wynagrodzenie" value="<?php                    
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
                    <textarea name="dni_pracy" class="w-100 bg-secondary border-0 rounded-3 text-light"  id="dni_pracy" cols="30" required rows="5"><?php
                    if($edytowanie)
                    {
                        echo $ogloEdit['dni_pracy'];                    
                    }
                    if(isset( $_SESSION['dni_pracy']))
                    {
                        echo  $_SESSION['dni_pracy'];
                        unset($_SESSION['dni_pracy']);
                    }?></textarea>
                </div>                
                
                <div class="m-1">
                    <label for="godziny_pracy">Godziny pracy:</label>
                    <input type="number" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" value="<?php                    
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
                    <input type="date" class="col-12 col-md-10 w-100 bg-secondary LogowanieInput border-0 rounded-3 text-light" value="<?php                    
                    if(isset( $_SESSION['data_waznosci']))
                    {
                        echo  $_SESSION['data_waznosci'];
                        unset($_SESSION['data_waznosci']);
                    }
                    elseif($edytowanie)
                    {
                        echo $ogloEdit['data_waznosci'];                    
                    }?>" name="data_waznosci" required>
                </div>                
                
                <div class="m-1 w-100">
                    <label class="col-md-2 mt-2">Zdjęcie:
                        <div class="PrzyciskDodawania btn UlubionyKolor btn-secondary text-light rounded-5 w-100 sm-ms-5 my-2">Wybierz zdjęcie</div>
                        <p id="ZdjecieText"></p>
                        <input type="file" required id="zdjecie" class="col-12 col-md-10" style="opacity: 0; position: absolute; z-index:-1" name="zdjecie">
                    </label>                   
                </div>                
        

                <div class="FormScroll p-2">                    
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Obowiązki  </h2>
                        <input type="image" src="../Images/Icons/dodawanie.png" id="DodajObowiazek" class="SzczegolyIconAdm rounded-3 ms-4 p-1 dlt-btn" alt="DodajObowiazek">
                    </div>                                        
                    <div id="PoleObowiazki" class="row">

                    </div>  
                    <p class="text-danger"><?php
                    if(isset($_SESSION['obowiazekBlad']))
                    {
                        echo $_SESSION['obowiazekBlad'];
                        unset($_SESSION['obowiazekBlad']);
                    }
                    ?></p>
                </div>
                
                <div class="FormScroll p-2">
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Wymagania</h2>
                        <input type="image" src="../Images/Icons/dodawanie.png" id="DodajWymaganie" class="SzczegolyIconAdm rounded-3 ms-4 p-1 dlt-btn" alt="DodajWymaganie">
                    </div>                
                    <div id="PoleWymagania">

                    </div>
                    <p class="text-danger"><?php
                    if(isset($_SESSION['wymaganieBlad']))
                    {
                        echo $_SESSION['wymaganieBlad'];
                        unset($_SESSION['wymaganieBlad']);
                    }
                    ?></p>
                </div>
            
                <div class="FormScroll p-2">
                    <div class="d-flex">
                        <h2 class="text-light mt-2 border-white border border-start-0 border-end-0 border-top-0 border-1 w-100">Benefity</h2>
                        <input type="image" src="../Images/Icons/dodawanie.png" id="DodajBenefit" class="SzczegolyIconAdm rounded-3 ms-4 p-1 dlt-btn" alt="DodajBenefit">
                    </div>
                    <div id="PoleBenefity">

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
                                 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>       
        function DodajObowiazek(obowiazek)
        {        
            const imgUsun = document.createElement('img');
            imgUsun.src = '../Images/Icons/usun.png';
            imgUsun.alt = 'Usuń';
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'me-2', 'dlt-btn');
            const WyswietlanyObowiazek = document.createElement("div");
            const ObowiazekInput = document.createElement("input");
            ObowiazekInput.type="text";
            ObowiazekInput.name="obowiazki[]";
            ObowiazekInput.value= obowiazek;
            ObowiazekInput.classList.add('bg-secondary', 'LogowanieInput', 'border-0', 'rounded-3', 'text-light');
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
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'me-2', 'dlt-btn');     
            const WyswietlaneWymaganie = document.createElement("div");
            const WymaganieInput = document.createElement("input");
            WymaganieInput.type="text";
            WymaganieInput.name="wymagania[]";
            WymaganieInput.value= wymaganie;
            WymaganieInput.classList.add('bg-secondary', 'LogowanieInput', 'border-0', 'rounded-3', 'text-light');
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
            BenefitInput.type="text";
            BenefitInput.name="benefity[]";
            BenefitInput.value= benefit;
            BenefitInput.classList.add('bg-secondary', 'LogowanieInput', 'border-0', 'rounded-3', 'text-light');
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
            imgUsun.classList.add('SzczegolyIconAdm', 'rounded-3', 'me-2', 'dlt-btn');
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
        if($edytowanie)
        {
            $result = $polaczenie->execute_query("SELECT obowiazekText FROM ogloszenie_obowiazki WHERE ogloszenie_id = ?", [$_GET['id']]);

            echo "<script>";
            if($result->num_rows>0)
            {                
                while($wierszObowiazki = $result->fetch_assoc())
                {
                    echo "DodajObowiazek('".htmlspecialchars($wierszObowiazki['obowiazekText'])."');";
                }            
            }

            $result = $polaczenie->execute_query("SELECT wymaganieText FROM ogloszenie_wymagania WHERE ogloszenie_id = ?", [$_GET['id']]);
            if($result->num_rows>0)
            {                
                while($wierszWymagania = $result->fetch_assoc())
                {
                    echo "DodajWymaganie('".htmlspecialchars($wierszWymagania['wymaganieText'])."');";
                }            
            }

            $result = $polaczenie->execute_query("SELECT benefitText FROM ogloszenie_benefity WHERE ogloszenie_id = ?", [$_GET['id']]);
            if($result->num_rows>0)
            {                
                while($wierszBenefity = $result->fetch_assoc())
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