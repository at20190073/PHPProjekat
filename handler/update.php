<?php

require "../dbBroker.php";
require "../model/artikl.php";

if(isset($_POST['id']) && isset($_POST['naziv']) && isset($_POST['cena']) && isset($_POST['IdPro'])){
    $artikl = new Artikl($_POST['id'], $_POST['cena'], $_POST['naziv'], $_POST['IdPro']);
    
    echo `
    <script>
    console.log( "Imamo sve!");
    </script>
    `;
    $status = $artikl->update($artikl->IdArt, $conn);
    

    if($status){
        echo 'Success';
    }else{
        echo $status;
        echo "Failed";
    }
}
else{
    echo `
    <script>
    console.log( "Nemamo sve!");
    </script>
    `;
}
?> 