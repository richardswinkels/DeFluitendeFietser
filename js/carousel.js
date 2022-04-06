///Zet standaardfoto op eerste foto
var iPicture = 0;
//Laat eerste foto zien
showPicture(iPicture);

function showPicture(valuePic) {
    //Haal de verschillende elementen op met klasse picture
    var pictures = document.getElementsByClassName("picture");
    //Loop door de elementen heen
    for (var i = 0; i < pictures.length; i++) {
        //Zet alle elementen op onzichtbaar
        pictures[i].style.display = "none";
    }
    //Als index groter is dan de lengte van pictures (min één want array begint bij nul)
    if(valuePic > (pictures.length - 1)) {
        //Begin weer bij 1
        iPicture = 0;
    }
    //Als index kleiner is dan nul
    if(valuePic < 0) {
        //Zet index gelijk aan de laatste foto
        iPicture = pictures.length - 1;
    }
    //Laat de gevraagde foto min één zien
    pictures[iPicture].style.display = "block";
}

function changePicture(direction) {
    //Verander foto
    showPicture(iPicture += direction);
}
