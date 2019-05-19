
<?php
$pathSite = 'http://localhost/'
//ARMAZENA O ENDEREÇO DO SERVIDOR

?>

<!doctype html> 
<html>
    <head>
        <?php
            session_start();
            if (!isset($_SESSION['login'])) {    
                header('location:index.php');
            }
        ?>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contratos</title>


        <!--criando link do arquivo de script do Extjs-->
       <!-- <script src="<?php echo $pathSite; ?>ext6/build/ext-all.js"></script> -->

            <!--criando link do arquivo de script do Extjs-->
        <script src="<?php echo $pathSite; ?>ext6/build/ext-all.js"></script>

        <!--cria link do arquivo css do tema crips do Extjs-->
        <link rel="stylesheet" type="text/css" href="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/resources/theme-crisp-all.css">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $pathSite; ?>/ProjetoContratos/estilo.css">
        
        
        
        <!--cria link do arquivo js do tema crips do Extjs-->
        <script src="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/theme-crisp.js"></script>
        
        <!--cria link do arquivo de funçoes do extjs-->
        <script src="<?php echo $pathSite; ?>/ProjetoContratos/javascript.js"></script>

        <!-- link do arquivo locale-->
        <script type="text/javascript" src="<?php echo $pathSite; ?>ext6/classic/locale/overrides/pt_BR/ext-locale-pt_BR.js"></script>
        
        <script>

            //Define os dados a serem mostrados no grid ou store?
            Ext.define('Contrato', {
                extend: 'Ext.data.Model',
                fields: ['idcontrato','cliente', 'razaosocial', 'numerocontrato', 'numeroproposta', 'nome', 'produto', 'datainicio', 'datafim', 'descricao', 'contato', 'status']

            });

            //a data store sera onde os dados do banco serão 'puxados' e armazenaodos para serem mostrados para o grid
            var contratoStore = Ext.create('Ext.data.Store', {
                model: 'Contrato',
                pageSize: 18,
                remoteSort: true,
                proxy: {
                    type: 'ajax',
                    url:'listaContratos.php',
                    reader:{
                        type: 'json',
                        root: 'contratos',
                        totalProperty: 'total',
                        valueField: 'idcontrato'
                    }
                },
                autoLoad: false  
            });
            
            //model e store do cliente
            Ext.define('Cliente', {
                extend: 'Ext.data.Model',
                fields: ['cliente', 'razaosocial']

            });
            
            var clienteStore = Ext.create('Ext.data.Store',{
                model: 'Cliente',
                proxy: {
                    type: 'ajax',
                    url:'listaCli.php',
                    reader:{
                        type: 'json',
                        root: 'razoes',
                        valueField: 'cliente',
                        displayField: 'razaosocial'
                    }
                }
            });
            
            
            ///model e store do produto
            Ext.define('Produto', {
                extend: 'Ext.data.Model',
                fields: ['produto', 'nome']

            });
            
            var produtoStore = Ext.create('Ext.data.Store',{
                model: 'Produto',
                proxy: {
                    type: 'ajax',
                    url:'listaProd.php',
                    reader:{
                        type: 'json',
                        root: 'produtos',
                        valueField: 'produto',
                        displayField: 'nome'
                    }
                    
                }
            });


            Ext.Loader.setPath();
            Ext.require(['*']);

            //carregando a função on-load do js para executar os scripts depois q a pagina foi carregada
            Ext.onReady(function () {
                Ext.create({
                        xtype: 'viewport',
                        layout: 'fit',
                        renderTo: Ext.getBody(), //renderizando na <div id="CadastroContrato">
                        items: [{
                        xtype: 'panel',
                        tbar: [{
                            xtype: 'toolbar',
                            flex: 1,
                            dock: 'top',
                            items: [{
                                    xtype: 'button', 
                                    text: 'Menu',
                                    menu: {
                                        items:[{
                                                text: 'Principal',
                                                handler: function() {
                                                    window.location.href = 'principal.php';
                                                }
                                            },{
                                                text: 'Cadastro de Clientes',
                                                handler: function() {
                                                    window.location.href = 'cliente.php'; 
                                                }
                                                
                                            },{
                                                text: 'Cadastro de Produtos',
                                                handler: function() {
                                                    window.location.href = 'produto.php';
                                                }
                                                
                                            },{
                                                text: 'Sair',
                                                    handler: function() {
                                                           window.location.href = 'index.php?logout=1';
                                                    }

                                                }]
                                            }                                    
                                },'-',
                                '->', // same as { xtype: 'tbfill' }
                                {
                                    xtype    : 'textfield',
                                    name     : 'procurar',
                                    emptyText: 'Procurar'
                                }
                                
                            ]
                        }],
                        items: [{
                                xtype: 'panel',
                                region: 'north',
                                defaults: {
                                    height: '100%',
                                    width: '98%',
                                    margin: '5 auto'
                                },
                                height: 50,                               
                                items: [{
                                        xtype: 'button',
                                        text: 'Novo',
                                        width: 60,
                                        margin: '2 5 5 2',
                                        listeners: {
                                            click: function () {
                                                novoForm('gridContrato', 'formContrato');

                                            }
                                        }


                                    },
                                    {
                                        xtype: 'button',
                                        text: 'Editar',
                                        width: 60,
                                        margin: '2 5 5 2',        
                                        listeners: {
                                            click: function () {
                                                editarForm('gridContrato', 'formContrato');

                                            }
                                        }

                                    },
                                    {
                                        xtype: 'button',
                                        text: 'Excluir',
                                        width: 60,
                                        margin: '2 5 5 2',
                                        listeners: {
                                            click: function () {
                                                excluirContrato('gridContrato');

                                            }
                                        }
                                    }]
                            }, {
                                xtype: 'grid',
                                id: 'gridContrato',
                                store: contratoStore, // selecionando a Store de onde os dados devem ser 'puxados' para o grid
                                region: 'center',
                                width: '100%',
                                margin: '5 0 0 0',
                                title: 'Contratos',
                                columns: [{
                                        dataIndex: 'idcontrato',
                                        hidden: true
                                    },
                                    {
                                        text: 'Cliente',
                                        width: 250,
                                        dataIndex: 'razaosocial'
                                    },
                                    {
                                        text: 'Número do Contrato',
                                        width: 140,
                                        dataIndex: 'numerocontrato',
                                    },
                                    {
                                        text: 'Número da Proposta',
                                        width: 140,
                                        dataIndex: 'numeroproposta',
                                    },
                                    {
                                        text: 'Produto',
                                        width: 100,
                                        dataIndex: 'nome',
                                    },
                                    {
                                        text: 'Data Inicio Contrato',
                                        width: 140,
                                        renderer: function(value){
                                            var data = value.split('-');
                                            return data[2]+'/'+data[1]+'/'+data[0];
                                        },
                                        dataIndex: 'datainicio',
                                    },
                                    {
                                        text: 'Data Fim Contrato',
                                        width: 140,
                                        renderer: function(value){
                                            var data = value.split('-');
                                            return data[2]+'/'+data[1]+'/'+data[0];
                                        },
                                        dataIndex: 'datafim',
                                    },
                                    {
                                        text: 'Resumo',
                                        width: 225  ,
                                        dataIndex: 'descricao',
                                    },
                                    {
                                        text: 'Contato',
                                        width: 130,
                                        dataIndex: 'contatocontrato',
                                    }],
                                tbar : new Ext.PagingToolbar({                                    
                                    
                                    store: contratoStore,
                                    displayInfo: true,
                                    displayMsg: 'Mostrando contratos',
                                    emptyMsg: "Desculpe, mas não há items para exibir."
                                
                                })

                            },{
                                xtype: 'panel',
                                layout: 'anchor',
                                width: 700,
                                heigth: '100%',
                                margin: '30 auto auto 300',
                                items:[{
                                    xtype: 'form',  
                                    anchor: '100%, 90%',
                                    title: 'Cadastro de Contratos',
                                    id: 'formContrato',
                                    tipo: 'contrato',
                                    border: true,
                                    bodyBorder: true,
                                    hidden: true,
                                    items: [{
                                            xtype: 'combobox',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            width: '70%',                                                                            
                                            store: clienteStore,
                                            name: 'cliente',
                                            fieldLabel: 'Cliente',
                                            displayField: 'razaosocial',
                                            valueField: 'cliente',
                                            loadingText: 'Carregando...',
                                            emptyText: 'Selecione o cliente...',

                                        },
                                        {
                                            xtype: 'textfield',
                                            name:'idcontrato',
                                            hidden: true
                                        },
                                        {
                                            xtype: 'textfield',
                                            name: 'numerocontrato',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            fieldLabel: 'Número do Contrato',
                                        },
                                        {
                                            xtype: 'textfield',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            name: 'numeroproposta',
                                            fieldLabel: 'Número da Proposta',
                                        },
                                        {
                                            xtype: 'combobox',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            store: produtoStore,
                                            name: 'produto',
                                            fieldLabel: 'Produto',
                                            displayField: 'nome',
                                            valueField: 'produto',
                                            loadingText: 'Carregando...',
                                            emptyText: 'Selecione o produto...',

                                        },
                                        {
                                            xtype: 'datefield',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            name: 'datainicio',
                                            fieldLabel: 'Data Inicio do Cotrato',

                                        },
                                        {
                                            xtype: 'datefield',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            name: 'datafim',
                                            fieldLabel: 'Data Fim do Cotrato',
                                        },
                                        {
                                            xtype: 'textfield',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            width: '70%',
                                            name: 'descricao',
                                            fieldLabel: 'Resumo do Cotrato',
                                        },
                                        {
                                            xtype: 'textfield',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            name: 'contatocontrato',
                                            fieldLabel: 'Contato',
                                        },
                                        {
                                            xtype: 'panel',
                                            width: '50%',
                                            bodyBorder: true,
                                            border: true,
                                            items: [{
                                                    xtype: 'button',
                                                    margin: '10 5 5 235',
                                                    width: 90,
                                                    padding: 2,
                                                    text: 'Salvar',                                                
                                                    listeners: {
                                                        click: function () {
                                                            salvaContrato('gridContrato','formContrato'); 
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    text: 'Cancelar',
                                                    margin: '10 5 5 10',
                                                    width: 90, 
                                                    padding: 2,
                                                    listeners: {
                                                        click: function () {
                                                            cancelarEdit('gridContrato', 'formContrato');

                                                        }
                                                    }

                                                }]


                                        }]
                                        
                                }]
                                
                            }]
                    }]
            });
                clienteStore.load();
                produtoStore.load();
                contratoStore.load({params:{start:0, limit:18}});
            });




        </script>
        
          </head>
    <body>
       
    </body>
</html>
