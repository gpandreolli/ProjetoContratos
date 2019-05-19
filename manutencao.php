<?php

include("conexao.php");

$campos = json_decode( $_POST['manut_contrato']);
$tipo = $_POST['tipo'];

//$excluir = $_POST['excluir_contrato'];

//busca parâmetros de paginação informados pelo Ext
//caso seja vazio (1ª requisição) coloca valores default


                 
                



$data = $campos->datainicio;
$dataP = explode('/',$data);
$datainicioBD = $dataP[2].'-'.$dataP[0].'-'.$dataP[1]; 

$dataA = $campos->datafim;
$dataQ = explode('/',$dataA);
$datafimBD = $dataQ[2].'-'.$dataQ[0].'-'.$dataQ[1]; 


//============================================================================================================================//
if (file_exists("conexao.php")){   
   
    if ($tipo == 'novo') {
        $sql = "SELECT MAX(idcontrato) from contrato";
        $result = pg_query($conexao, $sql);
        if(pg_num_rows($result) > 0){
            $row = pg_fetch_row($result);
            $id = $row[0]+1;
        }else{
            $id = 1;
        }
        
         $sql = "INSERT INTO contrato (idcontrato, cliente, numerocontrato, numeroproposta, produto, datainicio, datafim, "
                 . "descricao, contatocontrato) VALUES ("
                . "$id, $campos->cliente, '$campos->numerocontrato', '$campos->numeroproposta', $campos->produto,"
                 . " '$datainicioBD',"
                . " '$datafimBD',"
                . "'$campos->descricao', '$campos->contatocontrato')"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro salvo com sucesso';
            
        }else{
            echo 'Erro:.......... ' . $erro;
        }
    } else if($tipo == 'edita') {        
        $sql = "UPDATE contrato SET
                   cliente = '$campos->cliente',
                   numerocontrato = '$campos->numerocontrato',
                   numeroproposta = '$campos->numeroproposta',
                   produto = '$campos->produto', 
                   datainicio = '$datainicioBD',
                   datafim = '$datafimBD',
                   descricao = '$campos->descricao',
                   contatocontrato = '$campos->contatocontrato' 
                WHERE
                    idcontrato = $campos->idcontrato"; 
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro alterado com sucesso';
        }else{
            echo 'Erro:.......... ' . $erro;
        }
        
    } else if($tipo == 'excluir') {
        
        $excluir = $_POST['excluir_contrato'];

        $sql = "DELETE FROM contrato                   
                WHERE idcontrato = $excluir";
        $result = pg_query($conexao, $sql);        
        $erro = pg_last_error($conexao);
        if($erro == FALSE){
            echo 'Cadastro excluído com sucesso';
        }else{
            
            echo 'Erro:.......... ' . $erro;
        }
    }

}else{
    echo 'arquivo de conexão não existe' .$erro;
}