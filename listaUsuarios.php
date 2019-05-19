<?php


include("conexao.php");

 session_start();
 if (!isset($_SESSION['login'])) {    
    header('location:index.php');
}  else {
   //header('location:principal.php');
}   

$userLogado = $_SESSION['login'];



$sql = "SELECT iduser, senha, login, usuario.nome FROM usuario
         WHERE
        login = '$userLogado'";
$result = pg_query($conexao, $sql);

$users = array();

while ($user = pg_fetch_assoc($result)){
    $users[] = $user;    
}

echo json_encode($users);
