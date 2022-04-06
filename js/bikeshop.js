function showItem(itemname) {
    //Haal de elementen op uit de HTML
    var grid = document.getElementById("fietsen-grid");
    var item = document.getElementById(itemname);
    //Maak de fietsenselectie onzichtbaar en de gekozen fiets zichtbaar
    grid.style.display = "none";
    item.style.display = "block";
}

function showAllBikes() {
    //Haal de elementen op uit de HTML
    var grid = document.getElementById("fietsen-grid");
    var items = document.getElementsByClassName("fietsen-item");
    //Loop door alle fietsen en maak ze onzichtbaar
    for (var i = 0; i < items.length; i++) {
        items[i].style.display = "none";
    }
    //Laat de fietsenselectie zien
    grid.style.display = "grid";
}

function openShoppingCart() {
    //Haal de elementen op uit de HTML
    var overlay = document.getElementById("overlay");
    var cart = document.getElementById("shoppingcart");
    //Zorg dat de overlay en winkelwagen de klasse "visible" krijgen
    overlay.classList.add("visible");
    cart.classList.add("visible");
    //Scroll omhoog
    document.documentElement.scrollTop = 0;
}

function closeShoppingCart() {
    //Haal de elementen op uit de HTML
    var overlay = document.getElementById("overlay");
    var cart = document.getElementById("shoppingcart");
    //Verwijder de klasse "visible"
    overlay.classList.remove("visible");
    cart.classList.remove("visible");
}

function removeItem(button) {
    //Verwijder de parent van de verwijderbutton (dus de div met de fiets erin)
    button.parentElement.remove();
    //Update de prijs
    updatePrice();
}

function updatePrice() {
    //Haal alle elementen op uit de HTML
    var prijzen = document.getElementsByClassName("cartitem-fietsprijs");
    var aantallen = document.getElementsByClassName("aantal");
    var totaalprijsElement = document.getElementById("totaalbedrag");
    //Initialiseer variabele
    var totaalprijs = 0;

    //Loop door de prijzen van de producten heen
    for (var i = 0; i < prijzen.length; i++) {
        //Als het aantal groter of gelijk is aan nul
        if (parseInt(aantallen[i].value) >= 0) {
            //Tel het aantal keer de prijs op bij de totaalprijs
            totaalprijs += parseFloat(prijzen[i].innerHTML) * parseInt(aantallen[i].value);
        }
    }

    //Zet de totaalprijs in de HTML en rond het af op 2 decimalen
    totaalprijsElement.innerHTML = "&euro; " + totaalprijs.toFixed(2);
}

function addFiets(fietsId) {
    //Haal alle elementen op uit de HTML
    var cart = document.getElementById("shoppingcart");
    var totaalprijs = document.getElementById("totaalprijs");

    //Maak nieuw HTML-element
    var cartitem = document.createElement("div");
    //Zet de klasse gelijk aan cart-item
    cartitem.className = "cart-item";
    //Zet id gelijk aan cartitem plus meegegeven parameter
    cartitem.id = "cartitem" + fietsId;

    //Haal alle elementen op uit de HTML
    var existingCartitem = document.getElementById(cartitem.id);
    var fietsnaam = document.getElementById("naam" + fietsId).innerHTML;
    var fietsprijs = document.getElementById("prijs" + fietsId).innerHTML;
    var fietsimage = document.getElementById("image" + fietsId).src;

    //Als ID nog niet bestaat
    if (!existingCartitem) {
        //Voeg nieuwe fiets toe aan het winkelwagentje
        cartitem.innerHTML = "<i class='fa fa-trash' onclick='removeItem(this)'></i>\n<img src='" + fietsimage + "' alt='fiets'>\n<p class='cartitem-fietsnaam'>" + fietsnaam + "</p>\n<input type='number' class='aantal' value='1' onchange='updatePrice()'>\n<p class='cart-prijs'>&euro;<span class='cartitem-fietsprijs'>" + fietsprijs + "</span></p>";
        cart.insertBefore(cartitem, totaalprijs);
        //Update de totaalprijs
        updatePrice();
    }
    else {
        //Haal de elementen op uit de HTML
        inputAantal = existingCartitem.getElementsByClassName("aantal")[0];
        //Voeg één bij huidige aantal toe
        inputAantal.value = parseInt(existingCartitem.getElementsByClassName("aantal")[0].value) + 1;
    }
    //Bereken de totaalprijs
    updatePrice();
    //Open winkelwagentje
    openShoppingCart();
}