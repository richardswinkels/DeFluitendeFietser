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

  function writeHome() {
    //Zet de post waarde in een variabele
    $hometext = $_POST['homeText'];

    //Zet deze variabele om naar json
    $texttojson = json_encode($hometext);
    //schrijf deze variabele naar een json-file
    file_put_contents('beheerbestanden/home.json', $texttojson);

    //Geef melding aan de gebruiker
    echo "<p class='message'>Homepagina content opgeslagen!</p>";    
  }

  function saveFiets() {
    // krijg content uit de database
    $databasefietsen = file_get_contents("beheerbestanden/fietsen.json");
    // maak de content tot een array
    $databasefietsenarray = json_decode($databasefietsen , true);

    $id = filterInput($_POST['fietsId']);
    $isValid = true;

    $fietsNieuw = array();

    //Als fiets ID leeg is
    if(empty($_POST['fietsId'])) {
      $isValid = false;
      //Geef foutmelding
      echo "<p class='message'>Fiets ID ontbreekt!</p>";
    } else {
      $id -= 1;
      $fietsNieuw['id'] = $id;
    }
    //Als fietsnaam leeg is
    if(empty($_POST['fietsNaam'])) {
      $isValid = false;
      //Geef foutmelding
      echo "<p class='message'>Fietsnaam ontbreekt!</p>";
    } else {
      $fietsNieuw['naam'] = filterInput($_POST['fietsNaam']);
    }
    if(!isset($_POST['fietsAandrijving'])){
      $fietsNieuw['aandrijving'] = "";
    } else {$fietsNieuw['aandrijving'] = filterInput($_POST['fietsAandrijving']);}
    if(!isset($_POST['fietsDoelgroep'])){
      $fietsNieuw['doelgroep'] = "";
    } else {$fietsNieuw['doelgroep'] = filterInput($_POST['fietsDoelgroep']);}
    if(!isset($_POST['fietsModel'])){
      $fietsNieuw['model'] = "";
    } else {$fietsNieuw['model'] = filterInput($_POST['fietsModel']);}
    $fietsNieuw['type'] = filterInput($_POST['fietsType']);
    $fietsNieuw['merk'] = filterInput($_POST['fietsMerk']);
    if(!isset($_POST['fietsStaat'])){
      $fietsNieuw['staat'] = "";
    } else {$fietsNieuw['staat'] = filterInput($_POST['fietsStaat']);}
    $fietsNieuw['kleur'] = filterInput($_POST['fietsKleur']);
    $fietsNieuw['prijs'] = filterInput($_POST['fietsPrijs']);
    $fietsNieuw['opmerking'] = filterInput($_POST['fietsOpmerking']);
    //Als foto upload leeg is
    if ($_FILES["fietsAfbeelding"]["name"] == "") {
      //Als onzichtbaar fotoveld leeg is
      if(empty($_POST['fietsImage'])){
        $fietsNieuw['img'] = "";
      }
      else {
        $fietsNieuw['img'] = filterInput($_POST['fietsImage']);
      }
    } else {
      //Upload de foto in de fietsendirectory
      $target_dir = "images/fietsen/";
      $target_file = $target_dir . basename($_FILES["fietsAfbeelding"]["name"]);
      move_uploaded_file($_FILES["fietsAfbeelding"]["tmp_name"], $target_file);
      $fietsNieuw['img'] = $target_file;
    }

    //Als item in de array bestaat
    if(array_key_exists($id, $databasefietsenarray)) {
      //Vervang item door ingevoerde item
      $databasefietsenarray[$id] = $fietsNieuw; 
    }
    else {
      //Voeg fiets aan de array toe
      array_push($databasefietsenarray, $fietsNieuw);
    }

    //Als invoer juist is
    if($isValid) {
    //Zet array om naar json
    $arraytojson = json_encode($databasefietsenarray);
    //Schrijf naar json-file
    file_put_contents('beheerbestanden/fietsen.json', $arraytojson);

    //Geef melding aan gebruiker
    echo "<p class='message'>Fiets opgeslagen!</p>";
    }
  }

  function removeFiets() {
    // krijg content uit de database
    $databasefietsen = file_get_contents("beheerbestanden/fietsen.json");
    // maak content tot een array
    $databasefietsenarray = json_decode($databasefietsen , true);

    //Als fiets id is ingevuld
    if(!empty($_POST['fietsId'])) {
      $id = filterInput($_POST['fietsId']) - 1;

      //Kijk of fiets betreffende ID bestaat
      if(array_key_exists($id, $databasefietsenarray)) {
        //Kijk of er een afbeelding aan de fiets gekoppeld is
        if(!empty($databasefietsenarray[$id]['img'])) {
          //Verwijder de afbeelding van de server
          unlink($databasefietsenarray[$id]['img']);
        }
      //Verwijder fiets uit de array
      unset($databasefietsenarray[$id]);
      
      //Zet de array om naar json
      $arraytojson = json_encode($databasefietsenarray);
      //schrijf deze variabele naar een json-file
      file_put_contents('beheerbestanden/fietsen.json', $arraytojson);
      //Geef melding aan de gebruiker
      echo "<p class='message'>Fiets verwijderd!</p>";
      } 
      else {
        //Geef errormelding aan de gebruiker
        echo "<p class='message'>Fiets ID ontbreekt!</p>";
      }
    }
  }

  function readVerhuur() {
    // krijg content uit de database
    $databaseverhuur = file_get_contents("beheerbestanden/verhuur.json");
    // maak de content tot een array
    $databaseverhuurarray = json_decode($databaseverhuur, true);

    //Loop door de fietsen heen en maak voor elke fiets een nieuwe rij met inputvelden
    foreach ($databaseverhuurarray as $fiets) {
      echo "<div>\n";
      echo "<input type='text' name='verhuurNaam[]' value=\"" . $fiets['naam'] . "\"/>"; 
      echo "<input type='number' name='verhuurPrijs[]' step='0.01' value=\"" . number_format(floatval($fiets['prijs']), 2) . "\" />";
      echo "<input type='number' name='verhuurVoorraad[]' value=\"" . $fiets['voorraad'] . "\" />";
      echo "</div>";
    }
  }

  function writeVerhuur(){ 
    //Zet de post waarden in een variabelen
    $namen = $_POST['verhuurNaam'];
    $prijzen = $_POST['verhuurPrijs'];
    $voorraad = $_POST['verhuurVoorraad'];
    $fietsenarray = array();

    //Loop door de fietsen heen
    for ($i=0; $i < count($_POST['verhuurNaam']) ; $i++) { 
      if(!empty($_POST['verhuurNaam'][$i])) {
        $fiets["naam"] = filterInput($_POST['verhuurNaam'][$i]);
        $fiets["prijs"] = number_format(floatval(filterInput($_POST['verhuurPrijs'][$i])), 2);
        $fiets["voorraad"] = filterInput($_POST['verhuurVoorraad'][$i]);
        //Voeg fiets aan de array toe
        array_push($fietsenarray, $fiets);
      }
    }
   
    //Zet deze variabele om naar json
    $arraytojson = json_encode($fietsenarray);
    //schrijf deze variabele naar een json-file
    file_put_contents('beheerbestanden/verhuur.json', $arraytojson);

    //Geef melding aan de gebruiker
    echo "<p class='message'>Fietsen opgeslagen!</p>";
  }

  function readOpeningstijden($dag, $state) {
    // krijg content uit de database
    $databaseopeningstijden = file_get_contents("beheerbestanden/openingstijden.json");
    // maak de content tot een array
    $databaseopeningstijdenarray = json_decode($databaseopeningstijden, true);

    //pakt de dagen uit de array met daarin de openings en sluitings tijden, mocht hij geen data vinden dan zet die als default de tijden op "00:00"
    echo $databaseopeningstijdenarray[$dag][$state];
  }

  function writeOpeningstijden() {
    // krijg content uit de database
    $databaseopeningstijden = file_get_contents("beheerbestanden/openingstijden.json");
    // maak de content tot een array
    $databaseopeningstijdenarray = json_decode($databaseopeningstijden, true);

    //pakt de dagen uit de array met daarin de openings en sluitings tijden, mocht hij geen data vinden dan zet die als default de tijden op "00:00"
    $maandag = $databaseopeningstijdenarray['maandag'] ?? "00:00";
    $dinsdag = $databaseopeningstijdenarray['dinsdag'] ?? "00:00";
    $woensdag = $databaseopeningstijdenarray['woensdag'] ?? "00:00";
    $donderdag = $databaseopeningstijdenarray['donderdag'] ?? "00:00";
    $vrijdag =  $databaseopeningstijdenarray['vrijdag'] ?? "00:00";
    $zaterdag = $databaseopeningstijdenarray['zaterdag'] ?? "00:00";
    $zondag = $databaseopeningstijdenarray['zondag'] ?? "00:00";
    //check of de input velden ingevult waren, zo niet zet de bestaande tijden neer (dit voorkomt dat er niets staat)
    if (empty($_POST['maandagopen'])) {
        $maandagopen = $maandag[0];
    }else{$maandagopen = filterInput($_POST['maandagopen']);}
    if (empty($_POST['maandagsluit'])) {
        $maandagsluit = $maandag[1];
    }else{$maandagsluit = filterInput($_POST['maandagsluit']);}
    if (empty($_POST['dinsdagopen'])) {
        $dinsdagopen = $dinsdag[0];
    }else{$dinsdagopen = filterInput($_POST['dinsdagopen']);}
    if (empty($_POST['dinsdagsluit'])) {
        $dinsdagsluit = $dinsdag[1];
    }else{$dinsdagsluit = filterInput($_POST['dinsdagsluit']);}
    if (empty($_POST['woensdagopen'])) {
        $woensdagopen = $woensdag[0];
    }else{$woensdagopen = filterInput($_POST['woensdagopen']);}
    if (empty($_POST['woensdagsluit'])) {
        $woensdagsluit = $woensdag[1];
    }else{$woensdagsluit = filterInput($_POST['woensdagsluit']);}
    if (empty($_POST['donderdagopen'])) {
        $donderdagopen = $donderdag[0];
    }else{$donderdagopen = filterInput($_POST['donderdagopen']);}
    if (empty($_POST['donderdagsluit'])) {
        $donderdagsluit = $donderdag[1];
    }else{$donderdagsluit = filterInput($_POST['donderdagsluit']);}
    if (empty($_POST['vrijdagopen'])) {
        $vrijdagopen = $vrijdag[0];
    }else{$vrijdagopen = filterInput($_POST['vrijdagopen']);}
    if (empty($_POST['vrijdagsluit'])){
        $vrijdagsluit = $vrijdag[1];
    }else{$vrijdagsluit = filterInput($_POST['vrijdagsluit']);}
    if (empty($_POST['zaterdagopen'])) {
        $zaterdagopen = $zaterdag[0];
    }else{$zaterdagopen = filterInput($_POST['zaterdagopen']);}
    if (empty($_POST["zaterdagsluit"])){
        $zaterdagsluit = $zaterdag[1];
    }else{$zaterdagsluit = filterInput($_POST['zaterdagsluit']);}
    if (empty($_POST['zondagopen'])) {
        $zondagopen = $zondag[0];
    }else{$zondagopen = filterInput($_POST['zondagopen']);}
    if (empty($_POST['zondagsluit'])) {
        $zondagsluit = $zondag[1];
    }else {$zondagsluit = filterInput($_POST['zondagsluit']);}

    //update de nieuwe tijden
    $databaseopeningstijdenarray['maandag'][0] = $maandagopen;
    $databaseopeningstijdenarray['maandag'][1] = $maandagsluit;
    $databaseopeningstijdenarray['dinsdag'][0] = $dinsdagopen;
    $databaseopeningstijdenarray['dinsdag'][1] = $dinsdagsluit;
    $databaseopeningstijdenarray['woensdag'][0] = $woensdagopen;
    $databaseopeningstijdenarray['woensdag'][1] = $woensdagsluit;
    $databaseopeningstijdenarray['donderdag'][0] = $donderdagopen;
    $databaseopeningstijdenarray['donderdag'][1] = $donderdagsluit;
    $databaseopeningstijdenarray['vrijdag'][0] = $vrijdagopen;
    $databaseopeningstijdenarray['vrijdag'][1] = $vrijdagsluit;
    $databaseopeningstijdenarray['zaterdag'][0] = $zaterdagopen;
    $databaseopeningstijdenarray['zaterdag'][1] = $zaterdagsluit;
    $databaseopeningstijdenarray['zondag'][0] = $zondagopen;
    $databaseopeningstijdenarray['zondag'][1] = $zondagsluit;
    $arraytojson = json_encode($databaseopeningstijdenarray);
    file_put_contents('beheerbestanden/openingstijden.json', $arraytojson);

    //Geef melding aan de gebruiker
    echo "<p class='message'>Openingstijden opgeslagen!</p>";
  }

  function readAdresgegevens() {
    //Haal gegevens op uit de json-file
    $databaseadresgegevens = file_get_contents("beheerbestanden/adres.json");
    //Zet deze in een string
    $databaseadresgegevenstext = strip_tags(json_decode($databaseadresgegevens, true));
    
    //Laat deze string zien
    echo $databaseadresgegevenstext;
  }

  function writeAdresgegevens() {
    //Zet de post waarde in een variabele, zorg dat bij iedere nieuwe lijn een linebreak wordt toegevoegd
    $adresgegevens = nl2br(filterInput($_POST['adresgegevens']));

    //Zet deze variabele om naar json
    $texttojson = json_encode($adresgegevens);
    //schrijf deze variabele naar een json-file
    file_put_contents('beheerbestanden/adres.json', $texttojson);

    //Geef melding aan de gebruiker
    echo "<p class='message'>Adresgegevens opgeslagen!</p>";
  }

  function readOverons() {
    //Haal gegevens op uit de json-file
    $databaseoverons = file_get_contents("beheerbestanden/overons.json");
    //Zet deze in een string
    $databaseoveronstext = json_decode($databaseoverons, true);

    //Laat deze string zien
    echo $databaseoveronstext;
  }

  function writeOverons() {
    //Zet de post waarde in een variabele
    $overonstext = $_POST['overonsText'];

    //Zet deze variabele om naar json
    $texttojson = json_encode($overonstext);
    //schrijf deze variabele naar een json-file
    file_put_contents('beheerbestanden/overons.json', $texttojson);
    //Geef melding aan de gebruiker
    echo "<p class='message'>Over ons-pagina content opgeslagen!</p>";    
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
  <script src="js/beheer.js"></script>
</head>

<body>
  <?php
        include 'header.php';
        include 'menu.php'; 
    ?>
  <main>
    <article>
      <h1>Beheer</h1>
      <select id="formSelection" onchange="showForms()">
        <option disabled selected value> -- Maak een keuze -- </option>
        <option value="home">Homepagina</option>
        <option value="fietsen">Fietsenpagina</option>
        <option value="fietsenverhuur">Verhuurpagina</option>
        <option value="openingstijden">Openingstijdenpagina</option>
        <option value="overons">Over ons-pagina</option>
      </select>

      <?php  
        if(isset($_POST['submitHome'])) writeHome();
      ?>
      <form method="POST" action="beheer.php" id="formHomebeheer">
        <div class="home-beheer-flex">
          <label for="homeText">Tekst:</label>
          <textarea name="homeText" id="homeText" cols="60" rows="16"><?php readHome(); ?></textarea>
        </div>
        <input type="submit" name="submitHome" value="Sla homepagina op" />
      </form>

      <?php  
        if(isset($_POST['saveFiets'])) saveFiets();
        if(isset($_POST['removeFiets'])) removeFiets();
      ?>
      <form method="POST" action="beheer.php" id="formFietsenbeheer" enctype="multipart/form-data">
        <div class="beheer-fietsen-flex">
          <div class="beheer-fietsen-flex-inner">
            <div>
              <label for="fietsId">ID:</label>
              <input type="number" min="1" step="1" name="fietsId" id="fietsId" onchange="getFietsInfo()" required />
            </div>
            <div>
              <label for="fietsNaam">Naam:</label>
              <input type="text" name="fietsNaam" id="fietsNaam" />
            </div>
          </div>
          <div class="beheer-fietsen-flex-inner">
            <div>
              <label for="fietsAandrijving">Aandrijving:</label>
              <select name="fietsAandrijving" id="fietsAandrijving">
                <option disabled selected value> -- Maak een keuze -- </option>
                <option value="elektrisch">Elektrisch</option>
                <option value="niet elektrisch">Niet elektrisch</option>
              </select>
            </div>
            <div>
              <label for="fietsDoelgroep">Geschikt voor:</label>
              <select name="fietsDoelgroep" id="fietsDoelgroep">
                <option disabled selected value> -- Maak een keuze -- </option>
                <option value="privé">Privé</option>
                <option value="zakelijk">Zakelijk</option>
                <option value="zakelijk en privé">Zakelijk en privé</option>
              </select>
            </div>
          </div>
          <div class="beheer-fietsen-flex-inner">
            <div>
              <label for="fietsModel">Model:</label>
              <select name="fietsModel" id="fietsModel">
                <option disabled selected value> -- Maak een keuze -- </option>
                <option value="dames">Damesfiets</option>
                <option value="heren">Herenfiets</option>
                <option value="N.V.T.">N.V.T.</option>
              </select>
            </div>
            <div>
              <label for="fietsStaat">Staat:</label>
              <select name="fietsStaat" id="fietsStaat">
                <option disabled selected value> -- Maak een keuze -- </option>
                <option value="nieuw">Nieuw</option>
                <option value="tweedehands">Tweedehands</option>
              </select>
            </div>
          </div>
          <div class="beheer-fietsen-flex-inner">
            <div>
              <label for="fietsType">Type:</label>
              <input type="text" name="fietsType" id="fietsType" />
            </div>
            <div>
              <label for="fietsMerk">Merk:</label>
              <input type="text" name="fietsMerk" id="fietsMerk" />
            </div>
          </div>
          <div class="beheer-fietsen-flex-inner">
            <div>
              <label for="fietsKleur">Kleur:</label>
              <input type="text" name="fietsKleur" id="fietsKleur" />
            </div>
            <div>
              <label for="fietsPrijs">Prijs:</label>
              <input type="number" name="fietsPrijs" id="fietsPrijs" step="0.01" />
            </div>
          </div>
          <div class="beheer-fietsen-flex-bottom">
            <label for="fietsOpmerking">Opmerking:</label>
            <textarea name="fietsOpmerking" id="fietsOpmerking" cols="60" rows="10"></textarea>
          </div>
          <div class="beheer-fietsen-flex-bottom">
            <label for="fietsAfbeelding">Afbeelding:</label>
            <input type="hidden" name="fietsImage" id="fietsImage" />
            <input type="file" name="fietsAfbeelding" id="fietsAfbeelding" />
          </div>
        </div>
        <input type="submit" name="saveFiets" value="Sla fiets op" />
        <input type="submit" name="removeFiets" value="Verwijder fiets" />
      </form>

      <?php if(isset($_POST['submitVerhuur'])) writeVerhuur(); ?>
      <form method="POST" action="beheer.php" id="formVerhuurbeheer">
        <div id="verhuur-beheer-flex">
          <div>
            <label for="verhuurNaam">Naam van fiets:</label>
            <label for="verhuurPrijs">Prijs per dag:</label>
            <label for="verhuurVoorraad">Voorraad:</label>
          </div>
          <?php readVerhuur(); ?>
          <div>
            <input type="text" name="verhuurNaam[]" onchange="addInputBoxes()" />
            <input type="number" name="verhuurPrijs[]" step="0.01" onchange="addInputBoxes()" />
            <input type="number" name="verhuurVoorraad[]" onchange="addInputBoxes()" />
          </div>
        </div>
        <input type="submit" name="submitVerhuur" value="Sla fietsen op" />
      </form>

      <?php if(isset($_POST['submitOpeningstijden'])) writeOpeningstijden(); ?>
      <div class="openingstijdenpagina-beheer">
        <form method="POST" action="beheer.php" id="formOpeningstijdenbeheer">
          <div id="openingstijdenflexbox">
            <h2>
              Maandag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="maandagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('maandag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="maandagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('maandag', 1)?>">
              </div>
            </div>
            <h2>
              Dinsdag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="dinsdagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('dinsdag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="dinsdagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('dinsdag', 1)?>">
              </div>
            </div>

            <h2>
              Woensdag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="woensdagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('woensdag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="woensdagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('woensdag', 1)?>">
              </div>
            </div>

            <h2>
              Donderdag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="donderdagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('donderdag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="donderdagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('donderdag', 1)?>">
              </div>
            </div>

            <h2>
              Vrijdag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="vrijdagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('vrijdag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="vrijdagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('vrijdag', 1)?>">
              </div>
            </div>

            <h2>
              Zaterdag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="zaterdagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('zaterdag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="zaterdagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('zaterdag', 1)?>">
              </div>
            </div>

            <h2>
              Zondag
            </h2>
            <div class="dagenhead">
              <div class="openingstijd">
                <h3>Openingstijd:</h3>
                <input name="zondagopen" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('zondag', 0)?>">
              </div>
              <div class="sluitingstijd">
                <h3>Sluitingstijd:</h3>
                <input name="zondagsluit" type="time" min="00:00" max="24:00"
                  value="<?php readOpeningstijden('zondag', 1)?>">
              </div>
            </div>
          </div>
          <input type="submit" name="submitOpeningstijden" value="Verander openingstijden" />
        </form>

        <?php if(isset($_POST['submitAdresgegevens'])) writeAdresgegevens(); ?>
        <form method="POST" action="beheer.php" id="formAdresbeheer">
          <div class="adres-beheer-flex">
            <label for="adresgegevens">Adresgegevens:</label>
            <textarea name="adresgegevens" id="adresgegevens" cols="60"
              rows="7"><?php readAdresgegevens(); ?></textarea>
          </div>
          <input type="submit" name="submitAdresgegevens" value="Verander adresgegevens" />
        </form>
      </div>

      <?php  
        if(isset($_POST['submitOverons'])) writeOverons();
      ?>
      <form method="POST" action="beheer.php" id="formOveronsbeheer">
        <div class="overons-beheer-flex">
          <label for="overonsText">Tekst:</label>
          <textarea name="overonsText" id="overonsText" cols="60" rows="16"><?php readOverons(); ?></textarea>
        </div>
        <input type="submit" name="submitOverons" value="Sla over ons-pagina op" />
      </form>
    </article>
  </main>
  <?php include 'footer.php'?>
</body>

</html>