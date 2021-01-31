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

<button  class="fiszki" id="przycisk">NAUKA</button>
<button  class="zestawy" id="zestawy">ZARZĄDZAJ ZESTAWAMI</button>

</div>

<?php
// menu
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
            wyszukaj_zestaw();
            importuj_baze_danych();
            exportuj_baze_danych();
            wyloguj();
echo '
           </div>
   </div>
</div>'
;

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
    $pdo ->query($query) or die('Błąd zapytania CREATE TABLE');
    $querty = "INSERT INTO info_table (name_table, flaga) VALUES ('$db_name', '0')";
    $pdo ->query($querty) or die('Błąd zapytania INSERT INTO');
    
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
    $querty = "DROP table $db_name";
    $pdo ->query($querty) or die('Błąd zapytania DROP');
    $querty = "DELETE FROM info_table WHERE name_table = '$db_name'";
    $pdo ->query($querty) or die('Błąd zapytania DELETE');
    
    header("Location: tryb_wyboru.php");
      
    }
    catch(PDOException $e)
    {
       echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
       echo '</br><a href="tryb_wyboru.php">wróć</a>';
    }
    
break;
case 'wyszukaj_zestaw':
    // defincja db_name przychodzi z formlarza 
    $db_name = $_POST['databasename'];

    if (empty($db_name)){
        echo "Taka nazwa bazy danych nie istnieje";
    }
     
    try
    {
    $querty = "SELECT table_name  FROM information_schema.tables where table_schema='fiszki_nauka_slowek' AND table_name LIKE '$db_name'";
    $liczba = $pdo ->query($querty) or die('Nie znaleziono wybranej bazy danych');
    $wykonanie = $pdo->prepare($querty);
    $wykonanie->execute();
    $licznik_id=$wykonanie->rowCount();
        printf("<h2>WYSZUKANA BAZA DANYCH</h2>");
                    while($row = $liczba->fetch())
                              {                 
        printf("<div class='select'><button>".$row[0]."</button></div>");
                              }

    }
    catch(PDOException $e)
    {
       echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
       echo '</br><a href="tryb_wyboru.php">wróć</a>';
    }
break;
case 'importuj_beze_danych':

break;
default:                  

printf('<div>');
    require_once "table_select_admin.php" ; 
printf('</div>');
       
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

function wyszukaj_zestaw(){
    echo' <div></br>
                <h1>Wyszukiwanie zestawu</h1>
                <form action="tryb_wyboru.php?zestaw=wyszukaj_zestaw" method="post">
                    Wyszukaj zestaw: 
                        <input type="text" name="databasename">
                        <input class="submit" type="submit" value="Wyszukaj">
                </form>
          </div>';  
}

function importuj_baze_danych(){

          echo '</br><div class="import" ><form action="tryb_wyboru.php?zestaw=importuj_baze_danych" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Importuj dane z pliku CSV </legend>

                        <!-- File Button -->
                        <div style="float:left" class="form-group">
                            <label style="float:left" class="col-md-4 control-label" for="filebutton">Wybrany plik</label>
                            <div class="col-md-4">
                                <input type="file" name="file" required>
                            </div>
                        </div>
						
                        <!-- Button -->
                        <div style="float:left" class="form-group">
                            <label style="float:left" class="col-md-4 control-label" for="singlebutton">Importuj plik</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Wyślij</button>
                            </div>
                        </div>
						
                    </fieldset>
                </form></div>';
}

function exportuj_baze_danych(){
      echo '<div class="import"><form class="form-horizontal" action="tryb_wyboru.php?zestaw=exportuj_baze_danych" method="post" name="upload_excel" enctype="multipart/form-data">
                  <fieldset>
                   <!-- Form Name -->
                   <legend>Exportuj dane z pliku CSV </legend>
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <input type="submit" name="Export" class="btn btn-success" value="export to excel"/>
                            </div>
                        </div>
                 </fieldset>                    
            </form></div>';
}
function wyloguj(){
    echo'<div>
                    <a href="table_settings/log_out.php">WYLOGUJ</a>
         </div>';
}

?>
</body>

<script>
 $('.select button').click(function(){
            $('.select button').removeClass('active')
            console.log(this.classList.add('active'))
        })

const menu_click = document.querySelector('.menubutton').addEventListener('click', (e) => {
    document.querySelector('.menu').classList.toggle('active');
});


  $("button").on('click',function(){
    var zestaw = $( this ).text();
        window.document.location.href="tryb_edycji.php?zestaw="+zestaw;
        return false;
  });



  $('#przycisk').click(function(){
    window.document.location.href="fiszki.php";
    return false;
  });



  $('#zestawy').click(function(){
    window.document.location.href="tryb_wyboru.php";
    return false;
  });

</script>
