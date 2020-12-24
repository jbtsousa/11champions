<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/calendario.css">
    <title>Calendário</title>
</head>
<body>
<navbar>
    <a href="index.php"><img src="css/images/logo.svg"></a>

    <ul>
        <a href="jogadores.php"><li>JOGADORES</li> </a>
        <a href="equipas.php"><li>EQUIPAS</li></a>
        <a href="classif.php"><li>CLASSIFICAÇÕES</li></a>
        <a href="calendario.php"><li>CALENDÁRIO</li></a>

    </ul>
</navbar>

<?php
//para aceder à base de dados
$str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
$conn = pg_connect($str) or die("Erro na ligação");
//para o todos os jogadors
$result_jog = pg_query($conn,"select * from jogos") or die;
$numjogos = pg_affected_rows($result_jog);



?>

<main>
    <div id="calend">



                <?php
                $equipa1 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id; ") or die;
                $equipa2 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id1; ") or die;
?>

        <div id="passados">
            <h2>JOGOS PASSADOS</h2>

            <?php
                $result_jornadap= pg_query($conn,"select * from jogos where data<'2020-12-23'order by data,jornada") or die;
                $nump=pg_affected_rows($result_jornadap);

            for ($i=0; $i<$nump; $i++){

                    $row_jornadap=pg_fetch_assoc($result_jornadap);
                    $eq_1=pg_fetch_assoc($equipa1);
                    $eq_2=pg_fetch_assoc($equipa2);
                    $j=$i+1;

                   if ($i % 4 == 0){
                        echo "<h3>" . "Jornada " . $row_jornadap['jornada'] . "</h3>";}
                        echo
                        "<br/>".$row_jornadap['data']."<br/>"
                        .$eq_1['nome']." ".$row_jornadap['resultado']." ".$eq_2['nome'] . "<br/>";
                }
            ?>

        </div>

        <div id="futuros"">
            <h2>JOGOS FUTUROS</h2>
        <?php
        $result_jornadaf= pg_query($conn,"select * from jogos where data>='2020-12-23'order by data,jornada") or die;
        $numf=pg_affected_rows($result_jornadaf);

        for ($i=0; $i<$numf; $i++){
            $row_jornadaf=pg_fetch_assoc($result_jornadaf);
            $eq_1=pg_fetch_assoc($equipa1);
            $eq_2=pg_fetch_assoc($equipa2);
            if ($i%4 ==0){
                echo "<h3>" . "Jornada " . $row_jornadaf['jornada'] . "</h3>";}

            echo
                "<br/>".$row_jornadaf['data']."<br/>"
                .$eq_1['nome']." ".$row_jornadaf['resultado']." ".$eq_2['nome'] . "<br/>";
        }

        ?>
        </div>


    </div>
</main>

</body>
</html>

<?php
//ver o numero total de jornadas
$total_jornadas=pg_query($conn,"SELECT MAX( jornada ) AS max FROM jogos") or die;
$row = pg_fetch_array( $total_jornadas );
$tot = $row['max'];

//corre todos as jornadas
for($j=1; $j<$tot+1;$j++){
    $result_jornada= pg_query($conn,"select * from jogos where jornada='$j'") or die;
    $num=pg_affected_rows($result_jornada);
    echo "<br/>"."Jornada". $j;
    for ($i=0; $i<$num; $i++) {
        $row_jornada=pg_fetch_assoc($result_jornada);
        echo
            "<br/>".'Data'.$row_jornada['data']."<br/>"
            .' Resultado:'.$row_jornada['resultado'] . "<br/>"
            . "</div>";

    }
}
pg_close($conn);
?>