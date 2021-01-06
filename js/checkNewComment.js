
function mostraErrore(input, type) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
       
    if(type == 1)
        elemento.appendChild(document.createTextNode("Sono ammessi da 2 a 500 caratteri")); 
    else if(type == 3)
        elemento.appendChild(document.createTextNode("Spazi prima e dopo il contenuto non sono permessi")); 
    else
        elemento.appendChild(document.createTextNode("Contenuto non valido. Controlla che i tag d'aiuto siano corretti")); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function substr_count(string,substring,start,length){
    var c = 0;
    if(start) 
        string = string.substr(start); 
    if(length) 
        string = string.substr(0,length); 
    for (var i=0;i<string.length;i++){
        if(substring == string.substr(i,substring.length))
            c++;
    }
    return c;
}

function validateCampo(input){

    var text = input.value;
    var regex= /^[\s\S]{2,500}$/;

    //controllo che numero [en] == [/en]
    if(substr_count(text,'[en]',0,text.length)!=substr_count(text,'[/en]',0,text.length)) {
        mostraErrore(input,2);
        return false;
    }
    else if(/(^\s+|\s+$)/g.test(text)){ //ci sono spazi prima e dopo 
        mostraErrore(input,3);
        return false;
    }
    else if(text.search(regex) != 0) {  
        mostraErrore(input,1);
        return false;
    }
    else{
        return true;
    } 
}

function validateForm(){
    //pulisco eventuali errori precedenti
    var input = document.getElementById("postTextarea");
    var parent = input.parentNode;
    if(parent.children.length == 2){ //array che contiene i figli 
        //il primo figlio è l'input, il secondo se presente è lo strong con l'errore
        parent.removeChild(parent.children[1]);
    }

    return validateCampo(input);
}
