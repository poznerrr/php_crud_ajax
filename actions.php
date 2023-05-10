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
    die();
}

// Add city
if (isset($_POST['addCity'])) {
    $data = $_POST;
    $validator = new Validator();
    $validation = $validator->validate($data, [
        'name' => [
            'required' => true
        ],
        'population' => [
            'minNum' => 1,
        ]
    ]);
    if ($validation->hasErrors()) {
        $errors = '<ul class="list-unstyled text-start text-danger">';
        foreach ($validation->getErrors() as $v) {
            foreach ($v as $error) {
                $errors .= "<li>{$error}</li>";
            }
        }
        $errors .= '</ul>';
        $res = ['answer' => 'error', 'errors' => $errors];
    } else {
        $db->query("INSERT INTO city (`name`, `population`) VALUES (?,?)", [$data['name'], $data['population']]);
        $res = ['answer' => 'success'];
    }
    echo json_encode($res);
    die();
}


