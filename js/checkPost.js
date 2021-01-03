var dettagli_form = {

    "title": [/^[\w(#$%&=!)]{4,20}$/, "Sono ammesssi numeri, lettere e i simboli #,$,%,&,=,! da 5 a 20 caratteri"],
    "myfile": [/^[\w-]+\.(jpg|png|gif){1}$/, "Immagine troppo grande e/o non nel formato richiesto"],
    "altImmagine": [/^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,50}$/, "Sono ammesse solo lettere fino a 50 caratteri"],
    "content": [/^[\w(#$%&=!)]{4,20}$/, "Sono ammesssi numeri, lettere e i simboli #,$,%,&,=,! da 5 a 20 caratteri"],
}

function mostraErrore(input) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
       
    elemento.appendChild(document.createTextNode(dettagli_form[input.id][1])); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){
    
    var text = input.value;
    var regex= dettagli_form[input.id][0];

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

