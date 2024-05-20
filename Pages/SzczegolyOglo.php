<?php

session_start();

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if((!isset($_GET['id'])))
{
    header('Location: StronaGlowna.php'); 
    exit();
}

$zapytanieOglo = "SELECT ogloszenia.*, 
ogloszenie_stanowiska.nazwa_stanowiska, 
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

$zapytanieOgloFirma = "SELECT firmy.nazwa_firmy, firmy.informacje FROM ogloszenia JOIN firmy USING(firma_id) WHERE ogloszenie_id='{$_GET['id']}';";
$wynikOgloFirma = $polaczenie->query($zapytanieOgloFirma);
$wierszOgloFirma = $wynikOgloFirma ->  fetch_assoc();

$zapytanieObo = "SELECT * FROM ogloszenie_obowiazki WHERE ogloszenie_id='{$_GET['id']}';";
$wynikObo = $polaczenie->query($zapytanieObo);

$zapytanieBenef = "SELECT * FROM ogloszenie_benefity WHERE ogloszenie_id='{$_GET['id']}';";
$wynikBenef = $polaczenie->query($zapytanieBenef);

$zapytanieWymag = "SELECT * FROM ogloszenie_wymagania WHERE ogloszenie_id='{$_GET['id']}';";
$wynikWymag = $polaczenie->query($zapytanieWymag);

if(isset($_SESSION['zalogowany']))
{              

$nazwaUzytkownika = $_SESSION['user'];
$wynik = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = '$nazwaUzytkownika'");
$wierszUzytkownk = $wynik->fetch_assoc();

$idUzytkownika = $wierszUzytkownk['uzytkownik_id'];

$wynikProfil = $polaczenie->execute_query("SELECT profile.*, uzytkownicy.email FROM profile JOIN uzytkownicy USING(uzytkownik_id) WHERE uzytkownik_id = ?", [$idUzytkownika]);

$ogloszenieId = $_GET['id'];


if(isset($_POST['aplikuj']))
{
  $wynik = $polaczenie->query("INSERT INTO aplikowania (aplikowanie_id, uzytkownik_id, ogloszenie_id, status) VALUES(NULL, $idUzytkownika, $ogloszenieId, 'nie zatwierdzone')");
}

$wynikAplikacja = $polaczenie->execute_query("SELECT aplikowanie_id FROM aplikowania WHERE ogloszenie_id = ? AND uzytkownik_id = ?",[$ogloszenieId,$idUzytkownika]);

$wynikUlubione = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = '$nazwaUzytkownika'");

if(isset($_POST['nie_polubione_x']) && isset($_POST['nie_polubione_y']))
{
  $wynikUlubione = $polaczenie->query("INSERT INTO ulubione (ulubione_id, uzytkownik_id, ogloszenie_id) VALUES(NULL, $idUzytkownika, $ogloszenieId)");  
  
}  

if(isset($_POST['polubione_x']) && isset($_POST['polubione_y']))
{
  $wynikUlubione = $polaczenie->query("DELETE FROM ulubione WHERE ogloszenie_id = $ogloszenieId");    
} 
$wynikUlubione = $polaczenie->execute_query("SELECT ulubione_id FROM ulubione WHERE ogloszenie_id = ? AND uzytkownik_id = ?",[$ogloszenieId,$idUzytkownika]);


}
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
                        <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
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
                        <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Dane aplikacji</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <?php      
                while($wierszProfil = $wynikProfil->fetch_assoc())
                {
                  if(strlen($wierszProfil['imie']) != null && strlen($wierszProfil['nazwisko']))
                  {
                    echo'
                    <div class="modal-body">
                      <p>Przesyłasz dane:</p>
                              
                      <p>'.$wierszProfil['imie'].' '.$wierszProfil['nazwisko'].'</p>    
                      <p>Telefon: '.$wierszProfil['telefon'].'</p>          
                      <p>E-mail: '.$wierszProfil['email'].'</p>
                  
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>            
                      <form method="post" class="m-auto d-flex text-centre align-items-center">
                        <input type="submit" name="aplikuj" class="btn UlubionyKolor text-center btn-secondary text-light border-3 m-auto rounded-5 px-5 my-2" value="Aplikuj">                        
                      </form>
                    </div>';
                  }
                  else
                  {
                    echo'
                    <div class="modal-body">
                      <p>Nie uzupełnionio podstawowych danych w profilu, jak: imię, nazwisko, telefon</p>                                                                  
                    </div>
                    <div class="modal-footer d-flex">                            
                      <a href="Profil.php" active class="btn UlubionyKolor border-1 border-white w-100 rounded-4 text-light" role="button">Profil</a>
                      <button type="button" class="btn btn-secondary w-100 rounded-4" data-bs-dismiss="modal">Anuluj</button>      
                    </div>';
                  }                  
                }
          ?>
        </div>
      </div>
  </div>
    
    <section class="container my-2">    
      <?php
            if($wynikOglo->num_rows > 0)
            {
              while ($wierszOglo = $wynikOglo->fetch_assoc())
              {     
                $dataZBazy = $wierszOglo['data_waznosci']; 
                $dataWaznosci = new DateTime($dataZBazy);
                $sformatowanaData = $dataWaznosci->format('d.m.Y');
                $dzis = new DateTime();
                echo '
                <section class="ogloszenie mt-2 rounded-3 d-flex flex-wrap">
                    <div class="p-3 col-12 col-md-7">
                        <p class="text-light ms-3 fs-3">'.$wierszOglo['nazwa_ogloszenia'].'</p>                    
                        <div class="d-flex">                     
                            <img src="'.$wierszOglo['zdjecie'].'" class="logoSzczegolyOgloszenia ms-3 mt-1" alt="ZdjecieFirmy">
                            <p class="text-light ms-3 mt-4 fs-4">'.$wierszOgloFirma['nazwa_firmy'].'</p>
                        </div>
                    </div>                       
                    <div class="col-12 col-md-3 text-centre align-items-center d-flex">';                      
                      if(isset($_SESSION['zalogowany']))
                      {        
                        if($dataWaznosci > $dzis)
                        {
                          if($wynikAplikacja->num_rows > 0) 
                          {                    
                            echo '
                            <form method="post" class="m-auto d-flex text-centre align-items-center">
                              <div class="text-center p-2 fw-bold bg-secondary m-auto text-light m-auto border-3 rounded-5 px-5 my-2">Aplikowano</div>;                        
                            </form>';
                          }
                          else
                          {
                            echo '
                         
                            <input type="submit" name="aplikuj" class="btn UlubionyKolor text-center btn-secondary text-light border-3 m-auto rounded-5 px-5 my-2" data-bs-toggle="modal" data-bs-target="#exampleModal" value="Aplikuj">';
                                                    
                          } 
                          if($wynikUlubione->num_rows > 0) 
                          {
                            echo '
                            <form method="post" class="mt-2 mx-2">                 
                              <input type="image" src="../Images/Icons/polubione.png" class="SzczegolyIconMain rounded-3 m-auto dlt-btn" name="polubione" alt="polubione">                           
                            </form>';
                          }
                          else
                          {
                            echo '
                            <form method="post" class="mt-2 mx-2">                 
                              <input type="image" src="../Images/Icons/nie_polubione.png" class="SzczegolyIconMain rounded-3 m-auto dlt-btn" name="nie_polubione" alt="nie_polubione">                            
                            </form>';
                          }
                        }
                        else
                        {
                          if($wynikAplikacja->num_rows > 0) 
                          {             
                                  
                            echo '
                            <form method="post" class="m-auto d-flex text-centre align-items-center">
                              <div class="text-center p-2 fw-bold bg-secondary m-auto text-light m-auto border-3 rounded-5 px-5 my-2">Aplikowano</div>;                        
                            </form>';
                          }

                          if($wynikUlubione->num_rows > 0) 
                          {
                            echo '
                            <form method="post" class="mt-2 mx-2">                 
                              <input type="image" src="../Images/Icons/polubione.png" class="SzczegolyIconMain rounded-3 m-auto dlt-btn" name="polubione" alt="polubione">                           
                            </form>';
                          }
                        }  
                      }                             
                    echo '
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
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['lokalizacja'].'</p>                        
                            </div> 
                            
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/waznosc.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">Ważne do '.$sformatowanaData.'</p>                        
                            </div>

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/money.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.str_replace(".", ",", $wierszOglo['najmn_wynagrodzenie']).' - '.str_replace(".", ",", $wierszOglo['najw_wynagrodzenie']).' zł/mies</p>                        
                            </div>  
                        </div>
                                            
                        <div class="row">
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/umowa.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['rodzaj_umowy'].'</p>                        
                            </div>  

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/czasPracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['wymiar_etatu'].'</p>                        
                            </div> 

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/godziny_pracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['godziny_pracy'].' godz</p>                        
                            </div> 
                        </div>';    
                        
                        if($wierszOglo['poziom_stanowiska'] != null)
                        {
                          echo '
                          <div class="row">
                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/stanowisko.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['nazwa_stanowiska'].' - '.$wierszOglo['poziom_stanowiska'].'</p>                        
                            </div>  

                            <div class="col-12 col-xl-4 my-2 d-flex">
                                <img src="../Images/Icons/miejscePracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['rodzaj_pracy'].'</p>                        
                            </div> 
                      
                            <div class="my-2 d-flex col-12 col-xl-4">
                              <img src="../Images/Icons/dni_pracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                              <p class="text-light ms-2 my-0 d-flex align-items-center">Dni pracy: '.$wierszOglo['dni_pracy'].'</p>                        
                            </div>
                          </div>';
                        }
                        else
                        {
                            echo '
                            <div class="row">
                              <div class="col-12 col-xl-4 my-2 d-flex">
                                  <img src="../Images/Icons/stanowisko.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                  <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['nazwa_stanowiska'].'</p>                        
                              </div>  

                              <div class="col-12 col-xl-4 my-2 d-flex">
                                  <img src="../Images/Icons/miejscePracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                  <p class="text-light ms-2 my-0 d-flex align-items-center">'.$wierszOglo['rodzaj_pracy'].'</p>                        
                              </div> 
                                                                                        
                              <div class="my-2 d-flex col-12 col-xl-4">
                                <img src="../Images/Icons/dni_pracy.png" class="SzczegolyIcon mt-1 rounded-3" alt="">
                                <p class="text-light ms-2 my-0 d-flex align-items-center">Dni pracy: '.$wierszOglo['dni_pracy'].'</p>                        
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
                        while ($wierszObo = $wynikObo->fetch_assoc())
                        {
                          echo '
                          <div class="col-12 d-flex">
                              <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                              <p class="text-light ms-2">'.$wierszObo['obowiazekText'].'</p>
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
                      while ($wierszWymag = $wynikWymag->fetch_assoc())
                      {
                        echo '
                        <div class="col-12 d-flex">
                            <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                            <p class="text-light ms-2">'.$wierszWymag['wymaganieText'].'</p>
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
                      while ($wierszBenef = $wynikBenef->fetch_assoc())
                      {
                        echo '
                        <div class="col-12 d-flex">
                            <img src="../Images/Icons/checked.png" class="ObowiazekIcon" alt="">
                            <p class="text-light ms-2">'.$wierszBenef['benefitText'].'</p>
                        </div> ';
                      }
                    }
                     
                    echo '
                    </div>            
                </section>

                <section class="ogloszenie mt-2 rounded-3">
                    <h3 class="text-light mx-3 my-4">'.$wierszOgloFirma['nazwa_firmy'].'</h3>    
                    <p class="text-light m-4 text-wrap w-50">'.$wierszOgloFirma['informacje'].'</p>      
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