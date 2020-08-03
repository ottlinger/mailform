<?php

// Check whether the file exists or fallback to the template
// DEVHINT: it's quite odd that file_exists seems to start at root, while parse takes the relative path from this file
if (file_exists(dirname(__FILE__).'/mailform-config.php')) {
    $filename = 'mailform-config.php';
} else {
    $filename = 'mailform-config.php.template';
}
$isTemplate = strpos($filename, '.template') !== false;

// load configuration and dump if template or debug=true
$GLOBALS['mailform'] = parse_ini_file($filename);

if ($isTemplate) {
    // allow error reporting
    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    echo '<pre>';
    if ($isTemplate) {
        echo '<strong>You should adapt your configuration and save it as mailform-config.php, currently the dummy template is used, which means NO mail is sent out!</strong>';
    }
    echo '</pre>';
}
