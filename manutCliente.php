<?php

include("conexao.php");


$camposcli = json_decode( $_POST['manut_cliente']);
$tipo = $_POST['tipo'];
$excluir = $_POST['excluir_cliente'];

if (file_exists("conexao.php")){   
    
  //Isert de um novo cliente   
    if($tipo == 'novo'){
        
        $sql_consultacnpj = "SELECT * from cliente
                               WHERE
                            cnpj = '$camposcli->cnpj'";
        $result = pg_query($conexao, $sql_consultacnpj);
            if (pg_num_rows($result) > 0) {

                echo 'CNPJ ja cadastrado';

            } else {
                    
               $sql_cli = "SELECT MAX(idcli) from cliente";
                $result = pg_query($conexao, $sql_cli);
                if(pg_num_rows($result) > 0){
                    $row = pg_fetch_row($result);
                    $id = $row[0]+1;
                }else{
                    $id = 1;
                }

                $sql_cli = "INSERT INTO cliente (idcli, razaosocial, cnpj, inscricaoestadual, rua, numero, bairro, complemento, cidade, cep, uf, contato) VALUES ("
                  . "$id, '$camposcli->razaosocial', '$camposcli->cnpj', '$camposcli->inscricaoestadual', '$camposcli->rua'"
                    . ", '$camposcli->numero', '$camposcli->bairro', '$camposcli->complemento', '$camposcli->cidade', '$camposcli->cep',"
                         . "'$camposcli->uf', '$camposcli->contato')"; 
                $result = pg_query($conexao, $sql_cli);        
                $erro = pg_last_error($conexao);
                if($erro == FALSE){
                    echo 'Cadastro salvo com sucesso';
                }else{
                    echo 'cagada monstro: ' . $erro;
                }

                if (!file_exists("conexao.php")){

                    $msgErro .= "Não será possível executar nenhuma ação no Banco de Dados!";   

                    echo $msgErro;

                    exit;
                }

            }
        
            
    }else if($tipo == 'edita'){
        $sql = "UPDATE cliente SET
                    razaosocial = '$camposcli->razaosocial',
                    cnpj = '$camposcli->cnpj',
                    inscricaoestadual = '$camposcli->inscricaoestadual',
                    rua = '$camposcli->rua',
                    numero = '$camposcli->numero',
                    bairro = '$camposcli->bairro',
                    complemento = '$camposcli->complemento',
                    cidade = '$camposcli->cidade', 
                    cep = '$camposcli->cep', 
                    uf = '$camposcli->uf', 
                    contato = '$camposcli->contato'
                WHERE
                    idcli = $camposcli->idcli"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro alterado com sucesso';
        }else{
            echo 'Erro:.......... ' . $erro;
        }
    }else if ($tipo == 'excluir') {
        $sql = "DELETE FROM cliente                   
                WHERE idcli = $excluir";
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro excluído com sucesso';
        }else{
            
            echo 'Erro:.......... ' . $erro;
        }
    }
}