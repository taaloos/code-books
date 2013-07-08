function processaAjax() {
	this.LOADED = [];
};
processaAjax.prototype = {
LOADED:	[],
recuperaScript:	function(txt) {
					var onlyscr = "";
					while(txt!="") {
						var pos = txt.search(/<SCRIPT/i);
						if(pos===-1) {
							txt = "";
						} else {
							var fim = txt.search(/<\/SCRIPT/i);
							onlyscr += txt.substring(pos,fim+9);
							txt = txt.substr(fim+9);
						}
					};
					return onlyscr.replace(/script/gi,'SCRIPT');
				},
loadXMLString:	function(txt) {
					txt = '<XML>' + this.recuperaScript(txt.replace(/&/gi,'&amp;')) + '</XML>';
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
				var xml = this.loadXMLString(html);
				var scr = xml.getElementsByTagName('SCRIPT');
				for (i=0;i<scr.length;i++) {
					var node = scr[i];
					if(node.hasChildNodes()) {
						var txt  = node.childNodes[0].data;
						if(txt!==null&&txt!=="") {
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
								nscr.text = txt.replace(/&lt;/gi,'<').replace(/&gt;/gi,'>');
								document.body.appendChild(nscr);
							}
						}
					}
				}
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
			},
runPost:	function(url,div,params,after) {
				var ax=new AJAX();
				ax.url=url;
				ax.div=div;
				ax.obj=this;
				ax.metodo='POST';
				ax.params=params;
				ax.after=after;
				ax.processaresultado=function(html) {
					if(this.div!==null) {
						var div = document.getElementById(this.div);
						if(div.tagName==='DIV'||div.tagName==='TD'||div.tagName==='TEXTAREA') {
							div.innerHTML = html;
						} else {
							div.value = html;
						}
					}
					this.obj.processaJS(html);
					if(this.after!==null&&typeof this.after==='function') {
						this.after();
					}
				}; 
				ax.conectar();
			}
};

var ObjProcAjax = new processaAjax();