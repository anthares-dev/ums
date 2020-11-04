<?php
session_start();
require_once 'functions.php';
if (!isUserLoggedin()) {
    header('Location: login.php');
    exit;
}

if (!userCanUpdate()) {
    header('Location: index.php');
    exit;
}

require_once 'headerInclude.php';
?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h2 class="mt-5">UPDATE USER</h2>

        <?php

$id = getParam('id', 0);
$action = getParam('action', '');
$orderDir = getParam('orderDir', 'DESC');
$orderBy = getParam('orderBy', 'id');
$search = getParam('search', '');
$page = getParam('page', 1);
$paramsArray = compact('orderBy', 'orderDir', 'search', 'page');

$defaultParams = http_build_query($paramsArray, '', '&amp;');

if ($id) {
    $user = getUser($id);
} else {

    $user = [
        'username' => '',
        'id' => '',
        'fiscalcode' => '',
        'age' => '',
        'email' => '',
        'avatar' => '',
        'password' => '',
        'roletype' => 'user',
    ];
}

//var_dump($user);die;
require_once 'view/formUpdate.php';
?>
    </div>
</main>
<?php
require_once 'view/footer.php';
?>