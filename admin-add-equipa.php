
<?php
//adicionar equipa
    $nequipa = $_GET['new_nomeeq'];
    $npontuacao = $_GET['new_pontuacao'];
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligacao");
    $result = pg_query($conn, "insert into equipa (nome, pontuacao,num_jogos_efect) values ('$nequipa','$npontuacao','0')") or die;
    $result2 = pg_query($conn, "select * from equipa") or die;
    ?>





