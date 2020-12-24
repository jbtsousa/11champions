<?php


//adicionar jogo
    $id = $_GET['id_jogo'];
    $resultado = $_GET['edit_resultado'];
    $neq2 = $_GET['new_eq2'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "UPDATE jogos SET resultado ='$resultado' where id= '$id'") or die;
    $result2 = pg_query($conn, "select * from jogos") or die;
    header("location: admin.php");


?>





