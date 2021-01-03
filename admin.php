<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>11Champions-Admin</title>

</head>
<body>
<navbar>
    <a href="index.php"><img src="css/images/logo.svg"></a>

    <div class="right">
        <a href='logout.php'><h3>LOGOUT</h3></a>
    </div>

</navbar>

<?php
//para aceder à base de dados
$str = "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
$conn = pg_connect($str) or die("Erro na ligação");
//administradores
$result_admin = pg_query($conn, "select * from admin") or die;
$numadmin = pg_affected_rows($result_admin);
//jogadores
$result_jogad = pg_query($conn, "select * from jogador") or die;
$equipa_jogad = pg_query($conn, "select equipa.nome from equipa, jogador where equipa.id=jogador.equipa_id; ") or die;

$numjogad = pg_affected_rows($result_jogad);
//equipas
$result_equipas = pg_query($conn, "select * from equipa order by id") or die;
$numequipas = pg_affected_rows($result_equipas);
//jogos
$result_jogos = pg_query($conn, "select * from jogos order by id") or die;
$equipa1 = pg_query($conn, "select equipa.nome from equipa, jogos where equipa.id=jogos.equipa1_id; ") or die;
$equipa2 = pg_query($conn, "select equipa.nome from equipa, jogos where equipa.id=jogos.equipa2_id; ") or die;
$numjogos = pg_affected_rows($result_jogos);
//golos
// a tabela golo já tem criados todos os golos que acontecem em todos os jogos,
// mas na pagina admin apenas sao mostrados os que já tem minuto e jogador associado (para nao mostrar erro de acesso a array c valores vazios ao aceder ao nome do jogador)
//para ver todos os golos (com e sem minuto e jogador associado) basta retirar o where jogador_id is not null do seguinte query
$result_golo = pg_query($conn, "select * from golo where jogador_id is not null order by id") or die;
$numgolos = pg_affected_rows($result_golo);
$golo_jogad = pg_query($conn, "select jogador.nome from jogador, golo where jogador.id=golo.jogador_id ") or die;

$result_jogad_e = pg_query($conn, "select * from jogador order by nome asc") or die;
$jogadores= pg_affected_rows($result_jogad_e);


?>

<main>

    <h1>Bem vindo à Admin Page!</h1>

    <div id="cont-admin">

        <div class="tabela">
            <div class="see">
                <h2>Administradores</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Users</th>
                        <th>Password</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $numadmin; $i++) {
                        $row_a = pg_fetch_assoc($result_admin);
                        echo "<tr>" .
                            "<td>" . $row_a['id'] . "</td>" .
                            "<td>" . $row_a['email'] . "</td>" .
                            "<td>" . $row_a['password'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>

        </div>


        <div class="tabela">
            <div class="see">
                <h2>Equipas</h2>
                <table class="equipas">
                    <tr>
                        <th>ID</th>
                        <th>Equipas</th>
                        <th>Nº Jogos <br/> efectuados</th>
                        <th>Vitórias</th>
                        <th>Derrotas</th>
                        <th>Empates</th>
                        <th>Golos</br>Marcados</th>
                        <th>Golos</br>Sofridos</th>
                        <th>Pontuação</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $numequipas; $i++) {
                        $row_e = pg_fetch_assoc($result_equipas);
                        echo "<tr>" .
                            "<td>" . $row_e['id'] . "</td>" .
                            "<td>" . $row_e['nome'] . "</td>" .
                            "<td>" . $row_e['num_jogos_efect'] . "</td>" .
                            "<td>" . $row_e['pontuacao'] . "</td>" .
                            "<td>" . $row_e['vitorias'] . "</td>" .
                            "<td>" . $row_e['derrotas'] . "</td>" .
                            "<td>" . $row_e['empates'] . "</td>" .
                            "<td>" . $row_e['g_marcados'] . "</td>" .
                            "<td>" . $row_e['g_sofridos'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="right">
                <div class="add">
                    <h2>Adicionar nova Equipa</h2>
                    <form method="get" action="admin-add-equipa.php">
                        Nome: <input name="new_nomeeq" type="name"/> <br/>
                        <input type="submit" value="Adicionar"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="tabela">
            <div class="see">
                <h2>Jogadores</h2>
                <table class="jogadores">
                    <tr>
                        <th>ID</th>
                        <th>Jogadores</th>
                        <th>Nºcamisola</th>
                        <th>Idade</th>
                        <th>Peso</th>
                        <th>Equipa</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $numjogad; $i++) {
                        $row_j = pg_fetch_assoc($result_jogad);
                        $eq_jogad = pg_fetch_array($equipa_jogad);
                        echo "<tr>" .
                            "<td>" . $row_j['id'] . "</td>" .
                            "<td>" . $row_j['nome'] . "</td>" .
                            "<td>" . $row_j['n_camisola'] . "</td>" .
                            "<td>" . $row_j['idade'] . "</td>" .
                            "<td>" . $row_j['peso'] . "</td>" .
                            "<td>" . $eq_jogad['nome'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="tabela">
            <div class="see">
                <h2>Jogos</h2>
                <table class="jogos">
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Resultado</th>
                        <th>Jornada</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $numjogos; $i++) {
                        $row_jg = pg_fetch_assoc($result_jogos);
                        $equipa_1 = pg_fetch_array($equipa1);
                        $equipa_2 = pg_fetch_array($equipa2);
                        echo "<tr>" .
                            "<td>" . $row_jg['id'] . "</td>" .
                            "<td>" . $row_jg['data'] . "</td>" .
                            "<td>" . $equipa_1['nome'] ." ". $row_jg['equipa1_golos'] ."-". $row_jg['equipa2_golos'] ." ". $equipa_2['nome'] . "</td>" .
                            "<td>" . $row_jg['jornada'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="right">
                <div class="add">
                    <form method="get" action="admin-add-jogo.php">
                        <h2>Adicionar novo Jogo</h2>
                        Data: <input name="new_date" type="date"/> <br/>

                        Equipa 1:<select name="equipa_escolhida1">
                            <option selected disabled>Nome</option>
                            <?php
                            for ($k=0; $k<$numequipas; $k++){
                                //tabela equipa
                                $row_eq=pg_fetch_assoc($result_equipas);
                                $equipaID1= $k+1;
                                //vai à tabela equipa buscar o nome da equipa
                                $equipa = pg_query($conn, "select * from equipa where id=$equipaID1") or die;
                                $equipa = pg_fetch_assoc($equipa);
                                $nome=$equipa['nome'];
                                //cada opçao vai mostrar o nome da equipa e guarda o valor do id
                                print "<option value=\"$equipaID1\"> $nome </option> ";
                            }
                            ?>
                                </select>
                       Equipa 2: <select name="equipa_escolhida2">
                            <option selected disabled>Nome</option>
                            <?php
                            for ($j=0; $j<$numequipas; $j++){
                                //tabela equipa
                                $row_e=pg_fetch_assoc($result_equipas);
                                $equipaID2= $j+1;
                                //vai à tabela equipa buscar o nome da equipa
                                $equipa = pg_query($conn, "select * from equipa where id=$equipaID2") or die;
                                $equipa = pg_fetch_assoc($equipa);
                                $nome=$equipa['nome'];
                                //cada opçao vai mostrar o nome da equipa
                                print "<option value=\"$equipaID2\"> $nome </option> <br/>";
                            }
                            ?>
                        </select>
                        <br/>Golos Equipa 1: <input name="new_golos1" type="text"/> <br/>
                        Golos Equipa 2: <input name="new_golos2" type="text"/> <br/>
                        Jornada: <input name="new_jornada" type="number"/> <br/>
                        <input type="submit" value="Adicionar"/>
                    </form>
                </div>
                <div class="edit">
                    <form method="get" action="admin-edit-jogo.php">
                        <h2>Editar Jogo</h2>
                        ID do Jogo: <input name="id_jogo" type="bumber"/> <br/>
                        Golos Equipa 1: <input name="edit_golos1" type="text"/> <br/>
                        Golos Equipa 2: <input name="edit_golos2" type="text"/> <br/>
                        <input type="submit" value="Adicionar"/>
                    </form>
                </div>
            </div>

        </div>
        <div class="tabela">
            <div class="see">
                <h2>Golos</h2>
                <table class="golos">
                    <tr>
                        <th>ID</th>
                        <th>Minuto</th>
                        <th>Jogador</th>
                        <th>Jogo</th>

                    </tr>
                    <?php

                    for ($i = 0; $i < $numgolos; $i++) {

                        $row_g = pg_fetch_assoc($result_golo);
                        $id= $row_g['jogador_id'];
                        $nome_jog= pg_query("select jogador.nome  from golo,jogador where jogador.id= '$id'");
                        $row_goloa=pg_fetch_assoc($nome_jog);

                        echo "<tr>" .
                            "<td>" . $row_g['id'] . "</td>" .
                            "<td>" . $row_g['minuto']."</td>" .
                            "<td>" .$row_goloa['nome']. "</td>" .
                            "<td>" . $row_g['jogo_id'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="right">
                <div class="add">
                    <form method="get" action="admin-edit-golo.php">
                        <h2>Editar Golo</h2>
                        ID do Golo: <input name="id_golo" type="number"/> <br/>
                        Minuto: <input name="edit_minuto" type="date"/> <br/>

                        Jogador: <select name="edit_jogador">
                            <option selected disabled>Nome</option>
                            <?php
                            for ($j=0; $j<$jogadores; $j++){
                                //tabela equipa
                                $row_j=pg_fetch_assoc($result_jogad_e);
                                $jogadID= $j+1;
                                //vai à tabela equipa buscar o nome da equipa
                                $jogador = pg_query($conn, "select * from jogador where id=$jogadID") or die;
                                $jog = pg_fetch_assoc($jogador);
                                $jnome=$jog['nome'];
                                //cada opçao vai mostrar o nome da equipa
                                print "<option value=\"$jogadID\"> $jnome </option> <br/>";
                            }
                            ?>
                        </select> <br/>

                        <input type="submit" value="Adicionar"/>
                    </form>
                </div>


            </div>
        </div>


    </div>


</main>

</body>
</html>

