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

        <div id="ordena">
            <form method='get' action='classif.php'>
                <label  for='ordenar'>Ordenar por:</label>
                <select name='ordenar_a'>
                    <option selected disabled>Nome</option>
                    <option value='asc'>A-Z</option>
                    <option value='desc'>Z-A</option>
                </select>

                <select name='ordenar_j'>
                    <option selected disabled>Jogos Efectuados</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>
                <select name='ordenar_v'>
                    <option selected disabled>Vitórias</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>
                <select name='ordenar_d'>
                    <option selected disabled>Derrotas</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>
                <select name='ordenar_e'>
                    <option selected disabled>Empates</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>

                <select name='ordenar_gm'>
                    <option selected disabled>Golos Marcados</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>

                <select name='ordenar_gs'>
                    <option selected disabled>Golos Sofridos</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>
                <select name='ordenar_p'>
                    <option selected disabled>Pontuação</option>
                    <option value='asc'>Ascendente</option>
                    <option value='desc'>Descendente</option>
                </select>

                <input id="escolhe_equipa"  type="submit" value="Submeter"/>
            </form>

          <form action="classif.php" method="get">
               <input name="search" type="search" autofocus> <input type="submit" name="button">
            </form>

        <?php
        $str = "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
        $conn = pg_connect($str) or die("Erro na ligação");
        $result_equipa = pg_query($conn, 'select * from equipa ') or die;

        //filtros ordenar
        switch($_GET['ordenar_a']){
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by nome asc') or die;
                break;
            case 'desc':
                $result_equipa = pg_query($conn, 'select * from equipa order by nome desc') or die;
                break;
        }
        switch($_GET['ordenar_j'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by num_jogos_efect asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by num_jogos_efect desc') or die;
                break;
        }
        switch($_GET['ordenar_v'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by vitorias asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by vitorias desc') or die;
                break;
        }
        switch($_GET['ordenar_d'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by derrotas asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by derrotas desc') or die;
                break;
        }
        switch($_GET['ordenar_e'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by empates asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by empates desc') or die;
                break;
        }
        switch($_GET['ordenar_gm'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by g_marcados asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by g_marcados desc') or die;
                break;
        }
        switch($_GET['ordenar_gs'])  {
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by g_sofridos asc') or die;
                break;
            case'desc':
                $result_equioa = pg_query($conn, 'select * from equipa order by g_sofridos desc') or die;
                break;
        }
        switch($_GET['ordenar_p']){
            case 'asc':
                $result_equipa = pg_query($conn, 'select * from equipa order by pontuacao asc') or die;
                break;
            case 'desc':
                $result_equipa = pg_query($conn, 'select * from equipa order by pontuacao desc') or die;
                break;
        }

        if( isset ($_GET['search'])) {
            $search = $_GET['search'];
            $result_equipa = pg_query("select * from equipa where nome like '%{$search}%' ") or die;
        }
       $numequipa = pg_affected_rows($result_equipa);


        ?>
        </div>


    <div>

        <div id="tabela">
            <table class="classifica">
                <tr>
                    <th>Nome</th>
                    <th>Nº Jogos Efectuados</th>
                    <th>Vitórias</th>
                    <th>Derrotas</th>
                    <th>Empates</th>
                    <th>Golos Marcados</th>
                    <th>Golos Sofridos</th>
                    <th>Pontuação</th>
                </tr>

                <?php
                for ($i = 0;$i < $numequipa;$i++) {
                    $row_e = pg_fetch_assoc($result_equipa);
                    echo
                    "<tr>"
                    ."<td>" . $row_e['nome'] . "</td>"
                    ."<td>" . $row_e['num_jogos_efect']. "</td>"
                    ."<td>" .$row_e['vitorias'].  "</td>"
                    ."<td>" . $row_e['derrotas']. "</td>"
                    ."<td>" . $row_e['empates']. "</td>"
                    ."<td>" . $row_e['g_marcados']. "</td>"
                    ."<td>" .$row_e['g_sofridos'].  "</td>"
                    ."<td>" . $row_e['pontuacao']. "</td>"
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