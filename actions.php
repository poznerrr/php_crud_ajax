<?php
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';
require_once 'classes/Validator.php';

$db = Db::getInstance()->getConnection($config['db']);

$data = json_decode(file_get_contents('php://input'), true); //вариант получения json из запроса

//Search
if (isset($data['search'])) {
    $search = trim($data['search']);
    $searchCities = searchCities($search);
    require_once 'views/search.tpl.php';
    exit();
}
//pagination
if (isset($data['page'])) {
    $page = (int)$data['page'];
    $total = getCount('city');
    $perPage = $config['perPage'];
    $pagination = new Pagination((int)$page, $perPage, $total);
    $start = $pagination->get_start();
    $cities = getCities($start, $perPage);
    require_once 'views/index-content.tpl.php';
    exit();
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

//Get city
if (isset($data['action']) && $data['action'] == 'get_city') {
    $id = isset($data['id']) ? (int)$data['id'] : 0;
    $city = $db->query("SELECT * FROM city WHERE id = ?", [$id])->find();
    if ($city) {
        $res = ['answer' => 'success', 'city' => $city];
    } else {
        $res = ['answer' => 'error'];
    }
    echo json_encode($res);
    die();
}


// Edit city
if (isset($_POST['editCity'])) {
    $data = $_POST;
    $validator = new Validator();
    $validation = $validator->validate($data, [
        'name' => [
            'required' => true
        ],
        'population' => [
            'minNum' => 1,
        ],
        'id' => [
            'minNum' => 1
        ],
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
        $db->query("UPDATE city SET `name` = ?, `population` = ? WHERE id = ?", [$data['name'], $data['population'], $data['id']]);
        $res = ['answer' => 'success'];
    }
    echo json_encode($res);
    die();
}

//Delete city
if (isset($data['action']) && $data['action'] == 'delete_city') {
    $id = isset($data['id']) ? (int)$data['id'] : 0;
    $res = $db->query("DELETE FROM city WHERE id = ?", [$id]);
    if ($res) {
        $res = ['answer' => 'success'];
    } else {
        $res = ['answer' => 'error'];
    }
    echo json_encode($res);
    die();
}

