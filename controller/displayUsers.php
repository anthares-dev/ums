<?php

if (!in_array($orderBy, getConfig('orderByColumns'))) {
    $orderBy = 'id';
}
$params = [
    'orderBy' => $orderBy,
    'orderDir' => $orderDir,
    'recordsPerPage' => $recordsPerPage,
    'search' => $search,
    'page' => $page,
];
$orderByParams = $orderByNavigatorParams = $params;
unset($orderByParams['orderBy']);
unset($orderByParams['orderDir']);
unset($orderByNavigatorParams['page']);
$orderByQueryString = http_build_query($orderByParams, '', '&amp;'); // key=value&key2=value2 ...
$navOrderByQueryString = http_build_query($orderByNavigatorParams,'', '&amp;'); // key=value&key2=value2 ...

$totalUsers = countUsers($params);
$numPages = ceil($totalUsers / $recordsPerPage);
$users = getUsers($params);
require_once 'view/usersList.php';