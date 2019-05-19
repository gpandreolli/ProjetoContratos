    
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
        <script src="<?php echo $pathSite; ?>ext6/build/ext-all.js"></script>

        <!--cria link do arquivo css do tema crips do Extjs-->
        <link rel="stylesheet" type="text/css" href="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/resources/theme-crisp-all.css">
        
       
        
        
        
        <!--cria link do arquivo js do tema crips do Extjs-->
        <script src="<?php echo $pathSite; ?>ext6/build/classic/theme-crisp/theme-crisp.js"></script>
        
        <!--cria link do arquivo de funçoes do extjs-->
        <script src="<?php echo $pathSite; ?>/ProjetoContratos/javascript.js"></script>

        <!-- link do arquivo locale-->
        <script type="text/javascript" src="<?php echo $pathSite; ?>ext6/classic/locale/overrides/pt_BR/ext-locale-pt_BR.js"></script>
        
        <script>

            //Define os dados a serem mostrados no grid
            Ext.define('Usuario', {
                extend: 'Ext.data.Model',
                fields: ['iduser', 'senha', 'login', 'nome']

            });

            //a data store sera onde os dados do banco serão 'puxados' e armazenaodos para serem mostrados para o grid
            var usuarioStore = Ext.create('Ext.data.Store', {
                model: 'Usuario',
                proxy: {
                    type: 'ajax',
                    url:'listaUsuarios.php',
                    reader:{
                        type: 'json',
                        root: 'users',
                        valueField: 'iduser'
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
                        renderTo: 'CadastroUsuario', //renderizando na <div id="CadastroContrato">
                        items: [{
                        xtype: 'panel',
                        //layout: 'border',
                        //region: 'center',
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
                                            },,{
                                                text: 'Cadastro de Contratos',
                                                handler: function() {
                                                    window.location.href = 'contrato.php'; 
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
                                        margin: '2 5 2 2',
                                        cls: 'botao_novo',
                                        listeners: {
                                            click: function () {
                                                novoForm('gridUsuario', 'formUsuario');

                                            }
                                        }


                                    },
                                    {
                                        xtype: 'button',
                                        text: 'Editar',
                                        width: 60,
                                        margin: '2 5 2 2',        
                                        listeners: {
                                            click: function () {
                                                editarForm('gridUsuario', 'formUsuario');

                                            }
                                        }

                                    }]
                            }, {
                                xtype: 'grid',
                                id: 'gridUsuario',
                                store: usuarioStore, // selecionando a Store de onde os dados devem ser 'puxados' para o grid
                                region: 'center',
                                width: '100%',
                                margin: '5 0 0 0',
                                title: 'Usuários',
                                columns: [{
                                        dataIndex: 'iduser',
                                        hidden: true
                                    },{
                                        dataIndex: 'senha',
                                        hidden: true
                                    },
                                    {
                                        text: 'Login',
                                        width: 200,
                                        dataIndex: 'login'
                                    },
                                    {
                                        text: 'Nome',
                                        width: 140,
                                        dataIndex: 'nome',
                                    }],
                                tbar : new Ext.PagingToolbar({                                    
                                    
                                    store: usuarioStore,
                                    displayInfo: true,
                                    displayMsg: 'Mostrando usuarios',
                                    emptyMsg: "Desculpe, mas não há items para exibir."
                                
                                })

                            },{
                                xtype: 'panel',
                                layout: 'anchor',
                                width: 700,
                                heigth: 550,
                                margin: '30 auto auto 300',
                                items:[{
                                    xtype: 'form',  
                                    anchor: '100%, 90%',
                                    title: 'Cadastro de Usuários',
                                    id: 'formUsuario',
                                    tipo: 'usuario',
                                    border: true,
                                    bodyBorder: true,
                                    hidden: true,
                                    items: [,{
                                            xtype: 'textfield',
                                            name:'iduser',
                                            hidden: true
                                        },
                                        {
                                            xtype: 'textfield',
                                            name: 'login',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            fieldLabel: 'Login',
                                        },
                                        {
                                            xtype: 'textfield',
                                            inputType: 'password',
                                            width: '70%',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            name: 'senha',
                                            fieldLabel: 'Senha'
                                        },
                                        {
                                            xtype: 'textfield',
                                            padding: '5',
                                            margin: '10 0 3 30',
                                            width: '70%',
                                            name: 'nome',
                                            fieldLabel: 'Nome',
                                        },
                                        {
                                            xtype: 'panel',
                                            width: '50%',

                                            items: [{
                                                    xtype: 'button',
                                                    margin: '5 50 5 50',
                                                    width: 90,
                                                    padding: 2,
                                                    text: 'Salvar',                                                
                                                    listeners: {
                                                        click: function () {
                                                             SalvaUsuario('gridUsuario', 'formUsuario');
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    text: 'Cancelar',
                                                    margin: '5 50 5 50',
                                                    width: 90,    
                                                    listeners: {
                                                        click: function () {
                                                            cancelarEdit('gridUsuario', 'formUsuario');

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
        <div id="CadastroUsuario" style="width:100%;height:1000px;"></div>

    </body>
</html>
