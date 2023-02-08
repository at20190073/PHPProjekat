<?php

require "../dbBroker.php";
require "../model/artikl.php";

if(isset($_POST['id'])){
    $obj = new Artikl($_POST['id']);
    $status = $obj->deleteById($conn);
    if ($status){
        echo "Success";
    }else{
        echo "Failed";
    }
}

?>