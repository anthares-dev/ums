<?php
session_start();

require_once 'functions.php';
// check if the form is not empty
if (!empty($_POST)) {
    // echo $_SESSION['csrf'];
    // var_dump($_POST);
    if (!empty($_POST['action']) && $_POST['action'] === 'logout') {

        $_SESSION = [];
        header('Location: login.php');
        exit;
    }

    $token = $_POST['_csrf'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = verifyLogin($email, $password, $token);
    unset($_SESSION['csrf']);
    //var_dump($result);

    if ($result['success']) {
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        unset($result['user']['passoword']);
        $_SESSION['userData'] = $result['user'];
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = $result['message'];
        header('Location: login.php');
    }

} else {
    header('Location: login.php');
}