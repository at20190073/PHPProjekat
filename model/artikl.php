<?php
class Artikl{
    public $IdArt;   
    public $cena;   
    public $naziv;
    public $IdPro;
    
    public function __construct($IdArt=null, $cena=null, $naziv=null, $IdPro=null)
    {
        $this->IdArt = $IdArt;
        $this->cena = $cena;
        $this->naziv = $naziv;
        $this->IdPro = $IdPro;
    }

    #funkcija prikazi sve getAll

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM artikl";
        return $conn->query($query);
    }

    #funkcija getById

    public static function getById($id, mysqli $conn){
        $query = "SELECT * FROM artikl WHERE IdArt=$id";

        $myObj = array();
        if($msqlObj = $conn->query($query)){
            while($red = $msqlObj->fetch_array(1)){
                $myObj[]= $red;
            }
        }

        return $myObj;

    }

    public static function getBySellerId($id, mysqli $conn){
        $query = "SELECT * FROM artikl WHERE IdPro=$id";

        $myObj = array();
        if($msqlObj = $conn->query($query)){
            while($red = $msqlObj->fetch_array(1)){
                $myObj[]= $red;
            }
        }

        return $myObj;

    }

    #deleteById

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM artikl WHERE IdArt=$this->IdArt";
        return $conn->query($query);
    }

    #update
    public function update($id, mysqli $conn)
    {
        $query = "UPDATE artikl set cena = $this->cena, naziv = $this->naziv, IdPro = $this->IdPro WHERE IdArt=$id";
        return $conn->query($query);
    }

    #insert add
    public static function add(Artikl $artikl, mysqli $conn)
    {
        $query = "INSERT INTO artikl(cena, naziv, IdPro) VALUES('$artikl->cena','$artikl->naziv','$artikl->IdPro')";
        return $conn->query($query);
    }
}

?>