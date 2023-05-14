<?php

function print_arr(array $data): void
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

function getCount(string $table): int
{
    global $db;
    return $db->query("SELECT COUNT(*) FROM {$table}")->findColumn();
}

function getCities(int $start, int $perPage): array
{
    global $db;
    return $db->query("SELECT * FROM city LIMIT $start, $perPage")->findAll();
}

function searchCities(string $search): array
{
    global $db;
    return $db->query("SELECT * FROM city WHERE name LIKE ?", ["%{$search}%"])->findAll();
}
