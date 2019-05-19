
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
        <title>Informações Contratos</title>


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
            Ext.define('Consulta', {
                extend: 'Ext.data.Model',
                fields: ['idcontrato', 'status', 'cliente', 'razaosocial', 'numerocontrato', 'nome', 'produto', 'datafim','contato']

            });

            //a data store sera onde os dados do banco serão 'puxados' e armazenaodos para serem mostrados para o grid
            var consultaStore = Ext.create('Ext.data.Store', {
                model: 'Consulta',
                pageSize: 20,
                remoteSort: true,
                proxy: {
                    type: 'ajax',
                    url: 'listaPrincipal.php',
                    reader:{
                        type: 'json',
                        root: 'consultas',
                        totalProperty: 'total',
                        valueField: 'idcontrato' 
                    }
                    
                },
                autoLoad: false  
            });
            
            Ext.Loader.setPath();
            Ext.require(['*']);
            //carregando a função on-load do js para executar os scripts depois q a pagina foi carregada
            Ext.onReady(function () {
            Ext.create({
                xtype: 'viewport',
                    renderTo: 'ConsultaContratos', //renderizando na <div id="ConsultaContratos">
                    items: [{
                        xtype: 'panel',
                        
                        items: [{
                            xtype: 'panel',
                                    width: '100%',
                                    height: '100%',
                                    tbar: [{
                                        xtype: 'toolbar',
                                        flex: 1,
                                        dock: 'top',
                                        items: [{
                                                xtype: 'button', // default for Toolbars
                                                text: 'Menu',
                                                menu: {
                                                    items:[{
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
                                                            text: 'Cadastro de Usuários',
                                                            handler: function() {
                                                                window.location.href = 'usuario.php';
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
                                            },{
                                                xtype: 'button',
                                                text: 'Procurar'
                                            }
                                        ]
                                    }],
                                items:[{
                                        xtype: 'grid',
                                        id: 'gridPrincipal',
                                        store: consultaStore,
                                        title:'Informações de Contratos',
                                        width: '100%',
                                            columns:[{
                                                text: 'Status',
                                                width: 250,
                                                dataIndex: 'status'
                                                
                                            },{
                                                text: 'Cliente',
                                                width: 300,
                                                dataIndex: 'razaosocial'
                                            },{
                                               text: 'Numero do contrato',
                                               width: 180,
                                               dataIndex: 'numerocontrato'
                                            },{
                                                text:'Produto',
                                                width: 150,
                                                dataIndex: 'nome'                                    
                                            },{
                                                text: 'Data Término do Contrato',
                                                width: 200,
                                                dataIndex: 'datafim',
                                                renderer: function(value){
                                                var data = value.split('-');
                                                return data[2]+'/'+data[1]+'/'+data[0];
                                            },
                                            },{
                                                text: 'Contato',
                                                width: 200,
                                                dataIndex: 'contatocontrato'
                                            }],
                                        tbar : new Ext.PagingToolbar({ 
                                            store: consultaStore,
                                            displayInfo: true,
                                            displayMsg: 'Consulta',
                                            emptyMsg: "Desculpe, mas não há items para exibir."
                                        })
                                }]

                        }]
                }]
            });
            consultaStore.load({params:{start:0, limit:20}});
        });
              
</script>
        
  </head>
    <body>
        <div id="ConsultaContratos" ></div>

    </body>
</html>
