<?php


include("conexao.php");

$sql = "SELECT idprod AS produto, nome FROM produto";

$result = pg_query($conexao, $sql);

$razoes = array();
while ($produto = pg_fetch_assoc($result)){
    $produtos[] = $produto;    
}

echo json_encode($produtos);
