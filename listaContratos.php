<?php


include("conexao.php");

$start = isset($_GET["start"]) ? (int)$_GET["start"]:0;
$limit = isset($_GET["limit"]) ? (int)$_GET["limit"]:18;

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

$sql = "SELECT idcontrato, cliente, razaosocial , produto.nome, produto, numerocontrato, 
               numeroproposta, datainicio, datafim, contrato.descricao, contatocontrato 
          FROM contrato 
         INNER JOIN CLIENTE ON cliente.idcli  = contrato.cliente
         INNER JOIN produto ON produto.idprod = contrato.produto 
         $filtro
         LIMIT $limit OFFSET $start";

$result = pg_query($conexao, $sql);

$contratos = array();
    while ($contrato = pg_fetch_assoc($result)){
    $contratos[] = $contrato;    
}

echo json_encode(array(
    "contratos" => $contratos,
    "total" => $num_total_registros
));
