<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/equipas.css">
    <title>Equipas</title>
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
<main>
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


<div>
    <div id="equipas">
        <div class="escolhe_equipa">
            <div class="but_equipas">
                <form method='get' action='equipas.php'>
                    <label  for='equipas'> Escolher </label>
                    <select name='equipa_escolhida'>";
                        <option selected disabled>Equipa</option>
                        <?php
                        for ($j=0; $j<$numequipa; $j++){
                            //tabela equipa
                            $row_e=pg_fetch_assoc($result_equipa);
                            $variavelID= $j+1;
                            //vai à tabela equipa buscar o nome da equipa
                            $nomeequipa=$row_e['nome'];
                            //vai à tabela equipa buscar o id da equipa
                            $idequipa= $row_e['id'];
                            //cada opçao vai mostrar o nome da equipa
                            print "<option value=\"$variavelID\"> $nomeequipa </option>";
                        }
                        ?>
                    </select>
                    <input id="escolhe_equipa"  type="submit" value="Submeter"/>
                </form>
            </div>
        </div>
    </div>

    <div id="equipa_escolhida">

        <?php
        if (isset($_GET['equipa_escolhida']) )
        {
            //vai buscar o id da equipa escolhida
            $equipa_esc = $_GET['equipa_escolhida'];
            //query para a linha da equipa escolhida
            $equipa = pg_query($conn, "select * from equipa where id=$equipa_esc") or die;
            $equipa = pg_fetch_assoc($equipa);
            //vai a essa tabela buscar o nome da equipa
            echo "<p> Jogadores do/a " . $equipa['nome'] .":" ."</p>" ;


            echo "<div class='grid'>";
            //vai a tabela jogador, e percorre todos os jogadores
            for ($i=0; $i<$numjog; $i++){
                //conta golos do jogador
                $jogador=$i+1;
                $golos_jogad= pg_query($conn, "SELECT COUNT (id) FROM golo WHERE jogador_id='$jogador';") or die;
                $num_golos=pg_fetch_array($golos_jogad);
                $row_j=pg_fetch_assoc($result_jog2);
                // se o id da equipa a que o jogador pertence for igual ao id da equipa escolhida
                if($equipa_esc == $row_j['equipa_id']) {
                    //cria o rectangulozinho com a info do jogador
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
            }
            echo "</div >";
        }
        ?>
    </div>





</div>
</main>

</body>
</html>