<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Zaloguj</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
<?php

session_start();


if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
    header('Location: ../Pages/Logowanie.php');
    exit();   
}

require_once "connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno!=0)
{
    echo "Error: ".$polaczenie->connect_errno;
}
else
{
    
    $login = $_POST['login']; 
    $haslo = $_POST['haslo']; 

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
         
    if($result = $polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE nick='%s'", mysqli_real_escape_string($polaczenie,$login))))
    { 
        
        $ile = $result->num_rows;

        if($ile>0)
        {
            $wiersz = $result->fetch_assoc();
            if(password_verify($haslo, $wiersz['haslo']))
            {

                $_SESSION['zalogowany']=true;
                $_SESSION['uzytkownik_id'] = $wiersz['uzytkownik_id'];
           
                $adm = $wiersz['administrator'];

                $_SESSION['administrator'] = $adm;
                
                $_SESSION['user'] = $wiersz['nick'];

                unset($_SESSION['blad']);
                $result->free_result();
                header('Location: ../Pages/StronaGlowna.php');
            }
            else
            {               
                $_SESSION['blad'] = '<p class="error d-flex align-items-center justify-content-center mt-2">Nieprawidłowy login lub hasło</p';

                header('Location: ../Pages/Logowanie.php');                   
            }

           
        }
        else
        {               
             $_SESSION['blad'] = '<p class="error d-flex align-items-center justify-content-center mt-2" >Nieprawidłowy login lub hasło</p>';

             header('Location: ../Pages/Logowanie.php');                   
        }
    }

    $polaczenie->close();
    
}

?>
</body>
</html>

