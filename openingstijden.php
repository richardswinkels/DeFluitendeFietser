<!DOCTYPE html>
<html lang="nl">
<?php
    // krijg content uit de database
    $databaseadres = file_get_contents("beheerbestanden/adres.json");
    // maak de content tot een array
    $databaseadrestext = json_decode($databaseadres, true);

    //Haal gegevens op uit de json-file
    $databaseopeningstijden = file_get_contents("beheerbestanden/openingstijden.json");
    //Zet deze in een string
    $databaseopeningstijdenarray = json_decode($databaseopeningstijden, true);

    //pakt de dagen uit de array met daarin de openings en sluitings tijden, mocht hij geen data vinden dan zet die als default de tijden op "00:00"
    $maandag = $databaseopeningstijdenarray['maandag'] ?? "00:00";
    $dinsdag = $databaseopeningstijdenarray['dinsdag'] ?? "00:00";
    $woensdag = $databaseopeningstijdenarray['woensdag'] ?? "00:00";
    $donderdag = $databaseopeningstijdenarray['donderdag'] ?? "00:00";
    $vrijdag =  $databaseopeningstijdenarray['vrijdag'] ?? "00:00";
    $zaterdag = $databaseopeningstijdenarray['zaterdag'] ?? "00:00";
    $zondag = $databaseopeningstijdenarray['zondag'] ?? "00:00";
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
        <article>
            <h1>Openingstijden</h1>
            <div class="openingstijden-grid">
                <div class="openingstijden-tijden">
                    <p>
                        Onze openingstijden<br /><br />
                        Maandag<br />
                        Dinsdag<br />
                        Woensdag<br />
                        Donderdag<br />
                        Vrijdag<br />
                        Zaterdag<br />
                        Zondag
                    </p>
                    <p>
                        <br /><br />
                        <?php
                            if ($maandag[0] != $maandag[1]) {
                                echo $maandag[0] . " - " . $maandag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($dinsdag[0] != $dinsdag[1]) {
                                echo $dinsdag[0] . " - " . $dinsdag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($woensdag[0] != $woensdag[1]) {
                                echo$woensdag[0] . " - " . $woensdag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($donderdag[0] != $donderdag[1]) {
                                echo $donderdag[0] . " - " . $donderdag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($vrijdag[0] != $vrijdag[1]) {
                                echo $vrijdag[0] . " - " . $vrijdag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($zaterdag[0] != $zaterdag[1]) {
                                echo $zaterdag[0] . " - " . $zaterdag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                            if ($zondag[0] != $zondag[1]) {
                                echo $zondag[0] . " - " . $zondag[1] . "<br />";
                            }
                            else{
                                echo "Gesloten" . "<br />";
                            }
                        ?>
                    </p>
                </div>
                <div class="openingstijden-adres">
                    <p>
                        Adresgegevens<br /><br />
                        <?php echo $databaseadrestext; ?>
                    </p>
                </div>
                <div class="openingstijden-map">
                    <iframe src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=nl&amp;q=51.47424,%205.595563+(De%20fluitende%20fietser)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                </div>
            </div>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>