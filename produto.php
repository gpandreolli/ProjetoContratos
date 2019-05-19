
<?php
$pathSite = 'http://localhost/';
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
        <title>Produtos</title>


        <!--criando link do arquivo de script do Extjs-->
        <script src="<?php echo $pathSite; ?>ext6/build/ext-all.js"></script>

        <!--cria link do arquivo css do tema crips do Extjs-->
        <link rel="stylesheet" type="text/css" href="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/resources/theme-crisp-all.css">

        <!--cria link do arquivo js do tema crips do Extjs-->
        <script src="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/theme-crisp.js"></script>

        <!--cria link do arquivo de funçoes do extjs-->
        <script src="<?php echo $pathSite; ?>/ProjetoContratos/javascript.js"></script>

        <script>

            //Define os dados a serem mostrados no grid
            Ext.define('Produto', {
            extend: 'Ext.data.Model',
                    fields: ['idprod', 'nome', 'descrição', 'setor']

            });
            //a data store sera onde os dados do banco serão 'puxados' e armazenaodos para serem mostrados para o grid
            var produtoStore = Ext.create('Ext.data.Store', {
            model: 'Produto',
            pageSize: 18,
            remoteSort: true,
            proxy: {
                    type: 'ajax',
                    url:'listaProdutos.php',
                    
                    reader:{
                        type: 'json',
                        root: 'produtos',
                        totalProperty: 'total'
                    }
                    
                },
                autoLoad: true
            
            });
            
            Ext.Loader.setPath();
            Ext.require(['*']);
            //carregando a função on-load do js para executar os scripts depois q a pagina foi carregada
            Ext.onReady(function () {
            Ext.create({
            xtype: 'viewport',
                    layout: 'fit',
                    renderTo: Ext.getBody(), //renderizando na <div id="CadastroCliente">
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
                                                text: 'Cadastro de Contratos',
                                                handler: function() {
                                                    window.location.href = 'contrato.php';
                                                }
                                                
                                            },{
                                                text: 'Sair',
                                                    handler: function() {
                                                           window.location.href = 'index.php?logout=1';
                                                    }

                                                }]
                                            }                                    
                                },'-',
                                '->', 
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
                                            novoForm('gridProduto', 'formProduto');

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
                                            editarForm('gridProduto', 'formProduto');

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
                                                excluirProduto('gridProduto', 'formProduto');

                                            }
                                        }
                                }]
                    }, {
                    xtype: 'grid',
                            store: produtoStore, // selecionando a Store de onde os dados devem ser 'puxados' para o grid
                            region: 'center',
                            width: '100%',
                            margin: '5 0 0 0',
                            id: 'gridProduto',
                            title: 'Produtos',
                            columns: [{
                                    dataIndex: 'idprod',
                                    hidden: true
                            },{
                                    text: 'Nome',
                                    width: 220,
                                    dataIndex: 'nome'
                            },{
                            text: 'Descrição',
                                    width: 150,
                                    dataIndex: 'descricao'
                            },{
                            text: 'Setor Atendido',
                                    width: 150,
                                    dataIndex: 'setor'
                            }],
                            tbar : new Ext.PagingToolbar({                                    
                                    
                                    store: produtoStore,
                                    displayInfo: true,
                                    displayMsg: 'Mostrando produtos',
                                    emptyMsg: "Desculpe, mas não há items para exibir."
                                
                                })

                    }, {
                        xtype: 'panel',
                        layout: 'anchor',
                        width: 700,
                        height: '100%',
                        margin: '170 auto auto 450',
                        items:[{
                           xtype: 'form',
                            bodyBorder: true,
                            border: true,
                            title: 'Cadastro de produtos',
                            id: 'formProduto',
                            tipo: 'produto',
                            anchor: '50%, 50%',
                            hidden: true,
                            items:[{
                            xtype: 'textfield',
                                    
                                    name: 'idprod',
                                    hidden: true
                            },{
                            xtype: 'textfield',
                                    name: 'nome',
                                    margin:'5 0 0 5',
                                    fieldLabel: 'Nome'
                            }, {
                            xtype:'textfield',
                                    name: 'descricao',
                                    margin:'5 0 0 5',
                                    fieldLabel: 'Descrição'

                            }, {
                            xtype: 'textfield',
                                    name: 'setor',
                                    margin:'5 0 0 5',
                                    fieldLabel: 'Setor Atendido'
                            }, {
                            xtype: 'panel',
                                    width: '100%',
                                    height: 50,
                                    margin: '10 10 10 10',
                                    items: [{
                                        xtype: 'button',
                                                text: 'Salvar',
                                                margin: '5 5 5 50',
                                                width: 90,
                                                height: 30,
                                                padding: 2,
                                                listeners: {
                                                click: function () {
                                                        salvaProduto('gridProduto', 'formProduto');

                                                    }
                                                }
                                        },
                                        {
                                        xtype: 'button',
                                                text: 'Cancelar',
                                                margin: '5 5 5 5',
                                                height: 30,
                                                width: 90, 
                                                listeners: {
                                                click: function () {
                                                        cancelarEdit('gridProduto', 'formProduto');

                                                    }
                                                }

                                        }]


                                    }]
                                }]
                              
                           }]
                        }]
                    
                });
            });
        </script>

    </head>
    <body>

    </body>
</html>