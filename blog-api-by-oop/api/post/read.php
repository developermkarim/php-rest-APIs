<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include_once './config/Database.php';
include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database;
$connect = $database->connect();

// Post Instantiate
$post = new Post($connect);
$allPosts = $post->read();

/* Row Count of Fetch Data */
$rowCount = $allPosts->rowCount();
if($rowCount > 0){

    /*  Posts array */
    $post_arr = array();
    // $post_arr['data'] = array(); 
    while($row = $allPosts->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        /* Post ITem by Iterating */
        $post_items = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        ];

           /* Push to Associative "data" key */
    // array_push($post_arr['data'],$post_items);

    array_push($post_arr,$post_items);

    }
 
    echo json_encode($post_arr);
}else{
    echo json_encode(['message'=>"No Post available"]);
}