<?php
session_start();
require_once 'functions.php';
// check if the form is not empty and there is a ajax call

$header = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
if (!empty($_POST) && $header === 'XMLHTTPREQUEST') {

    $token = $_POST['_csrf'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = verifyLogin($email, $password, $token);
    if ($result['success']) {
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        unset($result['user']['passoword']);
        $_SESSION['userData'] = $result['user'];

    }

    // echo json_encode(getallheaders());
    //exit;
    echo json_encode($result);

}