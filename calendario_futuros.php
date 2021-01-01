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
        <div class="dropdown">
            <button class="dropbtn">CALENDÁRIO
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="calendario_passados.php">Jogos Passados</a>
                <a href="calendario_futuros.php">Jogos Futuros</a>
            </div>
        </div>
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
                $equipa1 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa1_id; ") or die;
                $equipa2 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa2_id; ") or die;
?>

        <div id="futuros"">
            <h2>JOGOS FUTUROS</h2>

        <?php
        //ver o primeiro dos jogos que ainda n aconteceram
        $prim_f = pg_query($conn, "SELECT MIN( jornada ) AS min FROM jogos where equipa1_golos is null") or die;
        $row = pg_fetch_array($prim_f);
        $primeiro = $row['min'];
        //ver a ultima jornada dos jogos que ainda nao aconteceram
        $ult_f = pg_query($conn, "SELECT MAX( jornada ) AS max FROM jogos where equipa1_golos is null") or die;
        $row = pg_fetch_array($ult_f);
        $ultimo = $row['max'];

        //corre todos as jornadas
        echo "<div class='jornadas_grid' >";

        for ($j = $primeiro; $j < $ultimo ; $j++) {
            $result_jornada = pg_query($conn, "select * from jogos where jornada='$j' order by id") or die;
            $num = pg_affected_rows($result_jornada);
            echo "<div class='jornadas_grid' >";
            echo "<br>". "Jornada " . $j."</br>";
            for ($i = 0; $i < $num; $i++) {
                $row_jornadap = pg_fetch_assoc($result_jornada);
                $eq_1=pg_fetch_assoc($equipa1);
                $eq_2=pg_fetch_assoc($equipa2);
                echo
                    "<br/>".$row_jornadap['data']."<br/>"
                    .$eq_1['nome']." ". $row_jornadap['equipa1_golos'] ."-". $row_jornadap['equipa2_golos'] ." ".$eq_2['nome'] . "<br/>"
                ;
            }
            echo "</div>";
        }
        echo "</div>";
        pg_close($conn);

        ?>
        </div>


    </div>
</main>

</body>
</html>
