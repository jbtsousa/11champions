<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/jogadores.css">
    <title>11Champions</title>

</head>
<body>

<div>
    <?php
    //para aceder à base de dados
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligação");
    //para o todos os jogadors
    $result_jog = pg_query($conn,"select * from jogador") or die;
    //para o todos os jogadores de uma certa equipa
    $result_jog2 = pg_query($conn,"select * from jogador") or die;

    //query que mostra a tabela equipa
    $result_equipa = pg_query($conn, 'select * from equipa') or die;

    //determina numero de jogadores e de equipas (numero de linhas da tabela)
    $numjog = pg_affected_rows($result_jog);
    $numjog2 = pg_affected_rows($result_jog2);

    $numequipa = pg_affected_rows($result_equipa);

    ?>
</div>


<navbar>
    <a href="index.php"><img src="css/images/logo.svg"></a>

    <ul>
        <a href="jogadores.php"> <li>JOGADORES</li> </a>
        <a href="equipas.php"> <li>EQUIPAS</li> </a>
        <a href="classif.php"> <li>CLASSIFICAÇÕES</li> </a>
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
<main>

    <div>

    </div>


    <div class="escolhe_equipa">
        <div class="but_equipas">
        <form method='get' action='jogadores.php'>
                <label  for='ordenar'> Ordenar por </label>
                    <select name='ordenar_a'>
                        <option selected disabled>Nome</option>
                        <option value='asc'>A-Z</option>
                        <option value='desc'>Z-A</option>
                    </select>

                    <select name='ordenar_p'>
                        <option selected disabled>Peso</option>
                        <option value='asc'>Ascendente</option>
                        <option value='desc'>Descendente</option>
                    </select>

                    <select name='ordenar_p'>
                        <option selected disabled>Nº Golos</option>
                        <option value='asc'>Ascendente</option>
                        <option value='desc'>Descendente</option>
                    </select>

            <input id="ordenar"  type="submit" value="Submeter"/>

        </form>
        </div>
    </div>

    <div id="jogadores">
        <p>Todos os jogadores:</p>
        <?php
        echo "(Número total de jogadores: " . $numjog .")";

        ?>

        <div class="grid">
            <?php
            for ($i=0; $i<$numjog; $i++){
                //conta golos do jogador
                $jogador=$i+1;
                $golos_jogad= pg_query($conn, "SELECT COUNT (id) FROM golo WHERE jogador_id='$jogador';") or die;
                $num_golos=pg_fetch_array($golos_jogad);

                $row_j=pg_fetch_assoc($result_jog);
                echo
                    "<div class='jogador'>"
                        ."<div class='icon_jog'>"
                            ."<img class='icon' src='css/images/icon.png' >"
                            ."<div class='n_camisola'>". $row_j['n_camisola'] ."</div>"
                        ."</div>"
                        ."<div class='info_jogador'>"
                            . "<p>".$row_j['nome'] . "</p>"
                            . $row_j['idade'] . ' anos' . "<br/>"
                            //.' Camisola nº' . $row_j['n_camisola'] .  "<br/>"
                            . $row_j['peso'] . 'kg' . "<br/>"
                            .'Nº Golos: '.$num_golos['count']
                        . "</div>"
                    . "</div>";
            }
            ?>

        </div>
    </div>
</main>
</body>
</html>

