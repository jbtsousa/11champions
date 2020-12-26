<?php


//adicionar jogo
    $id = $_GET['id_jogo'];
    $egolos1 = $_GET['edit_golos1'];
    $egolos2 = $_GET['edit_golos2'];
    $neq2 = $_GET['new_eq2'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result1 = pg_query($conn, "UPDATE jogos SET equipa1_golos ='$egolos1' where id= '$id'") or die;
$result1 = pg_query($conn, "UPDATE jogos SET equipa2_golos ='$egolos2' where id= '$id'") or die;

header("location: admin.php");


?>





