<?php

//* connessione con il database
// invece di stabilire una variabile , poniamo direttamente un return
// in tal modo non è necessario richiamare una variabile specifica quando si
// richiama config.php da altre zone del codice

$mega = 1024 * 1024;
$giga = $mega * 1024;

$maxUpload = ini_get('upload_max_filesize');
if (stristr($maxUpload, 'G')) {
    $maxUpload = intval($maxUpload) * $giga;
} else {
    $maxUpload = intval($maxUpload) * $mega;
}

return [
    'mysql_host' => 'localhost',
    'mysql_user' => 'root',
    'mysql_password' => 'admin',
    'mysql_db' => 'corso_php',
    'recordsPerPage' => 10,
    'recordsPerPageOptions' => [5, 10, 20, 50, 100],
    'orderByColumns' => [
        'id', 'email', 'fiscalcode', 'age', 'username', 'roletype',
    ],
    'numLinkNavigator' => 5,
    'maxFileUpload' => $maxUpload,
    'avatarDir' => $_SERVER['DOCUMENT_ROOT'] . '/avatar/',
    'webAvatarDir' => '/avatar/',
    'thumbNail_width' => 200,
    'previewImg_width' => 600,
    'roletypes' => ['user', 'editor', 'admin'],
];

//const MAX_FILE_SIZE = 3000000000;