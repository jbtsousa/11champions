<?php
$str = "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
$conn = pg_connect($str) or die("Erro na ligação");
$result_equipa = pg_query($conn, 'select * from equipa ') or die;
$numequipa = pg_affected_rows($result_equipa);

for ($i = 0; $i < $numequipa; $i++) {

    $row_e = pg_fetch_assoc($result_equipa);
    $equipa = $i + 1;

//calcula numero de jogos efctuados
    $jogos_visitado = pg_query($conn, "SELECT COUNT(equipa1_id) FROM jogos WHERE equipa1_id='$equipa'and equipa1_golos IS NOT NULL") or die;
    $jogos_visitante = pg_query($conn, "SELECT COUNT(equipa2_id) FROM jogos WHERE equipa2_id='$equipa' and equipa1_golos IS NOT NULL") or die;
    $num_visitado = pg_fetch_array($jogos_visitado);
    $num_visitante = pg_fetch_array($jogos_visitante);
    $tot_jogos_eq = $num_visitado['count'] + $num_visitante['count'];

//calcula vitórias
    $vence_visitado = pg_query($conn, "select * from jogos where equipa1_golos>equipa2_golos and equipa1_id='$equipa'") or die;
    $vence_visitante = pg_query($conn, "select * from jogos where equipa1_golos<equipa2_golos and equipa2_id='$equipa'") or die;
    $tot_vitorias_eq = pg_affected_rows($vence_visitado) + pg_affected_rows($vence_visitante);

//calcula derrotas
    $perde_visitado = pg_query($conn, "select * from jogos where equipa1_golos<equipa2_golos and equipa1_id='$equipa'") or die;
    $perde_visitante = pg_query($conn, "select * from jogos where equipa1_golos>equipa2_golos and equipa2_id='$equipa'") or die;
    $tot_derrotas_eq = pg_affected_rows($perde_visitado) + pg_affected_rows($perde_visitante);

//calcula empates
    $empate_visitado = pg_query($conn, "select * from jogos where equipa1_golos=equipa2_golos and equipa1_id='$equipa'") or die;
    $empate_visitante = pg_query($conn, "select * from jogos where equipa1_golos=equipa2_golos and equipa2_id='$equipa'") or die;
    $tot_empates_eq = pg_affected_rows($empate_visitado) + pg_affected_rows($empate_visitante);

//calcula golos marcados
    $golos_visitado = pg_query($conn, "SELECT SUM(equipa1_golos) FROM jogos where equipa1_id='$equipa'") or die;
    $golos_visitante = pg_query($conn, "SELECT SUM(equipa2_golos) FROM jogos where equipa2_id='$equipa'") or die;
    $g_visitado = pg_fetch_array($golos_visitado);
    $g_visitante = pg_fetch_array($golos_visitante);
    $tot_golos_eq = $g_visitado['sum'] + $g_visitante['sum'];

//calcula golos sofridos
    $sofridos_visitado = pg_query($conn, "SELECT SUM(equipa2_golos) FROM jogos where equipa1_id='$equipa'") or die;
    $sofridos_visitante = pg_query($conn, "SELECT SUM(equipa1_golos) FROM jogos where equipa2_id='$equipa'") or die;
    $s_visitado = pg_fetch_array($sofridos_visitado);
    $s_visitante = pg_fetch_array($sofridos_visitante);
    $tot_golos_sof = $s_visitado['sum'] + $s_visitante['sum'];

//calcula pontuação
    $pont = ($tot_vitorias_eq * 5) + $tot_empates_eq;

//adicionar jogos efectuados e pontuação à tabela equipa
    $update_efect = pg_query($conn, "update equipa set num_jogos_efect='$tot_jogos_eq' where id='$equipa'") or die;
    $update_pont = pg_query($conn, "update equipa set pontuacao='$pont'where id='$equipa'") or die;
    $update_vit = pg_query($conn, "update equipa set vitorias='$tot_vitorias_eq'where id='$equipa'") or die;
    $update_der = pg_query($conn, "update equipa set derrotas='$tot_derrotas_eq'where id='$equipa'") or die;
    $update_emp = pg_query($conn, "update equipa set empates='$tot_empates_eq'where id='$equipa'") or die;
    $update_marc = pg_query($conn, "update equipa set g_marcados='$tot_golos_eq'where id='$equipa'") or die;
    $update_sof = pg_query($conn, "update equipa set g_sofridos='$tot_golos_sof'where id='$equipa'") or die;

    $result2 = pg_query($conn, "select * from equipa") or die;


}
?>
