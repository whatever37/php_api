<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Category read query
    $result = $category->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if($num > 0) {
        // Categories array
        $categories_arr = array();
        $categories_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $category_item = array(
                'id' => $id,
                'name' => $name
            );

            // Push to "data"
            array_push($categories_arr['data'], $category_item);
        }

        // TUrn to JSON & output
        echo json_encode($categories_arr);
    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }