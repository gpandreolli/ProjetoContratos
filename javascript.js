
        //funcao que abre o form com os dados do registro selecionado no grid
                function editarForm(grid, form) {

                    grid = Ext.getCmp(grid);
                    var rec = grid.getSelectionModel().getSelection();
                    if (rec) {
                        form = Ext.getCmp(form);
                        form.acao = 'edita';
                        form.loadRecord(rec[0]);
                        grid.hide();
                        form.show(); 
                    }

                }
        //botao cancelar fecha o form (form.reset) e limpa os dados do form(form.reset)
        function cancelarEdit(grid, form) {
            form = Ext.getCmp(form);
            grid = Ext.getCmp(grid);
            form.reset();
            form.hide();            
            grid.show();
            grid.store.reload();
            
        }
        
        

        //funcao que abre o form para cadastrar novo registro
        function novoForm(grid, form) {
            form = Ext.getCmp(form);
            form.acao = 'novo';
            Ext.getCmp(grid).hide();
            form.show();

        }
        //botao salva registros cadastrados no form do Contrato
        function salvaContrato(grid, form) {
            form = Ext.getCmp(form); 
            grid = Ext.getCmp(grid);
            if (form.isValid()) {
                var campos = form.getValues();               
                Ext.Ajax.request({
                    url: 'manutencao.php',
                    method: 'POST',
                    
                    params: {
                        manut_contrato: JSON.stringify(campos),
                        tipo: form.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){                                
                                form.reset();
                                form.hide();            
                                grid.show();
                                grid.store.reload();
                        });
                    }
                });
            } else {
                Ext.Msg.alert('Erro', 'Favor preencher os campos corretamente');
            }
        }
        
        //botao salva registros cadastrados no form do Cliente
        function salvaCliente(grid, form) {
            grid = Ext.getCmp(grid);
            form = Ext.getCmp(form);
            if (form.isValid()) {
                var camposcli = form.getValues();                
                Ext.Ajax.request({
                    url: 'manutCliente.php',
                    method: 'POST',
                    params: {
                        manut_cliente: JSON.stringify(camposcli),
                        tipo: form.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                form.reset();
                                form.hide();            
                                grid.show();
                                grid.store.reload();
                        });
                    }
                });
            } else {
                Ext.Msg.alert('Erro', 'Favor preencher os campos corretamente');
            }
        }


        //botao salva registros cadastrados no form do Produto
        function salvaProduto(grid, form) {
            form = Ext.getCmp(form);
            grid = Ext.getCmp(grid)
            if (form.isValid()) {
                var camposprod = form.getValues();                
                Ext.Ajax.request({
                    url: 'manutProduto.php',
                    method: 'POST',
                    params: {
                        manut_prod: JSON.stringify(camposprod),
                        tipo: form.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                form.reset();
                                form.hide();            
                                grid.show();
                                grid.store.reload();
                        });
                    }
                });
            } else {
                Ext.Msg.alert('Erro', 'Favor preencher os campos corretamente');
            }
        }


        function logar(form) {
            form = Ext.getCmp(form);
            if (form.isValid()) {
                var camposlog = form.getValues();                
                Ext.Ajax.request({
                    url: 'login.php',
                    method: 'POST',
                    params: {
                        manut_login: JSON.stringify(camposlog)
                        },
                    callback: function (options, success, response) {
                      
                            if(response.responseText == 'aleluia'){
                                  window.location.href = 'principal.php';
                            }else{
                                  window.location.href = 'index.php';                        
                            }
                    }
                        
                });
            }else {
                Ext.Msg.alert('Erro', 'Favor preencher os campos corretamente');
            }


        }
        
        
        
        
        function excluirContrato(grid){
           
            grid = Ext.getCmp(grid);
            grid.acao = 'excluir';
            var selecao = grid.getSelectionModel().getSelection();
            var rec = selecao[0].get('idcontrato');    
                        
            if(rec){
                Ext.Ajax.request({
                    url: 'manutencao.php',
                    method: 'POST',
                    params:{
                        excluir_contrato: rec,
                        tipo: grid.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                grid.store.reload();
                        });
                    }
                });
            }
        }
        
        function excluirCliente(grid){
            grid = Ext.getCmp(grid);
            grid.acao = 'excluir';
            var selecao = grid.getSelectionModel().getSelection();
            var rec = selecao[0].get('idcli');    
                        
            if(rec){
                Ext.Ajax.request({
                    url: 'manutCliente.php',
                    method: 'POST',
                    params:{
                        excluir_cliente: rec,
                        tipo: grid.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                grid.store.reload();
                        });
                    }
                });
            }
        }
       

//botao salva registros cadastrados no form do Cliente
        function SalvaUsuario(grid, form) {
            grid = Ext.getCmp(grid);
            form = Ext.getCmp(form);
            if (form.isValid()) {
                var camposuser = form.getValues();                
                Ext.Ajax.request({
                    url: 'manutUsuario.php',
                    method: 'POST',
                    params: {
                        manut_user: JSON.stringify(camposuser),
                        tipo: form.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                form.reset();
                                form.hide();            
                                grid.show();
                                grid.store.reload();
                        });
                    }
                });
            } else {
                Ext.Msg.alert('Erro', 'Favor preencher os campos corretamente');
            }
        }

function excluirProduto(grid){
            grid = Ext.getCmp(grid);
            grid.acao = 'excluir';
            var selecao = grid.getSelectionModel().getSelection();
            var rec = selecao[0].get('idprod');    
                        
            if(rec){
                Ext.Ajax.request({
                    url: 'manutProduto.php',
                    method: 'POST',
                    params:{
                        excluir_prod: rec,
                        tipo: grid.acao
                    },
                    callback: function (options, success, response) {
                        Ext.Msg.alert('Sucesso', response.responseText, function(){
                                grid.store.reload();
                        });
                    }
                });
            }
        }

