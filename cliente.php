
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
        <title>Clientes</title>


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
            Ext.define('Cliente', {
            extend: 'Ext.data.Model',
                    fields: ['idcli','razaosocial', 'cnpj', 'inscricaoestadual', 'rua', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'cep', 'contato']

            });
            //a data store sera onde os dados do banco serão 'puxados' e armazenaodos para serem mostrados para o grid
            var cliStore = Ext.create('Ext.data.Store', {
            model: 'Cliente',
            pageSize: 18,
            remoteSort: true,
            proxy: {
                    type: 'ajax',
                    url:'listaClientes.php',
                    reader:{
                        type: 'json',
                        root: 'clientes',
                        totalProperty: 18
                    }
                    
                },
                autoLoad: false
            
            });
            
            Ext.Loader.setPath(); //carregar os caminhos no carregador de classes
            Ext.require(['*']); //incluir todas as classes do Ext no javascript
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
                                                        text: 'Cadastro de Contratos',
                                                        handler: function() {
                                                            window.location.href = 'contrato.php'; 
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
                                        }]
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
                                    margin: '2 5 2 2',
                                    listeners: {
                                        click: function () {
                                            novoForm('gridCliente', 'formCliente');

                                            }
                                        }
                                    },  {
                                    xtype: 'button',
                                            text: 'Editar',
                                            width: 60,
                                            margin: '2 5 2 2',
                                            listeners: {
                                                click: function () {
                                                    editarForm('gridCliente', 'formCliente');

                                                }
                                            }
                                    },{
                                    xtype: 'button',
                                            text: 'Excluir',
                                            width: 60,
                                            margin: '2 5 5 2',
                                            listeners: {
                                                click: function () {
                                                    excluirCliente('gridCliente');

                                                }
                                            }
                                    }]
                    },{ 
                    xtype: 'grid',
                            store: cliStore, // selecionando a Store de onde os dados devem ser 'puxados' para o grid
                            id: 'gridCliente',
                            region: 'center',
                            width: '100%',
                            margin: '5 0 0 0',
                            title: 'Clientes',
                            columns: [{
                                text: 'Razão Social',
                                        width: 220,
                                        dataIndex: 'razaosocial'
                                },
                                {
                                text: 'CNPJ',
                                        width: 150,
                                        dataIndex: 'cnpj'
                                },
                                {
                                text: 'Insc. Estadual',
                                        width: 150,
                                        dataIndex: 'inscricaoestadual'
                                },
                                {
                                text: 'Rua',
                                        width: 100,
                                        dataIndex: 'rua'
                                },
                                {
                                text: 'Número',
                                        width: 100,
                                        dataIndex: 'numero'
                                },
                                {
                                text: 'Bairro',
                                        width: 100,
                                        dataIndex: 'bairro'
                                },
                                {
                                text: 'Complemento',
                                        width: 100,
                                        dataIndex: 'complemento'
                                },
                                {
                                text: 'Cidade',
                                        width: 100,
                                        dataIndex: 'cidade'
                                },
                                {
                                text: 'UF',
                                        width: 50,
                                        dataIndex: 'uf'
                                },
                                {
                                text: 'C.E.P.',
                                        width: 90,
                                        dataIndex: 'cep'
                                },
                                {
                                text: 'Contato',
                                        width: 120,
                                        dataIndex: 'contato'
                                }],
                            tbar : new Ext.PagingToolbar({                                    
                                    
                                    store: cliStore,
                                    displayInfo: true,
                                    displayMsg: 'Mostrando clientes',
                                    emptyMsg: "Desculpe, mas não há items para exibir."
                            })

                    }, {
                            xtype: 'panel',
                                layout: 'anchor',
                                width: 700,
                                heigth: 500,
                                margin: '30 auto auto 300',
                                items:[{
                                    xtype: 'form',
                                    id: 'formCliente',
                                    title: 'Cadastro de clientes',
                                    bodyBorder: true,
                                    border: true,
                                    tipo: 'cliente',
                                    anchor: '100%, 90%',
                                    hidden: true,
                                    items:[{
                                    xtype: 'textfield',
                                            name: 'razaosocial',
                                            width: '50%',
                                            margin: '30 0 0 50',
                                            fieldLabel: 'Razão Social'
                                    }, {
                                    xtype:'textfield',
                                            name: 'cnpj',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'CNPJ'

                                    },{
                                    xtype:'textfield',
                                            name: 'idcli',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            hidden: true

                                    },{
                                    xtype: 'textfield',
                                            name: 'inscricaoestadual',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Insc. Estadual'
                                    }, {
                                    xtype: 'textfield',
                                            name: 'rua',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Rua'
                                    }
                                    , {
                                    xtype: 'textfield',
                                            name: 'numero',
                                            width: '50%', 
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Número'
                                    }
                                    , {
                                    xtype: 'textfield',
                                            name: 'bairro',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Bairro'
                                    }, {
                                    xtype: 'textfield',
                                            name: 'complemento',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Complemento'
                                    }, {
                                    xtype: 'textfield',
                                            name: 'cidade',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Cidade'
                                    }
                                    , {
                                    xtype: 'textfield',
                                            name: 'uf',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'UF'
                                    }, {
                                    xtype: 'textfield',
                                            name: 'cep',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'C.E.P.'
                                    }, {
                                    xtype: 'textfield',
                                            name: 'contato',
                                            width: '50%',
                                            margin: '5 0 0 50',
                                            fieldLabel: 'Contato'
                                    }, {
                                    xtype: 'panel',
                                            width: '100%',
                                            margin: '5 0 10 0',
                                            height: 100,
                                            items: [{
                                            xtype: 'button',
                                                    text: 'Salvar',
                                                    width: 90,
                                                    margin: '10 5 5 135',
                                                    listeners: {
                                                    click: function () {
                                                            salvaCliente('gridCliente', 'formCliente');
                                                        }
                                                    }
                                            },
                                            {
                                            xtype: 'button',
                                                    text: 'Cancelar',
                                                    width: 90,
                                                    margin: '10 5 5 10',                                                    listeners: {
                                                    click: function () {
                                                            cancelarEdit('gridCliente', 'formCliente');
                                                        }
                                                    }

                                            }]


                                }]
                            }]
                        }]
                    }]
                });
                cliStore.load({params:{start:0, limit:18}})
         });
         
        </script>

    </head>
    <body>

    </body>
</html>