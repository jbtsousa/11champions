<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/classif.css">
    <title>Classificações</title>
</head>
<body>
<navbar>
    <a href="index.php"><img src="css/images/logo.svg"></a>

    <ul>
        <a href="jogadores.php">
            <li>JOGADORES</li>
        </a>
        <a href="equipas.php">
            <li>EQUIPAS</li>
        </a>
        <a href="classif.php">
            <li>CLASSIFICAÇÕES</li>
        </a>
        <a href="calendario.php">
            <li>CALENDÁRIO</li>
        </a>

    </ul>
</navbar>

<main>
    <div>
        <?php
        //para aceder à base de dados
        $str = "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
        $conn = pg_connect($str) or die("Erro na ligação");
        $result_equipa = pg_query($conn, 'select * from equipa') or die;
        $numequipa = pg_affected_rows($result_equipa);
        ?>
    </div>

    <div>
        <div id="tabela">
            <table class="classifica">
                <tr>
                    <th>Nome</th>
                    <th>Nº Jogos</th>
                    <th>Vitórias</th>
                    <th>Derrotas</th>
                    <th>Empates</th>
                    <th>Golos</th>
                    <th>Pontuação</th>
                </tr>

                <?php
                for ($i = 0;$i < $numequipa;$i++) {
                    $row_e = pg_fetch_assoc($result_equipa);
                    $equipa=$i+1;
                    //calcula numero de jogos efctuados
                    $jogos_visitado=pg_query($conn, "SELECT COUNT(equipa_id) FROM jogos WHERE equipa_id='$equipa'") or die;
                    $jogos_visitante=pg_query($conn, "SELECT COUNT(equipa_id1) FROM jogos WHERE equipa_id1='$equipa'") or die;
                    $num_visitado = pg_fetch_array($jogos_visitado);
                    $num_visitante = pg_fetch_array($jogos_visitante);
                    $tot_jogos_equipa= $num_visitado['count'] + $num_visitante['count'];
                    //
                    echo
                    "<tr>"
                    ."<td>" . $row_e['nome'] . "</td>"
                    ."<td>" . $tot_jogos_equipa. "</td>"
                    ."</tr>";
                }

                ?>
            </table>
        </div>
    </div>


    </div>
</main>

</body>
</html>