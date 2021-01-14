<?php 
//Dzięki temu plikowi można wybrać której tabeli słówek w danej chwili się uczysz, chciałbym to zamienić by aktywną tabelę ustawiało się bezpośrednio w ustawieniach po przez dodanie flagi w bazie danych   AND DATA_FREE='0'"; //

        $query = "SELECT table_name  FROM information_schema.tables where table_schema='fiszki_nauka_slowek' AND data_free='0'";//wyszukuje nazwy tabel z db
        $result=mysqli_query($connect,$query); 
        $count = 0;
        while ($row = mysqli_fetch_array($result)) {
             echo '<button>'.$row[0]."</button>";
            $count++;
        }
    if($count == 0){//gdy nie ma żadnej tabeli dodaj fiszki
        $query = "CREATE TABLE fiszki_nauka_slowek.fiszki ( id INT NOT NULL AUTO_INCREMENT ,  v1 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  v2 VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,  weight INT NOT NULL,  PRIMARY KEY  (id)) ENGINE = InnoDB";
        $result=mysqli_query($connect,$query);
        //wyświetlanie przedchwilo dodanej tabeli fiszki
        $query = "SELECT table_name  FROM information_schema.tables where table_schema='fiszki_nauka_slowek'";
       $result=mysqli_query($connect,$query); 
        $count = 0;
        while ($row = mysqli_fetch_array($result)) {
            echo '<button>'.$row[0]."</button>";
            $count++;
        }
    }  
?>
