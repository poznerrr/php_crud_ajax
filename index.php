<?php
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';

$db = Db::getInstance()->getConnection($config['db']);
$total = getCount('city');
$page = $_GET['page'] ?? 1;
$perPage = $config['perPage'];
$pagination = new Pagination((int)$page, $perPage, $total);
$start = $pagination->get_start();
$cities = getCities($start, $perPage);

require_once 'views/index.tpl.php';

