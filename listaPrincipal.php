<?php


include("conexao.php");

$start = isset($_GET["start"]) ? (int)$_GET["start"]:0;
$limit = isset($_GET["limit"]) ? (int)$_GET["limit"]:20;

$filtro = "ORDER BY datafim ASC";

if(isset($_GET["sort"])){
    
    $sort = json_decode($_GET["sort"], true);
    $order = $sort[0]['property'];
    $direction = $sort[0]['direction'];
    $filtro = "ORDER BY $order $direction";
}

$sql_limite = "SELECT idcontrato FROM contrato";
$rs = pg_query($conexao, $sql_limite);
$num_total_registros = pg_num_rows($rs);

$dataAtual = date('Y-m-d');
$dataFutura = date('Y-m-d', strtotime($dataAtual. ' + 30 day'));
$dataFutura2 = date('Y-m-d', strtotime($dataAtual. ' + 15 day'));



$sql = "SELECT idcontrato, cliente, razaosocial , produto.nome, produto, numerocontrato, 
               numeroproposta, datafim, contatocontrato,
         CASE 
            WHEN datafim > '$dataFutura' THEN 'Válido'
            WHEN datafim <= '$dataFutura' AND datafim > '$dataAtual' 
                AND datafim > '$dataFutura2' THEN 'A Vencer em um mês'
            WHEN datafim <= '$dataFutura2' AND datafim > '$dataAtual' THEN 'A Vencer em 15 dias'
            WHEN datafim < '$dataAtual' THEN 'Expirado'
            END AS status                
         FROM contrato
         INNER JOIN cliente
                 ON cliente = idcli
         INNER JOIN produto
                 ON produto = idprod
          $filtro       
            LIMIT $limit OFFSET $start";

$result = pg_query($conexao, $sql);

$consultas = array();
while ($consulta = pg_fetch_assoc($result)){
    $consultas[] = $consulta;    
}

echo json_encode(array(
        "consultas" => $consultas,
        "total" => $num_total_registros
));
