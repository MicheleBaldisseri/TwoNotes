const countReg = function(str) {
    const re = /\[abbr=([^\]]+)]/g;
    return ((str || '').match(re) || []).length;
}

function mostraErrore(input, type) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
       
    switch (type) {
        case 1:
            elemento.appendChild(document.createTextNode("Contenuto non valido. Controlla che i tag d'aiuto siano corretti")); 
            break;
        case 2:
            elemento.appendChild(document.createTextNode("Sono ammessi da 2 a 500 caratteri")); 
            break;
        case 3:
            elemento.appendChild(document.createTextNode("Tag d'aiuto senza contenuto, inserire almeno un carattere")); 
            break;
    }

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
    //elimino spazi prima e dopo
    var text = input.value.replace(/(^\s+|\s+$)/g,'');
    var regex= /^[\s\S]{2,500}$/;

    //presenza di tag d'aiuto
    var tags = (substr_count(text,'[en]',0,text.length) > 0) || 
               (substr_count(text,'[abbr=',0,text.length) > 0) ||
               (substr_count(text,'[/abbr]',0,text.length) > 0) ||
               (substr_count(text,'[/en]',0,text.length) > 0) ? true : false;
    
    if(tags){ //sono presenti tag d'aiuto

        //controllo che tag di apertura e chiusura corrispondano
        var abbr = substr_count(text,'[/abbr]',0,text.length) != countReg(text) ? false : true;
        var en = substr_count(text,'[en]',0,text.length) != substr_count(text,'[/en]',0,text.length) ? false : true;

        if(abbr == false || en == false) { //errore utilizzo tag
            mostraErrore(input,1);
            return false;
        }
        else{ //tag inseriti correttamente ma vuoti e assenza di altro testo -> evitare inserimento di campi vuoti
            text = text.replace('[en]','');
            text = text.replace('[/en]','');
            text = text.replace(/\[abbr=([^\]]+)]/g,'');
            text = text.replace('[/abbr]','');
            text = text.replace(/(^\s+|\s+$)/g,'');

            if(text == ''){
                mostraErrore(input,3);
                return false;
            }
        }
    }
    else if(text.search(regex) != 0) {  //contenuto non valido
        mostraErrore(input,2);
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
