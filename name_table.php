<?php
  include "baza.php";
 // include "table_select.php";
                     $result=mysqli_query($connect,$query);//wyszukuje nazwy tabel z db
                     while ($row = mysqli_fetch_array($result)) 
                     {
                        echo '<label><input class="pokaz-tabele" type="radio" name="word_operation" value="'.$row[0].'" checked>'.$row[0].'</label>';
                     }
                     
                    
 /* Gdańsk 
24 grudnia

Wraz z kolegą realizujemy film o aborcji (17 minut),  bo tyle mamy czasu do wykorzystania na emisji w TV TRWAM. Ograliśmy Artura Ważnego (obecnie nowy biskup pomocniczy diecezji Tarnowskiej, egzorcysta który wraz z siostrą Małgorzatą prowadzą rekolekcje Winnica Racheli do kobiet po aborcji, są one oparte na standardowym programie psychologicznym zintegrowane z wrzutką proklamowania dobrej nowiny). Tematem filmu są skutki grzechu aborcji, stąd też jego tytuł "Oszukane" w kontekście fali strajków które przeszły przez Polskę. Materiał w podsumowaniu miałby wskazać drogę do pojednania się z Panem Bogiem, sobą i nienarodzonym dzieckiem po przez zachęcenie kobiet potrzebujących do uczestnictwa w rekolekcjach "Winnica Racheli".
Chciałbym dopełnić go świadectwem osoby po aborcji, lecz te kobiety które uczestniczą w tych rekolekcjach nie są jeszcze gotowe by się tym dzielić. Jedna siostra Wiesława ma takie doświadczenie i dzieliła się między innymi tym w "Radiu Niepokalanów", ale nie mamy do niej kontaktu.  */
 
?>
 

