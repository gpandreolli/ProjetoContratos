<?php


include("conexao.php");

$sql = "SELECT * FROM produto";

$result = pg_query($conexao, $sql);

$produtos = array();
while ($produto = pg_fetch_assoc($result)){
    $produtos[] = $produto;    
}

echo json_encode($produtos);
