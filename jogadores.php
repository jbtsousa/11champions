<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/jogadores.css">
    <title>11Champions</title>

</head>
<body>

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
    <?php $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligação"); ?>

    <div id="top">
        <p class="titulo">Top 5 Marcadores</p>
        <?php
        $golos_jogad= pg_query($conn, "select jogador.nome, jogador.id, jogador.equipa_id,
        COUNT(golo.jogador_id) as num_golos  from jogador, golo 
        where jogador.id=golo.jogador_id
        group by jogador.nome, jogador.id, jogador.equipa_id
        order by num_golos desc") or die;

        echo "<div id='grid_top'>";
        for ($j=0;$j<5;$j++) {

            $golos=pg_fetch_array($golos_jogad);
            $id_jogador= $golos['id'];
            $jogador = pg_query($conn,"select * from jogador where id='$id_jogador'") or die;
            $equipaid_jogador= $golos['equipa_id'];
            $equipa_j= pg_query($conn,"select equipa.nome from equipa where id =$equipaid_jogador") or die;

            $rowj = pg_fetch_assoc($jogador);
            $rowe=pg_fetch_assoc($equipa_j);


            echo
                "<div class='jogador'>"
                . "<div class='icon_jog'>"
                . "<img class='icon' src='css/images/icon.png' >"
                . "<div class='n_camisola'>" . $rowj['n_camisola'] . "</div>"
                . "</div>"
                . "<div class='info_jogador'>"
                . "<p>" . $golos['nome'] . "</p>"
                . $rowe['nome']. "<br/>"
                . 'Nº Golos: ' . $golos['num_golos']
                . "</div>"
                . "</div>";
        }
        echo "</div>";
        ?>

    </div>
    <div id="todos">
    <p class="titulo">Jogadores da Liga</p>

    <div class="escolhe_equipa">
        <form method='get' action='jogadores.php'>
                <label  for='ordenar'> Ordenar por </label>
                    <select name='ordenar_n'>
                        <option selected disabled>Nome</option>
                        <option value='asc'>A-Z</option>
                        <option value='desc'>Z-A</option>
                    </select>

                    <select name='ordenar_i'>
                        <option selected disabled>Idade</option>
                        <option value='asc'>Ascendente</option>
                        <option value='desc'>Descendente</option>
                    </select>

                    <select name='ordenar_p'>
                        <option selected disabled>Peso</option>
                        <option value='asc'>Ascendente</option>
                        <option value='desc'>Descendente</option>
                    </select>

            <input id="ordenar"  type="submit" value="Submeter"/>
        </form>
    </div>
    <?php
        //para aceder à base de dados

        //para o todos os jogadors
        $result_jog = pg_query($conn,"select * from jogador") or die;



    //filtros ordenar
    $action_n = isset($_GET['ordenar_n']) ? $_GET['ordenar_n'] : null;
        switch($action_n){
            case 'asc':
                $result_jog = pg_query($conn, 'select * from jogador order by nome asc') or die;
                break;
            case 'desc':
                $result_jog = pg_query($conn, 'select * from jogador order by nome desc') or die;
                break;
        }
    $action_i = isset($_GET['ordenar_i']) ? $_GET['ordenar_i'] : null;
    switch($action_i)  {
            case 'asc':
                $result_jog = pg_query($conn, 'select * from jogador order by idade asc') or die;
                break;
            case'desc':
                $result_jog = pg_query($conn, 'select * from jogador order by idade desc') or die;
                break;
        }
    $action_p = isset($_GET['ordenar_p']) ? $_GET['ordenar_p'] : null;
    switch($action_p)  {
            case 'asc':
                $result_jog = pg_query($conn, 'select * from jogador order by peso asc') or die;
                break;
            case'desc':
                $result_jog = pg_query($conn, 'select * from jogador order by peso desc') or die;
                break;
        }


        $numjog = pg_affected_rows($result_jog);
    ?>

    <div id="jogadores">

        <?php  echo "(Número total de jogadores: " . $numjog .")"; ?>
        <div class="grid">
            <?php
            for ($i=0; $i<$numjog; $i++){
                //conta golos do jogador
                $jogador=$i+1;
                $golos_jogad= pg_query($conn, "SELECT COUNT (golo.jogador_id) as num_golos FROM golo WHERE jogador_id='$jogador'") or die;


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
                            . $row_j['peso'] . 'kg' . "<br/>"
                            .'Nº Golos: '.$num_golos['num_golos']
                        . "</div>"
                    . "</div>";


            }

            ?>

        </div>
    </div>
    </div>
</main>
</body>
</html>

