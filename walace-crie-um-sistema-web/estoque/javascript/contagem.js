// rotinas javascript para contagem
// inventário

function contagem() {};
contagem.prototype = {
buscaContagem:	function() {
					var params='classe=inventario&metodo=buscaContagem&arquivo_classe=estoque/classes/classe_inventario.inc';
					params += '&INVENTARIO_CODIGO='+objSelect.checked('INVENTARIO_CODIGO');
					ObjProcAjax.runPost('executa_busca_ajax.php5','CONTAGEM_NUMERO',params);
				},
buscaProdutos:	function() {
					this.habilita();
					objSelect.clearAll('PRODUTO_CODIGO');
					objSelect.clearAll('LOCAL_CODIGO');
					if(objSelect.checked('INVENTARIO_CODIGO')!=='-') {
						var params='classe=inventarioproduto&metodo=buscaprodutos&arquivo_classe=estoque/classes/classe_inventarioproduto.inc';
						params += '&INVENTARIO_CODIGO='+objSelect.checked('INVENTARIO_CODIGO');
						ObjProcAjax.runPost('executa_busca_ajax.php5',null,params,objContagem.addProdutos);
					}
				},
addProdutos:	function(txt) {
					var arr = txt.evalJSON();
					objSelect.addOption('PRODUTO_CODIGO','-','Selecione o produto');
					for(var i=0;i<arr.length;i++) {
						objSelect.addOption('PRODUTO_CODIGO',arr[i].PRODUTO_CODIGO,arr[i].PRODUTO_DESC);
					}
				},
buscaLocais:	function() {
					this.habilita();
					objSelect.clearAll('LOCAL_CODIGO');
					if(objSelect.checked('PRODUTO_CODIGO')!=='-') {
						var params='classe=inventarioproduto&metodo=buscalocais&arquivo_classe=estoque/classes/classe_inventarioproduto.inc';
						params += '&INVENTARIO_CODIGO='+objSelect.checked('INVENTARIO_CODIGO') +
								  '&PRODUTO_CODIGO='+objSelect.checked('PRODUTO_CODIGO');
						ObjProcAjax.runPost('executa_busca_ajax.php5',null,params,objContagem.addLocais);
					}
				},
addLocais:		function(txt) {
					var arr = txt.evalJSON();
					objSelect.addOption('LOCAL_CODIGO','-','Selecione o Local');
					if(arr.length===0) {
						objContagem.buscaProdutos();
					} else {
						for(var i=0;i<arr.length;i++) {
							objSelect.addOption('LOCAL_CODIGO',arr[i].LOCAL_CODIGO,arr[i].LOCAL_DESC);
						}
					}
				},
habilita:		function() {
					var i = objSelect.checked('INVENTARIO_CODIGO');
					if(i==='-') {
						objSelect.clearAll('PRODUTO_CODIGO');
					}
					var p = objSelect.checked('PRODUTO_CODIGO');
					if(p==='-') {
						objSelect.clearAll('LOCAL_CODIGO');
					}
					var l = objSelect.checked('LOCAL_CODIGO');
					var h = (i==='-'||p==='-'||l==='-') ? true : false;
					document.getElementById('CONTAGEM_ESTOQUE').disabled = h;
					if(h===false) {
						document.getElementById('CONTAGEM_ESTOQUE').focus();
					}
				},
gravar:			function() {
					var i = objSelect.checked('INVENTARIO_CODIGO');
					var p = objSelect.checked('PRODUTO_CODIGO');
					var l = objSelect.checked('LOCAL_CODIGO');
					var q = document.getElementById('CONTAGEM_ESTOQUE').value;
					if(i==='-'||p==='-'||l==='-'||q===''||q===0) {
						alert('Erro no processamento...Informe os dados do inventário/contagem');
						document.getElementById('INVENTARIO_CODIGO').focus();
					} else {
						if(objForm.estaOk()===true) {
							// Gravar os dados da Contagem
							var c = document.getElementById('CONTAGEM_NUMERO').value;
							var params='classe=contagem&metodo=gravarContagem&arquivo_classe=estoque/classes/classe_contagem.inc';
							params += '&INVENTARIO_CODIGO='+i+'&PRODUTO_CODIGO='+p;
							params += '&LOCAL_CODIGO='+l+'&CONTAGEM_ESTOQUE='+q+'&CONTAGEM_NUMERO='+c;
							ObjProcAjax.runPost('executa_busca_ajax.php5',null,params,objContagem.posgravar);
						}
					}
				},
addColuna:		function(tr,v) {
					var td  = document.createElement("TD");
					td.appendChild(document.createTextNode(v));
				    td.style.textAlign = 'center';
					tr.appendChild(td);
				},
posgravar:		function(txt) {
				    var tbody = document.getElementById('TAB_CONTAGEM').getElementsByTagName("TBODY")[0];
    				var row = document.createElement("TR");
				    objContagem.addColuna(row,objSelect.texto('INVENTARIO_CODIGO'));
				    objContagem.addColuna(row,document.getElementById('CONTAGEM_NUMERO').value);
				    objContagem.addColuna(row,objSelect.texto('PRODUTO_CODIGO'));
				    objContagem.addColuna(row,objSelect.texto('LOCAL_CODIGO'));
				    objContagem.addColuna(row,document.getElementById('CONTAGEM_ESTOQUE').value);
				    objContagem.addColuna(row,txt);
				    tbody.appendChild(row);
				    objContagem.buscaLocais();
				    document.getElementById('CONTAGEM_ESTOQUE').value = '';
				}
};

var objContagem = new contagem();
var objSelect   = new Select(); 