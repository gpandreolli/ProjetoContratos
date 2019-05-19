<?php

include("conexao.php");


//$camposprod = json_decode( $_POST['manut_prod']);
$tipo = $_POST['tipo'];


if (file_exists("conexao.php")){   
    
  //Isert de um novo produto   
    if($tipo == 'novo'){
            $camposprod = json_decode( $_POST['manut_prod']);

            $sql_prod = "SELECT MAX(idprod) from produto";
            $result = pg_query($conexao, $sql_prod);
            if(pg_num_rows($result) > 0){
                $row = pg_fetch_row($result);
                $id = $row[0]+1;
            }else{
                $id = 1;
            }

             $sql_prod = "INSERT INTO produto (idprod, nome, descricao, setor) VALUES ("
              . "$id, '$camposprod->nome', '$camposprod->descricao', '$camposprod->setor')"; 
            $result = pg_query($conexao, $sql_prod);        
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
    }else if($tipo == 'edita'){

        $camposprod = json_decode( $_POST['manut_prod']);
        $sql = "UPDATE produto SET
                    nome = '$camposprod->nome',
                    descricao = '$camposprod->descricao',
                    setor = '$camposprod->setor'
                WHERE
                    idprod = $camposprod->idprod"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro alterado com sucesso';
        }else{
            echo 'Erro:.......... ' . $erro;
        }
        
    }elseif ($tipo == 'excluir') {
        $excluir = $_POST['excluir_prod'];
        $sql = "DELETE FROM produto                   
                WHERE idprod = $excluir";
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro excluído com sucesso';
        }else{
            
            echo 'Erro:.......... ' . $erro;
        }
    }
}