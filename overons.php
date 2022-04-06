<!DOCTYPE html>
<html lang="nl">
<?php
    function readOverons() {
        //Haal gegevens op uit de json-file
        $databaseoverons = file_get_contents("beheerbestanden/overons.json");
        //Zet deze in een string
        $databaseoveronstext = json_decode($databaseoverons, true);

        //Laat de string zien
        echo $databaseoveronstext;
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
        <article>
            <h1>Over ons</h1>
            <div class="overons-grid">
                <div class="overons-text">
                    <?php readOverons(); ?>
                </div>
                <div class="overons-photos">
                    <img src="images/historie1.jpg" alt="Historische foto" />
                    <img src="images/team.png" alt="Foto van het team" />
                </div>
            </div>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>