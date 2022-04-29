<?php
require_once './autoload.php';

$sessionConfig = new SessionConfig();
$sessionConfig->expiration = new SessionExpiration(0, 1, 0);
// HTTPS only
// $sessionConfig->options['cookie_secure'] = true;

$session = new Session($sessionConfig);

if (Helpers::isPost() && Helpers::getFormField('end_session', FieldTypes::boolean)) {
    $session->end();
}

// init / get session vars
$entries = $session->get('entries') ?? [];

if (Helpers::isPost()) {
    $newEntry = Helpers::getFormField('entry', FieldTypes::string);
    if ($newEntry) {
        array_push($entries, $newEntry);
    }
}

// save session vars
$session->set('entries', $entries);

// --- CONTENT START:
// -> no output before to allow modification of HTTP headers

// DEBUG ONLY
echo '<!-- SESSION ID: ' . $session->id() . ' -->';
echo '<!-- LAST ACTIVITY:   ' . $session->get('LAST_ACTIVITY') . ' -->';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook</title>

    <style>
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        /* spacing */

        .mt-1 {
            margin-top: 10px;
        }

        .mb-1 {
            margin-bottom: 10px;
        }

        .mt-2 {
            margin-top: 20px;
        }

        .mb-2 {
            margin-bottom: 20px;
        }

        /* helpers */

        .hidden {
            display: none;
        }

        .italic {
            font-style: italic;
        }

        .bold {
            font-weight: 700;
        }

        /* colors */

        .success {
            color: #00FF00;
        }

        .info {
            color: #0000FF;
        }

        .warn {
            color: #FFD700;
        }

        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
<noscript>
    <div class="mb-2">
        <strong class="error">Please enable JavaScript to use this application.</strong>
    </div>
</noscript>

<div class="hidden mb-2" id="cookies-disabled">
    <strong class="error">Please enable cookies to use this application.</strong>
</div>

<div id="app">
    <div>
        <h1>Logbook</h1>
        <p>Entries:</p>

        <ul>
            <?php
            foreach ($entries as $entry) :
                ?>
                <li><?php echo $entry; ?></li>
            <?php
            endforeach;

            if (!count($entries)) :
                ?>
                <li class="italic">...</li>
            <?php
            endif;
            ?>
        </ul>
    </div>


    <div>
        <form method="post">
            <input type="text" name="entry" id="entry" placeholder="enter something ..." autofocus>
            <button type="submit">Add</button>
        </form>
    </div>

    <div class="mt-2">
        <form method="post">
            <input type="hidden" name="end_session" value="true">
            <button type="submit">End Session</button>
        </form>
    </div>
</div>

<script>
    if (!navigator.cookieEnabled) {
        document.getElementById('cookies-disabled').style.display = 'block';
        document.getElementById('app').classList.add('hidden');
    }
</script>
</body>

<?php
if (Helpers::isPost()) {
    Helpers::preventReSubmit();
}
?>

</html>
