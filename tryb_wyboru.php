<?php
include('baza.php');//sprawdzam połączenie
if(!$connect){
    header('location: index.php');//przekierowanie do logowania
}
require_once('polaczeniePDO.php');
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
            <? require_once "table_select_admin.php" ; ?> 
            </div>
</br>
</div>
<?php
// poruszanie sie po stronie
if(!isset($_GET['zestaw']))   {

    $_GET['zestaw'] = 'zestaw';
 
 }
// zarzadzanie zestawami
switch($_GET['zestaw']){

case 'dodaj_zestaw':
    // dodaje tak naprawdę dwa zestawy pierwszy z informacja o słówkach drugi z miejscem na nie
    // schemat tabel:
    
    /* :: tutaj flaga decyduje czy dany zestaw jest aktywny
        ---------------------------
       - id - name_table - flaga -
       ---------------------------
       -  1 -   Unit_1   -   1   -  
       -    -            -       -
       --------------------------- 
       
       :: tutaj flaga decyduje czy danego słówka w danej chwili chcemy się uczyć 
       ---------------------------------
       - id - v1 - v2 - zdanie - flaga -
       ---------------------------------
       -    -    -    -        -       -
       -    -    -    -        -       -
       ---------------------------------  */
       // formularz który zdefinuje zmienną db_name
       //  $query = "CREATE TABLE $db_name ( id INT NOT NULL AUTO_INCREMENT ,  v1 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  v2 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  weight INT NOT NULL ,    PRIMARY KEY  (id)) ENGINE = InnoDB";

    $db_name = $_POST['databasename'];
    
    if (empty($db_name)){
        echo "Taka nazwa bazy danych nie istnieje";
        //header("Location: tryb_wyboru.php");
    }
     
    try
    {
    $query = "CREATE TABLE $db_name ( id INT NOT NULL AUTO_INCREMENT ,  v1 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  v2 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  weight INT NOT NULL ,    PRIMARY KEY  (id)) ENGINE = InnoDB";
    $pdo ->query($query) or die('Błąd zapytania');
    // aktualizuję tablicę z informacją o aktywności tablic
    // miejsce na dane musi pojawić się w momencie pierwszego logowania do strony 
    $querty = "INSERT INTO info_table (name_table, flaga) VALUES ('$db_name', '0')";
    header("Location: tryb_wyboru.php");
      
    }
    catch(PDOException $e)
    {
       echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
       echo '</br><a href="tryb_wyboru.php">wróć</a>';
    }
    
break;
case 'usun_zestaw':
    // defincja db_name przychodzi z formlarza 
    $db_name = $_POST['databasename'];

    if (empty($db_name)){
        echo "Taka nazwa bazy danych nie istnieje";
    }
     
    try
    {
    $pdo ->query("DROP table $db_name") or die('Błąd zapytania');
    header("Location: tryb_wyboru.php");
      
    }
    catch(PDOException $e)
    {
       echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
       echo '</br><a href="tryb_wyboru.php">wróć</a>';
    }
    
break;
case 'modyfikuj_nazwe_zestawu';
break;
default:                  
echo '
<div class="menu">
   <div class="menubutton"><i class="icon-cog-alt"></i>
   </div>
   <div class="menu-content"> 
           <div>
            <h1>Operacje na zestawach</h1>'
;
            dodaj_zestaw();
            usun_zestaw();
            wyloguj();
echo '
           </div>
   </div>
</div>'
;
       
break;                    

} // zamykający swittch

function dodaj_zestaw(){
   // formularz tworzy wartość string zmiennej db_name
    echo '<div></br>
                <h1>Dodawanie nowej tabeli</h1>
                <form action="tryb_wyboru.php?zestaw=dodaj_zestaw" method="post">
                    Nazwa nowej tabeli:
                        <input type="text" name="databasename">
                        <input class="submit" type="submit" value="Dodaj">
                </form>
         </div>';
    
}     

function usun_zestaw(){
    // formularz tworzy i definuje zmienną db_name
    echo' <div></br>
                <h1>Usuwanie tabel</h1>
                <form action="tryb_wyboru.php?zestaw=usun_zestaw" method="post">
                    Nazwa usuwanej tabeli: 
                        <input type="text" name="databasename">
                        <input class="submit" type="submit" value="Usuń">
                </form>
          </div>';   
}               

function wyloguj(){
    echo'<div>
                    <a href="table_settings/log_out.php">WYLOGUJ</a>
         </div>';
}

?>
</body>

<script>

const menu_click = document.querySelector('.menubutton').addEventListener('click', (e) => {
    document.querySelector('.menu').classList.toggle('active');
});

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
