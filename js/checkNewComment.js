
function mostraErrore(input) {

    var elemento = document.createElement("strong");
    elemento.className = "errori"; //classe degli errori
       
    elemento.appendChild(document.createTextNode("Sono ammessi da 1 a 500 caratteri")); 

    var p = input.parentNode; //span 
    p.appendChild(elemento);
}

function validateCampo(input){

    var text = input.value;
    var regex= /^[\s\S]{1,500}$/;

    if(text.search(regex) != 0) {  
        mostraErrore(input);
        return false;
    }else{
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
