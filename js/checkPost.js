var dettagli_form = {

    "title": [/^[\s\S]{2,30}$/, "Sono ammessi da 2 a 30 caratteri"],
    "myfile": "Immagine con dimensione troppo grande e/o in un formato non consentito",
    "altImmagine": [/^[\s\S]{5,75}$/, "Aggiungere una descrizione solo se caricata un'immagine, da 5 fino a 75 caratteri"],
    "content": [/^[\s\S]{5,1000}$/, "Sono ammessi da 5 a 1000 caratteri"],
}

function mostraErrore(input,type) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
       
    if(type) 
        elemento.appendChild(document.createTextNode("Spazi prima e dopo il contenuto non sono permessi")); 
    else if(input.id == "myfile") //immagine non valida
        elemento.appendChild(document.createTextNode(dettagli_form[input.id]));    
    else //tutti gli altri casi
        elemento.appendChild(document.createTextNode(dettagli_form[input.id][1])); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){

    var text = input.value;
    var regex= dettagli_form[input.id][0];

    if(/(^\s+|\s+$)/g.test(text)){ //ci sono spazi prima e dopo 
        mostraErrore(input,true);
        return false;
    }
    else if(input.id == "myfile"){
        if(document.getElementById("myfile").value != ""){ //se l'immagine è caricata
            
            //controllo dimensione
            var inputImage = document.getElementById("myfile");
            var image = inputImage.files[0];

            if(image.size > 500000){ //maggiore 500kb
                mostraErrore(input,false);
                return false;
            }

            //controllo formato
            var allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
            var fileExtension = inputImage.value.split('.').pop().toLowerCase();
            
            var isValidFile = false;

            for(var extension in allowedExtension) {
                if(fileExtension === allowedExtension[extension]) {
                    isValidFile = true; 
                }
            }
            //formato non consentito
            if(!isValidFile) {
                mostraErrore(input,false);
                return false;
            }
            //tutto ok
            return isValidFile;
        }
        else{ //immagine non caricata, nessun controllo
            return true;
        } 
    }
    else if(input.id == "altImmagine"){
        if(document.getElementById("myfile").value != ""){ //se l'immagine è caricata
            if(text.search(regex) != 0){
                mostraErrore(input,false);
                return false;
            }else{
                return true;
            }
        }
        else{
            if(document.getElementById("altImmagine").value == "")
                return true;
            else{
                mostraErrore(input,false);
                return false;
            } 
        }
    }
    else if(text.search(regex) != 0) {  //titolo e contenuto
        //-1 se non l'ha trovata altrimenti ritorna la posizione dove inizia
        mostraErrore(input,false);
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
