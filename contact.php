<!DOCTYPE html>
<html lang="nl">
<?php 
    function writeData() {
        //Als formulier met POST verstuurd wordt
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Als name, email en postalcode niet leeg zijn
            if(!empty($_POST['email'])) {
                //Controleer of e-mail voldoet
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $firstname = FilterInput($_POST['firstname']);
                    $lastname = FilterInput($_POST['lastname']);
                    $email = FilterInput($_POST['email']);
                    $question = FilterInput($_POST['question']);

                    $text = "Voornaam: " . $firstname . "\n" . 
                            "Achternaam: " . $lastname . "\n" . 
                            "E-mail: " . $email . "\n" . 
                            "Vraag: " . $question . "\n";

                    //Zet default tijdzone op Amsterdam
                    date_default_timezone_set('Europe/Amsterdam');
                    //Open tekstbestand in de map "bestellingen" met bestandsnaam die klantnaam en datum+tijd bevat
                    $file = fopen(getcwd() . "/vragen/Vraag - {$firstname} {$lastname} - " . date("d-m-y His") . ".txt", "w") or die("Kan bestand niet openen!");
                    //Schrijf tekst naar tekstbestand
                    fwrite($file, $text);
                    //Sluit tekstbestand
                    fclose($file);
                    //Laat de gebruiker weten dat de  gegevens zijn verstuurd
                    echo '<p>De gegevens zijn verstuurd!</p><br/>';
                    }
                    else {
                        //Geef foutmelding aan de gebruiker
                        echo '<p>Uw e-mailadres voldoet niet aan de gevraagde indeling!</p><br/>';  
                    }
            }
            //Anders
            else {
                //Geef foutmelding aan de gebruiker
                echo '<p>Er is geen e-mailadres ingevoerd!</p>';
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
            <h1>Contact</h1>
            <?php if(isset($_POST['contactSubmit'])) writeData(); ?>
            <form method="POST" class="contact-form">
                <div class="contact-form-flex-top">
                    <div>
                        <label for="firstname">Voornaam:</label>
                        <input type="text" name="firstname" id="firstname" />
                    </div>
                    <div>
                        <label for="lastname">Achternaam:</label>
                        <input type="text" name="lastname" id="lastname" />
                    </div>
                </div>
                <div class="contact-form-flex-bottom">
                    <div>
                        <label for="email">E-mailadres:</label>
                        <input type="email" name="email" id="email"
                            pattern="[a-zA-Z0-9.-_]+@[a-zA-Z.-]+[.]{1}[a-zA-Z]{2,}"
                            title="E-mailadres moet geldig zijn." required />
                    </div>
                    <div>
                        <label for="question">Uw vraag:</label>
                        <textarea name="question" id="question" cols="60" rows="10"></textarea>
                    </div>
                    <div>
                        <input type="submit" value="Verzenden" name="contactSubmit" id="contactSubmit" />
                    </div>
                </div>
            </form>
        </article>
    </main>
    <?php include 'footer.php'?>
</body>

</html>