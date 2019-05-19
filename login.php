<?php 

include("conexao.php");

// session_start inicia a sessão
session_start();

$camposlog = json_decode($_POST['manut_login']);    


// A vriavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$sql = "SELECT login, senha FROM usuario "
        . "WHERE "
        . "login = '$camposlog->login' "
        . "AND "
        . "senha = '$camposlog->senha' ";

$result = pg_query($conexao, $sql);

ob_clean();

if (pg_num_rows($result)==1) {
    $_SESSION['login']= $camposlog->login;
    echo 'aleluia';
    
}else{
    echo '0';
}

session_write_close(); 