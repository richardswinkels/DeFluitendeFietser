<!DOCTYPE html>
<html lang="nl">
<?php 
    function writeData() {
        $isValid = true;

        //Als formulier met POST verstuurd wordt
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Als naam niet leeg is
            if(!empty($_POST['name'])) {
                $name = FilterInput($_POST['name']);
            }
            else {
                $name= "";
                $isValid = false;
                echo '<p>Er is geen naam ingevoerd!</p>';
            }
            //Als email niet leeg is
            if(!empty($_POST['email'])) {
                //Als email voldoet
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $email = FilterInput($_POST['email']);
                }
                else {
                    $email = "";
                    $isValid = false;
                    echo '<p>Uw e-mailadres voldoet niet aan de gevraagde indeling!</p>';  
                }
            }
            else {
                $email = "";
                $isValid = false;
                echo '<p>Er is geen e-mailadres ingevoerd!</p>';
            }
            $phone = FilterInput($_POST['phone']);
            $address = FilterInput($_POST['adres']);
            $city = FilterInput($_POST['city']);
            //Als postcode niet leeg is
            if(!empty($_POST['postalcode'])) {
                $pattern = '/^[1-9][0-9]{3} ?[A-Z]{2}$/';
                //Als postcode voldoet aan de indeling
                if (preg_match($pattern, $_POST['postalcode'])) {
                    $postalcode = FilterInput($_POST['postalcode']);
                }
                else {
                    $postalcode = "";
                    $isValid = false;
                    echo '<p>Postcode voldoet niet aan de gevraagde indeling!</p>';
                }
            }
            else {
                $postalcode = "";
                $isValid = false;
                echo '<p>Er is geen postcode ingevoerd!</p>';
            }

            $text = "Naam: " . $name . "\n" . 
                    "E-mail: " . $email . "\n" . 
                    "Telefoonnummer: " . $phone . "\n" . 
                    "Adres: " . $address . "\n" . 
                    "Stad: " . $city . "\n" .
                    "Postcode: " . $postalcode . "\n" .
                    "Bestelling: ";
            
            //Als er fietskeuze gezet is
            if(isset($_POST['fietskeuze'])) {
                //Haal de invoervelden op
                $fietskeuze = $_POST['fietskeuze'];
                //Split de array om naar string gescheiden door komma's en voeg deze toe aan de variable text
                $text .= implode(', ', $fietskeuze);
            }
            else {
                $isValid = false;
                //Geef foutmelding aan de gebruiker
                echo '<p>Er is geen fietskeuze gemaakt!</p>';
            }

            if($isValid) {
            //Zet default tijdzone op Amsterdam
            date_default_timezone_set('Europe/Amsterdam');
            //Open tekstbestand in de map "bestellingen" met bestandsnaam die klantnaam en datum+tijd bevat
            $file = fopen(getcwd() . "/bestellingen/Bestelling - {$name} - " . date("d-m-y His") . ".txt", "w") or die("Kan bestand niet openen!");
            //Schrijf tekst naar tekstbestand
            fwrite($file, $text);
            //Sluit tekstbestand
            fclose($file);
            //Laat de gebruiker weten dat de  gegevens zijn verstuurd
            echo '<p>De gegevens zijn verstuurd!</p>';
            }
        }
        //Anders
        else {
            //Geef foutmelding aan de gebruiker
            echo '<p>Onjuiste verzendmethode!</p>';
        }
    }

    function filterInput($input) {
        //Filter input op HTML karakters
        $input = htmlspecialchars($input);
        //Verwijder onnodige whitespace
        $input = trim($input);
        return $input;
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
            <h1>Fietsverhuur</h1>
            <?php writeData(); ?>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>