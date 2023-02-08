<?php

require "../dbBroker.php";
require "../model/prijava.php";

if(isset($_POST['id']) && isset($_POST['naziv']) && isset($_POST['cena'])){
    $artikl = new Artikl($_POST['id'], $_POST['cena'], $_POST['naziv'], $_SESSION['user_id']);
    if(isset($_POST['IdPro'])){
        $artikl->IdPro = $_POST['IdPro'];
    }
    $status = $artikl->update($artikl->IdArt, $conn);
    

    if($status){
        echo 'Success';
    }else{
        echo $status;
        echo "Failed";
    }
}

?> 