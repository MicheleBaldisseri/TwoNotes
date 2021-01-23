var dettagli_form = {

    "title": [/^[\s\S]{2,100}$/, "Sono ammessi da 2 a 100 caratteri"],
    "myfile": "Immagine con dimensione troppo grande e/o in un formato non consentito",
    "altImmagine": [/^[\s\S]{5,75}$/, "Aggiungere una descrizione solo se caricata un'immagine, da 5 fino a 75 caratteri"],
    "content": [/^[\s\S]{5,1000}$/, "Sono ammessi da 5 a 1000 caratteri"],
}

const countReg = function(str) {
    const re = /\[abbr=([^\]]+)]/g;
    return ((str || '').match(re) || []).length;
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

function mostraErrore(input,type) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori

    switch (type) {
        case 1:
            elemento.appendChild(document.createTextNode("Contenuto non valido. Controlla che i tag d'aiuto siano corretti")); 
            break;
        case 2: //errore immagine caricata
            elemento.appendChild(document.createTextNode(dettagli_form[input.id]));  
            break;
        case 3: //tutti gli altri casi
            elemento.appendChild(document.createTextNode(dettagli_form[input.id][1]));  
            break;
        case 4:
            elemento.appendChild(document.createTextNode("Tag d'aiuto senza contenuto, inserire almeno un carattere")); 
            break;
    }

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){
    //elimino spazi prima e dopo
    var text = input.value.replace(/(^\s+|\s+$)/g, '');

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
                mostraErrore(input,4);
                return false;
            }
        }

        return true;
    }
    else if(input.id == "myfile"){ //immagine 
        if(document.getElementById("myfile").value != ""){ //se l'immagine è caricata
            
            //controllo dimensione
            var inputImage = document.getElementById("myfile");
            var image = inputImage.files[0];

            if(image.size > 500000){ //maggiore 500kb
                mostraErrore(input,2);
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
                mostraErrore(input,2);
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
            var regex= dettagli_form[input.id][0];
            if(text.search(regex) != 0){ //controllo contenuto dell'alt
                mostraErrore(input,3);
                return false;
            }else{
                return true;
            }
        }
        else{//immagine non caricata
            if(text == "") //se non è stato inserito Alt ok
                return true;
            else{
                mostraErrore(input,3); //Alt inserito -> errore perchè nessuna immagine
                return false;
            } 
        }
    }
    else if(text.search(dettagli_form[input.id][0]) != 0) {  //titolo e contenuto
        //-1 se non l'ha trovata altrimenti ritorna la posizione dove inizia
        mostraErrore(input,3);
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
