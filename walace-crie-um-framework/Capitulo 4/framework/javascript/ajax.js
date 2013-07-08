// Objeto AJAX para comunicação Assincrona com um servidor de aplicações WEB
function AJAX(url,metodo,params,processa,modo,asinc) {
	this.url = url;
	this.metodo = (metodo) ? metodo : 'GET';
	this.params  = (metodo=='GET') ? null : params;
	this.processaresultado = processa;
	this.Header = new Array();
	this.modo = (modo) ? modo : 'T';
	this.asinc = (asinc) ? asinc : true;
	if(this.asinc!==false) { this.asinc = true; }
	if(this.modo!='T'&&this.modo!='X') {
		this.modo = 'T';
	}
	this.conectar();
}
AJAX.prototype = {
url:		'',
metodo:		'GET',
params:		'',
Header:		[],
modo:		'T',
asinc:		true,
addHeader:	function(h,v) {
				this.Header[h] = v;
			},
delHeader:	function(h) {
				delete(this.Header[h]);
			},
setHeader:	function() {
				if(this.httprequest===null|this.Header===null|this.Header.length<=0) { return;} 
				for(h in this.Header) {
					this.httprequest.setRequestHeader(h,this.Header[h]);
				}
			},
conectar:			function() {
						if(this.url==undefined||this.url=='') {
							return; 
						}
						this.httprequest = null;
					   	if (window.XMLHttpRequest) { // Mozilla, Safari,...
				         	this.httprequest = new XMLHttpRequest();
			        	} else if (window.ActiveXObject) { // IE
				         	try {
						     	 this.httprequest = new ActiveXObject("Msxml2.XMLHTTP");
			    	     	} catch (e) {
			               		try {
	        		           	 this.httprequest = new ActiveXObject("Microsoft.XMLHTTP");
								} catch (e) {}
							}
						}
						if(this.httprequest!=null&&this.httprequest!=undefined) {
							var obj = this;
							this.httprequest.onreadystatechange = 	function() {
																		obj.processaretorno.call(obj);
																	}
							if(this.metodo==undefined||this.metodo=='') { this.metodo = 'GET';}
							if(this.asinc!==false) { this.asinc = true; }
				        	this.httprequest.open(this.metodo,this.url,this.asinc);
							this.setHeader();
							if(this.params===undefined) {
								this.params = '';
							}
							try {
								this.httprequest.send(this.params);
							} catch(e) {
								this.httprequest.send(String(this.params));
							}
						}
					},
processaretorno:	function() {
						if(this.httprequest.readyState==4) {
							if(this.httprequest.status==200) {
								var resp = (this.modo=='T') ? 
											this.httprequest.responseText : 
											this.httprequest.responseXML;
								if(this.processaresultado!=null) {
									this.processaresultado(resp);
								} else {
									alert(resp);
								}
							} else { 
								this.processaerro();
							}
						}
					},
processaerro:		function() {
						alert(	'Erro= '+ this.httprequest.status + '-' + 
								this.httprequest.statusText + ' URL= ' + 
								this.url
							 );
					}
}


