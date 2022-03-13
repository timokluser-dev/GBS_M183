<!DOCTYPE html>
<html lang="en">

<?php
require_once './helpers.php';

if (count($_POST)) {
  Helpers::debug($_POST);
}
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bestellformular</title>

  <style>
    form>div {
      margin-bottom: 10px;
    }

    .mt {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <h1>WM-Ticketservice</h1>

  <form method="POST">
    <div>
      <input type="radio" name="anrede" id="herr" value="mr" required>
      <label for="herr">Herr</label>

      <input type="radio" name="anrede" id="frau" value="ms" required>
      <label for="frau">Frau</label>
    </div>

    <div>
      <label for="vorname">Vorname</label>
      <input type="text" name="Vorname" id="vorname" required />
    </div>

    <div>
      <label for="nachname">Nachname</label>
      <input type="text" name="Nachname" id="nachname" required />
    </div>

    <div>
      <label for="email">E-Mail-Adresse </label>
      <input type="email" name="Email" id="email" required />
    </div>

    <div>
      <label for="promo">Promo-Code</label>
      <input type="password" name="Promo" id="promo" />
    </div>

    <div>
      <label for="anzahl">Anzahl Karten</label>
      <select name="Anzahl" id="anzahl" required>
        <option value="" disabled selected>Bitte wählen</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div>

    <div>
      <label for="sektion">Gewünschte Sektion im Stadion</label>
      <select name="Sektion[]" size="4" multiple="multiple" id="sektion" required>
        <option value="nord">Nordkurve</option>
        <option value="sued">Südkurve</option>
        <option value="haupt">Haupttribüne</option>
        <option value="gegen">Gegentribüne</option>
      </select>
    </div>

    <div>
      <label for="kommentare">Kommentare/Anmerkungen</label>
      <textarea cols="70" rows="10" name="Kommentare" id="kommentare"></textarea>
    </div>

    <div class="mt">
      <label for="agb">Ich akzeptiere die AGB.</label>
      <input type="checkbox" name="AGB" id="agb" value="ok" required />
    </div>

    <div class="mt">
      <button type="submit">Bestellung aufgeben</button>
    </div>
  </form>
</body>

</html>
