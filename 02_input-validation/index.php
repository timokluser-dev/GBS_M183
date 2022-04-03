<!DOCTYPE html>
<html lang="en">

<?php
require_once './helpers.php';

$errors = [];

#region Form Fields
$anrede = Helpers::getFormField('Anrede');
$vorname = Helpers::getFormField('Vorname');
$nachname = Helpers::getFormField('Nachname');
$email = Helpers::getFormField('Email');
$promo = Helpers::getFormField('Promo');
$anzahl = Helpers::getFormField('Anzahl', FieldTypes::int);
$kommentare = Helpers::getFormFieldLongText('Kommentare');
$sektion = Helpers::getFormField('Sektion', FieldTypes::array);
$agb = Helpers::getFormField('AGB', FieldTypes::boolean);
#endregion Form Fields

$reset = Helpers::getFormField('reset');
if ($reset) {
  $anrede = null;
  $vorname = null;
  $nachname = null;
  $email = null;
  $promo = null;
  $anzahl = null;
  $kommentare = null;
  $sektion = null;
  $agb = null;
}

if (Helpers::isPost()) {
  // Helpers::preventReSubmit();

  if (!$anrede) {
    array_push($errors, 'Keine Anrede angegeben');
  }
  $anreden = ['mr', 'ms'];
  if (!Helpers::array_includes($anrede, $anreden)) {
    array_push($errors, 'Keine gültige Anrede angegeben');
  }

  if (!$vorname) {
    array_push($errors, 'Keinen Vornamen angegeben');
  }

  if (!$nachname) {
    array_push($errors, 'Keinen Nachname angegeben');
  }

  if (!$email) {
    array_push($errors, 'Keine Email angegeben');
  }

  $promoCodes = Helpers::getJson('promo.json')->promos;
  if ($promo && !Helpers::array_includes($promo, $promoCodes)) {
    array_push($errors, 'Ungültiger Promo-Code eingegeben');
  }

  if (!$anzahl) {
    array_push($errors, 'Keine Anzahl Tickets angegeben');
  }

  if (!$sektion) {
    array_push($errors, 'Keine Sektion(en) ausgewählt');
  }


  if (!$agb) {
    array_push($errors, 'Die AGBs wurden nicht akzeptiert');
  }
}
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bestellformular</title>

  <style>
    @charset "UTF-8";

    form>div {
      margin-bottom: 10px;
    }

    .mt {
      margin-top: 20px;
    }

    .form-detail__container span {
      font-weight: 600;
    }

    .form-detail__container>div>p,
    .form-detail__container>div>span {
      display: inline;
    }
  </style>
</head>

<body>
  <h1>WM-Ticketservice</h1>

  <?php
  if (count($errors) && !$reset) :
  ?>

    <div class="form-errors">
      <h2>Folgende Fehler sind aufgetreten:</h2>

      <ul>
        <?php
        foreach ($errors as $error) :
        ?>
          <li><?php echo $error; ?></li>
        <?php
        endforeach;
        ?>
      </ul>
    </div>

  <?php
  endif;

  if (Helpers::isPost() && !$errors) :
  ?>

    <div class="form-detail">
      <h2>Besten Dank!</h2>
      <h3>Ihre Angaben:</h3>

      <div class="mt form-detail__container">
        <div>
          <span>Anrede:</span>
          <p><?php echo $anrede; ?></p>
        </div>
        <div>
          <span>Vorname:</span>
          <p><?php echo $vorname; ?></p>
        </div>
        <div>
          <span>Nachname:</span>
          <p><?php echo $nachname; ?></p>
        </div>
        <div>
          <span>Email:</span>
          <p><?php echo $email; ?></p>
        </div>
        <div>
          <span>Promo:</span>
          <p><?php echo $promo; ?></p>
        </div>
        <div>
          <span>Anzahl Karten:</span>
          <p><?php echo $anzahl; ?></p>
        </div>
        <div>
          <span>Sektion:</span>
          <p><?php echo join(' ', $sektion); ?></p>
        </div>
        <div>
          <span>Kommentar:</span>
          <div>
            <p><?php echo ($kommentare) ? $kommentare : '-- keinen --'; ?></p>
          </div>
        </div>
        <div>
          <span>AGB:</span>
          <p><?php echo ($agb) ? '✅' : ''; ?></p>
        </div>
      </div>
    </div>

  <?php

  else :
  ?>

    <div class="mt form">
      <form method="POST">
        <div>
          <input type="radio" name="Anrede" id="herr" value="mr" <?php if ($anrede === 'mr') : echo 'checked';
                                                                  endif; ?>>
          <label for="herr">Herr</label>

          <input type="radio" name="Anrede" id="frau" value="ms" <?php if ($anrede === 'ms') : echo 'checked';
                                                                  endif; ?>>
          <label for="frau">Frau</label>
        </div>

        <div>
          <label for="vorname">Vorname</label>
          <input type="text" name="Vorname" id="vorname" value="<?php echo $vorname; ?>" />
        </div>

        <div>
          <label for="nachname">Nachname</label>
          <input type="text" name="Nachname" id="nachname" value="<?php echo $nachname; ?>" />
        </div>

        <div>
          <label for="email">E-Mail-Adresse </label>
          <input type="email" name="Email" id="email" value="<?php echo $email; ?>" />
        </div>

        <div>
          <label for="promo">Promo-Code</label>
          <input type="password" name="Promo" id="promo" value="<?php echo $promo; ?>" />
        </div>

        <div>
          <label for="anzahl">Anzahl Karten</label>
          <select name="Anzahl" id="anzahl">
            <option value="" disabled <?php if (!$anzahl) : echo 'selected';
                                      endif; ?>>Bitte wählen</option>
            <option value="1" <?php if ($anzahl === 1) : echo 'selected';
                                endif; ?>>1</option>
            <option value="2" <?php if ($anzahl === 2) : echo 'selected';
                              endif; ?>>2</option>
            <option value="3" <?php if ($anzahl === 3) : echo 'selected';
                              endif; ?>>3</option>
            <option value="4" <?php if ($anzahl === 4) : echo 'selected';
                              endif; ?>>4</option>
          </select>
        </div>

        <div>
          <label for="sektion">Gewünschte Sektion im Stadion</label>
          <select name="Sektion[]" size="4" multiple="multiple" id="sektion">
            <option value="nord" <?php if ($sektion && Helpers::array_includes('nord', $sektion)) : echo 'selected';
                                  endif; ?>>Nordkurve</option>
            <option value="sued" <?php if ($sektion && Helpers::array_includes('sued', $sektion)) : echo 'selected';
                                  endif; ?>>Südkurve</option>
            <option value="haupt" <?php if ($sektion && Helpers::array_includes('haupt', $sektion)) : echo 'selected';
                                  endif; ?>>Haupttribüne</option>
            <option value="gegen" <?php if ($sektion && Helpers::array_includes('gegen', $sektion)) : echo 'selected';
                                  endif; ?>>Gegentribüne</option>
          </select>
        </div>

        <div>
          <label for="kommentare">Kommentare/Anmerkungen</label>
          <!-- SpecialCase: textarea when still edit, no Helpers::getFormFieldLongText -->
          <textarea cols="70" rows="10" name="Kommentare" id="kommentare"><?php echo Helpers::getFormField('Kommentare'); ?></textarea>
        </div>

        <div class="mt">
          <label for="agb">Ich akzeptiere die AGB.</label>
          <input type="checkbox" name="AGB" id="agb" value="error" <?php if ($agb) : echo 'checked';
                                                                            endif; ?> />
        </div>

        <div class="mt">
          <button type="submit">Bestellung aufgeben</button>
          <button type="submit" name="reset" value="true">Formular zurücksetzen</button>
        </div>
      </form>
    </div>

  <?php
  endif;
  ?>
</body>

</html>
