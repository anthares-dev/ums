<?php
//* Aggiungiamo delle funzioni per gestione di dati nel DB in maniera automatica

// per ottenere la var $mysqli
require_once 'connection.php';

function verifyLogin($email, $password, $token)
{

    require_once 'model/User.php';

    $result = [
        'message' => 'USER LOGGEN IN',
        'success' => true,
    ];

    if ($token !== $_SESSION['csrf']) {
        $result = [
            'message' => 'TOKEN MISMATCH',
            'success' => false,
        ];
        return $result;
    }

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $result = [
            'message' => 'WRONG EMAIL',
            'success' => false,
        ];
        return $result;
    }

    if (strlen($password) < 4) {
        $result = [
            'message' => 'PASSWORD TOO SMALL',
            'success' => false,
        ];
        return $result;
    }

    $resEmail = getUserByEmail($email);
    if (!$resEmail) {
        $result = [
            'message' => 'USER NOT FOUND',
            'success' => false,
        ];
        return $result;
    }

    if (!password_verify($password, $resEmail['password'])) {
        $result = [
            'message' => 'WRONG PASSWORD',
            'success' => false,
        ];
        return $result;
    }

    $result['user'] = $resEmail;

    return $result;
}

function getConfig($param, $default = null)
{
    $config = require 'config.php';
    //var_dump($config);
    return array_key_exists($param, $config) ? $config[$param] : $default;
}

function getParam($param, $default = null)
{

    //* utilizziamo $_REQUEST perche cosi leggiamo sia get che post
    return $_REQUEST[$param] ?? $default;

}

//creaiamo una funzione per generare nomi in maniera random
function getRandName()
{
    $names = [
        'Roberto', 'Giovanni', 'Giulia', 'Mario', 'Ale', 'Fulvio', 'Michele',
    ];
    $lastnames = [
        'Rossi', 'Bianchi', 'Smith', 'Mendoza', 'Cruz', 'Wilde', 'Esposito',
    ];

    // generiamo degli indici casuali che vanno da 0 fino alla lunghezza array
    $rand1 = mt_rand(0, count($names) - 1);
    $rand2 = mt_rand(0, count($lastnames) - 1);

    return $names[$rand1] . ' ' . $lastnames[$rand2];
}
//echo getRandName();

function getRandEmail($name)
{
    $domains = ['google.com', 'yahoo.com', 'hotmail.it', 'libero.it'];

    $rand1 = mt_rand(0, count($domains) - 1);

    return $str = strtolower(str_replace(' ', '.', $name) . mt_rand(10, 99) . '@' . $domains[$rand1]);

}

// ecco la funzione per generare nomi random e popolare la nostra base dati
//echo getRandEmail(getRandName());

function getRandFiscalCode()
{
    $i = 16;
    $res = ''; //ABQZ
    //http://www.asciitable.com/
    //65-90 per le lettere maiuscole in formato ascii

    while ($i > 0) {
        $res .= chr(mt_rand(65, 90));
        $i--;
    }
    return $res;
}

//echo getRandFiscalCode();

function getRandAge()
{
    return mt_rand(0, 120);
}

//echo getRandAge();

//* Inseriamo i dati random nel databese attraverso una query SQL
function insertRandUser($totale, mysqli $conn)
{
    // facciamo un ciclo while da zero fino al totale stabilito, decrementando
    while ($totale > 0) {
        $username = getRandName();
        $email = getRandEmail($username);
        $fiscalcode = getRandFiscalCode();
        $age = getRandAge();

        $sql = "INSERT INTO users (username, email, fiscalcode, age) VALUES ('$username', '$email', '$fiscalcode', $age)";
        echo $totale . ' ' . $sql . '<br>';
        $res = $conn->query($sql);
        if (!$res) {
            echo $conn->error . '<br>';
        } else {
            // decremento il totale se non c'è errore, per poter chiudere il ciclo
            $totale--;
        }}
};

// commento per non creare altri 30 utenti random
//insertRandUser(100, $mysqli);

//* prendiamo la lista degli utenti
function getUsers(array $params = [])
{

    $conn = $GLOBALS['mysqli'];
    $orderBy = array_key_exists('orderBy', $params) ? $params['orderBy'] : 'id';
    $orderDir = array_key_exists('orderDir', $params) ? $params['orderDir'] : 'DESC';
    if ($orderDir !== 'ASC' && $orderDir !== 'DESC') {
        $orderDir = 'ASC';
    }
    $limit = (int) array_key_exists('recordsPerPage', $params) ? $params['recordsPerPage'] : 10;
    $page = (int) array_key_exists('page', $params) ? $params['page'] : 0;
    $start = $limit * ($page - 1);

    if ($start < 0) {$start = 0;}
    $search = array_key_exists('search', $params) ? $params['search'] : '';
    $search = $conn->escape_string($search);

    $records = [];

    $sql = 'SELECT * FROM users ';
    if ($search) {
        $sql .= "WHERE username LIKE '%$search%' ";
        $sql .= "OR fiscalcode LIKE '%$search%' ";
        $sql .= "OR email LIKE '%$search%' ";
        $sql .= "OR age LIKE '%$search%' ";
        $sql .= "OR id LIKE '%$search%' ";
    }
    $sql .= "ORDER BY $orderBy $orderDir LIMIT $start, $limit";

    //echo $sql;
    $res = $conn->query($sql);
    if ($res) {
        //* fetch_assoc() prende il primo valore e lo associa ad un array
        while ($row = $res->fetch_assoc()) {
            //* aggiungiamo ogni row dentro records
            $records[] = $row;
        }
    } else {
//* if there is no res
        die($conn->error);
    }

    return $records;
}

//* contiamo gli utenti
function countUsers()
{
    $conn = $GLOBALS['mysqli'];
    $total = 0;

    // contami tutti gli utenti e mettimili nell'alias total
    $sql = 'SELECT COUNT(*) as total FROM users';
    //echo $sql;
    $res = $conn->query($sql);
    if ($res) {
        $row = $res->fetch_assoc();
        $total = $row['total'];

    } else {
//* if there is no res
        die($conn->error);
    }

    return $total;
}

//var_dump(countUsers());

function copyAvatar(int $userid)
{

    $result = [
        'success' => false,
        'message' => 'PROBLEM SAVING IMAGE',
        'filename' => '',
    ];

    if (empty($_FILES)) {

        $result['message'] = 'NO FILE UPLOADED';
        return $result;
    }

    $FILE = $_FILES['avatar'];
    if (!is_uploaded_file($FILE['tmp_name'])) {
        $result['success'] = true;
        $result['message'] = '';
        return $result;
    }
    $finfo = finfo_open(FILEINFO_MIME);
    $info = finfo_file($finfo, $FILE['tmp_name']);
    if (stristr($info, 'image/jpeg', ) === false) {
        $result['message'] = 'THE UPLOADED FILE IS NOT JPEG';
        return $result;
    }
    $maxSize = getConfig('maxFileUpload');
    if ($FILE['size'] > $maxSize) {
        $result['message'] = 'THE UPLOADED FILE IS TOO BIG. MAX SIZE IS ' . $maxSize;
        return $result;
    }

    // after checks, copying file:
    $filename = $userid . '_' . str_replace('.', '', microtime(true)) . '.jpg';
    $avatarDir = getConfig('avatarDir');

    if (!move_uploaded_file($FILE['tmp_name'], $avatarDir . $filename)) {
        $result['message'] = 'COULD NOT MOVE UPLOADED FILE';
        return $result;
    }

    // miniatura
    $newImg = imagecreatefromjpeg($avatarDir . $filename);
    if (!$newImg) {
        $result['message'] = 'COULD NOT CREATE THUMBNAIL RESOURCE';
        return $result;
    }
    $thumbNailImg = imagescale($newImg, getConfig('thumbNail_width', 120));
    $previewImg = imagescale($newImg, getConfig('previewImg_width', 400));
    if (!$thumbNailImg) {
        $result['message'] = 'COULD NOT SCALE THUMBNAIL RESOURCE';
        return $result;
    }
    imagejpeg($thumbNailImg, $avatarDir . 'thumb_' . $filename);
    imagejpeg($previewImg, $avatarDir . 'preview_' . $filename);

    $result['success'] = 1;
    $result['message'] = '';
    $result['filename'] = $filename;
    return $result;
}

function removeOldAvatar(int $id, array $userData = null)
{
    $userData = $userData ?: getUser($id);
    if (!$userData || !$userData['avatar']) {
        return;
    }

    $avatarFolder = getConfig('avatarDir');
    $filename = $avatarFolder . $userData['avatar'];
    $filenameThumb = $avatarFolder . 'thumb_' . $userData['avatar'];
    if (file_exists($filename)) {
        unlink($filename);
    }
    if (file_exists($filenameThumb)) {
        unlink($filenameThumb);
    }
}

function isUserLoggedin()
{
    return $_SESSION['loggedin'] ?? false;

}

function getUserLoggedInFullname()
{
    return $_SESSION['userData']['username'] ?? '';
}

function getUserRole()
{
    return $_SESSION['userData']['roletype'] ?? '';
}

function getUserEmail()
{
    return $_SESSION['userData']['email'] ?? '';
}

function isUserAdmin()
{
    return getUserRole() === 'admin';
}

function userCanUpdate()
{
    $role = getUserRole();
    return $role = 'admin' || $role === 'editor';
}

function userCanDelete()
{
    return isUserAdmin();
}