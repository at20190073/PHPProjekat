<?php

require "../dbBroker.php";
require "../model/artikl.php";

if(isset($_POST['naziv']) && isset($_POST['cena']) && isset($_POST['IdPro'])){
    $artikl = new Artikl(null, $_POST['cena'], $_POST['naziv'], $_POST['IdPro']);
    $status =  Artikl::add($artikl, $conn);

    if($status){
        echo 'Success';
    }else{
        echo $status;
        echo "Failed";
    }
}


?>