var dettagli_form = {

    "nome": [ /^[A-Za-z]{2,20}$/, "Questo campo non può contenere numeri o caratteri speciali"],
    "cognome": [/^[A-Z]'?[(a-z)(A-Z)(àèìòù)]{2,20}$/, "Questo campo non può contenere numeri o caratteri speciali"],
    //"data": "Sei troppo giovane, non credi?",
    "provenienza": [/^[\w]{8,20}$/, "Questo campo non può contenere numeri o caratteri speciali fino a 20 caratteri"],
    "username": [/^[\w]{2,20}$/, "Questo campo può contenere numeri, lettere e caratteri speciali fino a 20 caratteri"],
    "email": [/^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/, "Formato e-mail inserito non valido"],
    "psw": [/^[\w]{8,20}$/, "La password deve essere almeno di 8 caratteri e può contenere lettere, numeri e caratteri speciali fino ad un massimo di 20"],
    "conf-psw": "Le password non corrispondono"
}

function mostraErrore(input) {

    var elemento = document.createElement("strong");
    elemento.className = "erroriForm"; //classe degli errori
   
    if(input.id == "conf-psw" || input.id == "data") //conferma password
        elemento.appendChild(document.createTextNode(dettagli_form[input.id]));    
    else //tutti gli altri casi
        elemento.appendChild(document.createTextNode(dettagli_form[input.id][1])); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){
    
    var text = input.value;

    if(input.id == "conf-psw"){ //check corrispondenza password
        if(text != document.getElementById("psw").value)
            mostraErrore(input);
    }
    /*
    else if(input.id == "data"){ //età minima per l'iscrizione
            mostraErrore(input);
    }
    */
    else{
        var regex= dettagli_form[input.id][0];
        if(text.search(regex) != 0) {
            //-1 se non l'ha trovata altrimenti ritorna la posizione dove inizia
            mostraErrore(input);
            return false;
        }else{
            return true;
        }
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

