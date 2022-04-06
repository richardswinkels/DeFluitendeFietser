function toggleMenu() {
    //Zet elementen met klasse .menu in variabele menu
    var menu = document.querySelector(".menu");

    //Als menu de klasse "nav-visible" heeft
    if (menu.classList.contains("visible")) {
        //Verwijder klasse "nav-visible"
        menu.classList.remove("visible");
    }
    else {
        //Voeg klasse "nav-visible" toe
        menu.classList.add("visible");
    }
}