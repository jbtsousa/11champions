<?php

//adicionar jogo
    $ndata = $_GET['new_date'];
    $neq1 = $_GET['new_eq1'];
    $neq2 = $_GET['new_eq2'];
    $ngolos1 = $_GET['new_golos1'];
    $ngolos2 = $_GET['new_golos2'];
    $njornada = $_GET['new_jornada'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "insert into jogos (data, jornada, equipa1_id, equipa2_id, equipa1_golos,equipa2_golos) 
    values ('$ndata','$njornada','$neq1','$neq2','$ngolos1','$ngolos2')") or die;
    header("location: admin.php");


?>





