

<?php
        if(isset($_GET['logout'])){
            session_start();
            unset($_SESSION['login']); 
        }           
	$pathSite = 'http://localhost/'//$_SERVER["HTTP_REFERER"];
	//ARMAZENA O ENDEREÇO DO SERVIDOR
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>	

	<!--criando link do arquivo de script do Extjs-->
	<script src="<?php echo $pathSite;?>ext6/build/ext-all-debug.js"></script>

	<!--cria link do arquivo de funçoes do extjs-->
        <script src="<?php echo $pathSite; ?>ProjetoContratos/javascript.js"></script>

	<!--cria link do arquivo css do tema crisp do Extjs-->
	<link rel="stylesheet" type="text/css" href="<?php echo $pathSite;?>ext6/build/classic/theme-crisp/resources/theme-crisp-all.css">
	<script src="<?php echo $pathSite;?>ext6/build/classic/theme-crisp/theme-crisp.js"></script>
	<script >
		Ext.Loader.setPath();
		Ext.require(['*']);
		//carregando a função on-load do extjs para executar os scripts depois q a pagina foi carregada
		Ext.onReady(function (){
			Ext.create({
                            xtype: 'viewport',
                            renderTo: Ext.getBody(),
                            layout: 'border',
                            items:[{
				xtype: 'panel',
                                region: 'center',
                                layout: 'vbox',
				items : [{
					xtype: 'panel', 
                                        width: '100%',
                                        flex: 1
                                    },{
					xtype: 'panel',
                                        layout: 'hbox',
					width: '100%',
                                        height: 150, 
					items: [{
                                                xtype: 'panel',                                                 
                                                heigth: '100%',
                                                flex: 1
                                               },{                                                       
						xtype: 'form',
                                                border: true,
                                                bodyBorder: true,
                                                width: 450,
						id: 'formLogin',
						items: [{
							xtype: 'textfield',
							fieldLabel: 'Login',
							inputType: 'text',
							id: 'login',
                                                        name: 'login',
							width: 350,
							height: 30,
                                                        margin: '15 50 5 50'
						},{
							xtype: 'textfield',
							fieldLabel: 'Senha',
							inputType: 'password',
							id: 'senha',
                                                        name: 'senha',
							width: 350,
							height: 30,
                                                        margin: '15 50 5 50'
						},{
							xtype: 'button',
							text: 'Logar',
                                                        margin: '10 50 15 300',
							width: 100,
							height: 35,
							listeners: {
								click: function () {
                                                                 logar('formLogin');

                                                                }
							}
						}]
					},{
                                                    xtype: 'panel',
                                                    heigth: '100%',
                                                    flex: 1
                                                }]	
                                    },{
					xtype: 'panel', 
					width: '100%',
                                        flex: 1
                                    }]

			}]
                    });
		});

	</script>
</head>
<body>
	


</body>
</html>