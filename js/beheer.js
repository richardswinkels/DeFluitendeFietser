function getFietsInfo() {
    //Haal alle velden op uit de HTML
    var id = parseInt(document.getElementById("fietsId").value) - 1;
    var fietsNaam = document.getElementById("fietsNaam");
    var fietsAandrijving = document.getElementById("fietsAandrijving");
    var fietsDoelgroep = document.getElementById("fietsDoelgroep");
    var fietsModel = document.getElementById("fietsModel");
    var fietsType = document.getElementById("fietsType");
    var fietsMerk = document.getElementById("fietsMerk");
    var fietsStaat = document.getElementById("fietsStaat");
    var fietsKleur = document.getElementById("fietsKleur");
    var fietsPrijs = document.getElementById("fietsPrijs");
    var fietsOpmerking = document.getElementById("fietsOpmerking");
    var fietsImage = document.getElementById("fietsImage");

    //Maak nieuwe instance van object XMLHttpRequest
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //Parse de JSON en zet het in een variabele
            var fietsData = JSON.parse(this.responseText);
            //Als item uit de JSON-file bestaat
            if (typeof fietsData[id] != "undefined") {
                //Zet de data uit de JSON-file in de velden
                fietsNaam.value = fietsData[id].naam;
                fietsAandrijving.value = fietsData[id].aandrijving;
                fietsDoelgroep.value = fietsData[id].doelgroep;
                fietsModel.value = fietsData[id].model;
                fietsType.value = fietsData[id].type;
                fietsMerk.value = fietsData[id].merk;
                fietsStaat.value = fietsData[id].staat;
                fietsKleur.value = fietsData[id].kleur;
                fietsPrijs.value = parseFloat(fietsData[id].prijs).toFixed(2);
                fietsOpmerking.value = fietsData[id].opmerking;
                fietsImage.value = fietsData[id].img;
            }
            else {
                //Anders maak ze weer leeg
                fietsNaam.value = "";
                fietsAandrijving.value = "";
                fietsDoelgroep.value = "";
                fietsModel.value = "";
                fietsType.value = "";
                fietsMerk.value = "";
                fietsStaat.value = "";
                fietsKleur.value = "";
                fietsPrijs.value = "";
                fietsOpmerking.value = "";
                fietsImage.value = "";
            }
        }
    };
    //Maak get request voor JSON file (+ timestamp om te verkomen dat JSON-file wordt gecached)
    xmlhttp.open("GET", "beheerbestanden/fietsen.json?" + new Date().getTime(), true);
    //Stuur request
    xmlhttp.send();
}

function showForms() {
    var formSelection = document.getElementById("formSelection").value;
    var formHomebeheer = document.getElementById("formHomebeheer");
    var formFietsenbeheer = document.getElementById("formFietsenbeheer");
    var formVerhuurbeheer = document.getElementById("formVerhuurbeheer");
    var formOpeningstijdenbeheer = document.getElementById("formOpeningstijdenbeheer");
    var formAdresbeheer = document.getElementById("formAdresbeheer");
    var formOveronsbeheer = document.getElementById("formOveronsbeheer");

    switch (formSelection) {
        case "home":
            formHomebeheer.style.display = "block";
            formFietsenbeheer.style.display = "none";
            formVerhuurbeheer.style.display = "none";
            formOpeningstijdenbeheer.style.display = "none";
            formAdresbeheer.style.display = "none";
            formOveronsbeheer.style.display = "none";
            removeMessage();
            break;   
        case "fietsen":
            formHomebeheer.style.display = "none";
            formFietsenbeheer.style.display = "block";
            formVerhuurbeheer.style.display = "none";
            formOpeningstijdenbeheer.style.display = "none";
            formAdresbeheer.style.display = "none";
            formOveronsbeheer.style.display = "none";
            removeMessage();
            break;
        case "fietsenverhuur":
            formHomebeheer.style.display = "none";
            formFietsenbeheer.style.display = "none";
            formVerhuurbeheer.style.display = "block";
            formOpeningstijdenbeheer.style.display = "none";
            formAdresbeheer.style.display = "none";
            formOveronsbeheer.style.display = "none";
            removeMessage();
            break;
        case "openingstijden":
            formHomebeheer.style.display = "none";
            formFietsenbeheer.style.display = "none";
            formVerhuurbeheer.style.display = "none";
            formOpeningstijdenbeheer.style.display = "block";
            formAdresbeheer.style.display = "block";
            formOveronsbeheer.style.display = "none";
            removeMessage();
            break;
        case "overons":
            formHomebeheer.style.display = "none";
            formFietsenbeheer.style.display = "none";
            formVerhuurbeheer.style.display = "none";
            formOpeningstijdenbeheer.style.display = "none";
            formAdresbeheer.style.display = "none";
            formOveronsbeheer.style.display = "block";
            removeMessage();
            break;
    }

    function removeMessage() {
        var messages = document.getElementsByClassName("message");
        if(messages.length >= 1) {
            messages[0].remove();
        }
    }
}

function addInputBoxes() {
    var parentElement = document.getElementById("verhuur-beheer-flex");
    var inputboxes = document.getElementById("verhuur-beheer-flex").lastElementChild.children;
    var newDiv = document.createElement("div");
    newDiv.innerHTML = "<input type='text' name='verhuurNaam[]' onchange='addInputBoxes()'/><input type='number' name='verhuurPrijs[]' step='0.01' onblur='addInputBoxes()'/><input type='number' name='verhuurVoorraad[]' onblur='addInputBoxes()'/>"

    if (inputboxes[0].value.length > 0 && inputboxes[1].value.length > 0 && inputboxes[2].value.length > 0) {
        {
            parentElement.appendChild(newDiv);
        }
    }
}