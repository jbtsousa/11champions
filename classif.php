<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <title>Classificações</title>
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

<main>
    <div>
        <?php
    //para aceder à base de dados
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligação");
    $result_equipa = pg_query($conn, 'select * from equipa') or die;
    $numequipa = pg_affected_rows($result_equipa);
    ?>
    </div>

    <div>
        <div id="equipas">
            <p>Todas as equipas:</p>
            <?php
        echo "(Número total de equipas: " . $numequipa .")";
        ?>

            <div class="grid">

                <?php
            for ($i=0; $i<$numequipa; $i++){
                echo "<div class='equipa'>";
                $row_e=pg_fetch_assoc($result_equipa);
                //i começa no 0 e nao há equipa com id 0, logo tem q se somar 1 p começar no 1
                $id_equipa=$i+1;
                $result_jogador = pg_query($conn,"select jogador.nome from jogador where jogador.equipa_id='$id_equipa'; ") or die;
                $numjogad = pg_affected_rows($result_jogador);

                echo
                "<p>".$row_e['nome']."</p>"
                . ' Pontuação: '. $row_e['pontuacao']  . "<br/>"
                . 'Nº jogos efectuados: ' . $row_e['num_jogos_efect']
                ."<br/>".'Jogadores:';

                for ($j=0;$j<$numjogad;$j++){
                $row_j= pg_fetch_assoc($result_jogador);
                echo
                "<br/>".$row_j['nome'];
                }
                echo "</div>";
            }
            ?>

        </div>
    </div>





    </div>
</main>

</body>
</html>