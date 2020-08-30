<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");

include_once "../../config/Database.php";
include_once "../../models/Category.php";


$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$result = $cat->read();
$count = $result->rowCount();

if ($count > 0) {
    $cat_arr = array();
    $cat_arr["data"] = array();


    // while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    //     extract($row);
    //     $catItem = array(
    //         'id' => $id,
    //         'name' => $name,
    //         'created_at' => $created_at
    //     );
    //     // $catItem = array(
    //     //     'id' => $row['id'],
    //     //     'name' => $row['name'],
    //     //     'created_at' => $row['created_at']
    //     // );

    //     array_push($cat_arr["data"], $catItem);
    // }
    $all = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($all as $row) {
        $catItem = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'created_at' => $row['created_at']
        );
        array_push($cat_arr["data"], $catItem);
    }

    echo json_encode($cat_arr);
} else {
    echo json_encode(array(["message" => "No data found"]));
}
