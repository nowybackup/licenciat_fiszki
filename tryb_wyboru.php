<?php

include('baza.php');//sprawdzam połączenie
if(!$connect){
    header('location: index.php');//przekierowanie do logowania
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>

<body>
<h2>PANEL ADMINISTRACYJNY</h2>

<div class="select" >

<button  id="przycisk">NAUKA</button>
<button  id="zestawy">ZARZĄDZAJ ZESTAWAMI</button>

</div>

<div>
<h2>TRYB WYBORU</h2>
            <div id="select_admin" class="select_admin">
            <?php
                            require_once "table_select_admin.php" ;
            ?>
            </div>
</br>
</div>
</body>

<script>

$(document).ready(function(){
  $("button").on('click',function(){
    var zestaw = $( this ).text();
        window.document.location.href="tryb_edycji.php?zestaw="+zestaw;
        return false;
  });
});

$(document).ready(function(){
  $('#przycisk').click(function(){
    window.document.location.href="fiszki.php";
    return false;
  });
});

$(document).ready(function(){
  $('#zestawy').click(function(){
    window.document.location.href="tryb_wyboru.php";
    return false;
  });
});
</script>
