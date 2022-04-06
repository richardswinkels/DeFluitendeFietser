<!DOCTYPE html>
<html lang="nl">
<?php 
    // krijg content uit de database
    $verhuurdatabase = file_get_contents("beheerbestanden/verhuur.json");
    // maak de content tot een array
    $verhuurarray = json_decode($verhuurdatabase, true);
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
    <script src="js/rental.js"></script>
</head>

<body>
    <?php
        include 'header.php';
        include 'menu.php'; 
    ?>
    <main>
        <article>
            <h1>Fietsverhuur</h1>
            <div class="fietsverhuur-selection-grid" id="fietsverhuur-selection-grid">
                <div class="fietsverhuur-photos" id="left">
                    <img src="images/verhuur1.jpg" alt="Foto van fietsen" id="imgVerhuurEen" />
                    <img src="images/ebike.png" alt="Pictogram van ebike" id="imgEbike" />
                </div>
                <div class="fietsverhuur-tabel">
                    <span id="rental-error"></span>
                    <table>
                        <tr>
                            <th></th>
                            <th>Naam van fiets</th>
                            <th>Prijs per tijdseenheid</th>
                        </tr>
                        <?php 
                            //Genereer tabel
                            foreach($verhuurarray as $fiets){
                            echo "<tr>\n";
                            echo "<td><input type='checkbox' value=\"" . $fiets['naam'] . "\" /></td>\n";
                            echo "<td>" . $fiets['naam'] . "</td>\n";
                            echo "<td>&euro;" . $fiets['prijs'] . " / dag</td>\n";
                            echo "</tr>\n";
                            }
                        ?>
                    </table>
                    <button onclick="showForm()">Huur een fiets</button>
                </div>
                <div class="fietsverhuur-photos" id="right">
                    <img src="images/fietsen/1.jpg" alt="foto van fiets" id="imgFiets" />
                    <img src="images/verhuur2.jpg" alt="foto van fietsen" id="imgVerhuurTwee" />
                </div>
            </div>
            <div class="fietsverhuur-form-flex" id="fietsverhuur-form-flex">
                <div class="fietsverhuur-form">
                    <form action="bestel.php" method="POST" id="bestelForm">
                        <div>
                            <label for="name">Naam:</label>
                            <input type="text" name="name" id="name" required />
                        </div>
                        <div>
                            <label for="email">E-mailadres:</label>
                            <input type="email" name="email" id="email"
                                pattern="[a-zA-Z0-9.-_]+@[a-zA-Z.-]+[.]{1}[a-zA-Z]{2,}"
                                title="E-mailadres moet geldig zijn." required />
                        </div>
                        <div>
                            <label for="phone">Telefoonnummer:</label>
                            <input type="tel" name="phone" id="phone" />
                        </div>
                        <div>
                            <label for="adres">Adres:</label>
                            <input type="text" name="adres" id="adres" />
                        </div>
                        <div class="fietsverhuur-inner-flex">
                            <div id="fietsverhuur-form-city">
                                <label for="city">Stad:</label>
                                <input type="text" name="city" id="city" />
                            </div>
                            <div id="fietsverhuur-form-postalcode">
                                <label for="postalcode">Postcode:</label>
                                <input type="text" name="postalcode" id="postalcode"
                                    pattern="[1-9]{1}[0-9]{3}[\s]?[A-Za-z]{2}" required />
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Gegevens versturen" id="submitVerhuur">
                        </div>
                    </form>
                </div>
                <div class="fietsverhuur-bestelling" id="fietsverhuur-bestelling">
                    <h2>Gekozen fiets(en)</h2>
                </div>
            </div>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>