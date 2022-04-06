<!DOCTYPE html>
<html lang="nl">
<?php 
    // krijg content uit de database
    $fietsendatabase = file_get_contents("beheerbestanden/fietsen.json");
    // maak de content tot een array
    $fietsenarray = json_decode($fietsendatabase, true);
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
    <script src="js/bikeshop.js"></script>
</head>

<body>
    <?php
        include 'header.php';
        include 'menu.php'; 
    ?>
    <main>
        <article>
            <h1>Fietsen</h1>
                <a href="#" class="winkelwagen-button" onclick="openShoppingCart()">
                    <img src="images/winkelwagen.png" alt="winkelwagentje">
                    <p>Open winkelwagentje</p>
                </a>
            <div class="fietsen-grid" id="fietsen-grid">
                <?php 
                //Als fietsenarray niet leeg is
                if(!empty($fietsenarray)) {
                    //Maak een div voor elke fiets uit de array
                    foreach ($fietsenarray as $fiets) {
                        $idnum = $fiets['id']+1;
                        $id = "fiets" . $idnum;
                        echo "<div onclick=\"showItem('" . $id . "')". "\">\n";
                        if(!empty($fiets['img'])) {
                            echo "<img src=\"" . $fiets['img'] . "\" alt=\"" . "Foto van " . $fiets['naam'] . "\" />\n";
                        }
                        else {
                            echo "<img src=\"images\\fietsen\\placeholder.png\" alt=\"" . "Foto van " . $fiets['naam'] . "\" />\n";
                        }
                        echo "<p>" . $fiets['naam'] . "</p>\n";
                        echo "</div>\n";
                    }
                }
                ?>
            </div>
            <?php 
                //Als fietsenarray niet leeg is
                if(!empty($fietsenarray)) {
                    //Maak een div voor elke fiets uit de array
                    foreach ($fietsenarray as $fiets) {
                        $idnum = $fiets['id']+1;
                        $id = "fiets" . $idnum;                        
                        echo "<div class='fietsen-item' id=\"" . $id . "\">";
                        echo "<a href='#' onclick='showAllBikes()'>Terug naar fietsenoverzicht</a>";
                        echo "<div class='fietsen-item-flex'>\n";
                        if(!empty($fiets['img'])) {
                            echo "<img src=\"" . $fiets['img'] . "\" alt=\"" . "Foto van " . $fiets['naam'] . "\" id=\"image" . $id . "\" />\n";
                        }
                        else {
                            echo "<img src=\"images\\fietsen\\placeholder.png\" alt=\"" . "Foto van " . $fiets['naam'] . "\" id=\"image" . $id . "\" />\n";
                        }
                        echo "<div>\n";
                        echo "<h1 id=\"naam" . $id . "\">" . $fiets['naam'] . "</h1>";
                        echo "<p>" . $fiets['opmerking'] . "</p>";
                        if(!empty($fiets['prijs'])) {
                            echo "<p>Prijs: &euro; <span id=\"prijs" . $id . "\">" . $fiets['prijs'] . "</span></p>";
                        }
                        else {
                            echo "<p>Prijs: &euro; <span id=\"prijs" . $id . "\">0,00</span></p>";   
                        }
                        echo "<input type='image' src='images/winkelwagen.png' alt='Pictogram van winkelwagen' class='cartSubmit' onclick=\"addFiets('" . $id . "')\"/>";
                        echo "<h3>Specificaties</h3>";
                        echo "<p>Fietscode: " . $idnum . "</br>\n";
                        if(!empty($fiets['aandrijving'])) {
                            echo "Aandrijving: " . $fiets['aandrijving'] . "</br>\n";
                        }
                        if(!empty($fiets['doelgroep'])) {
                            echo "Geschikt voor: " . $fiets['doelgroep'] . "</br>\n";
                        }
                        if(!empty($fiets['model'])) {
                            echo "Model: " . $fiets['model'] . "</br>\n";
                        }
                        if(!empty($fiets['type'])) {
                            echo "Type: " . $fiets['type'] . "</br>\n";
                        }
                        if(!empty($fiets['merk'])) {
                            echo "Merk: " . $fiets['merk'] . "</br>\n";
                        }
                        if(!empty($fiets['staat'])) {
                            echo "Staat: " . $fiets['staat'] . "</br>\n";
                        }
                        if(!empty($fiets['kleur'])) {
                            echo "Kleur: " . $fiets['kleur'] . "</br>\n";
                        }
                        echo "</p>\n</div>\n</div>\n</div>\n";
                    }
                }
            ?>
            <div id="overlay">
                    <div id="shoppingcart">
                        <h2>Winkelwagen</h2>
                        <i class="fa fa-times" onclick="closeShoppingCart()"></i>
                        <div id="totaalprijs">
                            <h2>Totaalprijs:</h2>
                            <p id="totaalbedrag">&euro; 0,00</p>
                        </div>
                        <button id="submitAfrekenen">Afrekenen</button>
                    </div>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>