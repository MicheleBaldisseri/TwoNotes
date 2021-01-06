var dettagli_form = {

    "nome": [ /^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,20}$/, "Sono ammesse solo lettere fino a 20 caratteri"],
    "cognome": [ /^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,20}$/, "Sono ammesse solo lettere fino a 20 caratteri"],
    "dataNascita": "Sei troppo giovane, non credi?",
    "provenienza": [/^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,20}$/, "Sono ammesse solo lettere fino a 20 caratteri"],
    "username": [/^[\.\w-]{2,20}$/, "Sono ammessi numeri e lettere fino a 20 caratteri"],
    "email": [/[\S]{2,32}@[\w]{2,32}((?:\.[\w]+)+)?(\.(it|com|edu|gov|org|net|info)){1}/, 'Formato <span xml:lang="en">email</span> inserito non valido'],
    "oldpsw": [/^[\w(#$%&=!)]{4,20}$/, "Sono ammessi numeri, lettere e i simboli #,$,%,&,=,! da 5 a 20 caratteri"],
    "newpsw": [/^[\w(#$%&=!)]{4,20}$/, "Sono ammessi numeri, lettere e i simboli #,$,%,&,=,! da 5 a 20 caratteri"],
    "conf-psw": 'Le <span xml:lang="en">password</span> non corrispondono'
}

function mostraErrore(input,type) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
   
    if(type) 
        elemento.appendChild(document.createTextNode("Spazi prima e dopo il contenuto non sono permessi")); 
    else if(input.id == "conf-psw" || input.id == "dataNascita") //conferma password
        elemento.appendChild(document.createTextNode(dettagli_form[input.id]));    
    else //tutti gli altri casi
        elemento.appendChild(document.createTextNode(dettagli_form[input.id][1])); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){
    
    var text = input.value;

    if(text != ""){

        if(/(^\s+|\s+$)/g.test(text)){ //ci sono spazi prima e dopo 
            mostraErrore(input,true);
            return false;
        }
        else if(input.id == "conf-psw"){ //check corrispondenza password
            if(text != document.getElementById("newpsw").value){
                mostraErrore(input,false);
                return false;
            }else{
                return true;
            }
        }
        else if(input.id == "dataNascita"){ //età minima per l'iscrizione
            dataInserita=new Date(text);
            if((Date.now() - dataInserita) / (31557600000) < 14) {
                mostraErrore(input,false);
                return false
            }else{
                return true;
            }
        }
        else{
            var regex= dettagli_form[input.id][0];
            if(text.search(regex) != 0) {
                //-1 se non l'ha trovata altrimenti ritorna la posizione dove inizia
                mostraErrore(input,false);
                return false;
            }else{
                return true;
            }
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

