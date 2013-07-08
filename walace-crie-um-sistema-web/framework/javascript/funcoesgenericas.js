// Exibe de forma continua a data e hora atual
function mostradatahora() {
	this.construct();
};
mostradatahora.prototype = {					
semana: [],
meses:  [],
construct:	function() {
				this.semana = ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
				this.meses  = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
			},
show:	function(div) {
			var hoje = new Date();
			var dia  = hoje.getDate();
			var mes  = this.meses[hoje.getMonth()];
			var dsem = this.semana[hoje.getDay()];
			var hora = '0'+hoje.getHours(); 
			var min  = '0'+hoje.getMinutes();
			var sec  = '00'+hoje.getSeconds();
			var agora= hora.substr(hora.length-2) + ':'+ min.substr(min.length-2) + ':' +  sec.substr(sec.length-2);
			document.getElementById(div).innerHTML = dsem + ', ' + dia + ' de ' + mes + ' de ' + hoje.getFullYear() + ' ' + agora;
			var obj = this;
			setTimeout(function() {obj.show(div);},1000);
		 }
};

var objDataHora = new mostradatahora();

// Função utilizada no retorno de Ajax.Autocompleter
function atualizaFormulario(li) {
	if(li.getAttributeNode('VALOR').nodeValue!=='0') {
		document.getElementById(li.getAttributeNode('TARGET').nodeValue).value = li.getAttributeNode('VALOR').nodeValue;
	}
};


// Processamento de Formulários
function formulario() {};
formulario.prototype = {
listaCampos: [],
construct:		function() {
					this.listaCampos = [];
				},
addCampo:		function(cpo,label,tipo,min,max,ob) {
					this.listaCampos[this.listaCampos.length] = [document.getElementById(cpo),label,tipo,min,max,parseInt(ob)];
				},
verificaCampo:	function (e,tipo,el) {
					var keynum = (window.event ? e.keyCode : (e.which ? e.which : null));
					if(keynum===8||keynum===13||typeof keynum==='undefined'||keynum===null) {
						return true;
					};
					var keychar = String.fromCharCode(keynum);
					switch(tipo) {
						case 'CUR':
						case 'FLT':
						case 'FLOAT':	var reg = /[0-9]|\-|,/;
										break;
						case 'DATE':
						case 'DTIME':
						case 'INT':		var reg = /[0-9]/;
										break;
						default:		return true;
					};
					var ok = reg.test(keychar);
					if(ok===true) {
						if(tipo==='DATE'||tipo==='DTIME') {
							el.value += (el.value.length===2||el.value.length===5) ? '-' : '';
							if(tipo==='DTIME') {
								el.value += (el.value.length===10 ? ' ' : (el.value.length===13||el.value.length===16 ? ':' :''));
							}
						} else {
							if(tipo==='FLOAT'||tipo==='CUR') {
								if(isNaN((el.value+keychar).replace(/,/g,'.'))) {
									ok = false;
								}
							}
						}
					} 
					return ok;
				},
validaDataHora: function (el,tipo,min,max) {
					var data = el.value.substr(0,10);	
					var dd = data.split('-');
					var aD = new Date(dd[2],dd[1]-1,dd[0]);
					var ok = true;
					if(aD===null||aD===undefined) {
						ok = false;
					} else if(aD.getMonth()!=(dd[1]-1)||aD.getDate()!=dd[0]||aD.getFullYear()!=dd[2]) {
								ok = false;
					} else {
						if(tipo==='DTIME') {
							var hora = el.value.substr(11,8);
							var hh   = hora.split(':');
							if(hh[0]>24||hh[1]>59||hh[2]>59) {
								ok = false;
							}
						}
					};
					if(ok===true) {
						if(min!=='0') {
							var dmin = (min.toUpperCase()==='NOW' ? new Date() : new Date(parseInt(min.substr(6,4)),parseInt(min.substr(3,2))-1,parseInt(min.substr(0,2))));
							if(aD<dmin) {
								return 'Data informada deve ser >= ' + dmin.getDate() + '-' + (dmin.getMonth()+1) + '-' + dmin.getFullYear();
							} 
						}
						if(max!=='0') {
							var dmax = (max.toUpperCase()==='NOW' ? new Date() : new Date(parseInt(max.substr(6,4)),parseInt(max.substr(3,2))-1,parseInt(max.substr(0,2))));
							if(aD>dmax) {
								return 'Data informada deve ser <= ' + dmax.getDate() + '-' + (dmax.getMonth()+1) + '-' + dmax.getFullYear();
							} 
						}
					}
					return (ok===false ? 'Não é uma Data Válida' : true);
				},
validaValor:	function (el,min,max) {
					if(el.value==='') { 
						el.value = '0';
					}
					if(isNaN(parseFloat(el.value.replace(/,/g,'.')))) {
						return 'Não é um número';
					} else {
						var vmin = (min.substr(0,1)==='[' ? document.getElementById(min.slice(1,-1).toUpperCase()).value : (min==='' ? null : min));
						var vmax = (max.substr(0,1)==='[' ? document.getElementById(max.slice(1,-1).toUpperCase()).value : (max==='' ? null : max));
						if(vmin!==null) {
							vmin = parseFloat(vmin.replace(/,/g,'.'));
							if(isNaN(vmin)) { vmin = null;}
						};
						if(vmax!==null) {
							vmax = parseFloat(vmax.replace(/,/g,'.'));
							if(isNaN(vmax)) { vmax = null;}
						};
						if(vmin===null&&vmax===null) {
							return true;
						} else {
							var valor = parseFloat(el.value.replace(/,/g,'.'));	
							if(valor<vmin&&vmin!==null) {
								return 'O valor deve ser >= ' + vmin;
							}
							if(valor>vmax&&vmax!==null) {
								return 'O valor deve ser <=' + vmax;
							}
						}
					}
					return true;
				},
validaTexto:	function (el,min) {
					var ok = true;
					if(min.substr(0,1)==='[') {
						var ref = document.getElementById(min.slice(1,-1).toUpperCase());
						if(el.value!==ref.value) {
							ok = el.id + ' deve ser igual a ' + ref.id;
						}
					} else {
						if(parseInt(min)>0) {
							if(el.value.length<parseInt(min)) {
								ok = 'o Campo deve ter pelo menos ' + min + ' caracteres';
							}
						}
					};
					return ok;
				},
validaSenha:	function(el,ref) {
					var sref = document.getElementById(ref.slice(1,-1).toUpperCase()).value;
					if(el.value!==sref.value) {
						return 'Senha e Confirmação de Senha devem ser iguais';
					} else {
						return true;
					}
				},
estaOk:			function() {
					var msg = '';
					var ok  = true;
					var ef  = null;
					for(var i=0;i<this.listaCampos.length;i++) {
						var campo = this.listaCampos[i];
						if(campo[5]===1||campo[0].value.length>0) {
							switch(campo[2]) {
							case 'INT':
							case 'FLOAT':
							case 'FLT':
							case 'CUR':		ok = this.validaValor(campo[0],campo[3],campo[4]);
											break;
							case 'STR':		ok = this.validaTexto(campo[0],campo[3]);
											break;
							case 'DATE':
							case 'DTIME':	ok = this.validaDataHora(campo[0],campo[2],campo[3],campo[4]);
											break;
							}
							if(ok!==true) {
								msg += 'O conteúdo de "' + campo[1] + '" é inválido(' + ok + ')\n';
								if(ef===null) { 
									ef = campo[0];
								}
	 						}
						}
					};
					if(msg!=='') {
						alert(msg);
						ef.focus();
						return false;
					} 
					return true;
				}
};

var objForm = new formulario();
// Fim Formulário


// Menu: Rotina para contornar um problema do IE
var browserName=navigator.appName; 
var ie=false;
if(browserName=="Microsoft Internet Explorer") {
	ie = true;
}
function IEPseudoHover() {
	var ul = document.getElementsByTagName("ul");
	for(var j=0;j<ul.length;j++) {
		var navItems = ul[j].getElementsByTagName("li");		
		for (var i=0; i<navItems.length; i++) {
			if(navItems[i].className == "principal") {
				navItems[i].onmouseover=function() { this.className += " over"; }
				navItems[i].onmouseout=function() { this.className = "principal"; }
			}
		}
	}
	var tooltips = document.getElementsByTagName('IMG');
	for (var i=0; i<tooltips.length; i++) {
		if(tooltips[i].id == "TOOLTIP") {
			tooltips[i].onmouseover=function() { this.className = "over"; }
			tooltips[i].onmouseout=function() { this.className = ""; }
		}
	}
}

// Marca elementos para exibição de titulo da imagem (tooltip)
function ajustatooltip() {
	var tooltips = document.getElementsByTagName('IMG');
	for (var i=0; i<tooltips.length; i++) {
		if(tooltips[i].id == "TOOLTIP") {
			new Tooltip(tooltips[i], {backgroundColor: "#FFF8DC", borderColor: "#778899", 
			textColor: "#777777", textShadowColor: "#000", mouseFollow: false, 
			hideDuration: 0,
			fixTop: (ie) ? false : tooltips[i].y+tooltips[i].height+13});
		}
	}
};

// Processamento no carregamento da página
function wLoad() {
	if(ie) {
		IEPseudoHover();
	};
	ajustatooltip();
};

window.onload = wLoad;

// Dados Gerais da página
function infoPagina() {};
infoPagina.prototype = {
classeAtual: '',
arquivoClasse: '',
programaAtual: '',
retornaParametros:	function() {
						return 'classe='+this.classeAtual+'&arquivo_classe='+this.arquivoClasse+'&programa='+this.programaAtual;
					}
};

var ObjInfoPagina = new infoPagina();
// Fim dos dados gerais da página

// Mostra ou Esconde um elemento da Página
// Usando Effect.SlideDown e SlideUp da classe script.aculo.us
function mostraesconde() {};
mostraesconde.prototype = {
visivel: 	false,
id:			'',
inicializa:	function(id) {
				this.id = id;
				this.visivel = false;
			},
run:		function() {
				if(this.id!==null) {
					if(this.visivel===false) {
						Effect.SlideDown(this.id);
					} else {
						Effect.SlideUp(this.id);
					}
					this.visivel = !this.visivel;
				}
			},
reset:		function() {
				if(this.visivel===true) {
					this.run();
				}
			}
};
// Fim mostra e Esconde

// Tratamento de Filtro

// Mostra ou Esconde o Filtro
function processaFiltro() {
	objdivFiltro.run();
};

var objdivFiltro = new mostraesconde();
objdivFiltro.inicializa('FILTRAR');

// Monta os parametros para filtro
function retornaFiltro(f,dm) {
	var params = (dm===false ? '' : 'metodo=salvarFiltro');
	var aux = '&';
	for(var i=0;i<f.elements.length;i++) {
		var el = f.elements[i];
		if(el.type!=='submit') {
			if((el.type=='radio'||el.type=='checkbox')&&el.checked===false) {
				continue;
			}
			params += aux + el.id + '=';
			if(el.type=='select') {
				 params += el.options[el.selectedIndex].value;
			} else { 
				params += el.value;
			}
		}
	};
	return params;
};

function filtrar() {
	if(document.getElementById('FILTRAR').style.display==='none') {
		ObjProcAjax.runPost('executa_busca_ajax.php5','FILTRO','metodo=getFormularioFiltro&'+ObjInfoPagina.retornaParametros(),processaFiltro);
	} else {
		processaFiltro();
	}
};

function limparFiltro() {
	ObjProcAjax.runPost(ObjInfoPagina.programaAtual,'CORPO','metodo=salvarFiltro');
	if(document.getElementById('FILTRAR').style.display!=='none') {
		processaFiltro();
	}
};
// Fim do Tratamento de Filtro

// Manipulação de campos do tipo SELECT
function Select() {};
Select.prototype = {
move:		function(eo,ed) {
				this.copy(eo,ed);
				this.remove(eo);
			},
copy:		function(eo,ed) {
				var origem  = document.getElementById(eo);
				var destino = document.getElementById(ed);
				for(var i=0;i<origem.options.length;i++) {
					if(origem.options[i].selected===true) {
						destino.options[destino.options.length] = new Option(origem.options[i].text,origem.options[i].value,false,false);
					}
				}
			},
remove:		function(eo) {
				var origem  = document.getElementById(eo);
				for(var i=origem.options.length-1;i>=0;i--) {
					if(origem.options[i].selected===true) {
						origem.remove(i);
					}
				}
			},
checkall:	function(e) {
				var origem  = document.getElementById(e);
				for(var i=0;i<origem.options.length;i++) {
					origem.options[i].selected=true;
				}
			},
values:		function(e) {
				var valores = '';
				var el  = document.getElementById(e);
				for(var i=0;i<el.options.length;i++) {
					valores += (valores!=='' ? ',' : '') + el.options[i].value;
				}
				return valores;
			},
checked:	function(e) {
				var el  = document.getElementById(e);
				try {
					return el.options[el.selectedIndex].value;
				} catch(e) {
					return '-';
				}
			},
texto:		function(e) {
				var el  = document.getElementById(e);
				try {
					return el.options[el.selectedIndex].text;
				} catch(e) {
					return '-';
				}
			},
clearAll:	function(e) {
				var origem  = document.getElementById(e);	
				for(var i=origem.options.length-1;i>=0;i--) {
					origem.remove(i);
				}
			},
addOption:	function(e,ov,ol) {
				var el  = document.getElementById(e);	
				var opt = new Option(ol,ov);
				try {
					el.add(opt);
				} catch(err) {
					el.add(opt,null);
				};
			}
};
// Fim Manipulação de campos do tipo SELECT

// Tratamento de Relatorio
function relatorio(){};
relatorio.prototype = new Select(); 
relatorio.prototype.id = '';
relatorio.prototype.objme= null;
relatorio.prototype.inicializa= function(id) { 
									this.id = id;
									this.objme = new mostraesconde();
									this.objme.inicializa(this.id);
								};
relatorio.prototype.showhide=	function() {
									this.objme.run();
								};
relatorio.prototype.exibir=	 	function() {
									var objAtual = this;
									if(this.objme.visivel===false) {
										ObjProcAjax.runPost('executa_busca_ajax.php5','RELATORIO',
															'metodo=getFormularioRelatorio&'+ObjInfoPagina.retornaParametros(),
															function() {objAtual.showhide();});
									} else {
										this.showhide();
									}
								};
relatorio.prototype.run=		function() {
									var ax=new AJAX();
									ax.url='executa_busca_ajax.php5';
									ax.metodo='POST';
									ax.params='metodo=ImprimirRelatorio&campos='+this.values('CAMPOS_SELECIONADOS')+
											  '&ordem='+this.values('CAMPOS_ORDEM')+'&filtro='+(document.getElementById('USARFILTRO').checked ? 'S' : 'N') +																			  '&titulo='+document.getElementById('TITULO').innerHTML+'&'+ObjInfoPagina.retornaParametros();
									ax.obj = this;
									ax.processaresultado=function(html) {
										var w = window.open('','relatorio','height=600,width=960,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,status=no');
										w.document.write(html);
										w.document.close();
										if(window.focus) {
											w.focus();
										}
										ax.obj.objme.reset();
									}; 
									ax.conectar();
								};
relatorio.prototype.runRelatorio=	
								function(params) {
									var ax=new AJAX();
									ax.url='executa_busca_ajax.php5';
									ax.metodo='POST';
									ax.params='metodo=ImprimirRelatorioEspecial'+params+
											  '&titulo='+document.getElementById('TITULO').innerHTML+'&'+ObjInfoPagina.retornaParametros();
									ax.obj = this;
									ax.processaresultado=function(html) {
										var w = window.open('','relatorio','height=600,width=1010,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,status=no');
										w.document.write(html);
										w.document.close();
										if(window.focus) {
											w.focus();
										}
										ax.obj.objme.reset();
									}; 
									ax.conectar();
								};
								
var objRelatorio = new relatorio();
objRelatorio.inicializa('DIVRELATORIO');
//var objAtual;
//function processaRelatorio() {
//	objRelatorio.showhide();
//}
// Relatórios que não devem esconder o filtro
var objRelatEspecial = new relatorio();
objRelatEspecial.inicializa(null);
// Fim do Tratamento de Relatório

// Menu Suspenso
function menususpenso() {};
menususpenso.prototype = {
Id:	'',
inicializa:	function(id) {
				this.Id = id;
			},
create:		function() {
				var div = document.getElementById(this.Id);
				if(div!==null) {
					document.getElementById('MENU').removeChild(div);
				}
				div = document.createElement('DIV');
				div.style.visibility = 'hidden';
				div.id = this.Id;
				div.style.position = 'absolute';
				div.style.width = '200';
				div.style.display = 'block';
				div.style.top = document.getElementById('MENU').offsetTop+5;
				document.getElementById('MENU').appendChild(div);
			},
run:		function(params,after) {
				ObjProcAjax.runPost('executa_busca_ajax.php5',this.Id,params,after);
			},
show:		function() {
				var div = document.getElementById(this.Id);
				div.style.left = mouseX-180;
				div.style.visibility = 'visible';
				div.style.border = '1px solid #c0c0c0';
				div.style.backgroundColor = '#ffffff';
				div.focus();
				div.onmouseout = function() {this.style.visibility = 'hidden';};
				div.onmouseover = function() {this.style.visibility = 'visible';};
			}
}

// Historico
function historico() {
	objHistorico.create();
	objHistorico.run('classe=historico&metodo=getHistorico&arquivo_classe=framework/classes/classe_historico.inc',mostrahistorico);
};

function mostrahistorico() {
	objHistorico.show();
};

function limparhistorico() {
	var params = 'classe=historico&metodo=limparHistorico&arquivo_classe=framework/classes/classe_historico';
	ObjProcAjax.runPost('executa_busca_ajax.php5',null,params);
};

var objHistorico = new menususpenso();
objHistorico.inicializa('HISTORICO');
// Fim Historico

// Favoritos
function favoritos() {
	objFavoritos.create();
	objFavoritos.run('classe=favoritos&metodo=getFavoritos&arquivo_classe=framework/classes/classe_favoritos.inc',mostrafavoritos);
};

function mostrafavoritos() {
	objFavoritos.show();
};

function addfavorito() {
	var params = 'classe=favoritos&metodo=addFavorito&arquivo_classe=framework/classes/classe_favoritos.inc&programa='+ObjInfoPagina.programaAtual;
	ObjProcAjax.runPost('executa_busca_ajax.php5',null,params);
};

function delfavorito() {
	var params = 'classe=favoritos&metodo=delFavorito&arquivo_classe=framework/classes/classe_favoritos.inc&programa='+ObjInfoPagina.programaAtual;
	ObjProcAjax.runPost('executa_busca_ajax.php5',null,params);
};

var objFavoritos = new menususpenso();
objFavoritos.inicializa('FAVORITOS');
// Fim Favoritos

var mouseX = 0;
var mouseY = 0;
function getcords(e){
	mouseX = Event.pointerX(e);
	mouseY = Event.pointerY(e);
}
Event.observe(document, 'mousemove', getcords);

// Carregar Script Dinamicamente
function LoadJS(url) {
   var e = document.createElement("script");
   e.src = url;
   e.type="text/javascript";
   document.getElementsByTagName("head")[0].appendChild(e);
};

function mostraescondebotao(b,f) {
	var img = document.images;
	for(var i=0;i<img.length;i++) {
		if(b.indexOf(img[i].src)!=-1||b.indexOf(img[i].name)!=-1) {
			img[i].parentNode.style.display = (f===true ? 'none' : 'inline');
		}
	}
};