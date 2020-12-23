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
        <a href="classif.html"><li>CLASSIFICAÇÕES</li></a>
        <a href="calendario.php"><li>CALENDÁRIO</li></a>
        <li><input type="text" placeholder="Search.."></li>
    </ul>
</navbar>

<?php
//para aceder à base de dados
$str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
$conn = pg_connect($str) or die("Erro na ligação");
//para o todos os jogadors
$result_jog = pg_query($conn,"select * from jogos") or die;
$numjogos = pg_affected_rows($result_jog);
$jogos = pg_fetch_array($result_jog);

$equipa1 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id; ") or die;
$equipa2 = pg_query($conn,"select equipa.nome from equipa, jogos where equipa.id=jogos.equipa_id1; ") or die;


?>

<main>

    <div>JOGOS</div>

<?php
for ($i=0; $i<$numjogos; $i++) {
    $row_j=pg_fetch_assoc($result_jog);
    $equipa_1 = pg_fetch_array($equipa1);
    $equipa_2 = pg_fetch_array($equipa2);

    echo
        "<br>"
        .$jogos['data'] . "<br/>"
        . $jogos['jornada'] . 'º jornada' . "<br/>"
        . ' Resultado: '. $equipa_1['nome'] ." ". $jogos['resultado']." ". $equipa_2['nome'] . "<br/>";

}

pg_close($conn);
?>
</main>

</body>
</html>