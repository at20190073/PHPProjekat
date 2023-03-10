<?php

require "dbBroker.php";
require "model/korisnik.php";

session_start();
if(isset($_POST['username']) && isset($_POST['password'])){
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    
    $korisnik = new Korisnik(1, $uname, $upass, null, null);
   
    $odg = Korisnik::logInUser($korisnik, $conn); 

    if($odg->num_rows==1){
        echo  `
        <script>
        console.log( "Uspešno ste se prijavili");
        </script>
        `;
        $row = $odg->fetch_array();
        $korisnik->IdKor = $row['IdKor'];
        $korisnik->ime = $row['ime'];
        $korisnik->prezime = $row['prezime'];
        $_SESSION['user_id'] = $korisnik->IdKor;
        header('Location: home.php');
        exit();
    }else{
        echo `
        <script>
        console.log( "Niste se prijavili!");
        </script>
        `;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Dobrodošli</title>

    
</head>
<body>
    <div class="login-form">
        <div class="main-div">
            <form method="POST" action="#">
                <div class="container">
                  
                    <input type="text" name="username" class="form-input"   required>
                  
                   
                    <input type="password" name="password" class="form-control" required>
                    <button type="submit" class="btn btn-primary" name="submit">Prijavi se</button>
                </div>

            </form>
        </div>

        
    </div>
</body>
</html>