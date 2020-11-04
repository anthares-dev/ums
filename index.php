<?php
session_start();
require_once 'functions.php';

var_dump($_SESSION);

if (!isUserLoggedin()) {
    header('Location: login.php');
    exit;
}

require_once 'headerInclude.php';
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <h1 class="mt-5 text-center"></h1>
        <?php

if (!empty($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $alertType = $_SESSION['success'] ? 'success' : 'danger';
    require 'view/message.php';
    unset($_SESSION['message'], $_SESSION['success']);
}

require_once 'controller/displayUsers.php';

?>

    </div>
</main>

<?php
require_once 'view/footer.php';
?>