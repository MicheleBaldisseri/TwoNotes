var dettagli_form = {

    "username": [ /^[\w]{2,20}$/, "Username inserito non valido"],
    "psw": [/^[\w]{8,20}$/, "Password inserita non valida"]
}

function mostraErrore(input) {

    var elemento = document.createElement("strong");
    elemento.className = "erroriLogin"; //classe degli errori
    elemento.appendChild(document.createTextNode(dettagli_form[input.id][1])); //errore

    var p = input.parentNode; //ovvero lo span aggiunto
    p.appendChild(elemento);
}

function validateCampo(input){
    var regex= dettagli_form[input.id][0];
    var text = input.value;
    if(text.search(regex) != 0) {
        //-1 se non l'ha trovata altrimenti ritorna la posizione dove inizia
        mostraErrore(input);
        return false;
    }else{
        return true;
    }
}

function validateForm(){
    //pulisco eventuali errori precedenti
    for (var key in dettagli_form){
        
        var parent = document.getElementById(key).parentNode; //recupero lo span

        if(parent.children.length == 2){ //array che contiene i figli 
            //il primo figlio è l'input, il secondo se presente è lo strong con l'errore
            parent.removeChild(parent.children[1]);
        }
    }  

    var corretto = true;
    for (var key in dettagli_form){
        var input = document.getElementById(key);
        var risultato = validateCampo(input);
        corretto = corretto && risultato;
    }
    return corretto;
}