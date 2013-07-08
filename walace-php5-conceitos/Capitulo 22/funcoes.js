	/* 	
		Este script JavaScript irá realizar validações em formulários 
		Walace Soares
		Livro PHP5
		(baseado no JavaScript mostrado no livro Crie um site B2C)
	*/
	
	// Esta é uma função simples para validar emails
	function valida_email(email) {
		var chars = "@#$&[]()/\\\{}!^:'\"";
		var pat=/^(.+)@(.+)$/;
		
		var emaildiv = email.match(pat);
		
		if(emaildiv==null)
			return false;
			
		var login = emaildiv[1];
		var dominio = emaildiv[2];
		
		for(var i=0;i<chars.length;i++) {
			if(login.indexOf(chars.substr(i,1))!=-1)
				return false;
		}
		
		for(var i=0;i<chars.length;i++) {
			if(dominio.indexOf(chars.substr(i,1))!=-1)
				return false;
		}
		
		return true;
	}
	
	// Valida uma string em particular (tipo login ou senha)
	function valida_string(string) {
		str = new String(string);
		if(str.length<3)
			return false;
		if(str.indexOf(" ")!=-1)
			return false;
	
		var chars = "@#$&[]()/\\\{}!^:'\"";
	
		for(var i=0;i<chars.length;i++) {
			if(str.indexOf(chars.substr(i,1))!=-1) {
				return false;
			}
		}
			
		return true;
	
	} 
	
	function valida_form(form,campos,nomescampos,tipos,status) {
		/*
		form = posição do formulário (0,1,...)
		campos = campos a verificar (0,1,2,...)
		tipos = tipo de cada campo:
					4-email
					8-string
					9-login/senha
					10-confirmação de senha 
		status = 0 - não obrigatório, 1 - obrigatório
		*/
	
		var mensagem = "Os seguintes campos estão incorretos\n\n";
		var erro = false;
		
		for(var i=0;i<campos.length;i++) {
			resultado=true;
			valor = document.forms[form].elements[campos[i]].value;
			switch(tipos[i]) {
			case 4:
				resultado = valida_email(valor);
				break;
			case 8:
			    if(status[i]<=1) {
				  resultado = (valor.length==0) ? false : true;
				}
				else {
				 resultado = (valor.length<status[i]) ? false : true;
				}
				break;
			case 9:
				resultado = valida_string(valor);
				break;
			case 10:
				resultado = valida_string(valor);
				if(resultado)
					resultado = (valor==document.forms[form].elements[campos[i-1]].value);
				break;
			}
			
			if(!resultado && (status[i]>=1 || (status[i]==0 && valor.length!=0))) {
				mensagem+= "- " + nomescampos[i] + "\n";
				erro = true;
			}
			
		}
	
		if(erro)
			alert(mensagem)
			
		return !erro;
	
	}
