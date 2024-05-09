<?php
    session_start();

    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
    {
        header('Location: StronaGlowna.php'); 
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/Other/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
</head>
<body class="d-flex align-items-center justify-content-center flex-column vh-100 LogowanieTlo"> 
        <div class="d-inline-flex UlubionyKolor mb-2 rounded-5">
            <a href="StronaGlowna.php" class="d-flex justify-content text-decoration-none logoLogowanie">
                <img src="../Images/Other/logo.png" class="" alt="logo">
                <div class="mt-4 d-flex justify-content-center align-items-center UlubionyKolor mb-3 px-2 rounded-5 logNapis">
                    <h2 class="text-center text-light fw-bold logNapisFont">MoonWork</h2>   
                </div>  
            </a>              
        </div>              
        <div class="UlubionyKolor rounded-4 LogowanieMainDiv">
            <h2 class="text-center mb-5 text-light">Logowanie</h2>
            <form action="../PHPScripts/zaloguj.php" class="d-flex flex-column px-1" method="post">   
            <p class="mb-0 ms-1">Login</p>                  
            <input type="text" class="bg-secondary LogowanieInput border-0 rounded-3" name="login"><br>       
            <p class="mb-0 ms-1">Hasło</p>        
            <input type="password" class="bg-secondary LogowanieInput border-0 rounded-3" placeholder="haslo" name="haslo"><br> 
            <button type="button" class="btn UlubionyKolor btn-secondary text-light rounded-5 sm-ms-5 my-2"><input type="submit" class="w-100 bg-transparent border-0 text-light" value="Zaloguj się"></button>               
            <a class="text-center mt-3 text-light text-decoration-none" href="Rejestracja.php" >Zarejestruj się</a>
            </form>   
            <?php
            if(isset($_SESSION['blad']))
            echo $_SESSION['blad'];

            session_destroy();
            ?>    
        </div>            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>