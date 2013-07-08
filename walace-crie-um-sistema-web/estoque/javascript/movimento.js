function movimento() {};
movimento.prototype = {
FOk: false,
FEntrada: true,
FEstorno: false,
inicializa:		function(){
					this.FOk=false;
					if(this.FEstorno!==true) {
						document.getElementById('PRODUTO_DESC').value='';
						document.getElementById('PRODUTO_ESTOQUE').value='';
						document.getElementById('PRODUTO_CUSTOMEDIO').value='';
						document.getElementById('LOCAL_CODIGO').selectedIndex=0;
						document.getElementById('TIPOMOV_CODIGO').selectedIndex=0;
					} else {
						this.FOk = true;
					}
				},
buscar: 		function() {
					var params='classe=produto&metodo=buscarXML&arquivo_classe=estoque/classes/classe_produto.inc';
					params += '&campos=PRODUTO_CODIGO&valores='+document.getElementById('PRODUTO_CODIGO').value;
					ObjProcAjax.runPostXML('executa_busca_ajax.php5',params,objBP.processa);
				},
processa: 		function(xml){
					var l = xml.childNodes[0].childNodes[0];
					var vlr = l.getElementsByTagName('PRODUTO_DESC')[0];
					document.getElementById('PRODUTO_DESC').value = (vlr.hasChildNodes() ? vlr.firstChild.nodeValue : '');
					var vlr = l.getElementsByTagName('PRODUTO_ESTOQUE')[0];
					document.getElementById('PRODUTO_ESTOQUE').value = (vlr.hasChildNodes() ? vlr.firstChild.nodeValue : '0,000');
					var vlr = l.getElementsByTagName('PRODUTO_CUSTOMEDIO')[0];
					document.getElementById('PRODUTO_CUSTOMEDIO').value = (vlr.hasChildNodes() ? vlr.firstChild.nodeValue : '0,00');
					objBP.FOk=true;
					// Se for uma saida, colocar valor_unitario=preco_atual ou custo_atual????
					if(this.FEntrada!==true&&this.FEstorno!==true) {
						document.getElementById('HISTORICO_VALOR_UNIT').value = document.getElementById('PRODUTO_CUSTOMEDIO').value;
						document.getElementById('CUSTO_SAIDA').value = document.getElementById('PRODUTO_CUSTOMEDIO').value;
					};
					document.getElementById('LOCAL_CODIGO').focus();
				},
produtoOk:		function() {
					if(this.FOk!==true&&this.FEstorno!==true){ 
						alert('Selecione um produto primeiro');
						document.getElementById('PRODUTO_CODIGO').focus();
						return false;
					} else {
						return true;
					}
				},
buscaLocal:		function() {
					if(this.produtoOk()!==true){ 
						document.getElementById('LOCAL_CODIGO').selectedIndex=0;
					} else {
						var local = document.getElementById('LOCAL_CODIGO').options[document.getElementById('LOCAL_CODIGO').selectedIndex].value;
						if(local!='-') {
							var params='classe=estoquelocal&metodo=buscarXML&arquivo_classe=estoque/classes/classe_estoquelocal.inc';
							params += '&campos=PRODUTO_CODIGO,LOCAL_CODIGO&valores='+document.getElementById('PRODUTO_CODIGO').value;
							params += ','+local;
							ObjProcAjax.runPostXML('executa_busca_ajax.php5',params,objBP.EstoqueLocal);
						} else {
							document.getElementById('LOCAL_ESTOQUE').value = '-';
						}
					};
					this.habilitaCampos();
				},
validaTipomov:	function() {
					if(this.produtoOk()!==true){ 
						document.getElementById('TIPOMOV_CODIGO').selectedIndex=0;
					};
					this.habilitaCampos();
				},
EstoqueLocal:	function(xml) {
					var est = '0,000';
					if(xml.hasChildNodes()&&xml.childNodes[0].hasChildNodes()) {
						var l = xml.childNodes[0].childNodes[0];
						var vlr = l.getElementsByTagName('PRODUTO_ESTOQUE')[0];
						est =  (vlr.hasChildNodes() ? vlr.firstChild.nodeValue : '');
					}
					document.getElementById('LOCAL_ESTOQUE').value = est;
				},
habilitaCampos:	function() {
					var enabled = false;
					if(document.getElementById('LOCAL_CODIGO').selectedIndex>0&&document.getElementById('TIPOMOV_CODIGO').selectedIndex>0) {
						enabled = true;
					};
					document.getElementById('HISTORICO_DOCUMENTO').disabled = !enabled;
					document.getElementById('HISTORICO_QUANTIDADE').disabled = !enabled||(this.FEstorno===true);
					if(this.FEntrada===true) {
						document.getElementById('HISTORICO_VALOR_UNIT').disabled = !enabled||(this.FEstorno===true);
						document.getElementById('HISTORICO_VALOR_TOTAL').disabled = !enabled||(this.FEstorno===true);
					}
					document.getElementById('HISTORICO_HISTORICO').disabled = !enabled;
					document.getElementById('HISTORICO_DATA').disabled = !enabled;
					if(!enabled&&this.FEstorno!==true) {
						document.getElementById('HISTORICO_DOCUMENTO').value = '';
						document.getElementById('HISTORICO_QUANTIDADE').value = '';
						if(this.FEntrada===true) {
							document.getElementById('HISTORICO_VALOR_UNIT').value = '';
							document.getElementById('HISTORICO_VALOR_TOTAL').value = '';
						}
						document.getElementById('HISTORICO_HISTORICO').innerHTML = '';
						document.getElementById('HISTORICO_DATA').value = '';
					} else {
						document.getElementById('HISTORICO_DATA').focus();
					}
				}
};
var objBP = new movimento();

function formataNumero(n) {
	var cent = n%1;
	n -= cent;
	cent = Math.round(cent*100);
	return n + ',' + (cent<10 ? '0' : '')+ cent;
};

// Recalculo de Valores
function recalculoValores(obj) {
	var q = document.getElementById('HISTORICO_QUANTIDADE');
	var v = document.getElementById('HISTORICO_VALOR_UNIT');
	var t = document.getElementById('HISTORICO_VALOR_TOTAL');
	var qde = parseFloat(q.value.replace(/,/gi,'.'));
	var vun = parseFloat(v.value.replace(/,/gi,'.'));;
	var vtt = parseFloat(t.value.replace(/,/gi,'.'));
	if(isNaN(vun)) { vun = 0};
	if(isNaN(vtt)) { vtt = 0};
	if(obj.id==='HISTORICO_VALOR_UNIT'||obj.id==='HISTORICO_QUANTIDADE') {
		t.value = formataNumero(qde*vun);
	} else {
		v.value = formataNumero(vtt/qde);
	}
};