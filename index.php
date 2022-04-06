<!DOCTYPE html>
<html lang="nl">
<?php
    function readHome() {
        //Haal gegevens op uit de json-file
        $databasehome = file_get_contents("beheerbestanden/home.json");
        //Zet deze in een string
        $databasehometext = json_decode($databasehome , true);

        //Laat de string zien
        echo $databasehometext;
    }

    function getStoreState() {
        //Zet default tijdzone op Amsterdam
        date_default_timezone_set('Europe/Amsterdam');

        // krijg content uit de database
        $databaseopeningstijden = file_get_contents("beheerbestanden/openingstijden.json");
        // maak de content tot een array
        $databaseopeningstijdenarray = json_decode($databaseopeningstijden, true);
        // soorteer de array

        //pakt de dagen uit de array met daarin de openings en sluitings tijden, mocht hij geen data vinden dan zet die als default de tijden op "00:00"
        $maandag = $databaseopeningstijdenarray['maandag'] ?? "00:00";
        $dinsdag = $databaseopeningstijdenarray['dinsdag'] ?? "00:00";
        $woensdag = $databaseopeningstijdenarray['woensdag'] ?? "00:00";
        $donderdag = $databaseopeningstijdenarray['donderdag'] ?? "00:00";
        $vrijdag =  $databaseopeningstijdenarray['vrijdag'] ?? "00:00";
        $zaterdag = $databaseopeningstijdenarray['zaterdag'] ?? "00:00";
        $zondag = $databaseopeningstijdenarray['zondag'] ?? "00:00";

        //Zet openingstijden in array
        $openingstijden = array (
            "Mon"  => array("open" => $maandag[0], "gesloten" => $maandag[1]),
            "Tue"  => array("open" => $dinsdag[0], "gesloten" => $dinsdag[1]),
            "Wed"  => array("open" => $woensdag[0], "gesloten" => $woensdag[1]),
            "Thu"  => array("open" => $donderdag[0], "gesloten" => $donderdag[1]),
            "Fri"  => array("open" => $vrijdag[0], "gesloten" => $vrijdag[1]),
            "Sat"  => array("open" => $zaterdag[0], "gesloten" => $zaterdag[1]),
            "Sun"  => array("open" => $zondag[0], "gesloten" => $zondag[1])
        );
        
        //Zet tijdstip van opening van vandaag uit de array om naar timestamp
        $openTimeToday = strtotime($openingstijden[date('D')]['open']);
        //Zet tijdstip van sluiting van vandaag uit de array om naar timestamp
        $closingTimeToday = strtotime($openingstijden[date('D')]['gesloten']);
        //Krijg tijdstamp van huidige tijdstip
        $currentTime = time();

        //Als huidige timestamp tussen opening en sluit valt
        if($currentTime > $openTimeToday && $currentTime < $closingTimeToday) {
            //Geef 'geopend' terug
            return 'geopend';
        }
        else {
            //Geef 'gesloten' terug
            return 'gesloten';
        }
    } 
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluitende Fietser</title>
    <link rel="icon" href="images/logo20x20.png" type="image/png" sizes="20x20" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/menu.js"></script>
</head>

<body>
    <?php
        include 'header.php';
        include 'menu.php'; 
    ?>
    <main>
        <div class="carousel">
            <a class="carousel-button" id="previous" onclick="changePicture(-1)">&#10094;</a>
            <a class="carousel-button" id="next" onclick="changePicture(1)">&#10095;</a>
            <div class="picture">
                <img src="images/winkel1.jpg" alt="Foto van fietsenwinkel" />
            </div>
            <div class="picture">
                <img src="images/team.png" alt="Foto van fietsen" />
            </div>
            <div class="picture">
                <img src="images/winkel2.jpg" alt="Foto van fietsenwinkel" />
            </div>
            <div class="picture">
                <img src="images/winkel3.jpg" alt="Foto van fietsenwinkel" />
            </div>
        </div>
        <article id="home">
            <h1>De winkel is op dit moment <?php echo getStoreState(); ?>!</h1>
            <?php readHome();?>
        </article>
    </main>
    <?php include 'footer.php'?>
    <script src="js/carousel.js"></script>
</body>

</html>