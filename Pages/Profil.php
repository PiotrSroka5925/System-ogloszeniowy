<?php

session_start();
if((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] != true)) {
    header('Location: Logowanie.php'); 
    exit();
}

require_once "../PHPScripts/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$nazwaUzytkownika = $_SESSION['user'];

$wynikUzytkownik = $polaczenie->execute_query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick = ?", [$nazwaUzytkownika]);
$wierszUzytkownk = $wynikUzytkownik->fetch_assoc();

$idUzytkownika = $wierszUzytkownk['uzytkownik_id'];

$wynikUzytkownikProfilID = $polaczenie->execute_query("SELECT profil_id FROM profile WHERE uzytkownik_id = ?", [$idUzytkownika]);
$wierszProfilID = $wynikUzytkownikProfilID->fetch_assoc();

if (!$wierszProfilID) 
{
    $polaczenie->execute_query("INSERT INTO profile (uzytkownik_id) VALUES (?)", [$idUzytkownika]);
    
    $wynikNowyProfilID = $polaczenie->execute_query("SELECT profil_id FROM profile WHERE uzytkownik_id = ?", [$idUzytkownika]);
    $wierszNowyProfilID = $wynikNowyProfilID->fetch_assoc();
    $IdProfilu = $wierszNowyProfilID['profil_id'];
} 
else 
{
    
    $IdProfilu = $wierszProfilID['profil_id'];
}

$wynikProfil = $polaczenie->execute_query("SELECT profile.*, profil_miejsce_zamieszkania.miasto, profil_stanowisko_pracy.*, uzytkownicy.email 
FROM profile 
JOIN profil_miejsce_zamieszkania USING(profil_id)
JOIN profil_stanowisko_pracy USING(stanowisko_pracy_id) 
JOIN uzytkownicy USING(uzytkownik_id) 
WHERE uzytkownik_id = ?", [$idUzytkownika]);

$wynikDoswiadczenieZawodowe = $polaczenie->execute_query("SELECT * FROM profil_doswiadczenie_zawodowe WHERE profil_id = ?", [$IdProfilu]);

$wynikWyksztalcenie = $polaczenie->execute_query("SELECT * FROM profil_wyksztalcenie WHERE profil_id = ?", [$IdProfilu]);

$wynikJezyki = $polaczenie->execute_query("SELECT * FROM profil_znajomosc_jezykow WHERE profil_id = ?", [$IdProfilu]);

$wynikUmiejetnosci = $polaczenie->execute_query("SELECT * FROM umiejetnosci WHERE profil_id = ?", [$IdProfilu]);

$wynikSzkolenia = $polaczenie->execute_query("SELECT * FROM profil_dodatkowe_szkolenia WHERE profil_id = ?", [$IdProfilu]);

$wynikSzkolenia = $polaczenie->execute_query("SELECT * FROM profil_dodatkowe_szkolenia WHERE profil_id = ?", [$IdProfilu]);

$wynikAktywnosci = $polaczenie->execute_query("SELECT * FROM profil_aktywnosci WHERE profil_id = ?", [$IdProfilu]);

$wynikHobby = $polaczenie->execute_query("SELECT * FROM profil_hobby WHERE profil_id = ?", [$IdProfilu]);

$wynikLinki= $polaczenie->execute_query("SELECT * FROM profil_linki WHERE profil_id = ?", [$IdProfilu]);

?>

<!Doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil</title>    
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
                      <a class="nav-link active mt-1 me-0 fs-5 marginChange" aria-current="page" href="#">Strona główna</a>
                    </li>                   
                    <li class="nav-item dropdown border-white border border-1 rounded-3"> 
                      <a class="nav-link dropdown-toggle text-light fs-5 marginChange" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      '.$_SESSION['user'].'
                      </a>
                      <form class="dropdown-menu UlubionyKolor p-4 row">      
                        <a href="Aplikowane.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Aplikowane</a>    
                        <a href="Ulubione.php" active class="btn UlubionyKolor border-1 border-white rounded-4 col-12 mt-3 text-light" role="button">Ulubione</a>                    
                        <a href="../PHPScripts/logout.php" active class="btn UlubionyKolor border-1 border-white rounded-4 mt-3 col-12" role="button">Wyloguj</a>           
                      </form>
                    </li>
                  </ul>';
                    
                }                 
               }                                               
               ?>            
        </div>
    </nav>

    <section class="container my-2">        
        <?php
            while($wierszProfil = $wynikProfil->fetch_assoc())
            {
                $dataUrodzenia = new DateTime($wierszProfil['data_urodzenia']);

                echo '
                    <section class="ogloszenie mt-2 rounded-3">
                        <div class="p-3">                          
                            <div class="d-flex">                     
                                <img src="'.$wierszProfil['zdjecie_profilowe'].'" class="Profilowe ms-1 mt-1" alt="">                    
                                <p class="text-light ms-1 mt-4 fs-2 w-100">'.$wierszProfil['imie'].' '.$wierszProfil['nazwisko'].'</p>                                                                                                                                                                                                                                                                                                                       
                            </div>
                            <div class="mt-3">
                                <p class="text-light">'.$wierszProfil['nazwa_stanowiska'].' - '.$wierszProfil['opis_stanowiska'].'</p>
                                <div class="d-flex">
                                    <img src="../Images/Icons/localization.png" class="ObowiazekIcon" alt="">
                                    <p class="text-light">'.$wierszProfil['miasto'].'</p>                                                                      
                                </div>
                                <p class="text-light">Data urodzenia: '.$dataUrodzenia->format('d.m.Y').'</p>  
                            </div>                
                        </div>   
                        <button class="btn-dark border-light rounded-3 bg-dark border-1 mt-1 ms-3 mb-3 EditBtnProf">
                            <a href="" class="text-decoration-none text-light">Edytuj</a>
                        </button>                         
                    </section>
            
                    <section class="ogloszenie mt-2 rounded-3 ">
                        
                        <h3 class="text-light mx-3 my-4">Dane kontaktowe</h3>                                                                                
                        <div>
                            <p class="text-light ms-3">Email: '.$wierszProfil['email'].'</p> 
                            <p class="text-light ms-3">Telefon : '.$wierszProfil['telefon'].'</p>
                        </div>                                                          
                    </section>
            
                    <section class="ogloszenie mt-2 rounded-3">
                        <h3 class="text-light mx-3 my-4">Podsumowanie zawodowe</h3>    
                        <p class="text-light m-4 podsumowanie-zawodowe">'.$wierszProfil['podsumowanie_zawodowe'].'</p>
                    </section>';
            }
        ?>        
                            
        <section class="ogloszenie mt-2 rounded-3 ">
            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Doświadczenie zawodowe</h3>                
            </div> 
            <?php
                while($wierszDoswiadczenieZawodowe = $wynikDoswiadczenieZawodowe->fetch_assoc())
                {                                                                          
                echo'
                <div class="d-flex flex-wrap mt-2">
                    <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                        <div class="text-light ms-3 mt-3">
                            <p class="mt-1">'.$wierszDoswiadczenieZawodowe['stanowisko'].' / '.$wierszDoswiadczenieZawodowe['okres_zatrudnienia_od'].' - '.$wierszDoswiadczenieZawodowe['okres_zatrudnienia_do'].'</p>
                            <p>'.$wierszDoswiadczenieZawodowe['nazwa_firmy'].' ('.$wierszDoswiadczenieZawodowe['lokalizacja'].')</p>
                            <p>'.$wierszDoswiadczenieZawodowe['obowiazki'].'</p>
                        </div>                    
                    </div>                               
                </div>';
                }
            ?>                                                                               
        </section>                    

        <section class="ogloszenie mt-2 rounded-3 ">
            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Wykształcenie</h3>                
            </div>                           
                                         
            <?php
             while($wierszWyksztalcenie = $wynikWyksztalcenie->fetch_assoc())
             {                                                                          
                echo'
                <div class="d-flex flex-wrap mt-2">
                    <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                        <div class="text-light ms-3 mt-3">
                            <p class="mt-1">'.$wierszWyksztalcenie['placowka'].' / '.$wierszWyksztalcenie['okres_wyksztalcenia_od'].' - '.$wierszWyksztalcenie['okres_wyksztalcenia_do'].'</p>
                            <p>Kierunek: '.$wierszWyksztalcenie['kierunek'].'</p>
                            <p>Wyksztalcenie: '.$wierszWyksztalcenie['poziom_wyksztalcenia'].'</p>
                        </div>                   
                    </div>                               
                </div>';
             }
            ?>                                              
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">
            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Języki</h3>               
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
            <?php
                while($wierszJezyki = $wynikJezyki->fetch_assoc())
                {                                                                          
                    echo'
                    <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                        <div class="text-light ms-3 d-flex mt-3">
                            <p class="mt-1">'.$wierszJezyki['jezyk'].' - '.$wierszJezyki['poziom_jezyka'].' </p>                           
                        </div>                    
                    </div>';
                }
            ?>                                                   
            </div>                                              
        </section>

        <section class="ogloszenie mt-2 rounded-3">
            <h3 class="text-light mx-3 my-4">Umiejętności</h3>    
            <?php
                while($wierszUmiejetnosci = $wynikUmiejetnosci->fetch_assoc())
                {                                                                          
                    echo'<p class="text-light m-4 podsumowanie-zawodowe">'.$wierszUmiejetnosci['umiejetnoscText'].'</p>';
                }
            ?>
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">
            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Kursy, szkolenia, certyfikaty</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <?php
                    while($wierszSzkolenia = $wynikSzkolenia->fetch_assoc())
                    {                                                                          
                        echo'
                        <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                            <div class="text-light ms-3 mt-3">
                                <p class="mt-1">'.$wierszSzkolenia['nazwa_szkolenia'].' / '.$wierszSzkolenia['data_szkolenia_od'].' - '.$wierszSzkolenia['data_szkolenia_do'].'</p>                    
                                <p>'.$wierszSzkolenia['organizator'].'</p>
                            </div>                    
                        </div>';
                    }
                ?>                               
            </div>                                                               
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Organizacje, Aktywności, Stowarzyszenia</h3>               
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <?php
                    while($wierszkAktywnosci = $wynikAktywnosci->fetch_assoc())
                    {                                                                          
                        echo'
                        <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                            <div class="text-light ms-3 mt-3">
                                <p class="mt-1">'.$wierszkAktywnosci['organizacja'].' / '.$wierszkAktywnosci['czas_trwania_od'].' - '.$wierszkAktywnosci['czas_trwania_do'].'</p>   
                                <p>'.$wierszkAktywnosci['miejsce'].'</p>                                         
                                <p>'.$wierszkAktywnosci['czynnosci'].'</p>
                            </div>                   
                        </div>';
                    }
                ?>                               
            </div>                                                               
        </section>

        <section class="ogloszenie mt-2 rounded-3">
            <h3 class="text-light mx-3 my-4">Hobby</h3>  
            <?php
                while($wierszkHobby = $wynikHobby->fetch_assoc())
                {                                                                          
                    echo'<p class="text-light m-4 text-wrap w-50">'.$wierszkHobby['hobbyText'].'</p>';
                }
            ?>                                
        </section>

        <section class="ogloszenie mt-2 rounded-3 ">

            <div class="d-flex flex-wrap">
                <h3 class="text-light mx-3 my-4">Linki</h3>                
            </div>                           
                                                
            <div class="d-flex flex-wrap mt-2">
                <?php
                    while($wierszLinki = $wynikLinki->fetch_assoc())
                    {
                        echo'
                        <div class="d-flex flex-wrap w-100 border-top border-light border-1">
                            <div class="text-light ms-3 my-2">                                                      
                                <a href="'.$wierszLinki['link'].'" class="text-decoration-none text-light my-2" target="_blank">'.$wierszLinki['tytul_linku'].'</a>                                                   
                            </div>                   
                        </div>';
                    }
                ?>                               
            </div>                                                               
        </section>
                 
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