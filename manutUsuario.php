<?php

include("conexao.php");

$campos = json_decode( $_POST['manut_user']);
$tipo = $_POST['tipo'];


//============================================================================================================================//

if (file_exists("conexao.php")){   
   
    if ($tipo == 'novo') {
        $sql = "SELECT MAX(iduser) from usuario";
        $result = pg_query($conexao, $sql);
        if(pg_num_rows($result) > 0){
            $row = pg_fetch_row($result);
            $id = $row[0]+1;
        }else{
            $id = 1;
        }
        
         $sql = "INSERT INTO usuario (iduser, login, senha, nome)
                 VALUES ($id, '$campos->login', '$campos->senha', '$campos->nome')"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro salvo com sucesso';
            
        }else{
            echo 'Erro:.......... ' . $erro;
        }
    } else if($tipo == 'edita') {        
        $sql = "UPDATE usuario SET
                   login = '$campos->login',
                   senha = '$campos->senha',
                   nome = '$campos->nome'
                WHERE
                    iduser = $campos->iduser"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro alterado com sucesso';
        }else{
            echo 'Erro:.......... ' . $erro;
        }
        
    } 
    

}else{
    echo 'arquivo de conexão não existe' .$erro;
}