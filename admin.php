<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>11Champions</title>

</head>
<body>


<navbar>

    <img src="css/images/logo.svg">

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
$result_equipas = pg_query($conn, "select * from equipa") or die;
$numequipas = pg_affected_rows($result_equipas);
//jogos
$result_jogos = pg_query($conn, "select * from jogos order by data") or die;
$equipa1 = pg_query($conn, "select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id; ") or die;
$equipa2 = pg_query($conn, "select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id1; ") or die;
$numjogos = pg_affected_rows($result_jogos);
//golos
$result_golo = pg_query($conn, "select * from golo") or die;
$numgolos = pg_affected_rows($result_golo);
$golo_jogad = pg_query($conn, "select jogador.nome from  jogador, golo where jogador.id=golo.jogador_id; ") or die;

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

                    </tr>
                    <?php
                    for ($i = 0; $i < $numequipas; $i++) {
                        $row_e = pg_fetch_assoc($result_equipas);
                        echo "<tr>" .
                            "<td>" . $row_e['id'] . "</td>" .
                            "<td>" . $row_e['nome'] . "</td>" .
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
                            "<td>" . $equipa_1['nome'] . " " . $row_jg['resultado'] . " " . $equipa_2['nome'] . "</td>" .
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
                        ID Equipa 1:<input name="new_eq1" type="number"/> <br/>
                        ID Equipa 2:<input name="new_eq2" type="number"/> <br/>
                        Resultado (equipa1-equipa2): <input name="new_resultado" type="text"/> <br/>
                        Jornada: <input name="new_jornada" type="number"/> <br/>
                        <input type="submit" value="Adicionar"/>
                    </form>
                </div>
                <div class="edit">
                    <form method="get" action="admin-edit-jogo.php">
                        <h2>Editar Jogo</h2>
                        ID do Jogo: <input name="id_jogo" type="bumber"/> <br/>
                        Resultado (equipa1-equipa2): <input name="edit_resultado" type="text"/> <br/>
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
                        $g_jogad = pg_fetch_array($golo_jogad);
                        //$g_equipa = pg_fetch_array($golo_equipa);
                        echo "<tr>" .
                            "<td>" . $row_g['id'] . "</td>" .
                            "<td>" . $row_g['minuto'] . "</td>" .
                            "<td>" . $g_jogad['nome'] . "</td>" .
                            "<td>" . $row_g['jogos_id'] . "</td>" .
                            "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="right">
                <div class="add">
                    <form method="get" action="admin-add-golo.php">
                        <h2>Adicionar novo Golo</h2>
                        ID do Jogo: <input name="g_jogoid" type="number"/> <br/>
                        Jogador: <input name="new_resultado" type="text"/> <br/>
                        Minuto: <input name="g_minuto" type="date"/> <br/>
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
    </div>


</main>

</body>
</html>

