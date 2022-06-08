<?php

require("db.php");


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'));



if($uri[1] == 'book') {
    $action = $uri[2];
    
    if($action == 'add')  $res = addBook($conn, $data);
    else if($action == 'show') $res = showBooks($conn);
    else if($action == 'get' ) $res = getBook($conn, $data);
    else if($action == 'update' ) $res = updateBook($conn, $data);
    else if($action == 'delete' ) $res = deleteBook($conn, $data);
}
exit;

function addBook($conn, $data) {
 
    if(!isset($data)) {
        echo json_encode([
            'error' => true,
            'message' => 'Nie udało się dodać' 
        ]);  
        exit;
    }
    
    $name = ($data->name) ? $data->name : '';
    $publisher = ($data->publisher) ? $data->publisher : '';
    $pageAmount = ($data->pageAmount) ? $data->pageAmount : '';
    
    $sql_query = "INSERT INTO `books` (`name`, `publisher`, `page_amount`) VALUES ('".$name."', '".$publisher."', ".$pageAmount." );";
    $res = $conn->query($sql_query);
    
    echo json_encode([
        'error' => false,
        'message' => 'Książka została dodana: ' 
    ]); 
    exit;
}

function showBooks($conn) {
 
    $sql_query = "SELECT * FROM `books`;";
    $res = $conn->query($sql_query);
    
    if($res->num_rows > 0) {
        $rows = $res->fetch_all(); 
        echo json_encode([
            'error' => false,
            'message' => json_encode($rows)
        ]); 
        exit;
    } else {
        echo json_encode([
            'error' => true,
            'message' => 'Błędny login lub hasło'
        ]); 
        exit;
    }
}

function getBook($conn, $data) {

    if(!isset($data) || !isset($data->id)) {
        echo json_encode([
            'error' => true,
            'message' => 'Nie udało się dodać' 
        ]);  
        exit;
    }

    $id = $data->id;

    $sql_query = "SELECT * FROM `books` WHERE `id` = ". $id .";";
    $res = $conn->query($sql_query);

    if($res->num_rows > 0) {
        $row = $res->fetch_assoc(); 
        echo json_encode([
            'error' => false,
            'message' => json_encode($row)
        ]); 
    }
    exit;
}

function updateBook($conn, $data) {
 
    if(!isset($data)) {
        echo json_encode([
            'error' => true,
            'message' => 'Update is impossible' 
        ]);  
        exit;
    }
    
    $id = ($data->id) ? $data->id : 0;
    $name = ($data->name) ? $data->name : '';
    $publisher = ($data->publisher) ? $data->publisher : '';
    $pageAmount = ($data->pageAmount) ? $data->pageAmount : '';
    
    if($id == 0) {
        echo json_encode([
            'error' => true,
            'message' => 'Update is impossible' 
        ]);  
        exit;
    }
    $sql_query = " UPDATE `books` SET `name` = '".$name."', `publisher` = '".$publisher."', `page_amount` = '".$pageAmount."' WHERE `id` = ".$id.";";
    $res = $conn->query($sql_query);
    
    echo json_encode([
        'error' => false,
        'message' => 'The book was updated. ' 
    ]); 
    exit;
}

function deleteBook($conn, $data) {
 
    if(!isset($data)) {
        echo json_encode([
            'error' => true,
            'message' => 'Update is impossible' 
        ]);  
        exit;
    }
    
    $id = ($data->id) ? $data->id : 0;
    
    if($id == 0) {
        echo json_encode([
            'error' => true,
            'message' => 'Update is impossible' 
        ]);  
        exit;
    }
    $sql_query = " DELETE FROM `books` WHERE `id` = ".$id.";";
    $res = $conn->query($sql_query);
    
    echo json_encode([
        'error' => false,
        'message' => 'The book was updated. ' 
    ]); 
    exit;
}