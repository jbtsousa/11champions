<?php


//adicionar jogo
    $ndata = $_GET['new_date'];
    $neq1 = $_GET['new_eq1'];
    $neq2 = $_GET['new_eq2'];
    $nresultado = $_GET['new_resultado'];
    $njornada = $_GET['new_jornada'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "insert into jogos (data, resultado, jornada, equipa_id, equipa_id1) 
    values ('$ndata','$nresultado','$njornada','$neq1','$neq2')") or die;
    $result2 = pg_query($conn, "select * from equipa") or die;


?>





