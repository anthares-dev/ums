<?php
require_once 'headerInclude.php';
?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5 text-center p-">USER MANAGEMENT SYSTEM</h1>

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