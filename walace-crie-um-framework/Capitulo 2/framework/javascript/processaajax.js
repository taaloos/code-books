function processaAjax() {
	this.LOADED = [];
};
processaAjax.prototype = {
LOADED:	[],
loadXMLString:	function(txt) {
					try {
					// IE
					  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
					  xmlDoc.async="false";
					  xmlDoc.loadXML(txt);
					  return(xmlDoc); 
				  	} catch(e) {
				  		try {
						    parser=new DOMParser();
						    xmlDoc=parser.parseFromString(txt,"text/xml");
						    return(xmlDoc);
				    	} catch(e) {
				    		alert(e.message);
				    	}
				  	};
					return(null);
				},
processaJS:	function(html) {
				// Processar
				var xml = this.loadXMLString('<XML>'+html+'</XML>');
				var scr = xml.getElementsByTagName('SCRIPT');
				for (i=0;i<scr.length;i++) {
					var node = scr[i];
					var txt  = node.childNodes[0].data;
					var att  = node.getAttributeNode('ID');
					var id   = (att!==null ? att.nodeValue : null);
					var ex   = false;
					if(id!==null) {
						for(var k=0;k<this.LOADED.length;k++) {
							if(this.LOADED[k]==id) {
								ex = true;
								break;
							}
						}
					}
					if(ex===false) {
						if(id!==null) {
							this.LOADED[this.LOADED.length] = id;
						};
						var nscr = document.createElement('script');
						nscr.type     = 'text/javascript';
						nscr.language = 'javascript';
						nscr.text = txt;
						document.body.appendChild(nscr);
					}
				};
			},
run: 		function(url,div) {
				var ax=new AJAX();
				ax.url=url;
				ax.div=div;
				ax.obj=this;
				ax.processaresultado=function(html) {
					var div = document.getElementById(this.div);
					div.innerHTML = html;
					this.obj.processaJS(html);
				}; 
				ax.conectar();
			}
};

var ObjProcAjax = new processaAjax();