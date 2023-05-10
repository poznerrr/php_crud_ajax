<?php
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';
require_once 'classes/Validator.php';

$db = Db::getInstance()->getConnection($config['db']);

$data = json_decode(file_get_contents('php://input'), true); //вариант получения json из запроса

//pagination
if (isset($data['page'])) {
    $page = (int)$data['page'];
    $total = getCount('city');
    $perPage = $config['perPage'];
    $pagination = new Pagination((int)$page, $perPage, $total);
    $start = $pagination->get_start();
    $cities = getCities($start, $perPage);
    require_once 'views/index-content.tpl.php';
}



