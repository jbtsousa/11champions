<?php

//adicionar minuto e jogador a jogo
    $id = $_GET['id_golo'];
    $jogador = $_GET['edit_jogador'];
    $minuto = $_GET['edit_minuto'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "UPDATE golo SET jogador_id ='$jogador' where id='$id'") or die;
    $result = pg_query($conn, "UPDATE golo SET minuto ='$minuto' where id= '$id'") or die;
    $result2 = pg_query($conn, "select * from jogos") or die;
    header("location: admin.php");

?>





