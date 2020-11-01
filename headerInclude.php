<?php
session_start();

require_once 'functions.php';
require_once 'model/User.php';
require_once 'view/top.php';

$pageUrl = $_SERVER['PHP_SELF'];
$updateUrl = 'updateUser.php';
$deleteUserUrl = '/controller/updateRecord.php';

$orderDir = getParam('orderDir', 'DESC');
$orderBy = getParam('orderBy', 'id');
$orderByColumns = getConfig('orderByColumns', ['id', 'username', 'email', 'fiscalcode', 'age']);

$recordsPerPage = getParam('recordsPerPage', getConfig('recordsPerPage'));
$recordsPerPageOptions = getConfig('recordsPerPageOptions', [5, 10, 20, 50, 100]);
$search = getParam('search', '');

$page = getParam('page', 1);

require_once 'view/navbar.php';