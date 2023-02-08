$('#dodajForm').submit(function(){
    event.preventDefault();
    console.log("Dodavanje");
    const $form =$(this);
    const $input = $form.find('input, select, button, textarea');

    const serijalizacija = $form.serialize();
    console.log(serijalizacija);

    $input.prop('disabled', true);

    req = $.ajax({
        url: 'handler/add.php',
        type:'post',
        data: serijalizacija
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            alert("Artikl uspesno dodat");
            console.log("Dodar artikl");
            location.reload(true);
        }else console.log("Artikl nije dodat "+res);
        console.log(res);
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila> '+textStatus, errorThrown)
    });
});

$('#btn-obrisi').click(function(){
    console.log("Brisanje");

    const checked = $('input[name=checked-donut]:checked');

    req = $.ajax({
        url: 'handler/delete.php',
        type:'post',
        data: {'id':checked.val()}
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           checked.closest('tr').remove();
           alert('Obrisan artikl');
           console.log('Obrisan');
        }else {
        console.log("Artikl nije obrisan "+res);
        alert("Artikl nije obrisan ");

        }
        console.log(res);
    });

});

$('#btn-izmeni').click(function () {
    const checked = $('input[name=checked-donut]:checked');
    request = $.ajax({
        url: 'handler/get.php',
        type: 'post',
        data: {'id': checked.val()},
        dataType: 'json'
    });


    request.done(function (response, textStatus, jqXHR) {
        console.log('Izmenjeno');
        $('#naziv').val(response[0]['naziv']);
        console.log(response[0]['naziv']);

        $('#cena').val(response[0]['cena']);
        console.log(response[0]['cena']);

        $('#IdPro').val(response[0]['IdPro']);
        console.log(response[0]['IdPro']);

        $('#IdArt').val(checked.val());
        console.log(checked.val());

        console.log(response);
    });

   request.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('The following error occurred: ' + textStatus, errorThrown);
   });

});

$('#izmeniForm').submit(function () {
    event.preventDefault();
    console.log("Izmena");
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    console.log($inputs);
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

    reqest = $.ajax({
        url: "handler/update.php",
        type: "post",
        data: serializedData,
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            console.log('Artikl je izmenjen');
            location.reload();
        }
        else console.log('Artikl nije izmenjen ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });


});

$('#btn-pretraga').click(function () {

    var para = document.querySelector('#myInput');
    console.log(para);
    var style = window.getComputedStyle(para);
    console.log(style);
    if (!(style.display === 'inline-block') || ($('#myInput').css("visibility") ==  "hidden")) {
        console.log('block');
        $('#myInput').show();
        document.querySelector("#myInput").style.visibility = "";
    } else {
       document.querySelector("#myInput").style.visibility = "hidden";
    }
});

$('#btn').click(function () {
    $('#pregled').toggle();
});

$('#btnDodaj').submit(function () {
    $('#myModal').modal('toggle');
    return false;
});

$('#btnIzmeni').submit(function () {
    $('#myModal').modal('toggle');
    return false;
});

