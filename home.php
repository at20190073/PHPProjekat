<?php

require "dbBroker.php";
require "model/artikl.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$podaci = Artikl::getBySellerId($_SESSION['user_id'], $conn);
if (!$podaci) {
    echo "Nastala je greška pri preuzimanju podataka";
    die();
}
if ($podaci->num_rows == 0) {
    echo "Nema artikala koje korisnik prodaje";
    die();
} else {

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Artikli za prodaju:</title>

</head>

<body>


    <div class="row" style="background-color: rgba(225, 225, 208, 0.5);">
        <div class="col-md-4">
            <button id="btn" class="btn btn-info btn-block" style="background-color: teal !important; border: 1px solid white; "> Prikazi artikle</button>
        </div>
        <div class="col-md-4">
            <button id="btn-dodaj" type="button" class="btn btn-success btn-block" style="background-color: teal; border: 1px solid white;" data-toggle="modal" data-target="#myModal"> Dodaj artikl</button>

        </div>
        <div class="col-md-4">
            <button id="btn-pretraga" class="btn btn-warning btn-block" style="background-color:  teal; border: 1px solid white;"> Pretrazi artikle po imenu</button>
            <input type="text" id="myInput" onkeyup="funkcijaZaPretragu()" placeholder="Pretrazi artikle po imenu" hidden>
        </div>
    </div>

    <div id="pregled" class="panel panel-success" style="margin-top: 1%;" hidden=true>

        <div class="panel-body">
            <table id="myTable" class="table table-hover table-striped" style="color: black; background-color: grey;">
                <thead class="thead">
                    <tr>
                        <th scope="col">Artikl</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Naziv</th>
                        <th scope="col">Id Prodavca</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($red = $podaci->fetch_array()) :
                    ?>
                        <tr>
                            <td><?php echo $red["IdArt"] ?></td>
                            <td><?php echo $red["cena"] ?></td>
                            <td><?php echo $red["naziv"] ?></td>
                            <td><?php echo $red["IdPro"] ?></td>
                            <td>
                                <label class="custom-radio-btn">
                                    <input onclick="EnableIzmeni()" type="radio" name="checked-donut" value=<?php echo $red["IdArt"] ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </td>

                        </tr>
                <?php
                    endwhile;
                }
                ?>

                </tbody>
            </table>
            <div class="row">
                <div class="col-md-1" style="text-align: right">
                    <button id="btn-izmeni" disabled class="btn btn-warning" data-toggle="modal" data-target="#izmeniModal">Izmeni</button>

                </div>

                <div class="col-md-12" style="text-align: right">
                    <button id="btn-obrisi" formmethod="post" class="btn btn-danger" style="background-color: red; border: 1px solid white;">Obrisi</button>
                </div>

                <div class="col-md-2" style="text-align: right;">
                    <button id="btn-sortiraj" class="btn btn-normal" onclick="sortTable()">Sortiraj</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="dodajForm">
                            <h3 style="color: black; text-align: center">Dodavanje artikla</h3>
                            <div class="row">
                                <div class="col-md-11 ">
                                    <div class="form-group">
                                        <label for="">Naziv</label>
                                        <input type="text" style="border: 1px solid black" name="naziv" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Cena</label>
                                        <input type="text" style="border: 1px solid black" name="cena" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="sala">IdProdavca</label>
                                        <input type="sala" style="border: 1px solid black" name="IdPro" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <button id="btnDodaj" type="submit" class="btn btn-success btn-block" tyle="background-color: orange; border: 1px solid black;">Dodaj</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- Modal -->
    <div class="modal fade" id="izmeniModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal sadrzaj-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="izmeniForm">
                            <h3 style="color: black">Izmeni artikl</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="id" type="text" name="id" class="form-control idfield" placeholder="Id *" value="" readonly />
                                    </div>
                                    <div class="form-group">
                                        <input id="naziv" type="text" name="naziv" class="form-control" placeholder="Naziv*" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="cena" type="text" name="cena" class="form-control" placeholder="Cena *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="IdPro" type="text" name="IdPro" class="form-control" placeholder="IdPro(opciono)" value="" />
                                    </div>
                                    <div class="form-group">
                                        <button id="btnIzmeni" type="submit" class="btn btn-success btn-block" style="color: white; background-color: orange; border: 1px solid white"> Izmeni
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </div>
            </div>



        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("myTable");
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[2];
                    y = rows[i + 1].getElementsByTagName("td")[2];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        function funkcijaZaPretragu() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


</body>

</html>