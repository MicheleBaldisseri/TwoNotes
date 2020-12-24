var dettagli_form = {

    "username": [ /^[a-zA-Z]{7}$/, "Inserisci il tuo username"],
    "psw": [/^[a-zA-Z]{7}$/, "Inserisci la tua password"]
}

function mostraErrore(input) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
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
    //verifica l'input
    var parent = document.getElementById("username").parentNode; //recupero lo span
    if(parent.children.length == 2){ //array che contiene i figli 
        //il primo figlio è l'input, il secondo se presente è il strong con l'errore
        parent.removeChild(parent.children[0]);
    }

    var corretto = true;
    for (var key in dettagli_form){
        var input = document.getElementById(key);
        var risultato = validateCampo(input);
        corretto = corretto && risultato;
    }
    return corretto;
}