
<?php
//adicionar equipa
    $nequipa = $_GET['new_nomeeq'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "insert into equipa (nome) values ('$nequipa')") or die;
    $result2 = pg_query($conn, "select * from equipa") or die;
    header("location: admin.php")

?>







