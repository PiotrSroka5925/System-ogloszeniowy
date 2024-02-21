<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Images/logo.png" type="image/icon type">
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
            <input type="text" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" value="" name="nick" />
                 
            <p class="mb-0 ms-1 mt-3">Email</p>
            <input type="email" value="" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" name="email" placeholder="e-mail" />        
            
            <p class="mb-0 ms-1 mt-3">Hasło</p>
            <input type="password" placeholder="haslo" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" value="" name="haslo1" />
            
            <p class="mb-0 ms-1 mt-3">Powtórz hasło</p>       
            <input type="password" placeholder="powtórz hasło" class="bg-secondary LogowanieInput border-0 rounded-3 text-light" name="haslo2" />
            
            <div class="text-light mt-3">
                <input type="checkbox" name="regulamin" class="me-2"/>Akceptuję regulamin
            </div>            
                                                
          <!--<div class="g-recaptcha mt-3"  data-sitekey="6Lfr3ekkAAAAADzxweqZoBErhOHJzVxqcDnEXecm"></div> -->
                                                          
            <button type="button" class="btn UlubionyKolor btn-secondary text-light rounded-5 mt-3 sm-ms-5 my-2"><input type="submit" class="w-100 bg-transparent border-0 text-light" value="Zarejestruj się" /></button>
            <a href="Logowanie.php" class="text-decoration-none text-light text-center mt-2">Zaloguj się</a>
            
        </form>
        </div>
    
</body>
</html>