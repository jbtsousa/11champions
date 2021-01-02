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
                $golo_autor= pg_query($conn,"select jogador.nome  from golo,jogador where jogador.id= golo.jogador_id and golo.jogador_id is not null") or die;

                $ult_p = pg_query($conn, "SELECT MAX( jornada ) AS max FROM jogos where equipa1_golos is not null") or die;

                ?>
        <div id="passados">
            <h2>JOGOS PASSADOS</h2>

            <?php
            //ver a ultima jornada dos jogos que ja aconteceram
            $row = pg_fetch_array($ult_p);
            $tot = $row['max'];

            //corre todos as jornadas
            echo "<div class='jornadas_grid' >";

                for ($j = 1; $j < $tot + 1; $j++) {
                    $result_jornada = pg_query($conn, "select * from jogos where jornada='$j'") or die;
                    $num = pg_affected_rows($result_jornada);
                    echo "<div class='jornada' >";
                        echo "<br>". "Jornada " . $j."</br>";
                        for ($i = 0; $i < $num; $i++) {
                            $row_jornadap = pg_fetch_assoc($result_jornada);
                            $eq_1=pg_fetch_assoc($equipa1);
                            $eq_2=pg_fetch_assoc($equipa2);
                            //id jo jogo em que estamos para ir ver à tabela golo
                            $id_jogo=$row_jornadap['id'];
                            $result_golo = pg_query($conn,"select * from golo where jogo_id= $id_jogo") or die;
                            $num_golos=pg_affected_rows($result_golo);

                            echo
                                "<br/>".$row_jornadap['data']."<br/>"
                                .$eq_1['nome']." ". $row_jornadap['equipa1_golos'] ."-". $row_jornadap['equipa2_golos'] ." ".$eq_2['nome'] . "<br/>";

                           //corre os golos todos do jogo em que estamos
                            echo "<div class='minutos'>";
                            for($g=0;$g<$num_golos;$g++){
                                $row_golo= pg_fetch_assoc($result_golo);
                                $row_goloa=pg_fetch_assoc($golo_autor);
                                echo $row_goloa['nome']." ".$row_golo['minuto'] . "' ";
                            }
                            echo "</div>";
                            echo "<br/>";
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
