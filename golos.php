//calcula total de golos de cada jogo e adiciona à tabela golo cada golo que acontece nos jogos
<?php
$str = "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
$conn = pg_connect($str) or die("Erro na ligação");
$result_jogos = pg_query($conn, 'select * from jogos where equipa1_golos IS NOT NULL order by data') or die;
$num_jogos = pg_affected_rows($result_jogos);

for ($j = 0; $j < $num_jogos; $j++) {
    $jogo = pg_fetch_assoc($result_jogos);
    $sum = $jogo['equipa1_golos'] + $jogo['equipa2_golos'];
    $id_jogo = $jogo['id'];

    for ($i = 0; $i < $sum; $i++) {
        $result = pg_query($conn, "insert into golo (jogo_id) values ('$id_jogo')") or die;
    }
}
?>
