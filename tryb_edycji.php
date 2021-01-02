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
</div>
<h2>TRYB EDYCJI</h2>

<?php

function filtruj($zmienna) {
    if (get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe

// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return htmlspecialchars(trim($zmienna));
}

                            // typ pierwszy angielsko - poslki i polsko - angielski
                            $tabela = $_GET['zestaw'];
                            echo "<div class='text'><h2>$tabela</h2></div>"; 

                            // kolumny tabeli bazy danych
                            $mysqli = new mysqli('localhost', $_SESSION['fiszki_login'],$_SESSION['fiszki_password'], 'fiszki_nauka_slowek');
                            $angielski = 'v1';
                            $polski = 'v2';
                            $przyklad = 'weight';
                            $zdanie = 'zdanie';
                            $flaga_baza = 'flaga';
                        
                            // poruszanie sie po stronie
                            if(!isset($_GET[$tabela]))   {
                          
                                $_GET[$tabela] = 'panel_administracyjny';
                             
                             }
                            // zarzadzanie zestawami
                           switch($_GET[$tabela]){

                                  case 'dodaj':
                              
                                    $flaga = 1;

                                    if ($flaga == 1 && empty($_POST['dodaj_element1']) || empty($_POST['dodaj_element2'])){
	                                $flaga = 0;
                                        exit(header("Location: tryb_edycji.php?zestaw=$tabela"));
                                    }

                                    if ($flaga == 1){
                                        if ($mysqli->connect_error != 0) {
		                                $flaga = 0;
                                                echo "Error:" . $mysqli->connect_errno;
                                        }
                                    } 

                                   if ($flaga == 1){

                                            $dodaj_element1 = filtruj($_POST['dodaj_element1']);
                                            $dodaj_element2 = filtruj($_POST['dodaj_element2']);
                                            $dodaj_element3 = filtruj($_POST['dodaj_element3']);
                                                  
                                                if($flaga == 1 && $_SERVER['REQUEST_METHOD'] == 'POST'){
                                                    
                                                         if ($flaga == 1 && $_POST['dodaj_element1'] == $dodaj_element1  && $_POST['dodaj_element2'] == $dodaj_element2 && $_POST['dodaj_element3'] == $dodaj_element3) {
                                               try
                                               {
                                                  $pdo = new PDO('mysql:host=localhost;dbname=fiszki_nauka_slowek', 'root', '');
                                                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$zapytanie = "SELECT id FROM $tabela";
$wykonanie = $pdo->prepare($zapytanie);
$wykonanie->execute();
$licznik_id=$wykonanie->rowCount();
$licznik_id=$licznik_id+1;

                                                      $liczba = $pdo ->exec("INSERT INTO $tabela (id, $angielski, $polski, $przyklad , $zdanie, $flaga_baza ) VALUES ('$licznik_id','$dodaj_element1', '$dodaj_element2', '1', '$dodaj_element3', '0')");

                                                echo $sql;
                                                }
                                               catch(PDOException $e)
                                               {
                                                  echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
                                                  echo '</br><a href="tryb_edycji.php?zestaw='.$tabela.'">wróć</a>';
                                               }

                                                                   $flaga = 0;
                                                                   exit(header("Location: tryb_edycji.php?zestaw=$tabela"));

                                                 	   } 
		                                 }

                                                 if($flaga == 1){
			                            $flaga = 0;
                                                    echo "<div align=\"center\">Wystąpił błąd</div>";
			                            echo $dodaj_element1, $dodaj_element2, $dodaj_element3;
                                                    echo '<p></br><a href="tryb_edycji.php?zestaw='.$tabela.'">Spróbuj jeszcze raz!</a></p>';
                                                 }
                                                    

                                                if($flaga == 1){
		                                    $flaga = 0;
                                                    exit(header("Location: tryb_edycji.php?zestaw=$tabela"));
                                                }
                             	}     
                                    
                                  break;
                                  
                                  case 'edytuj':
                                     $id = $_GET['id'];
                                     $id = filtruj($id);

	                             $flaga = 1;

                                     if ($flaga == 1 && empty($id)){
	                                 $flaga = 0;
                                         echo"Wystąpił następujący błąd: Nieprawidłowy numer 'id'";
                                     }
                                          
                                     if ($flaga == 1 && empty($_POST['a'.$id.'']) || empty($_POST['b'.$id.''])){
	                                 $flaga = 0;
                                         header("Location: tryb_edycji.php?zestaw=$tabela");
                                     }

                                     if ($flaga == 1) {
                                          $edytuj_element1 = filtruj($_POST['a'.$id.'']);
                                          $edytuj_element2 = filtruj($_POST['b'.$id.'']);
                                          $edytuj_element3 = filtruj($_POST['c'.$id.'']);
                                          
                                          if ($_POST['a'.$id.''] == $edytuj_element1  && $_POST['b'.$id.''] == $edytuj_element2 && $_POST['c'.$id.''] == $edytuj_element3) {
                                               try
                                               {
                                                  $pdo = new PDO('mysql:host=localhost;dbname=fiszki_nauka_slowek', 'root', '');
                                                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                      $liczba = $pdo ->exec("UPDATE $tabela SET  v1 = '$edytuj_element1' , v2 = '$edytuj_element2', weight = '1'  , zdanie = '$edytuj_element3' WHERE id = '$id' ");
                                                      header("Location: tryb_edycji.php?zestaw=$tabela");
                                                  
                                               }
                                               catch(PDOException $e)
                                               {
                                                  echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
                                                  echo '</br><a href="tryb_edycji.php?zestaw='.$tabela.'">wróć</a>';
                                               }
                                          }
                                          else {
                                              echo "</br>Wystąpił błąd";
                                          }
                                         
                                      }
                               
                                  break;
                               
                                  case 'usun':
                                      
                                     $id = $_GET['id'];
                                     $id = filtruj($id);

	                             $flaga = 1;

                                     if ($flaga == 1 && empty($id)){
	                                 $flaga = 0;
                                         echo "Nie udało się usunąć wiersza tabeli";
                                     }
                                     
	                             if ($flaga == 1) {
                                          	   try
                                               {
                                                  $pdo = new PDO('mysql:host=localhost;dbname=fiszki_nauka_slowek', 'root', '');
                                                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                      $liczba = $pdo ->exec("DELETE FROM $tabela WHERE id = '$id' ") or die('Błąd zapytania');
                                                      header("Location: tryb_edycji.php?zestaw=$tabela");
                                                  
                                               }
                                               catch(PDOException $e)
                                               {
                                                  echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
                                                  echo '</br><a href="tryb_edycji.php?zestaw='.$tabela.'">wróć</a>';
                                               }

                              	}
                                  break;
                                  
                                  case 'wyszukaj':
                                  
                                  $slowo = $_POST['slowo'];
                                  $slowo = filtruj($slowo);

	                             $flaga = 1;

                                     if ($flaga == 1 && empty($slowo)){
	                                 $flaga = 0;
                                         echo "Nie można wyszukać słowa";
                                         header("Location: tryb_edycji.php?zestaw=$tabela");
                                     }
                                     
	                             if ($flaga == 1) {
                                          	  try
                                              {
                                              $pdo = new PDO('mysql:host=localhost;dbname=fiszki_nauka_slowek', 'root', '');
                                              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                              $zapytanie = "SELECT * FROM $tabela WHERE $polski OR $angielski LIKE '$slowo'";                 
                                              $liczba = $pdo ->query($zapytanie) or die('Błąd zapytania');
                                              $wykonanie = $pdo->prepare($zapytanie);
                                              $wykonanie->execute();
                                              $licznik_id=$wykonanie->rowCount();
                         echo $licznik_id;
                                                 if ($licznik_id == 0){
                                                        
                                                        header("Location: tryb_edycji.php?zestaw=$tabela");
                                                 }
                                                 else {
                                                        while($row = $liczba->fetch())
                                                                      {                 
                                                                      wyswietlam($tabela, $row);
                                                                      }
                                                 }
                                                                                                   
                                                      //header("Location: tryb_edycji.php?zestaw=$tabela");
                                                  
                                              }
                                              catch(PDOException $e)
                                              {
                                                  echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
                                                  echo '</br><a href="tryb_edycji.php?zestaw='.$tabela.'">wróć</a>';
                                              }

                              	}
                                  
                                  break;
                                 
                                  default:  
                                   
                                         formularz();
                                         try
                                           {
                                              $pdo = new PDO('mysql:host=localhost;dbname=fiszki_nauka_slowek', 'root', '');
                                              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                              $liczba = $pdo -> query("SELECT * FROM $tabela");

                                              
                                              while($row = $liczba->fetch())
                                              {
                                              wyswietlam($tabela, $row);
                                              }
                                                                                      
                                                                                      
                                           }
                                           catch(PDOException $e)
                                           {
                                              echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
                                           }

                            }

?>
</body>

<?
  function formularz(){
      $tabela = $_GET['zestaw'];
      echo '<div class="nowe_slowo"><form method="post" action="tryb_edycji.php?zestaw='.$tabela.'&'.$tabela.'=dodaj">
            Wyrażenie polskie:
            <input type="text" name="dodaj_element1" style="width: 250px">
        </br>
            Wrażenie hiszpańskie:
            <input type="text" name="dodaj_element2" style="width: 250px">
        </br>
            Przykładowe zdanie:
            <input type="text" name="dodaj_element3" style="width: 250px">
        </br>
            <input type="submit" name="submit" value="Wyślij">&nbsp;
        <input type="reset" value="Wyczyść formularz"></br></form>
        
    </div><div class="nowe_slowo">
    <form method="post" action="tryb_edycji.php?zestaw='.$tabela.'&'.$tabela.'=wyszukaj">
    Wyszukaj słowo:
            <input type="text" name="slowo" style="width: 250px">
        </br>
            <input type="submit" name="submit" value="Wyślij">&nbsp;
            <input type="reset" value="Wyczyść formularz">
    
    </div>';
  }
  
  function wyswietlam($tabela, $row){
    $id = $row['id'];
    echo '<div class="arkusz"v><div class="edytuj">
      <form method="post" action="tryb_edycji.php?zestaw='.$tabela.'&'.$tabela.'=edytuj&id='.$row['id'].'">
         <input type="text" name="a'.$id.'" placeholder="Wyrażenie polskie:" value="'.$row['v1'].'">
         <input type="text" name="b'.$id.'" placeholder="Wrażenie angielskie:"  value="'.$row['v2'].'">
         <input type="text" name="c'.$id.'" placeholder="Przykładowe zdanie" value="'.$row['zdanie'].'">
         <input type="submit" name="submit" value="Edytuj!"></form></div>'.
		'<div class="usun"><form method="post" action="tryb_edycji.php?zestaw='.$tabela.'&'.$tabela.'=usun&id='.$row['id'].'">
		 <input type="submit" name="submit" value="Usuń!"></form></div></div></br>';
  }

?>

<script>
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
