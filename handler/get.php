<?php

require "../dbBroker.php";
require "../model/artikl.php";

if(isset($_POST['id'])){
    $myArray = Artikl::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}

?>