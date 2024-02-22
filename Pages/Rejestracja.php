
<?php

	session_start();
	
	if (isset($_POST['email']))
	{

		$wszystko_OK=true;
		

		$nick = $_POST['nick'];
		

		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		

		$email = $_POST['email'];


		$_SESSION['email_cart'] = $email;

		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		

		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo2']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


		
	
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
	
		

		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "../PHPScripts/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				
				$rezultat = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

			
				$rezultat = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nick='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}

								
				if ($wszystko_OK==true)     
				{
					
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', '' )"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: Logowanie.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{		
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/Other/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
    <script async src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body class="d-flex align-items-center justify-content-center flex-column vh-100 LogowanieTlo">

   <!-- <div class="d-inline-flex UlubionyKolor mb-2 rounded-5">
        <img src="../Images/logo.png" class="" alt="logo">
        <div class="mt-4 d-flex justify-content-center align-items-center UlubionyKolor mb-3 px-2 rounded-5 logNapis">
            <h2 class="text-center text-light fw-bold logNapisFont">MoonWork</h2>   
        </div>                
    </div> -->
    <div  class="UlubionyKolor rounded-4 RejestracjaMainDiv">
        <h2 class="text-center mb-4 text-light">Rejestracja</h2>
        <form method="post" class="d-flex flex-column text-light px-1">
        
            <p class="mb-0 ms-1">Login</p>
            <input type="text" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		    ?>" name="nick" />

            <?php
                if (isset($_SESSION['e_nick']))
                {
                    echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                    unset($_SESSION['e_nick']);
                }
            ?>
                 
            <p class="mb-0 ms-1 mt-3">Email</p>
            <input type="email" value="<?php
                if (isset($_SESSION['fr_email']))
                {
                    echo $_SESSION['fr_email'];
                    unset($_SESSION['fr_email']);
                }
		    ?>" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" name="email" placeholder="e-mail" />    
            
            <?php
                if (isset($_SESSION['e_email']))
                {
                    echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                    unset($_SESSION['e_email']);
                }
		    ?>
            
            <p class="mb-0 ms-1 mt-3">Hasło</p>
            <input type="password" placeholder="haslo" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" value="<?php
                if (isset($_SESSION['fr_haslo1']))
                {
                    echo $_SESSION['fr_haslo1'];
                    unset($_SESSION['fr_haslo1']);
                }
		    ?>" name="haslo1" />

            <?php
                if (isset($_SESSION['e_haslo']))
                {
                    echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                    unset($_SESSION['e_haslo']);
                }
            ?>
            
            <p class="mb-0 ms-1 mt-3">Powtórz hasło</p>       
            <input type="password" placeholder="powtórz hasło" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" value="<?php
                if (isset($_SESSION['fr_haslo2']))
                {
                    echo $_SESSION['fr_haslo2'];
                    unset($_SESSION['fr_haslo2']);
                }
		    ?>" name="haslo2" />

			<?php
				if (isset($_SESSION['e_haslo2'])) {
					echo '<div class="error">'.$_SESSION['e_haslo2'].'</div>';
					unset($_SESSION['e_haslo2']);
				}
			?>
            
            <div class="text-light mt-3">
                <input type="checkbox" name="regulamin" class="me-2" <?php
                    if (isset($_SESSION['fr_regulamin']))
                    {
                        echo "checked";
                        unset($_SESSION['fr_regulamin']);
                    }
				?>/>Akceptuję regulamin

				<?php
					if (isset($_SESSION['e_regulamin'])) {
						echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
						unset($_SESSION['e_regulamin']);
					}
				?>

            </div>            
                                                
          <!--<div class="g-recaptcha mt-3"  data-sitekey="6Lfr3ekkAAAAADzxweqZoBErhOHJzVxqcDnEXecm"></div> -->
                                                          
            <button type="button" class="btn UlubionyKolor btn-secondary text-light rounded-5 mt-3 sm-ms-5 my-2"><input type="submit" class="w-100 bg-transparent border-0 text-light" value="Zarejestruj się" /></button>
            <a href="Logowanie.php" class="text-decoration-none text-light text-center mt-2">Zaloguj się</a>
            
        </form>
        </div>
    
</body>
</html>