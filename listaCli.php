<?php


include("conexao.php");

$sql = "SELECT idcli AS cliente, razaosocial FROM cliente";

$result = pg_query($conexao, $sql);

$razoes = array();
while ($razao = pg_fetch_assoc($result)){
    $razoes[] = $razao;    
}

echo json_encode($razoes);
