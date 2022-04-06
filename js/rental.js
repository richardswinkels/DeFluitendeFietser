function showForm() {
    //Haal de verschillende elementen op uit de HTML
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    var selectionGrid =  document.getElementById("fietsverhuur-selection-grid");
    var formContainer = document.getElementById("fietsverhuur-form-flex");
    var bestelling = document.getElementById("fietsverhuur-bestelling");
    var bestelForm = document.getElementById("bestelForm");

    //Als de lengte van checkboxes groter of gelijk is aan 1 (dus een of meerdere checkboxes zijn geselecteerd)
    if (checkboxes.length >= 1) {
        //Scroll omhoog
        document.documentElement.scrollTop = 0;
        //Zorg dat fietsselectie onzichtbaar wordt en het formulier zichtbaar
        selectionGrid.style.display = "none";
        formContainer.style.display = "flex";

        //Loop door de array van checkboxes
        for (var i = 0; i < checkboxes.length; i++) {
            //Maak nieuw <p>-element
            var paragraph = document.createElement("p");
            //Voeg de waarde van de checkbox toe aan het <p>-element
            paragraph.innerText = checkboxes[i].value;
            //Voeg dit <p>-element toe aan het besteloverzicht
            bestelling.appendChild(paragraph);

            //Maak nieuw div-element
            var div = document.createElement("div")
            //Maak onzichtbaar input-element dat later met PHP kan worden opgehaald
            div.innerHTML = "<input type='hidden' name='fietskeuze[]' value='" + checkboxes[i].value + "' />";
            //Voeg div-element toe aan het formulier
            bestelForm.appendChild(div);
        }
    }
    else {
        //Haal element op uit de HTML
        var errorElement = document.getElementById("rental-error");
        //Geef error in het rood
        errorElement.innerText = "Selecteer een fiets om verder te gaan!";
        errorElement.style.color = "red";
    }
}
